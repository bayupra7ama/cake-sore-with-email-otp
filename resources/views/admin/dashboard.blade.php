@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        <div class="bg-white p-6 rounded shadow">
            <p class="text-sm text-gray-500">Total Produk</p>
            <p class="text-2xl font-bold">0</p>
        </div>

        <div class="bg-white p-6 rounded shadow">
            <p class="text-sm text-gray-500">Pesanan Masuk</p>
            <p class="text-2xl font-bold">0</p>
        </div>

        <div class="bg-white p-6 rounded shadow">
            <p class="text-sm text-gray-500">Menunggu Validasi</p>
            <p class="text-2xl font-bold">0</p>
        </div>

    </div>
@endsection
