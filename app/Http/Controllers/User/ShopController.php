<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['images', 'category']);

        // 🔎 SEARCH by name
        if ($request->filled('q')) {
            $query->where('name', 'like', '%' . $request->q . '%');
        }

        // 🗂 FILTER CATEGORY
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // ↕ SORTING
        if ($request->sort === 'az') {
            $query->orderBy('name');
        } else {
            $query->latest();
        }

        $products = $query->paginate(9)->withQueryString();
        $categories = Category::orderBy('name')->get();

        return view('user.pages.product', compact('products', 'categories'));
    }
}
