<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AccountController extends Controller
{
    /**
     * Display the user's account page.
     */
    public function index()
    {
        $user = Auth::user();
        $addresses = $user->shippingAddresses;
        $orders = $user->orders()->latest()->take(5)->get();

        return view('account.index', compact('user', 'addresses', 'orders'));
    }

    /**
     * Show the form for editing the user's profile.
     */
    public function edit()
    {
        $user = Auth::user();
        return view('account.edit', compact('user'));
    }

    /**
     * Update the user's profile.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'phone' => ['nullable', 'string', 'max:20'],
            'current_password' => ['nullable', 'required_with:new_password'],
            'new_password' => ['nullable', 'confirmed', Password::defaults()],
        ]);

        // Check current password if user wants to change password
        if ($request->filled('current_password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Current password is incorrect.'])->withInput();
            }
            $validated['password'] = Hash::make($request->new_password);
        }

        // Remove password fields from validated data if not changing password
        if (!$request->filled('new_password')) {
            unset($validated['current_password'], $validated['new_password']);
        }

        $user->update($validated);

        return redirect()->route('account.index')->with('success', 'Profile updated successfully!');
    }
}