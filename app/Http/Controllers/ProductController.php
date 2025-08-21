<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\Genre;
use App\Http\Requests\ProductRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{

    public function index()
    {
        if (auth()->check() && auth()->user()->isAdmin()) {
            // 管理者は全て表示
            $products = Product::orderBy('created_at', 'desc')->paginate(8);
        } else {
            // ユーザーは販売中かつ在庫ありのみ表示
            $products = Product::where('status', 'available')
                ->where('stock', '>', 0)
                ->orderBy('created_at', 'desc')
                ->paginate(8);
        }

        return view('products.index', compact('products'));
    }

    public function create()
    {
        $genres = Genre::all();
        return view('products.create', compact('genres'));
    }

    public function store(ProductRequest $request)
    {
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'image_path' => $imagePath,
            'genre_id' => $request->genre_id,
            'status' => $request->status,
        ]);

        return redirect()->route('products.index')->with('success', '商品を登録しました');
    }

    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $genres = Genre::all();
        return view('products.edit', compact('product', 'genres'));
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->all();

        // 画像がアップロードされていた場合
        if ($request->hasFile('image')) {
            // 既存画像を削除
            if ($product->image_path && Storage::disk('public')->exists($product->image_path)) {
                Storage::disk('public')->delete($product->image_path);
            }

            // 新しい画像を保存
            $imagePath = $request->file('image')->store('products', 'public');
            $data['image_path'] = $imagePath;
        } else {
            // 画像がアップロードされなければ既存のまま
            unset($data['image_path']);
        }

        $product->update($data);

        return redirect()->route('products.index')->with('success', '商品を更新しました');
    }

    public function destroy(string $id)
    {
        $user = Auth::user();
        $product = Product::findOrFail($id);

        // 管理者のみ削除可能
        if (!$user || !$user->isAdmin()) {
            abort(403);
        }

        $product->delete(); // 論理削除

        return redirect()->route('products.index')->with('success', '商品を削除しました。');
    }
}
