@extends('layouts.admin')

@section('title', 'Edit Produk')

@section('content')

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <div class="max-w-5xl mx-auto bg-white rounded-xl border p-6">

        <h1 class="text-2xl font-bold mb-6">Edit Produk</h1>

        @if (session('success'))
            <div class="mb-4 bg-green-100 text-green-700 px-4 py-2 rounded">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data"
            class="space-y-6">

            @csrf
            @method('PUT')

            {{-- CATEGORY --}}
            <div>
                <label class="font-medium">Category</label>
                <select name="category_id" class="w-full mt-1 p-2 border rounded">
                    <option value="">None</option>
                    @foreach ($categories as $cat)
                        <option value="{{ $cat->id }}" {{ $product->category_id == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- NAME --}}
            <div>
                <label class="font-medium">Nama Produk</label>
                <input name="name" value="{{ $product->name }}" class="w-full mt-1 p-2 border rounded" required>
            </div>

            {{-- DESCRIPTION --}}
            <div>
                <label class="font-medium">Deskripsi</label>
                <textarea name="description" class="w-full mt-1 p-2 border rounded" rows="4">{{ $product->description }}</textarea>
            </div>

            {{-- PRICE & STOCK --}}
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="font-medium">Harga</label>
                    <input type="number" name="price" value="{{ $product->price }}"
                        class="w-full mt-1 p-2 border rounded">
                </div>

                <div>
                    <label class="font-medium">Stok</label>
                    <input type="number" name="stock" value="{{ $product->stock }}"
                        class="w-full mt-1 p-2 border rounded">
                </div>
            </div>

            {{-- GALLERY --}}
            <div class="space-y-3">
                <label class="font-medium">Gallery</label>

                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3">
                    @foreach ($product->images as $img)
                        <div class="relative" data-image-id="{{ $img->id }}">
                            <img src="{{ asset('storage/' . $img->image) }}" class="h-24 w-full object-cover rounded border">

                            <button type="button"
                                data-url="{{ route('admin.products.image.delete', [$product->id, $img->id]) }}"
                                class="delete-image absolute top-1 right-1
                                   bg-red-600 text-white text-xs px-2 py-1 rounded">
                                Hapus
                            </button>
                        </div>
                    @endforeach
                </div>

                <input type="file" name="images[]" multiple class="w-full p-2 border rounded">
            </div>

            <button class="px-6 py-2 bg-blue-600 text-white rounded">
                Update Produk
            </button>

        </form>
    </div>

    {{-- DELETE IMAGE AJAX --}}
    <script>
        document.querySelectorAll('.delete-image').forEach(btn => {
            btn.addEventListener('click', async () => {

                if (!confirm('Hapus gambar ini?')) return;

                const res = await fetch(btn.dataset.url, {
                    method: 'DELETE',
                    credentials: 'same-origin', // 🔥 PENTING
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                            .content,
                        'Accept': 'application/json'
                    }
                });

                if (res.ok) {
                    btn.closest('[data-image-id]').remove();
                } else {
                    alert('Gagal hapus gambar');
                }
            });
        });
    </script>

@endsection
