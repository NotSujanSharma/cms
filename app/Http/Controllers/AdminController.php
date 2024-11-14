<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    // AdminController.php
    public function index()
    {
        return view('admin.dashboard');
    }
    //
}
