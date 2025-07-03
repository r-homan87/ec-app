<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $user = Auth::user();

        // カート内容を取得
        $cartItems = CartItem::where('user_id', $user->id)->get();

        if ($cartItems->isEmpty()) {
            return redirect()->back()->with('error', 'カートが空です');
        }

        DB::beginTransaction();

        try {
            // まずは空の注文作成（合計金額はあとで更新）
            $order = Order::create([
                'user_id' => $user->id,
                'total_price' => 0,
            ]);

            $total = 0;

            foreach ($cartItems as $item) {
                $subtotal = $item->product->price * $item->quantity;
                $total += $subtotal;

                $order->orderItems()->create([
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price,
                ]);
            }

            $order->update(['total_price' => $total]);

            // カートを空にする
            CartItem::where('user_id', $user->id)->delete();

            DB::commit();

            return redirect()->route('orders.show', $order)->with('success', '注文が完了しました');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', '注文に失敗しました');
        }
    }

    public function show(Order $order)
    {
        $this->authorize('view', $order); // 任意：注文の所有者チェック

        $order->load('orderItems.product');

        return view('orders.show', compact('order'));
    }
}
