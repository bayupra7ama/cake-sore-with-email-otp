<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->get('status');

        $orders = Order::with('items')
            ->when($status, function ($q) use ($status) {
                $q->where('status', $status);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString(); // 🔥 penting biar filter ikut pagination

        return view('admin.order.index', compact('orders', 'status'));
    }

    public function show(Order $order)
    {
        $order->load('items');

        return view('admin.order.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,waiting_verification,paid,processed,completed,rejected',
        ]);

        $order->update([
            'status' => $request->status,
        ]);

        return back()->with('success', 'Status order berhasil diperbarui');
    }
}
