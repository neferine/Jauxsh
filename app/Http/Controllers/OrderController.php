<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of the user's orders.
     */
    public function index()
    {
        // Get all orders belonging to the logged-in user
        $orders = Order::where('user_id', Auth::id())
            ->with('orderItems.product') // eager load items + products
            ->latest('order_date')
            ->paginate(10);

        return view('pages.orders.index', compact('orders'));
    }

    /**
     * Display the specified order details.
     */
    public function show($id)
    {
        // Load order with items, products, and product images
        $order = Order::with(['orderItems.product.images'])
            ->where('user_id', Auth::id()) // ensure order belongs to logged-in user
            ->findOrFail($id);

        return view('pages.orders.show', compact('order'));
    }
}
