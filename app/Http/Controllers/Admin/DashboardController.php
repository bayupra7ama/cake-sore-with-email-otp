<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'totalProducts' => Product::count(),
            'totalCategories' => Category::count(),
            'totalOrders' => Order::count(),

            'pendingOrders' => Order::where('status', 'pending')->count(),
            'waitingVerification' => Order::where('status', 'waiting_verification')->count(),

            'totalRevenue' => Order::whereIn('status', ['paid', 'processed', 'completed'])
                ->sum('total'),

            'latestOrders' => Order::latest()->take(5)->get(),
        ]);
    }
}
