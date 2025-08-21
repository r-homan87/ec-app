<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class TopController extends Controller
{
    public function index()
    {
        $products = Product::where('status', 'available')
            ->where('stock', '>=', 1)
            ->orderBy('created_at', 'desc')
            ->take(4)
            ->get();

        return view('top.index', compact('products'));
    }
}
