<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function index()
    {
        // Basic statistics (optional)
        $totalUsers = User::count();
        $totalOrders = Order::count();
        $totalProducts = Product::count();
        $recentOrders = Order::latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalOrders',
            'totalProducts',
            'recentOrders'
        ));
    }
}
