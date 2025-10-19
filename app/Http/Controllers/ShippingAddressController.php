<?php

namespace App\Http\Controllers;

use App\Models\ShippingAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShippingAddressController extends Controller
{
    // Show create form
    public function create()
    {
        return view('account.addresses.create');
    }

    // Store new address
    public function store(Request $request)
    {
        $validated = $request->validate([
            'address_line1' => 'required|string|max:255',
            'address_line2' => 'nullable|string|max:255',
            'city' => 'required|string|max:255',
            'postal_code' => 'required|string|max:20',
            'country' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
        ]);

        ShippingAddress::create([
            'user_id' => Auth::id(),
            ...$validated
        ]);

        return redirect()->route('account.index')->with('success', 'Address added successfully');
    }

    // Show edit form
    public function edit(ShippingAddress $address)
    {
        // Check if address belongs to logged-in user
        if ($address->user_id !== Auth::id()) {
            abort(403);
        }

        return view('account.addresses.edit', ['address' => $address]);
    }

    // Update address
    public function update(Request $request, ShippingAddress $address)
    {
        // Check if address belongs to logged-in user
        if ($address->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'address_line1' => 'required|string|max:255',
            'address_line2' => 'nullable|string|max:255',
            'city' => 'required|string|max:255',
            'postal_code' => 'required|string|max:20',
            'country' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
        ]);

        $address->update($validated);

        return redirect()->route('account.index')->with('success', 'Address updated successfully');
    }

    // Delete address
    public function destroy(ShippingAddress $address)
    {
        // Check if address belongs to logged-in user
        if ($address->user_id !== Auth::id()) {
            abort(403);
        }

        $address->delete();

        return redirect()->route('account.index')->with('success', 'Address deleted successfully');
    }
}