@extends('user.layouts.app')

@section('title', 'Home')


@section('content')

    @include('user.partials.breadcrumb', [
        'title' => 'Product',
        'links' => [['label' => 'Home', 'url' => route('home')], ['label' => 'Product', 'url' => null]],
    ])

    <section class="shop spad">
        <div class="container">
            <div class="shop__option">
                <div class="row">
                    <div class="col-lg-7 col-md-7">
                        <div class="shop__option__search">
                            <form action="{{ route('shop') }}" method="GET">
                                <select name="category">
                                    <option value="">Categories</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ request('category') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>

                                <input type="text" name="q" value="{{ request('q') }}" placeholder="Search">
                                <button type="submit"><i class="fa fa-search"></i></button>
                            </form>

                        </div>
                    </div>
                    <div class="col-lg-5 col-md-5">
                        <div class="shop__option__right">
                            <select onchange="location = this.value;">
                                <option value="{{ route('shop') }}">Default sorting</option>
                                <option value="{{ route('shop', array_merge(request()->all(), ['sort' => 'az'])) }}">
                                    A to Z
                                </option>
                            </select>


                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                @forelse ($products as $product)
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="product__item">

                            @php
                                $image = $product->images->first();
                            @endphp
                            <a href="{{ route('product.detail', $product->slug) }}">

                                <div class="product__item__pic set-bg"
                                    data-setbg="{{ $image ? asset('storage/' . $image->image) : asset('template/img/shop/product-1.jpg') }}">

                                    <div class="product__label">
                                        <span>{{ $product->category?->name }}</span>
                                    </div>
                                </div>
                            </a>

                            <div class="product__item__text">
                                <h6>
                                    <a href="{{ route('product.detail', $product->slug) }}">
                                        {{ $product->name }}
                                    </a>
                                </h6>

                                <div class="product__item__price">
                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                </div>

                                <div class="cart_add">
                                    <form action="{{ route('user.cart.add') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <input type="hidden" name="quantity" value="1">

                                        <button type="submit" style="background:none;border:none;padding:0;color:inherit">
                                            Add to cart
                                        </button>
                                    </form>
                                </div>

                            </div>

                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center">
                        <p>Produk tidak ditemukan</p>
                    </div>
                @endforelse
            </div>

            <div class="shop__last__option">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        {{ $products->links('vendor.pagination.cake') }}
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <div class="shop__last__text">
                            <p>
                                Showing {{ $products->firstItem() }}–{{ $products->lastItem() }}
                                of {{ $products->total() }} results
                            </p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>


@endsection
