@extends('layouts.admin')

@section('title', 'Tambah Category')

@section('content')

    <form method="POST" action="{{ route('admin.categories.store') }}" class="bg-white p-6 rounded shadow max-w-md">
        @csrf

        <label class="block mb-2">Nama Category</label>
        <input name="name" class="w-full border px-3 py-2 rounded" required>

        <button class="mt-4 bg-blue-600 text-white px-4 py-2 rounded">
            Simpan
        </button>
    </form>

@endsection
