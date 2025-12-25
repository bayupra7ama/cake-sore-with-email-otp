@extends('layouts.admin')

@section('title', 'Tambah Produk')

@section('content')

    <div class="max-w-3xl bg-white p-6 rounded-xl shadow">

        <h2 class="text-lg font-semibold mb-6">Tambah Produk</h2>

        <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm mb-1">Nama Produk</label>
                <input name="name" class="w-full border px-3 py-2 rounded" required>
            </div>

            <div>
                <label class="block text-sm mb-1">Category</label>
                <select name="category_id" class="w-full border px-3 py-2 rounded">
                    <option value="">-- Tanpa Category --</option>
                    @foreach ($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm mb-1">Harga</label>
                <input type="number" name="price" class="w-full border px-3 py-2 rounded" required>
            </div>

            <div>
                <label class="block text-sm mb-1">Stok</label>
                <input type="number" name="stock" class="w-full border px-3 py-2 rounded" required>
            </div>

            <div>
                <label class="block text-sm mb-1">Deskripsi</label>
                <textarea name="description" rows="4" class="w-full border px-3 py-2 rounded"></textarea>
            </div>

            <div>
                <label class="block text-sm mb-1">Gambar Produk (bisa lebih dari 1)</label>
                <input type="file" name="images[]" multiple class="w-full border px-3 py-2 rounded" required>
            </div>

            <div class="flex gap-3 pt-4">
                <button class="bg-blue-600 text-white px-6 py-2 rounded">
                    Simpan
                </button>

                <a href="{{ route('admin.products.index') }}" class="px-6 py-2 border rounded">
                    Batal
                </a>
            </div>
        </form>
    </div>

@endsection
