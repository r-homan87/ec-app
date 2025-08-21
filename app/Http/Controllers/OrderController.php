<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\CartItem;
use App\Models\ShippingAddress;
use Illuminate\Http\Request;
use App\Http\Requests\OrderRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class OrderController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $orders = Order::with('orderItems.product')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('orders.index', compact('orders'));
    }

    public function create()
    {
        $user = Auth::user();
        $shippingAddresses = $user->shippingAddresses;

        return view('orders.create', compact('shippingAddresses'));
    }

    public function confirm(OrderRequest $request)
    {
        $user = Auth::user();

        $validated = $request->validated();

        $shippingData = [];

        if ($validated['shipping_option'] === 'myself') {
            $shippingData = [
                'postal_code' => $user->postal_code,
                'address' => $user->address,
                'recipient_name' => $user->name,
            ];
        } elseif ($validated['shipping_option'] === 'registered') {
            $address = ShippingAddress::where('user_id', $user->id)
                ->where('id', $validated['registered_address_id'])
                ->firstOrFail();
            $shippingData = [
                'postal_code' => $address->postal_code,
                'address' => $address->address,
                'recipient_name' => $address->recipient_name,
            ];
        } elseif ($validated['shipping_option'] === 'new') {
            $newAddress = ShippingAddress::create([
                'user_id' => $user->id,
                'postal_code' => $validated['new_postal_code'],
                'address' => $validated['new_address'],
                'recipient_name' => $validated['new_recipient_name'],
            ]);
            $shippingData = [
                'postal_code' => $newAddress->postal_code,
                'address' => $newAddress->address,
                'recipient_name' => $newAddress->recipient_name,
            ];
        }

        $cartItems = CartItem::where('user_id', $user->id)->get();

        $data = [
            'payment_method' => $validated['payment_method'],
            'shipping_option' => $validated['shipping_option'],
            'postal_code' => $shippingData['postal_code'] ?? '',
            'address' => $shippingData['address'] ?? '',
            'recipient_name' => $shippingData['recipient_name'] ?? '',
        ];

        return view('orders.confirm', [
            'data' => $data,
            'cartItems' => $cartItems,
            'user' => $user,
            'shippingAddresses' => $user->shippingAddresses ?? collect(),
        ]);
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $cartItems = CartItem::where('user_id', $user->id)->get();

        if ($cartItems->isEmpty()) {
            return redirect()->back()->with('error', 'カートが空です');
        }

        DB::beginTransaction();

        try {
            // 配送先情報のセット
            if ($request->shipping_option === 'myself') {
                $shipping_postal_code = $user->postal_code;
                $shipping_address = $user->address;
                $shipping_name = $user->last_name . $user->first_name;
            } elseif ($request->shipping_option === 'registered') {
                $shipping_postal_code = $request->postal_code;
                $shipping_address = $request->address;
                $shipping_name = $request->recipient_name;
            } elseif ($request->shipping_option === 'new') {
                $shipping_postal_code = $request->postal_code;
                $shipping_address = $request->address;
                $shipping_name = $request->recipient_name;
            } else {
                throw new \Exception('配送先が選択されていません');
            }

            // 注文作成
            $order = Order::create([
                'user_id' => $user->id,
                'shipping_postal_code' => $shipping_postal_code,
                'shipping_address' => $shipping_address,
                'shipping_name' => $shipping_name,
                'payment_method' => $request->payment_method,
                'total_price' => 0,
            ]);

            $total = 0;

            foreach ($cartItems as $item) {
                $product = $item->product;

                // 在庫が足りるかチェック
                if ($product->stock < $item->quantity) {
                    throw new \Exception("商品「{$product->name}」の在庫が不足しています");
                }

                // 在庫数を減らす
                $product->decrement('stock', $item->quantity);

                // 在庫が0になったら販売停止にする
                if ($product->stock - $item->quantity <= 0) {
                    $product->status = 'unavailable';
                    $product->stock = 0; // 念のためマイナスにならないように
                    $product->save();
                }

                $subtotal = $product->price * $item->quantity;
                $total += $subtotal;

                $order->orderItems()->create([
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $product->price,
                ]);
            }

            $order->update(['total_price' => $total]);

            // カートを空にする
            CartItem::where('user_id', $user->id)->delete();

            DB::commit();

            return redirect()->route('orders.complete', $order->id)->with('success', '注文が完了しました');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', '注文に失敗しました: ' . $e->getMessage());
        }
    }

    public function show(Order $order)
    {
        $this->authorize('view', $order);

        $order->load('orderItems.product');

        return view('orders.show', compact('order'));
    }

    public function complete()
    {
        return view('orders.complete');
    }
}
