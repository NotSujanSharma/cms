<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Club;


class SubAdminController extends Controller
{
    //
    // SubAdminController.php
    public function index()
    {
        $page="sub_admin";
        $subadminclub = Auth::user()->subAdminClub;
        $club = $subadminclub;
        return view('subadmin.dashboard',compact('page', 'club'));
    }


}
