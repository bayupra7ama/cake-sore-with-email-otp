<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Product;

class ProductDetailController extends Controller
{
    public function show(string $slug)
    {
        $product = Product::with(['images', 'category'])
            ->where('slug', $slug)
            ->firstOrFail();

        // Related products (kategori sama, selain produk ini)
        $relatedProducts = Product::with(['images', 'category'])
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->take(6)
            ->get();

        return view('user.pages.product-detail', compact('product', 'relatedProducts'));
    }
}
