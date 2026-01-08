@extends('user.layouts.app')

@section('title', 'Checkout')

@section('content')

    <section class="checkout spad">
        <div class="container">
            <div class="checkout__form">
                <form action="{{ route('user.order.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row">

                        {{-- ================= LEFT ================= --}}
                        <div class="col-lg-8 col-md-6">

                            <h6 class="checkout__title">Data Pemesan</h6>

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="checkout__input">
                                        <p>Nama Lengkap<span>*</span></p>
                                        <input type="text" name="name" required>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="checkout__input">
                                        <p>No. WhatsApp<span>*</span></p>
                                        <input type="text" name="phone" required>
                                    </div>
                                </div>
                            </div>

                            <div class="checkout__input">
                                <p>Alamat Lengkap<span>*</span></p>
                                <input type="text" name="address" placeholder="Alamat lengkap pengiriman" required>
                            </div>

                            <div class="checkout__input">
                                <p>Catatan Pesanan</p>
                                <input type="text" name="notes" placeholder="Contoh: kirim sore hari">
                            </div>

                            {{-- ================= PAYMENT METHOD ================= --}}
                            <h6 class="checkout__title mt-4">Metode Pembayaran</h6>

                            <div class="checkout__input__checkbox">
                                <label>
                                    <input type="radio" name="payment_method" value="bca" required>
                                    <span class="checkmark"></span>
                                    Transfer Bank BCA
                                </label>
                            </div>

                            <div class="checkout__input__checkbox">
                                <label>
                                    <input type="radio" name="payment_method" value="bri">
                                    <span class="checkmark"></span>
                                    Transfer Bank BRI
                                </label>
                            </div>

                            <div class="checkout__input__checkbox">
                                <label>
                                    <input type="radio" name="payment_method" value="dana">
                                    <span class="checkmark"></span>
                                    DANA
                                </label>
                            </div>

                            {{-- ================= REKENING INFO ================= --}}
                            <div class="checkout__input mt-3" id="rekening-info" style="display:none;">
                                <p>Silakan transfer ke rekening berikut:</p>

                                <div class="p-3 border rounded bg-light">
                                    <p class="mb-1"><strong id="bank-name"></strong></p>
                                    <p class="mb-1">No. Rekening: <strong id="bank-number"></strong></p>
                                    <p class="mb-0">Atas Nama: <strong>Raninsha Kitchen</strong></p>
                                </div>
                            </div>

                            {{-- ================= UPLOAD BUKTI ================= --}}
                            <div class="checkout__input mt-4">
                                <p>Upload Bukti Pembayaran<span>*</span></p>
                                <input type="file" name="payment_proof" accept="image/*" required>
                            </div>

                        </div>

                        {{-- ================= RIGHT ================= --}}
                        <div class="col-lg-4 col-md-6">
                            <div class="checkout__order">
                                <h6 class="order__title">Ringkasan Pesanan</h6>

                                <div class="checkout__order__products">
                                    Produk <span>Total</span>
                                </div>

                                <ul class="checkout__total__products">
                                    @foreach ($cart as $item)
                                        <li>
                                            {{ $item['quantity'] }} x {{ $item['name'] }}
                                            <span>
                                                Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}
                                            </span>
                                        </li>
                                    @endforeach
                                </ul>

                                <ul class="checkout__total__all">
                                    <li>
                                        Total
                                        <span>
                                            Rp {{ number_format($subtotal, 0, ',', '.') }}
                                        </span>
                                    </li>
                                </ul>

                                <button type="submit" class="site-btn">
                                    Kirim Pesanan
                                </button>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </section>

    {{-- ================= SCRIPT ================= --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {

            const rekeningInfo = document.getElementById('rekening-info');
            const bankName = document.getElementById('bank-name');
            const bankNumber = document.getElementById('bank-number');

            const rekening = {
                bca: {
                    name: 'Bank BCA',
                    number: '1234567890'
                },
                bri: {
                    name: 'Bank BRI',
                    number: '0987654321'
                },
                dana: {
                    name: 'DANA',
                    number: '0822-1449-1448'
                }
            };

            document.querySelectorAll('input[name="payment_method"]').forEach(radio => {
                radio.addEventListener('change', function() {
                    const data = rekening[this.value];
                    rekeningInfo.style.display = 'block';
                    bankName.innerText = data.name;
                    bankNumber.innerText = data.number;
                });
            });

        });
    </script>

@endsection
