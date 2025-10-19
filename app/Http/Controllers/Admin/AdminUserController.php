<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    /**
     * Display a listing of all users.
     */
    public function index()
    {
        $users = User::orderBy('created_at', 'desc')->paginate(15);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Display the specified user and their orders.
     */
    public function show($id)
    {
        $user = User::with('orders.orderItems.product')->findOrFail($id);
        return view('admin.users.show', compact('user'));
    }
}
