<div class="offcanvas-menu-overlay"></div>
<div class="offcanvas-menu-wrapper">
    <div class="offcanvas__logo">
        <a href="{{ route('home') }}">
            <img src="{{ asset('images\logo.png') }}" alt="">
        </a>
    </div>

    <div class="offcanvas__cart">

        <div class="offcanvas__cart__item">
            <a href="{{ route('user.cart') }}">
                <img src="{{ asset('template/img/icon/cart.png') }}" alt="">
                <span>0</span>
            </a>
            <div class="cart__price">Cart</div>
        </div>
    </div>


    <div id="mobile-menu-wrap"></div>

    <div class="offcanvas__option">
        <ul>


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
                        onclick="event.preventDefault(); document.getElementById('logout-form-mobile').submit();">
                        Logout
                    </a>

                    <form id="logout-form-mobile" action="{{ route('logout') }}" method="POST" style="display:none;">
                        @csrf
                    </form>
                </li>
            @endauth
        </ul>
    </div>
</div>
