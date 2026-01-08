@extends('user.layouts.app')

@section('title', 'Home')

@section('content')

    @include('user.partials.breadcrumb', [
        'title' => 'Product Detail',
        'links' => [
            ['label' => 'Home', 'url' => route('home')],
            ['label' => 'Product', 'url' => route('shop')],
            ['label' => $product->name, 'url' => null],
        ],
    ])

    <section class="product-details spad">
        <div class="container">
            <div class="row">

                {{-- LEFT : IMAGE --}}
                <div class="col-lg-6">
                    <div class="product__details__img">

                        <div class="product__details__big__img">
                            @php
                                $images = $product->images;
                                $mainImage = $images->first();
                            @endphp

                            <img class="big_img"
                                src="{{ $mainImage ? asset('storage/' . $mainImage->image) : asset('template/img/shop/details/product-big-1.jpg') }}"
                                alt="">
                        </div>

                        <div class="product__details__thumb">
                            @foreach ($images as $key => $image)
                                <div class="pt__item {{ $key === 0 ? 'active' : '' }}">
                                    <img data-imgbigurl="{{ asset('storage/' . $image->image) }}"
                                        src="{{ asset('storage/' . $image->image) }}" alt="">
                                </div>
                            @endforeach
                        </div>

                    </div>
                </div>

                {{-- RIGHT : TEXT --}}
                <div class="col-lg-6">
                    <div class="product__details__text">

                        <div class="product__label">
                            {{ $product->category?->name }}
                        </div>

                        <h4>{{ $product->name }}</h4>

                        <h5>Rp {{ number_format($product->price, 0, ',', '.') }}</h5>


                        <ul>
                           
                            <li>Category: <span>{{ $product->category?->name }}</span></li>
                            <li>Stock: <span>{{ $product->stock }}</span></li>
                        </ul>

                        <div class="product__details__option">
                            <div class="quantity">
                                <div class="pro-qty">
                                    <input type="text" id="qty" value="1">
                                </div>
                            </div>

                            <a href="#" class="primary-btn" id="add-to-cart">
                                Add to cart
                            </a>
                        </div>

                        <form id="cart-form" action="{{ route('user.cart.add') }}" method="POST" style="display:none">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="hidden" name="quantity" id="qty-hidden">
                        </form>

                    </div>
                </div>

            </div>

            {{-- TAB --}}
            <div class="product__details__tab">
                <div class="col-lg-12">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#tabs-1" role="tab">
                                Description
                            </a>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane active" id="tabs-1">
                            <div class="row d-flex justify-content-center">
                                <div class="col-lg-8">
                                    <p>{{ $product->description }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </section>


    <!-- Related Products Section Begin -->
    <section class="related-products spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="section-title">
                        <h2>Related Products</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="related__products__slider owl-carousel">
                    @foreach ($relatedProducts as $related)
                        @php
                            $image = $related->images->first();
                        @endphp

                        <div class="col-lg-3">
                            <div class="product__item">
                                <div class="product__item__pic set-bg"
                                    data-setbg="{{ $image ? asset('storage/' . $image->image) : asset('template/img/shop/product-1.jpg') }}">
                                    <div class="product__label">
                                        <span>{{ $related->category?->name }}</span>
                                    </div>
                                </div>

                                <div class="product__item__text">
                                    <h6>
                                        <a href="{{ route('product.detail', $related->slug) }}">
                                            {{ $related->name }}
                                        </a>
                                    </h6>

                                    <div class="product__item__price">
                                        Rp {{ number_format($related->price, 0, ',', '.') }}
                                    </div>

                                    <div class="cart_add">
                                        <form action="{{ route('user.cart.add') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                                            <button type="submit" class="border-0 bg-transparent p-0">
                                                Add to cart
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>
        </div>
    </section>


@endsection
