<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        // 🔐 kalau admin → langsung dashboard
        if (auth()->check() && auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        // 📦 data home (guest & user biasa)
        $categories = Category::all();
        $products = Product::with(['images', 'category'])
            ->latest()
            ->take(8)
            ->get();

        return view('user.pages.home', compact('products', 'categories'));
    }

}
