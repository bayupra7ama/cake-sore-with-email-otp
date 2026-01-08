<header class="header">
    <div class="header__top">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="header__top__inner">

                        {{-- LEFT --}}
                        <div class="header__top__left">
                            <ul>
                                <li>IDR <span></span></li>

                                @guest
                                    <li>
                                        <a href="{{ route('login') }}">Sign in</a>
                                    </li>
                                @endguest

                                @auth
                                    <li>
                                        Halo, <strong>{{ auth()->user()->name }}</strong>
                                    </li>

                                    <li>
                                        <a href="#"
                                            onclick="event.preventDefault(); document.getElementById('logout-form-desktop').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form-desktop" action="{{ route('logout') }}" method="POST"
                                            style="display:none;">
                                            @csrf
                                        </form>
                                    </li>
                                @endauth
                            </ul>
                        </div>

                        {{-- LOGO --}}
                        <div class="header__logo">
                            <a href="{{ route('home') }}">
                                <img src="{{ asset('images/logo.png') }}" alt="">
                            </a>
                        </div>

                        {{-- RIGHT --}}
                        <div class="header__top__right">
                            <div class="header__top__right__cart">
                                <a href="{{ route('user.cart') }}">
                                    <img src="{{ asset('template/img/icon/cart.png') }}" alt="">
                                    <span>0</span>
                                </a>
                                <div class="cart__price">Cart</div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="canvas__open"><i class="fa fa-bars"></i></div>
        </div>
    </div>

    {{-- MENU --}}
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <nav class="header__menu mobile-menu">
                    <ul>
                        <li class="{{ request()->routeIs('home') ? 'active' : '' }}">
                            <a href="{{ route('home') }}">Home</a>
                        </li>

                        <li class="{{ request()->routeIs('shop') ? 'active' : '' }}">
                            <a href="{{ route('shop') }}">Product</a>
                        </li>

                        <li class="{{ request()->routeIs('user.order.*') ? 'active' : '' }}">
                            <a href="{{ route('user.order.index') }}">Pesanan Saya</a>
                        </li>

                    </ul>
                </nav>
            </div>
        </div>
    </div>
</header>
