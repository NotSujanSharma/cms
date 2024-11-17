<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;


class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if ($user->role == 'admin') {
                return redirect()->route('admin.dashboard');
            } 
            else {
                return redirect()->route('user.dashboard');
            }
        }
        return back()->with('error', 'Invalid credentials');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }
    public function showSignupForm()
    {
        return view('auth.signup');
    }
    public function signup(Request $request)
    {
        $credentials = $request->only('name','email', 'password');
        $credentials['password'] = bcrypt($credentials['password']);
        $credentials['role'] = 'user';
        $user = User::create($credentials);
        Auth::login($user);
        return redirect()->route('user.dashboard');
    }


}
