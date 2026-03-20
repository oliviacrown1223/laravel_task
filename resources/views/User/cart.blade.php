@extends('layouts.app')

@section('content')

    @if(session('error'))
        <div class="container mt-3">
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        </div>
    @endif

    <div class="container py-5">

        <div class="row g-4">

            <!-- LEFT: CART ITEMS -->
            <div class="col-lg-8">

                <h4 class="mb-4 fw-bold">Shopping Cart</h4>

                @php $total = 0; @endphp

                @forelse($cart as $key => $item)

                    @php
                        $subtotal = $item['price'] * $item['qty'];
                        $total += $subtotal;
                    @endphp

                    <div class="card mb-3 border-0 shadow-sm rounded-4">
                        <div class="row g-0 align-items-center p-3">

                            <!-- Image -->
                            <div class="col-md-3 text-center">
                                <img src="{{ asset('uploads/products/'.$item['image']) }}"
                                     class="img-fluid rounded"
                                     style="height:120px; object-fit:cover;">
                            </div>

                            <!-- Details -->
                            <div class="col-md-4">
                                <h6 class="fw-semibold mb-1">{{ $item['name'] }}</h6>

                                @if(isset($item['stock']) && $item['stock'] > 0)
                                    <p class="text-success small mb-1">In Stock</p>
                                @else
                                    <p class="text-danger small mb-1">Out of Stock</p>
                                @endif

                                <small class="text-muted">₹ {{ $item['price'] }}</small>
                            </div>

                            <!-- Quantity -->
                            <div class="col-md-3 text-center">

                                <div class="d-inline-flex align-items-center border rounded-pill px-2">

                                    <!-- MINUS -->
                                    <a href="{{ route('cart.decrease', $key) }}"
                                       class="btn btn-sm">−</a>

                                    <!-- QTY -->
                                    <span class="mx-2 fw-bold">
                                    {{ $item['qty'] }}
                                </span>

                                    <!-- PLUS -->
                                    @if(isset($item['stock']) && $item['qty'] < $item['stock'])
                                        <a href="{{ route('cart.increase', $key) }}"
                                           class="btn btn-sm">+</a>
                                    @else
                                        <button class="btn btn-sm" disabled>+</button>
                                    @endif

                                </div>

                                <!-- STOCK MESSAGE -->
                                @if(isset($item['stock']) && $item['qty'] >= $item['stock'])
                                    <div class="text-danger small mt-1">
                                        Stock not available
                                    </div>
                                @endif

                            </div>

                            <!-- Price + Remove -->
                            <div class="col-md-2 text-end">

                                <h6 class="fw-bold mb-2">₹ {{ $subtotal }}</h6>

                                <a href="{{ route('cart.remove', $key) }}"
                                   class="text-danger small"
                                   onclick="return confirm('Remove item?')">
                                    Remove
                                </a>

                            </div>

                        </div>
                    </div>

                @empty

                    <div class="text-center p-5">
                        <h5>Your cart is empty 😢</h5>
                        <a href="/" class="btn btn-primary mt-3 rounded-pill">
                            Continue Shopping
                        </a>
                    </div>

                @endforelse

            </div>

            <!-- RIGHT: SUMMARY -->
            <div class="col-lg-4">

                <div class="card shadow-sm border-0 p-4 rounded-4">

                    <h5 class="fw-bold mb-3">Order Summary</h5>

                    <hr>

                    <p class="d-flex justify-content-between">
                        <span>Subtotal</span>
                        <strong>₹ {{ $total }}</strong>
                    </p>

                    <p class="d-flex justify-content-between">
                        <span>Delivery</span>
                        <span class="text-success">Free</span>
                    </p>

                    <hr>

                    <h5 class="d-flex justify-content-between">
                        <span>Total</span>
                        <strong>₹ {{ $total }}</strong>
                    </h5>

                    <a href="{{ route('checkout') }}" class="btn btn-warning w-100 mt-3 rounded-pill">
                        Proceed to Checkout
                    </a>

                </div>

            </div>

        </div>

    </div>

@endsection
