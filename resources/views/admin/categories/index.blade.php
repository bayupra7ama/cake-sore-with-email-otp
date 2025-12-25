@extends('layouts.admin')

@section('title', 'Category')

@section('content')

    @if (session('success'))
        <div class="mb-4 rounded bg-green-100 text-green-700 px-4 py-2">
            {{ session('success') }}
        </div>
    @endif

    <div class="flex justify-between items-center mb-4">
        <h2 class="text-lg font-semibold text-gray-800">
            Daftar Category
        </h2>

        <a href="{{ route('admin.categories.create') }}"
            class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
            + Tambah Category
        </a>
    </div>

    <div class="bg-white rounded-xl shadow overflow-hidden">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
                <tr>
                    <th class="px-6 py-3 text-left w-16">#</th>
                    <th class="px-6 py-3 text-left">Nama Category</th>
                    <th class="px-6 py-3 text-right w-32">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y">
                @forelse($categories as $item)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4">
                            {{ $loop->iteration }}
                        </td>

                        <td class="px-6 py-4 font-medium text-gray-800">
                            {{ $item->name }}
                        </td>

                        <td class="px-6 py-4">
                            <div class="flex justify-end gap-4">
                                <a href="{{ route('admin.categories.edit', $item) }}" class="text-blue-600 hover:underline">
                                    Edit
                                </a>

                                <form method="POST" action="{{ route('admin.categories.destroy', $item) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button onclick="return confirm('Hapus category ini?')"
                                        class="text-red-600 hover:underline">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="px-6 py-8 text-center text-gray-500">
                            Belum ada category
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

@endsection
