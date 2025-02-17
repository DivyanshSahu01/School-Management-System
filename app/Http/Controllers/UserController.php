<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate(); // Invalidate session
        $request->session()->regenerateToken(); // Prevent CSRF attacks

        return redirect('/');
    }
    //
    public function login(Request $request)
    {
        $credentials = $request->validate(['userid'=>'required', 'password'=>'required']);

        if(Auth::attempt($credentials))
        {
            $user = Auth::user();
            return redirect()->intended('student-list');
        }

        return back()->withErrors([
            'error' => 'Invalid credentials.',
        ]);
    }
}
