<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\News;
use App\Models\Event;


class SubAdminController extends Controller
{
    //
    // SubAdminController.php
    public function index()
    {
        $page="sub_admin";
        $subadminclub = Auth::user()->subAdminClub;
        $events = $subadminclub->events()->orderBy('event_date', 'desc')->get();
        $news = $subadminclub->news()->orderBy('date', 'desc')->get();
        $club = $subadminclub;
        
        return view('subadmin.dashboard',compact('page', 'club', 'events', 'news'));
    }

    public function destroyEvent(Event $event)
    {
        $event->delete();
        return redirect()->route('subadmin.dashboard')->with('success', 'Event deleted successfully');
    }

    public function updateEvent(Request $request, Event $event)
    {
        $event->update($request->all());
        return back()->with('success', 'Event updated successfully');
    }
    public function destroyNews(News $news)
    {
        $news->delete();
        return redirect()->route('subadmin.dashboard')->with('success', 'News deleted successfully');

    }
    public function updateNews(Request $request, News $news)
    {
        $news->update($request->all());
        return back()->with('success', 'News updated successfully');
    }

    public function createEvent(Request $request)
    {

        // dd($request->all());
        $event = new Event();

        $event->fill($request->all());
        $event->save();
        return back()->with('success', 'Event created successfully');
    }

    public function createNews(Request $request)
    {
        $news = new News();
        $news->fill($request->all());
        $news->save();
        return back()->with('success', 'News created successfully');
    }



}
