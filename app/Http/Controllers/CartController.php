<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CartItem;
use App\Models\Product;
use App\Http\Requests\CartRequest;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // カート一覧表示
    public function index()
    {
        $cartItems = CartItem::with('product')
            ->where('user_id', auth()->id())
            ->get();

        return view('cart.index', compact('cartItems'));
    }

    // 商品をカートに追加
    public function store(CartRequest $request)
    {
        $userId = auth()->id();
        $productId = $request->input('product_id');
        $quantity = $request->input('quantity');

        $product = Product::findOrFail($productId);

        // 在庫チェック
        if ($quantity > $product->stock) {
            return redirect()->back()->with('error', '在庫数を超える数量は追加できません。');
        }

        // すでにカートに入っているか確認
        $cartItem = CartItem::where('user_id', $userId)
            ->where('product_id', $productId)
            ->first();

        if ($cartItem) {
            $newQuantity = $cartItem->quantity + $quantity;

            // 合計数量が在庫を超えないようにする
            if ($newQuantity > $product->stock) {
                return redirect()->back()->with('error', '在庫数を超える数量は追加できません。');
            }

            $cartItem->quantity = $newQuantity;
            $cartItem->save();
        } else {
            CartItem::create([
                'user_id' => $userId,
                'product_id' => $productId,
                'quantity' => $quantity,
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'カートに商品を追加しました。');
    }

    // カートの数量更新
    public function update(Request $request, CartItem $cartItem)
    {
        if ($cartItem->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'quantity' => 'required|integer|min:1|max:' . $cartItem->product->stock,
        ]);

        $cartItem->quantity = $request->input('quantity');
        $cartItem->save();

        return redirect()->route('cart.index')->with('success', '数量を変更しました。');
    }

    // カートの商品を削除
    public function destroy(CartItem $cartItem)
    {
        if ($cartItem->user_id !== auth()->id()) {
            abort(403);
        }

        $cartItem->delete();
        return redirect()->route('cart.index')->with('success', '商品をカートから削除しました。');
    }
}
