@extends('layouts.admin')

@section('title', 'Pesanan')

@section('content')

    <div class="bg-white rounded-xl shadow p-6">

        {{-- HEADER --}}
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
            <h2 class="text-lg font-semibold">Daftar Pesanan</h2>

            {{-- FILTER STATUS --}}
            <form method="GET" class="flex gap-2">
                <select name="status" class="border rounded-lg px-3 py-2 text-sm">
                    <option value="">Semua Status</option>
                    <option value="pending" {{ $status === 'pending' ? 'selected' : '' }}>
                        Menunggu Pembayaran
                    </option>
                    <option value="waiting_verification" {{ $status === 'waiting_verification' ? 'selected' : '' }}>
                        Menunggu Verifikasi
                    </option>
                    <option value="paid" {{ $status === 'paid' ? 'selected' : '' }}>
                        Sudah Dibayar
                    </option>
                    <option value="processed" {{ $status === 'processed' ? 'selected' : '' }}>
                        Diproses
                    </option>
                    <option value="completed" {{ $status === 'completed' ? 'selected' : '' }}>
                        Selesai
                    </option>
                    <option value="rejected" {{ $status === 'rejected' ? 'selected' : '' }}>
                        Ditolak
                    </option>
                </select>

                <button class="bg-blue-600 text-white px-4 rounded-lg text-sm">
                    Filter
                </button>
            </form>
        </div>

        {{-- TABLE --}}
        <div class="overflow-x-auto">
            <table class="w-full text-sm border-collapse">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-3 text-left">No</th>
                        <th class="p-3 text-left">Nama</th>
                        <th class="p-3 text-left">Total</th>
                        <th class="p-3 text-left">Status</th>
                        <th class="p-3 text-left">Tanggal</th>
                        <th class="p-3 text-left">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($orders as $order)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="p-3">
                                {{ ($orders->currentPage() - 1) * $orders->perPage() + $loop->iteration }}
                            </td>
                            <td class="p-3 font-medium">
                                {{ $order->name }}
                            </td>
                            <td class="p-3">
                                Rp {{ number_format($order->total, 0, ',', '.') }}
                            </td>
                            <td class="p-3">
                                <span
                                    class="px-3 py-1 rounded-full text-xs font-semibold
                                @if ($order->status === 'pending') bg-yellow-100 text-yellow-700
                                @elseif($order->status === 'waiting_verification') bg-blue-100 text-blue-700
                                @elseif($order->status === 'paid') bg-green-100 text-green-700
                                @elseif($order->status === 'processed') bg-purple-100 text-purple-700
                                @elseif($order->status === 'completed') bg-emerald-100 text-emerald-700
                                @else bg-red-100 text-red-700 @endif">
                                    {{ $order->status_label }}
                                </span>
                            </td>
                            <td class="p-3 text-gray-600">
                                {{ $order->created_at->format('d M Y') }}
                            </td>
                            <td class="p-3">
                                <a href="{{ route('admin.orders.show', $order) }}"
                                    class="text-blue-600 hover:underline text-sm">
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-6 text-center text-gray-500">
                                Tidak ada pesanan
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- PAGINATION --}}
        <div class="mt-6">
            {{ $orders->links() }}
        </div>

    </div>

@endsection
