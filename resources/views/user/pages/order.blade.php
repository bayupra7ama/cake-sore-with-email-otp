@extends('user.layouts.app') @section('title', 'My Order') @section('content') @include('user.partials.breadcrumb', [
    'title' => 'My Order',
    'links' => [['label' => 'Home', 'url' => route('home')], ['label' => 'My Order', 'url' => null]],
]) <section
    class="shopping-cart spad">
    <div class="container">
        <div class="row mb-4">
            <div class="col-lg-12">
                <div class="order-status-carousel owl-carousel">

                    <a href="{{ route('user.order.index') }}" class="category-chip {{ !$status ? 'active' : '' }}">
                        Semua
                    </a>

                    <a href="{{ route('user.order.index', ['status' => 'pending']) }}"
                        class="category-chip {{ $status === 'pending' ? 'active' : '' }}">
                        Menunggu Pembayaran
                    </a>

                    <a href="{{ route('user.order.index', ['status' => 'waiting_verification']) }}"
                        class="category-chip {{ $status === 'waiting_verification' ? 'active' : '' }}">
                        Menunggu Verifikasi
                    </a>

                    <a href="{{ route('user.order.index', ['status' => 'paid']) }}"
                        class="category-chip {{ $status === 'paid' ? 'active' : '' }}">
                        Sudah Dibayar
                    </a>

                    <a href="{{ route('user.order.index', ['status' => 'processed']) }}"
                        class="category-chip {{ $status === 'processed' ? 'active' : '' }}">
                        Diproses
                    </a>

                    <a href="{{ route('user.order.index', ['status' => 'completed']) }}"
                        class="category-chip {{ $status === 'completed' ? 'active' : '' }}">
                        Selesai
                    </a>

                    <a href="{{ route('user.order.index', ['status' => 'rejected']) }}"
                        class="category-chip {{ $status === 'rejected' ? 'active' : '' }}">
                        Ditolak
                    </a>

                </div>
            </div>
        </div>

        <div class="shopping__cart__table table-responsive-mobile">
            <table class="order-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                        <tr>
                            <td data-label="Order">#{{ $order->id }}</td>
                            <td data-label="Total">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                            <td data-label="Status">
                                <span class="badge-status {{ $order->status }}">
                                    {{ $order->status_label }}
                                </span>
                            </td>
                            <td data-label="Aksi">
                                <button class="primary-btn btn-sm btn-detail" data-id="{{ $order->id }}">
                                    Detail
                                </button>
                            </td>
                        </tr>
                    @endforeach
                    
                </tbody>

            </table>
        </div>
    </div>
</section> {{-- MODAL --}} <div class="order-modal-overlay" id="orderModal">
    <div class="order-modal">
        <h4>Detail Order</h4>
        <ul class="order-detail-list" id="orderDetail"> {{-- injected by JS --}} </ul>
        <button class="site-btn btn-close-modal">Tutup</button>
    </div>
</div> @endsection
