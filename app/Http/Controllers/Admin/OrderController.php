<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;

class OrderController extends Controller
{
    public function index(User $user)
    {
        $orders = Order::where('user_id', $user->id)->with('orderItems')->latest()->get();
        return view('admin.orders.index', compact('user', 'orders'));
    }
}
