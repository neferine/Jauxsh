<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }
   
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
       
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
           
            // Redirect admin to dashboard
            if (Auth::user()->is_admin) {
                return redirect()->intended(route('admin.dashboard'));
            }
           
            // For regular users, always redirect to home (not intended)
            return redirect()->route('home');
        }
       
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }
   
    public function logout(Request $request)
    {
        Auth::logout();
       
        $request->session()->invalidate();
        $request->session()->regenerateToken();
       
        return redirect('/')->header('Cache-Control', 'no-cache, no-store, max-age=0, must-revalidate')
                           ->header('Pragma', 'no-cache')
                           ->header('Expires', 'Sat, 01 Jan 1990 00:00:00 GMT');
    }
}