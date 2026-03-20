{{--
<!DOCTYPE html>
<html>
<head>
    <title>MyShop</title>

    @php
        $setting = \App\Models\Setting::first();
        $headerMenus = \App\Models\Menu::where('type','header')->get();
    @endphp

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg" style="background: {{ $setting->theme_color ?? '#0d6efd' }}">
    <div class="container">

        <!-- LOGO -->
        <a class="navbar-brand" href="/">
            <img src="{{ asset('uploads/products/'.($setting->logo ?? 'default.png')) }}?v={{ time() }}"
                 height="50" alt="Logo">
        </a>

        <div class="ms-auto">

            @php $count = count(session('cart', [])); @endphp

            <a href="{{ route('cart.index') }}" class="btn btn-light">
                Cart ({{ $count }})
            </a>

        </div>
    </div>
</nav>

<!-- MAIN CONTENT -->
@yield('content')

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
--}}
    <!DOCTYPE html>
<html>
<head>
    <title>MyShop</title>

    @php
        $setting = \App\Models\Setting::first();
        $headerMenus = \App\Models\Menu::where('type','header')->get();
        $cart = session('cart', []);
        $count = count($cart);

        // optional (later filter by user)
        $orderCount = \App\Models\Order::count();
    @endphp

        <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body style="background:#f4f6fb;">

<!-- ================= NAVBAR ================= -->
<nav class="navbar navbar-expand-lg shadow-sm"
     style="background: {{ $setting->theme_color ?? '#0d6efd' }}">

    <div class="container">

        <!-- LOGO -->
        <a class="navbar-brand d-flex align-items-center text-white fw-bold" href="/">
            <img src="{{ asset('uploads/products/'.($setting->logo ?? 'default.png')) }}?v={{ time() }}"
                 height="40" class="me-2">
            MyShop
        </a>

        <!-- TOGGLE -->
        <button class="navbar-toggler bg-white" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- MENU -->
        <div class="collapse navbar-collapse" id="navMenu">
            <ul class="navbar-nav ms-auto align-items-center">

                <!-- Dynamic Menus -->
                @foreach($headerMenus as $menu)
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ url($menu->link) }}">
                            {{ $menu->name }}
                        </a>
                    </li>
                @endforeach

                <!-- Home -->
                <li class="nav-item">
                    <a class="nav-link text-white" href="{{ route('home') }}">
                        <i class="bi bi-house"></i> Home
                    </a>
                </li>

                @php
                    $cart = session('cart', []);
                    $count = count($cart);
                    $orderCount = \App\Models\Order::count(); // Optional: filter per user_id later
                @endphp

                    <!-- Cart -->
                <li class="nav-item ms-3 position-relative">
                    <a href="{{ route('cart.index') }}" class="btn btn-light">
                        <i class="bi bi-cart"></i> Cart
                    </a>
                    <span class="position-absolute top-0 start-100 translate-middle badge bg-danger">
            {{ $count }}
        </span>
                </li>

                <!-- My Orders -->
                <li class="nav-item ms-3 position-relative">
                    <a href="{{ route('user.orders') }}" class="btn btn-light">
                        <i class="bi bi-bag"></i> Orders
                    </a>
                    <span class="position-absolute top-0 start-100 translate-middle badge bg-success">
            {{ $orderCount }}
        </span>
                </li>

                <!-- Login -->
                <li class="nav-item ms-3">
                    <a href="#" class="btn btn-dark rounded-pill px-4">
                        Login
                    </a>
                </li>

            </ul>
        </div>

    </div>
</nav>

<!-- ================= CONTENT ================= -->
<div class="container py-4">
    @yield('content')
</div>

<!-- ================= FOOTER ================= -->
<footer class="text-center py-4 mt-5" style="background:#111; color:#ccc;">
    © {{ date('Y') }} MyShop. All Rights Reserved.
</footer>

<!-- JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
