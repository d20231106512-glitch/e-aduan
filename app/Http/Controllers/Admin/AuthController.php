<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    // 1. Show the custom login form
    public function showLoginForm()
    {
        if (session()->has('admin_authenticated')) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.login');
    }

    // 2. Validate fixed credentials
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // HARDCODED FIXED CREDENTIALS FOR ADMIN PORTAL
        $fixedUsername = 'admin';
        $fixedPassword = 'password123';

        if ($request->username === $fixedUsername && $request->password === $fixedPassword) {
            // Store a secure session flag indicating the admin is verified
            session(['admin_authenticated' => true]);
            return redirect()->route('admin.dashboard')->with('success', 'Welcome back, Admin!');
        }

        return redirect()->back()
            ->withInput($request->only('username'))
            ->with('error', 'Invalid username or password credentials.');
    }

    // 3. Clear session upon logging out
    public function logout()
    {
        session()->forget('admin_authenticated');
        return redirect()->route('admin.login')->with('success', 'Logged out successfully.');
    }
}
