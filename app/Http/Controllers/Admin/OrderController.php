<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrderItem;
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

    public function show($id)
    {
        $order = Order::with(['user', 'orderItems.product'])
            ->findOrFail($id);

        return view('admin.orders.show', compact('order'));
    }

    public function updateOrderItemStatus(Request $request, OrderItem $orderItem)
    {
        $orderItem->production_status = $request->input('production_status');
        $orderItem->save();

        // 注文ステータスの自動更新
        $orderItem->order->updateStatusBasedOnItems();

        return back()->with('success', '製作ステータスを更新しました。');
    }

    public function updateStatus(Request $request, $id)
    {
        $order = Order::with('orderItems')->findOrFail($id);
        $order->status = $request->order_status;
        $order->save();

        // 注文ステータス変更に応じて制作ステータスを更新
        $order->updateItemStatusesBasedOnOrder();

        return redirect()->back()->with('success', '注文ステータスを更新しました。');
    }
}
