<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $categories = Category::pluck('id');

        if ($categories->isEmpty()) {
            $this->command->warn('Category kosong. Isi category dulu.');
            return;
        }

        $imagePath = 'products/OPt4pNwPTeYWYQEdWeYqqxrHDvKYdAZAXK14pHUL.jpg';

        $productNames = [
            'Brownies Coklat Lumer',
            'Brownies Keju Premium',
            'Cookies Choco Chip',
            'Cookies Almond',
            'Dessert Box Tiramisu',
            'Dessert Box Coklat',
            'Brownies Matcha',
            'Brownies Red Velvet',
            'Cookies Oatmeal',
            'Dessert Box Cheese',
        ];

        for ($i = 1; $i <= 100; $i++) {
            $name = $productNames[array_rand($productNames)] . " #$i";

            $product = Product::create([
                'category_id' => $categories->random(),
                'name' => $name,
                'slug' => Str::slug($name) . '-' . Str::random(4),
                'description' => 'Produk homemade Raninsha Kitchen, dibuat fresh setiap hari dengan bahan berkualitas. Cocok untuk cemilan dan acara spesial.',
                'price' => rand(15000, 85000),
                'stock' => rand(5, 50),
            ]);

            // 🔗 SIMPAN GAMBAR KE TABEL product_images
            ProductImage::create([
                'product_id' => $product->id,
                'image' => $imagePath,
            ]);
        }

        $this->command->info('✅ 100 produk + gambar berhasil dibuat.');
    }
}
