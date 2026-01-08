<section class="product spad">
    <div class="container">
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

    </div>
</section>
