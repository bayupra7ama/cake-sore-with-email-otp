<?php

namespace App\Http\Controllers\User;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{

    public function index(Request $request)
    {
        $status = $request->get('status');

        $orders = Order::where('user_id', auth()->id())
            ->when($status, function ($q) use ($status) {
                $q->where('status', $status);
            })
            ->latest()
            ->get();

        return view('user.pages.order', compact('orders', 'status'));
    }


    public function show(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $order->load('items');

        return response()->json($order);
    }

    public function checkout()
    {
        $cart = session()->get('cart', []);
        $subtotal = 0;

        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        return view('user.pages.checkout', compact('cart', 'subtotal'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'payment_method' => 'required|in:bca,bri,dana',
            'payment_proof' => 'required|image|max:2048',
        ]);

        $cart = session()->get('cart');

        if (!$cart || count($cart) === 0) {
            return back()->with('error', 'Cart kosong');
        }

        // Hitung total
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        // Upload bukti pembayaran
        $proofPath = $request->file('payment_proof')
            ->store('payment_proofs', 'public');

        // Simpan order
        $order = Order::create([
            'user_id' => auth()->id(),
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
            'notes' => $request->notes,
            'payment_method' => $request->payment_method,
            'payment_proof' => $proofPath,
            'total' => $total,
            'status' => 'waiting_verification',
        ]);


        foreach ($cart as $item) {
            $order->items()->create([
                'product_id' => $item['id'],
                'product_name' => $item['name'],
                'price' => $item['price'],
                'quantity' => $item['quantity'],
                'subtotal' => $item['price'] * $item['quantity'],
            ]);
        }

        // Kosongkan cart
        session()->forget('cart');

        return redirect()
            ->route('user.checkout')
            ->with('success', 'Pesanan berhasil dikirim. Menunggu verifikasi pembayaran.');
    }
}
