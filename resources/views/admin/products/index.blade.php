@extends('layouts.admin')

@section('title', 'Produk')

@section('content')

    @if (session('success'))
        <div class="mb-4 bg-green-100 text-green-700 px-4 py-2 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="flex justify-between items-center mb-4">
        <h2 class="text-lg font-semibold text-gray-800">Daftar Produk</h2>

        <a href="{{ route('admin.products.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            + Tambah Produk
        </a>
    </div>

    <div class="bg-white rounded-xl shadow overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
                <tr>
                    <th class="px-6 py-3 text-left w-12">#</th>
                    <th class="px-6 py-3 text-left">Nama Produk</th>
                    <th class="px-6 py-3 text-left">Kategori</th>
                    <th class="px-6 py-3 text-left">Harga</th>
                    <th class="px-6 py-3 text-left">Stok</th>
                    <th class="px-6 py-3 text-right w-32">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y">
                @forelse ($products as $item)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            {{ $loop->iteration }}
                        </td>

                        <td class="px-6 py-4 font-medium text-gray-800">
                            {{ $item->name }}
                        </td>

                        <td class="px-6 py-4">
                            {{ $item->category?->name ?? '-' }}
                        </td>

                        <td class="px-6 py-4">
                            Rp {{ number_format($item->price, 0, ',', '.') }}
                        </td>

                        <td class="px-6 py-4">
                            {{ $item->stock }}
                        </td>

                        <td class="px-6 py-4">
                            <div class="flex justify-end gap-3">
                                <a href="{{ route('admin.products.edit', $item) }}" class="text-blue-600 hover:underline">
                                    Edit
                                </a>

                                <form method="POST" action="{{ route('admin.products.destroy', $item) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button onclick="return confirm('Hapus produk ini?')"
                                        class="text-red-600 hover:underline">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                            Belum ada produk
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

@endsection
