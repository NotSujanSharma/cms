<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Club; 
use App\Models\Event;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    //
    // UserController.php
    public function index()
    {
        $page = 'home';
        $clubs = Club::with(['events' => function($query) {
            $query->orderBy('event_date', 'desc')
                  ->take(3); // Get latest 3 events
        }, 'news' => function($query) {
            $query->orderBy('date', 'desc')
                  ->take(3); // Get latest 3 news items
        }])->get();

        $joined_clubs = Auth::user()->clubs->pluck('id')->toArray();

        return view('user.dashboard', compact('clubs','page','joined_clubs'));
    }

    public function profile()
    {
        $page = 'profile';
        $user = Auth::user();
        // clubs user have joined, and events user have joined
        $user->load('clubs', 'events');
        return view('user.profile', compact('user','page'));
    }
    public function news()
    {
        $page = 'news';
        $clubs = Club::with(['events' => function($query) {
            $query->orderBy('event_date', 'desc')
                  ->take(3); // Get latest 3 events
        }, 'news' => function($query) {
            $query->orderBy('date', 'desc')
                  ->take(3); // Get latest 3 news items
        }])->get();

        $joined_events = Auth::user()->events->pluck('id')->toArray();
        return view('user.news', compact('clubs','page','joined_events'));
    }

    public function calendar()
    {
        $page = 'user_calendar';
        $events = Event::all();
        $joined_events = Auth::user()->events->pluck('id')->toArray();
        $user_events = Event::whereIn('id', $joined_events)->get();
        return view('user.calendar', compact('events','page','user_events'));
    }

    
    public function club($club_id)
    {
        $page = 'club';
        $club = Club::with(['events' => function($query) {
            $query->orderBy('event_date', 'desc')
                  ->take(3); // Get latest 3 events
        }, 'news' => function($query) {
            $query->orderBy('date', 'desc')
                  ->take(3); // Get latest 3 news items
        }])->find($club_id);
        $is_member = Auth::user()->clubs->contains($club_id);
        $joined_events = Auth::user()->events->pluck('id')->toArray();
        return view('user.club', compact('club','is_member','page','joined_events'));
    }


    public function joinClub(Club $club)
    {
        $user = Auth::user();
        
        if (!$user->clubs->contains($club->id)) {
            $user->clubs()->attach($club->id);
            return back()->with('success', 'Successfully joined the club!');
        }
        
        return back()->with('error', 'You are already a member of this club.');
    }

    public function leaveClub(Club $club)
    {
        $user = Auth::user();
        
        if ($user->clubs->contains($club->id)) {
            $user->clubs()->detach($club->id);
            return back()->with('success', 'Successfully left the club!');
        }
        
        return back()->with('error', 'You are not a member of this club.');
    }

    public function joinEvent(Event $event)
    {
        $user = Auth::user();
        
        if (!$user->events->contains($event->id)) {
            $user->events()->attach($event->id);
            return back()->with('success', 'Successfully joined the event!');
        }
        
        return back()->with('error', 'You are already a member of this event.');
    }

    public function leaveEvent(Event $event)
    {
        $user = Auth::user();
        
        if ($user->events->contains($event->id)) {
            $user->events()->detach($event->id);
            return back()->with('success', 'Successfully left the event!');
        }
        
        return back()->with('error', 'You are not a member of this event.');
    }

    public function editProfile()
    {
        $page = 'edit-profile';
        $user = Auth::user();
        return view('user.edit-profile', compact('user','page'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $user->update($request->all());
        return back()->with('success', 'Profile updated successfully!');
    }
}
