<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())
            ->with('orderItems.product')
            ->latest('order_date')
            ->paginate(10);
            
        return view('pages.orders.index', compact('orders'));
    }
    
    public function show($id)
    {
        $order = Order::with(['orderItems.product.images'])
            ->where('user_id', Auth::id())
            ->findOrFail($id);
            
        return view('pages.orders.show', compact('order'));
    }
}