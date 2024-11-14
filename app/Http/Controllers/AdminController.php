<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Club;

class AdminController extends Controller
{
    // AdminController.php
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
        //active clubs with number of events and number of members
        $active_clubs = Club::withCount('events', 'users')->orderBy('events_count', 'desc')->take(3)->get();

        $page="admin_dashboard";
        return view('admin.dashboard' , compact('page','users','active_clubs'));
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
        return response()->json(['success' => true]);
        
    }

    public function destroy(User $user)
    {
        $user->delete();
        return response()->json(['success' => true]);
    }
}
