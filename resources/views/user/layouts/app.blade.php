<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Raninsha Kitchen')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- GOOGLE FONT (ASLI TEMPLATE) --}}
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    {{-- CSS TEMPLATE (LENGKAP & URUT) --}}
    <link rel="stylesheet" href="{{ asset('template/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('template/css/flaticon.css') }}">
    <link rel="stylesheet" href="{{ asset('template/css/barfiller.css') }}">
    <link rel="stylesheet" href="{{ asset('template/css/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('template/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('template/css/elegant-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('template/css/nice-select.css') }}">
    <link rel="stylesheet" href="{{ asset('template/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('template/css/slicknav.min.css') }}">
    <link rel="stylesheet" href="{{ asset('template/css/style.css') }}">
</head>

<body>

    {{-- PRELOADER (ASLI TEMPLATE) --}}
    <div id="preloder">
        <div class="loader"></div>
    </div>

    {{-- OFFCANVAS MENU --}}
    @include('user.partials.offcanvas')

    {{-- HEADER --}}
    @include('user.partials.header')

    {{-- ISI HALAMAN --}}
    @yield('content')

    {{-- FOOTER --}}
    @include('user.partials.footer')

    {{-- SEARCH MODAL --}}
    @include('user.partials.search')
    @if (session('success'))
        <div class="toast toast-success" id="toast">
            <span class="toast-icon">✔</span>
            <span class="toast-text">{{ session('success') }}</span>
            <button class="toast-close" onclick="closeToast()">×</button>
        </div>
    @endif

    @if (session('error'))
        <div class="toast toast-error" id="toast">
            <span class="toast-icon">✖</span>
            <span class="toast-text">{{ session('error') }}</span>
            <button class="toast-close" onclick="closeToast()">×</button>
        </div>
    @endif

    <script>
        const toast = document.getElementById('toast');

        function closeToast() {
            if (!toast) return;
            toast.style.opacity = '0';
            toast.style.transform = 'translateY(-10px)';
            setTimeout(() => toast.remove(), 300);
        }

        if (toast) {
            setTimeout(() => {
                closeToast();
            }, 4000);
        }
    </script>


    {{-- JS TEMPLATE (WAJIB LENGKAP & URUT) --}}
    <script src="{{ asset('template/js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('template/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('template/js/jquery.nice-select.min.js') }}"></script>
    <script src="{{ asset('template/js/jquery.barfiller.js') }}"></script>
    <script src="{{ asset('template/js/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('template/js/jquery.slicknav.js') }}"></script>
    <script src="{{ asset('template/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('template/js/jquery.nicescroll.min.js') }}"></script>
    <script src="{{ asset('template/js/main.js') }}"></script>
    <script src="{{ asset('template/js/custom.js') }}"></script>

</body>

</html>
