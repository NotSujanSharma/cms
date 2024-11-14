<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Club;
use App\Models\Event;

class AdminController extends Controller
{
    public function index()
    {
        $m_users = User::all();
        $user_count = User::count();
        $new_users = User::orderBy('created_at', 'desc')->take(5)->get();
        $most_active_users = User::withCount('events')->orderBy('events_count', 'desc')->take(5)->get();
        $users = [
            'users' => $m_users,
            'user_count' => $user_count,
            'new_users' => $new_users,
            'most_active_users' => $most_active_users
        ];
        $all_clubs = Club::all();
        $active_clubs = Club::withCount('events', 'users')->orderBy('events_count', 'desc')->take(3)->get();

        $page="admin_dashboard";
        return view('admin.dashboard' , compact('page','users','active_clubs','all_clubs'));
    }

    public function users()
    {
        $users = User::all();
        $page = 'users';
        
        return view('admin.users', compact('users','page'));
    }

    public function update(Request $request, User $user)
    {
        
        $user->update($request->all());
        return back()->with('success', 'User updated successfully');
        
    }

    public function destroy(User $user)
    {
        $user->delete();
        return back()->with('success', 'User deleted successfully');
    }

    public function createEvent(Request $request)
    {
        $event = new Event();
        $event->fill($request->all());
        $event->save();
        return back()->with('success', 'Event created successfully');
    }
}
