<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Kue',
            'Cupcake',
            'Donut',
            'Brownies',
            'Cookies',
            'Pudding',
            'Roti',
            'Cake Ulang Tahun',
        ];

        foreach ($categories as $name) {
            Category::updateOrCreate(
                ['name' => $name],
                ['name' => $name]
            );
        }
    }
}
