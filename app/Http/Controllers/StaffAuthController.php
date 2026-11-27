<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StaffAuthController extends Controller
{
    // Display the central login page
    public function showLogin()
    {
        return view('auth.login');
    }

    // Process Admin, Staff, and Customer login
    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'role' => 'required|in:admin,staff,customer',
        ]);

        $credentials = [
            'email' => $validated['email'],
            'password' => $validated['password'],
            'role' => $validated['role'],
        ];

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            if (in_array(Auth::user()->role, ['admin', 'staff'])) {
                return redirect()->intended(route('customers.index'));
            }

            return redirect()->intended(route('fixed-deposits.index'));
        }

        return back()->withErrors([
            'email' => 'Invalid email, password, or account type.',
        ])->onlyInput('email', 'role');
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
