<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class TopController extends Controller
{
    public function index()
    {
        $newProducts = Product::orderBy('created_at', 'desc')->take(4)->get();

        return view('top.index', compact('newProducts'));
    }
}
