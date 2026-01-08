@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')

    {{-- SUMMARY CARDS --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">

        <a href="{{ route('admin.products.index') }}" class="block bg-white p-5 rounded shadow hover:shadow-md transition">
            <p class="text-sm text-gray-500">Total Produk</p>
            <h3 class="text-2xl font-bold">{{ $totalProducts }}</h3>
        </a>


        <a href="{{ route('admin.categories.index') }}" class="block bg-white p-5 rounded shadow hover:shadow-md transition">
            <p class="text-sm text-gray-500">Kategori</p>
            <h3 class="text-2xl font-bold">{{ $totalCategories }}</h3>
        </a>


        <a href="{{ route('admin.orders.index') }}" class="block bg-white p-5 rounded shadow hover:shadow-md transition">
            <p class="text-sm text-gray-500">Total Pesanan</p>
            <h3 class="text-2xl font-bold">{{ $totalOrders }}</h3>
        </a>


        <div class="bg-white p-5 rounded shadow">
            <p class="text-sm text-gray-500">Omzet</p>
            <h3 class="text-2xl font-bold">
                Rp {{ number_format($totalRevenue, 0, ',', '.') }}
            </h3>
        </div>

    </div>

    {{-- STATUS ORDER --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        {{-- <div class="bg-white p-5 rounded shadow">
            <p class="text-sm text-gray-500">Pending</p>
            <h3 class="text-2xl font-bold text-yellow-600">
                {{ $pendingOrders }}
            </h3>
        </div> --}}

        <a href="{{ route('admin.orders.index', ['status' => 'waiting_verification']) }}"
            class="block bg-white p-5 rounded shadow hover:shadow-md transition">
            <p class="text-sm text-gray-500">Menunggu Verifikasi</p>
            <h3 class="text-2xl font-bold text-blue-600">
                {{ $waitingVerification }}
            </h3>
        </a>

    </div>

    {{-- LATEST ORDERS --}}
    <div class="bg-white rounded shadow">
        <div class="p-5 border-b font-semibold">
            Order Terbaru
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-left">
                    <tr>
                        <th class="p-3">No</th>
                        <th class="p-3">Nama</th>
                        <th class="p-3">Total</th>
                        <th class="p-3">Status</th>
                        <th class="p-3">Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($latestOrders as $order)
                        <tr class="border-t">
                            <td class="p-3">#{{ $order->id }}</td>
                            <td class="p-3">{{ $order->name }}</td>
                            <td class="p-3">
                                Rp {{ number_format($order->total, 0, ',', '.') }}
                            </td>
                            <td class="p-3 capitalize">
                                {{ str_replace('_', ' ', $order->status) }}
                            </td>
                            <td class="p-3">
                                {{ $order->created_at->format('d M Y') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-4 text-center text-gray-500">
                                Belum ada order
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection
