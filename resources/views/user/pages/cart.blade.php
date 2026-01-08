@extends('user.layouts.app')

@section('title', 'Cart')

@section('content')
    @include('user.partials.breadcrumb', [
        'title' => 'Cart',
        'links' => [['label' => 'Home', 'url' => route('home')], ['label' => 'Cart', 'url' => null]],
    ])

    <section class="shopping-cart spad">
        <div class="container">
            <div class="row">

                {{-- LEFT --}}
                <div class="col-lg-8">
                    <div class="shopping__cart__table">
                        <table>
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                    <th></th>
                                </tr>
                            </thead>

                            <tbody>
                                @php $subtotal = 0; @endphp

                                @forelse ($cart as $item)
                                    @php
                                        $itemTotal = $item['price'] * $item['quantity'];
                                        $subtotal += $itemTotal;
                                    @endphp

                                    <tr data-id="{{ $item['id'] }}">
                                        <td class="product__cart__item">
                                            <div class="product__cart__item__pic">
                                                <img
                                                    src="{{ $item['image'] ? asset('storage/' . $item['image']) : asset('template/img/shop/cart/cart-1.jpg') }}">
                                            </div>

                                            <div class="product__cart__item__text">
                                                <h6>{{ $item['name'] }}</h6>
                                                <h5>Rp {{ number_format($item['price'], 0, ',', '.') }}</h5>
                                            </div>
                                        </td>

                                        <td class="quantity__item">
                                            <div class="quantity">
                                                <div class="pro-qty">
                                                    <input type="number" class="cart-qty" min="1"
                                                        value="{{ $item['quantity'] }}" data-id="{{ $item['id'] }}"
                                                        data-price="{{ $item['price'] }}">
                                                </div>
                                            </div>
                                        </td>

                                        <td class="cart__price">
                                            Rp <span class="item-total">
                                                {{ number_format($itemTotal, 0, ',', '.') }}
                                            </span>
                                        </td>

                                        <td class="cart__close">
                                            <form action="{{ route('user.cart.remove', $item['id']) }}" method="POST">
                                                @csrf
                                                <button class="border-0 bg-transparent">
                                                    <span class="icon_close"></span>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>

                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-4">
                                            Cart kosong
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="continue__btn mt-3">
                        <a href="{{ route('shop') }}">Continue Shopping</a>
                    </div>
                </div>

                {{-- RIGHT --}}
                <div class="col-lg-4 mt-3">
                    <div class="cart__total">
                        <h6>Cart total</h6>
                        <ul>
                            <li>
                                Subtotal
                                <span id="cart-subtotal">
                                    Rp {{ number_format($subtotal, 0, ',', '.') }}
                                </span>
                            </li>
                            <li>
                                Total
                                <span id="cart-total">
                                    Rp {{ number_format($subtotal, 0, ',', '.') }}
                                </span>
                            </li>
                        </ul>

                        <a href="{{ route('user.checkout') }}" class="primary-btn">
                            Proceed to checkout
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </section>




@endsection
