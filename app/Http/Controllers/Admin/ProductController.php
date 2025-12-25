<?php

namespace App\Http\Controllers\Admin;

use Str;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('images', 'category')->latest()->get();
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'nullable|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
            'images' => 'required',
            'images.*' => 'image|max:2048',
        ]);

        $product = Product::create([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'slug' => $this->generateSlug($request->name),
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
        ]);

        foreach ($request->file('images') as $img) {
            $path = $img->store('products', 'public');
            ProductImage::create([
                'product_id' => $product->id,
                'image' => $path,
            ]);
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil ditambahkan');
    }

    private function generateSlug($name)
    {
        $slug = Str::slug($name);
        $count = Product::where('slug', 'like', "$slug%")->count();

        return $count ? "{$slug}-{$count}" : $slug;
    }

    public function edit(Product $product)
    {
        $product->load('images', 'category');
        $categories = Category::orderBy('name')->get();

        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'category_id' => 'nullable|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
            'images.*' => 'image|max:2048',
        ]);

        $product->update([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'slug' => \Str::slug($request->name),
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
        ]);

        // tambah gambar baru (gallery)
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $img) {
                $path = $img->store('products', 'public');
                $product->images()->create([
                    'image' => $path
                ]);
            }
        }

        return back()->with('success', 'Produk berhasil diperbarui');
    }

    public function deleteImage($productId, $imageId)
    {
        $image = ProductImage::where('id', $imageId)
            ->where('product_id', $productId)
            ->firstOrFail();

        Storage::disk('public')->delete($image->image);
        $image->delete();

        return response()->json(['message' => 'Image deleted']);
    }


}
