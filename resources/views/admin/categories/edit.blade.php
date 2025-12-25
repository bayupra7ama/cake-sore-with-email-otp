@extends('layouts.admin')

@section('title', 'Edit Category')

@section('content')

    <form method="POST" action="{{ route('admin.categories.update', $category) }}"
        class="bg-white p-6 rounded shadow max-w-md">
        @csrf
        @method('PUT')

        <label class="block mb-2">Nama Category</label>
        <input name="name" value="{{ $category->name }}" class="w-full border px-3 py-2 rounded" required>

        <button class="mt-4 bg-blue-600 text-white px-4 py-2 rounded">
            Update
        </button>
    </form>

@endsection
