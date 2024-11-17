<?php
namespace App\Http\Controllers;

use App\Notifications\ClubJoinNotification;
use App\Notifications\ClubLeaveNotification;
use App\Notifications\EventJoinNotification;
use App\Notifications\EventLeaveNotification;
use Illuminate\Http\Request;
use App\Models\Club;
use App\Models\Event;
use App\Models\News;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        $page = 'home';
        $clubs = Club::with([
            'events' => function ($query) {
                $query->orderBy('event_date', 'desc')
                    ->take(3);
            },
            'news' => function ($query) {
                $query->orderBy('date', 'desc')
                    ->take(3);
            }
        ])->get();

        $joined_clubs = Auth::user()->clubs->pluck('id')->toArray();

        return view('user.dashboard', compact('clubs', 'page', 'joined_clubs'));
    }

    public function profile()
    {
        $page = 'profile';
        $user = Auth::user();
        $user->load('clubs', 'events');
        return view('user.profile', compact('user', 'page'));
    }
    public function news()
    {
        $page = 'news';
        $clubs = Auth::user()->clubs()->with([
            'events' => function ($query) {
                $query->orderBy('event_date', 'desc')
                    ->take(3);
            },
            'news' => function ($query) {
                $query->orderBy('date', 'desc')
                    ->take(3);
            }
        ])->get();

        $joined_events = Auth::user()->events->pluck('id')->toArray();
        return view('user.newsFeed', compact('clubs', 'page', 'joined_events'));
    }

    public function event($event_id)
    {
        $page = 'event';
        $event = Event::find($event_id);
        $club = $event->club;

        $is_member = Auth::user()->clubs->contains($club->id);
        if (Auth::user()->isUser()) {
            if (!$is_member) {
                return back()->with('error', 'You must be a member of the club to view the event.');
            }
        }

        if (Auth::user()->isSubAdmin()) {
            if ($club->subAdmin->id != Auth::user()->id) {
                return back()->with('error', 'You are not authorized to view this event');
            }
        }
        return view('user.event', compact('event', 'club', 'is_member', 'page'));
    }

    public function showNews($news_id)
    {
        $page = 'news_view';

        $news = News::find($news_id);
        $club = $news->club;

        $is_member = Auth::user()->clubs->contains($club->id);
        if (Auth::user()->isUser()) {
            if (!$is_member) {
                return back()->with('error', 'You must be a member of the club to view the news.');
            }
        }
        if (Auth::user()->isSubAdmin()) {
            if ($club->subAdmin->id != Auth::user()->id) {
                return back()->with('error', 'You are not authorized to view this news');
            }
        }
        return view('user.news', compact('news', 'club', 'is_member', 'page'));
    }


    public function calendar()
    {
        $page = 'user_calendar';
        $events = Event::all();
        $joined_events = Auth::user()->events->pluck('id')->toArray();
        $user_events = $events;
        // $user_events = Event::whereIn('id', $joined_events)->get();
        return view('user.calendar', compact('events', 'page', 'user_events'));
    }




    public function club($club_id)
    {
        $page = 'club';
        $club = Club::with([
            'events' => function ($query) {
                $query->orderBy('event_date', 'desc')
                    ->take(3);
            },
            'news' => function ($query) {
                $query->orderBy('date', 'desc')
                    ->take(3);
            }
        ])->find($club_id);
        $is_member = Auth::user()->clubs->contains($club_id);
        $joined_events = Auth::user()->events->pluck('id')->toArray();
        return view('user.club', compact('club', 'is_member', 'page', 'joined_events'));
    }


    public function joinClub(Club $club)
    {
        $user = Auth::user();

        if (!$user->clubs->contains($club->id)) {
            $user->clubs()->attach($club->id);
            $subadmin = $club->subAdmin;

            // Send notification to the subadmin
            if ($user) {
                $subadmin->notify(new ClubJoinNotification($user, $club));
            }

            return back()->with('success', 'Successfully joined the club!');
        }

        return back()->with('error', 'You are already a member of this club.');
    }

    public function leaveClub(Club $club)
    {
        $user = Auth::user();

        if ($user->clubs->contains($club->id)) {
            // Check if the user is joined in any event of the club
            $clubEvents = $club->events->pluck('id')->toArray();
            $userEvents = $user->events->pluck('id')->toArray();
            $commonEvents = array_intersect($clubEvents, $userEvents);

            if (!empty($commonEvents)) {
                return back()->with('error', 'You cannot leave the club while you are joined in one of its events.');
            }

            $user->clubs()->detach($club->id);
            $subadmin = $club->subAdmin;
            if ($user) {
                $subadmin->notify(new ClubLeaveNotification($user, $club));
            }
            return back()->with('success', 'Successfully left the club!');
        }

        return back()->with('error', 'You are not a member of this club.');
    }

    public function joinEvent(Event $event)
    {
        $user = Auth::user();
        $club = $event->club; // Assuming Event model has a 'club' relationship

        if (!$user->clubs->contains($club->id)) {
            return back()->with('error', 'You must be a member of the club to join its events.');
        }

        if (!$user->events->contains($event->id)) {
            $user->events()->attach($event->id);
            $subadmin = $club->subAdmin;
            if ($user) {
                $subadmin->notify(new EventJoinNotification($user, $event));
            }
            return back()->with('success', 'Successfully joined the event!');
        }

        return back()->with('error', 'You are already a member of this event.');
    }

    public function leaveEvent(Event $event)
    {
        $user = Auth::user();

        if ($user->events->contains($event->id)) {

            $subadmin = $event->club->subAdmin;
            if ($user) {
                $subadmin->notify(new EventLeaveNotification($user, $event));
            }


            return back()->with('success', 'Requested to leave the event.');
        }

        return back()->with('error', 'You are not a member of this event.');
    }

    public function editProfile()
    {
        $page = 'edit-profile';
        $user = Auth::user();
        return view('user.edit-profile', compact('user', 'page'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'avatar' => ['nullable', 'image', 'max:7272'],
        ]);
        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                Storage::delete($user->avatar);
            }
            $path = $request->file('avatar')->store('avatars', 'public');
            $validated['avatar'] = $path;
        }
        $user->update($validated);
        return back()->with('success', 'Profile updated successfully!');
    }
}
