<?php
namespace Database\Seeders;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin Raninsha Kitchen',
            'email' => 'admin@ranisya.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'is_active' => 1,
        ]);
    }
}
