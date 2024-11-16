<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Club;
use App\Models\Event;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{

    public function index()
    {
        $m_users = User::all();
        $user_count = User::count();
        $new_users = User::orderBy('created_at', 'desc')->take(5)->get();
        $most_active_users = User::withCount('events')->orderBy('events_count', 'desc')->take(4)->get();
        $users = [
            'users' => $m_users,
            'user_count' => $user_count,
            'new_users' => $new_users,
            'most_active_users' => $most_active_users
        ];
        $all_clubs = Club::all();
        $active_clubs = Club::withCount('events', 'users')->orderBy('events_count', 'desc')->take(3)->get();

        $page = "admin_dashboard";
        return view('admin.dashboard', compact('page', 'users', 'active_clubs', 'all_clubs'));
    }

    public function profile()
    {
        $page = 'profile';
        $user = auth()->user();
        return view('admin.profile', compact('user', 'page'));
    }

    public function edit()
    {
        $page = 'profile';
        $user = auth()->user();
        return view('admin.edit-profile', compact('user', 'page'));
    }

    public function users()
    {
        $users = User::all();
        $page = 'users';

        return view('admin.users', compact('users', 'page'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'role' => ['required', 'string', Rule::in(['admin', 'subadmin', 'user'])],
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
        return back()->with('success', 'User updated successfully');

    }

    public function destroy(User $user)
    {
        $user->delete();
        return back()->with('success', 'User deleted successfully');
    }

    public function events()
    {
        $events = Event::all();
        $clubs = Club::all();
        $page = 'events';
        return view('admin.events', compact('events', 'page', 'clubs'));
    }



    public function createEvent(Request $request)
    {

        // dd($request->all());
        $event = new Event();

        $event->fill($request->all());
        $event->save();
        return back()->with('success', 'Event created successfully');
    }

    public function destroyEvent(Event $event)
    {
        $event->delete();
        return back()->with('success', 'Event deleted successfully');
    }

    public function updateEvent(Request $request, Event $event)
    {
        $event->update($request->all());
        return back()->with('success', 'Event updated successfully');
    }

    public function createUser(Request $request)
    {
        $user = new User();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', Rule::unique('users')],
            'role' => ['required', 'string', Rule::in(['admin', 'subadmin', 'user'])],
            'avatar' => ['nullable', 'image', 'max:7272'],
            'password' => ['required', 'string'],
        ]);

        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('avatars', 'public');
            $validated['avatar'] = $path;
        }
        $user->fill($validated);
        $user->save();
        return back()->with('success', 'User created successfully');
    }
}
