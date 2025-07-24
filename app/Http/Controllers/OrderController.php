<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\CartItem;
use App\Models\ShippingAddress;
use Illuminate\Http\Request;
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

    public function confirm(Request $request)
    {
        $user = Auth::user();
        $shippingOption = $request->input('shipping_option');

        $data = [
            'payment_method' => $request->input('payment_method'),
            'shipping_option' => $shippingOption,
        ];

        if ($shippingOption === 'new') {
            $data['new_recipient_name'] = $request->input('new_recipient_name');
            $data['new_postal_code'] = $request->input('new_postal_code');
            $data['new_address'] = $request->input('new_address');
        } elseif ($shippingOption === 'registered') {
            $registeredId = $request->input('registered_address_id');
            $data['registered_address_id'] = $registeredId;

            $selectedAddress = ShippingAddress::where('user_id', $user->id)
                ->where('id', $registeredId)
                ->first();

            if ($selectedAddress) {
                $data['registered_recipient_name'] = $selectedAddress->recipient_name;
                $data['registered_postal_code'] = $selectedAddress->postal_code;
                $data['registered_address'] = $selectedAddress->address;
            }
        }

        $cartItems = CartItem::with('product')->where('user_id', $user->id)->get();

        return view('orders.confirm', [
            'data' => $data,
            'user' => $user,
            'cartItems' => $cartItems,
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
            return redirect()->route('orders.complete', $order->id)->with('success', '注文が完了しました');
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
            return redirect()->back()->with('error', '注文に失敗しました');
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
