<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SubAdminController extends Controller
{
    //
    // SubAdminController.php
    public function index()
    {
        return view('subadmin.dashboard');
    }


}
