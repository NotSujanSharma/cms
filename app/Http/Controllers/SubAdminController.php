<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\EventCreatedNotification;
use App\Notifications\EventDeletedNotification;
use App\Notifications\NewsPostedNotification;
use App\Models\News;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

use App\Models\Notification;
use App\Models\Event;


class SubAdminController extends Controller
{
    //
    // SubAdminController.php
    public function index()
    {
        $page = "sub_admin";
        $subadminclub = Auth::user()->subAdminClub;
        if (!$subadminclub) {
            //return error subadmin.error page with error
            return view('subadmin.error', ['page' => 'sub_admin', 'error' => 'Sub-admin club not found']);
        }
        $events = $subadminclub->events()->orderBy('event_date', 'desc')->get();
        $news = $subadminclub->news()->orderBy('date', 'desc')->get();
        $club = $subadminclub;

        return view('subadmin.dashboard', compact('page', 'club', 'events', 'news'));
    }

    public function destroyEvent(Event $event)
    {
        $event->delete();
        $admin = User::where('role', 'admin')->first();
        $subadmin = $event->club->subAdmin;
        if ($admin) {
            // Assuming you have a notification system in place
            $admin->notify(new EventDeletedNotification($event, $subadmin));
        }
        return redirect()->route('subadmin.dashboard')->with('success', 'Event deleted successfully');
    }

    public function updateEvent(Request $request, Event $event)
    {
        $validated = $request->validate([
            'name' => ['required', 'string'],
            'event_date' => ['required'],
            'description' => ['nullable', 'string'],
            'picture' => ['nullable', 'image'],
        ]);
        if ($request->hasFile('picture')) {
            if ($event->picture) {
                Storage::delete($event->picture);
            }
            $path = $request->file('picture')->store('events', 'public');
            $validated['picture'] = $path;
        }

        $event->update($validated);
        return back()->with('success', 'Event updated successfully');
    }
    public function destroyNews(News $news)
    {
        $news->delete();
        return redirect()->route('subadmin.dashboard')->with('success', 'News deleted successfully');

    }
    public function updateNews(Request $request, News $news)
    {
        // if user is not subadmin to club of news, return error
        
        $validated = $request->validate([
            'headline' => ['required', 'string'],
            'date' => ['required'],
            'description' => ['nullable', 'string'],
            'picture' => ['nullable', 'image'],
        ]);
        if ($request->hasFile('picture')) {
            if ($news->picture) {
                Storage::delete($news->picture);
            }
            $path = $request->file('picture')->store('news', 'public');
            $validated['picture'] = $path;
        }

        $news->update($validated);
        return back()->with('success', 'News updated successfully');
    }

    public function createEvent(Request $request)
    {

        $event = new Event();
        $validated = $request->validate([
            'name' => ['required', 'string'],
            'event_date' => ['required'],
            'description' => ['nullable', 'string'],
            'picture' => ['nullable', 'image'],
            'club_id' => ['required', 'exists:clubs,id'],
        ]);
        if ($request->hasFile('picture')) {
            $path = $request->file('picture')->store('events', 'public');
            $validated['picture'] = $path;
        }
        $event->fill($validated);
        $event->save();
        //send event created notification to admin 
        $admin = User::where('role', 'admin')->first();
        $subadmin = $event->club->subAdmin;
        if ($admin) {
            // Assuming you have a notification system in place
            $admin->notify(new EventCreatedNotification($event, $subadmin));
            //notify all users
            $users = User::where('role', 'user')->get();
            foreach ($users as $user) {
                $user->notify(new EventCreatedNotification($event, $subadmin));
            }

        }
        return back()->with('success', 'Event created successfully');
    }

    public function createNews(Request $request)
    {
        $news = new News();
        $validated = $request->validate([
            'headline' => ['required', 'string'],
            'date' => ['required'],
            'description' => ['nullable', 'string'],
            'picture' => ['nullable', 'image'],
            'club_id' => ['required', 'exists:clubs,id'],
        ]);
        if ($request->hasFile('picture')) {
            $path = $request->file('picture')->store('news', 'public');
            $validated['picture'] = $path;
        }
        $news->fill($validated);
        $news->save();
        $users = User::where('role', 'user')->get();
        $club = $news->club;
        foreach ($users as $user) {
            $user->notify(new NewsPostedNotification($news, $club));
        }
        return back()->with('success', 'News created successfully');
    }

    public function approveLeaveEvent(Request $request)
    {
        $event = Event::find($request->event_id);
        $user = User::find($request->user_id);
        $notification = Notification::find($request->notification_id);

        if ($user->events->contains($event->id)) {
            $event->participants()->detach($user->id);
            $notification->delete();
        } else {
            $notification->delete();
        }
        return back()->with('success', 'User leave event approved successfully');
    }
    public function denyLeaveEvent(Request $request)
    {
        $notification = Notification::find($request->notification_id);
        $notification->delete();
        return back()->with('success', 'User leave event denied successfully');
    }





}
