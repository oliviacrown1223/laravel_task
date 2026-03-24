{{--
@extends('User.layouts.app')

@section('main')
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
@endsection



--}}
{{-- resources/views/User/home.blade.php --}}
    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop Products</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    @stack('css')
</head>
<body>

<!-- Header -->
@include('User.particles.header')

<!-- Main Content -->
<div class="main">
    <div class="container py-5">
        @if(session('cart_empty'))
            <div class="position-fixed top-0 start-50 translate-middle-x mt-4" style="z-index: 9999;">
                <div class="alert alert-warning shadow-lg rounded-4 px-4 py-3 text-center">
                    🛒 Your cart is empty! Please add products first.
                </div>
            </div>
        @endif
        <!-- Title -->
        <h2 class="mb-4 fw-bold text-dark">Our Products</h2>

        <!-- Products Grid -->
        <div class="row g-4">
            @foreach($product as $p)
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="card border-0 shadow-sm h-100" style="border-radius:12px;">

                        <!-- Product Image -->
                        <img src="{{ $p->image ? asset('uploads/products/'.$p->image) : 'https://via.placeholder.com/300x200' }}"
                             class="card-img-top"
                             style="height:200px; object-fit:cover; border-radius:12px 12px 0 0;">

                        <div class="card-body d-flex flex-column">
                            <!-- Product Name -->
                            <h5 class="card-title">{{ $p->name }}</h5>

                            <!-- Product Price -->
                            <p class="card-text fw-bold mb-3">₹{{ number_format($p->price, 2) }}</p>

                            @php
                                $variant = \App\Models\ProductVariant::where('product_id', $p->id)->first();
                            @endphp

                            @if($variant && $variant->stock > 0)
                                <a href="{{ route('cart.add', [$p->id, $variant->value_id]) }}" class="btn btn-primary mt-auto w-100">
                                    Add to Cart
                                </a>
                            @else
                                <button class="btn btn-secondary mt-auto w-100" disabled>
                                    Out of Stock
                                </button>
                            @endif
                        </div>

                    </div>
                </div>
            @endforeach
        </div>

    </div>
</div>

<!-- Footer -->
@include('User.particles.footer')

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
