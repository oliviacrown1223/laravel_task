<!DOCTYPE html>
<html>
<head>
    <title>Shop Products</title>

    @php
        $orderCount = \App\Models\Order::count(); // later filter by user
    @endphp

        <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
</head>

<body style="background:#f4f6fb;">

<!-- ================= NAVBAR ================= -->
<nav class="navbar navbar-expand-lg sticky-top"
     style="background: {{ $setting->theme_color ?? '#0d6efd' }}; box-shadow:0 4px 15px rgba(0,0,0,0.1);">

    <div class="container">

        <!-- Logo -->
        <a class="navbar-brand text-white fw-bold d-flex align-items-center" href="#">
            <img src="{{ asset('uploads/products/'.($setting->logo ?? 'default.png')) }}" height="40" class="me-2">
            MyShop
        </a>

        <!-- Toggle -->
        <button class="navbar-toggler bg-white" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Dynamic Header Menu -->
        <div class="collapse navbar-collapse" id="navMenu">
            <ul class="navbar-nav ms-auto align-items-center">

                @foreach($headerMenus as $menu)
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ url($menu->link) }}">
                            {{ $menu->name }}
                        </a>
                    </li>
                @endforeach
                    @php
                        $cart = session('cart', []);
                        $count = count($cart);
                    @endphp

                    <a href="{{ route('cart.index') }}" class="btn btn-light ms-3 position-relative">
                        Cart
                        <span class="position-absolute top-0 start-100 translate-middle badge bg-danger">
        {{ $count }}
    </span>
                    </a>
                    <li class="nav-item ms-3 position-relative">
                        <a href="{{ route('user.orders') }}" class="btn btn-light">
                            <i class="bi bi-bag"></i> Orders
                        </a>

                        <span class="position-absolute top-0 start-100 translate-middle badge bg-danger">
        {{ $orderCount }}
    </span>
                    </li>
                <!-- Login Button -->
                <li class="nav-item ms-3">
                    <a href="#" class="btn btn-light px-4 rounded-pill">
                        Login
                    </a>
                </li>

            </ul>
        </div>

    </div>
</nav>


<!-- ================= MAIN CONTENT ================= -->
<div class="container py-5">

    <!-- Title -->
    <h2 class="mb-4 fw-bold" style="color:#333;">Our Products</h2>

    <!-- Products -->
    <div class="row g-4">

        @foreach($product as $p)
            <div class="col-lg-3 col-md-4 col-sm-6">

                <div class="card border-0 shadow-sm h-100" style="border-radius:12px;">

                    <!-- Image -->
                    <img src="{{ $p->image ? asset('uploads/products/'.$p->image) : 'https://via.placeholder.com/300x200' }}"
                         class="card-img-top"
                         style="height:200px; object-fit:cover; border-radius:12px 12px 0 0;">
                    @php
                        $variant = \App\Models\ProductVariant::where('product_id', $p->id)->first();
                    @endphp

                    @if($variant && $variant->stock > 0)

                        <a href="{{ route('cart.add', [$p->id, $variant->value_id]) }}"
                           class="btn btn-primary w-100">
                            Add to Cart
                        </a>

                    @else

                        <button class="btn btn-secondary w-100" disabled>
                            Out of Stock
                        </button>

                    @endif

                </div>

            </div>
        @endforeach

    </div>

</div>


<!-- ================= FOOTER ================= -->
<footer style="background:#111; color:#ccc; padding:40px 0; margin-top:50px;">

    <div class="container text-center">

        <!-- Footer Menu -->
        <div class="mb-3">
            @foreach($footerMenus as $menu)
                <a href="{{ url($menu->link) }}" class="text-light me-3" style="text-decoration:none;">
                    {{ $menu->name }}
                </a>
            @endforeach
        </div>

        <!-- Copyright -->
        <p class="mb-0">
            © {{ date('Y') }} MyShop. All Rights Reserved.
        </p>

    </div>

</footer>


<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
