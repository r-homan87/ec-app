<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\ShippingAddress;
use App\Models\Order;

class MypageController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $shippingAddresses = ShippingAddress::where('user_id', $user->id)->get();
        $orders = Order::where('user_id', $user->id)->latest()->take(5)->get();

        return view('mypage.index', compact('user', 'shippingAddresses', 'orders'));
    }
}
