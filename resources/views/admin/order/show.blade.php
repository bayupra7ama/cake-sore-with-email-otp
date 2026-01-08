@extends('layouts.admin')

@section('title', 'Detail Pesanan')

@section('content')

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        {{-- INFO ORDER --}}
        <div class="md:col-span-2 bg-white p-6 rounded shadow">
            <h3 class="font-semibold mb-4">Informasi Pesanan</h3>

            <ul class="space-y-2 text-sm">
                <li><strong>Nama:</strong> {{ $order->name }}</li>
                <li><strong>Phone:</strong> {{ $order->phone }}</li>
                <li><strong>Alamat:</strong> {{ $order->address }}</li>
                <li><strong>Status:</strong> {{ $order->status_label }}</li>
                <li><strong>Total:</strong> Rp {{ number_format($order->total, 0, ',', '.') }}</li>
                <li><strong>Note:</strong> {{ $order->notes }}</li>

            </ul>

            <hr class="my-4">

            <h4 class="font-semibold mb-2">Produk</h4>
            <ul class="text-sm space-y-1">
                @foreach ($order->items as $item)
                    <li>
                        {{ $item->product_name }} × {{ $item->quantity }}
                        (Rp {{ number_format($item->subtotal, 0, ',', '.') }})
                    </li>
                @endforeach
            </ul>
        </div>

        {{-- PAYMENT --}}
        <div class="bg-white p-6 rounded shadow">
            <h3 class="font-semibold mb-4">Pembayaran</h3>

            <img src="{{ asset('storage/' . $order->payment_proof) }}" class="rounded border mb-4 w-full">

            <form method="POST" action="{{ route('admin.orders.update-status', $order) }}">
                @csrf
                @method('PATCH')

                <label class="block text-sm font-medium mb-1">
                    Ubah Status
                </label>

                <select name="status" class="w-full border rounded p-2 mb-3">
                    @foreach (['pending', 'waiting_verification', 'paid', 'processed', 'completed', 'rejected'] as $status)
                        <option value="{{ $status }}" {{ $order->status === $status ? 'selected' : '' }}>
                            {{ ucfirst(str_replace('_', ' ', $status)) }}
                        </option>
                    @endforeach
                </select>

                <button class="bg-blue-600 text-white px-4 py-2 rounded">
                    Update Status
                </button>
            </form>
        </div>

    </div>

@endsection
