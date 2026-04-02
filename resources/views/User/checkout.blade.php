@extends('User.layouts.app')

@section('content')

    @php
        $customer = session()->get('customer');
    @endphp
<style>
    .payment-option {
        display: flex;
        align-items: center;
        gap: 12px;
        border: 1px solid #ddd;
        padding: 15px;
        border-radius: 10px;
        cursor: pointer;
        margin-bottom: 10px;
        transition: 0.3s;
    }

    .payment-option:hover {
        background: #f8f9fa;
    }

    .payment-option input {
        transform: scale(1.2);
        cursor: pointer;
    }

    .payment-option.active {
        border: 2px solid #0d6efd;
        background: #eef4ff;
    }
</style>
    <div class="container py-5">

        <div class="row g-4">

            <!-- ================= LEFT: CHECKOUT FORM ================= -->
            <div class="col-lg-7">

                <div class="card border-0 shadow-lg rounded-4 p-4 checkout-card">

                    <h4 class="mb-4 fw-bold">🧾 Checkout Details</h4>

                    {{-- Alerts --}}
                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <form action="{{ route('checkout.place') }}" method="POST" id="checkoutForm">
                        @csrf

                        <!-- Name -->
                        <div class="form-floating mb-3">
                            <input type="text" name="name"
                                   class="form-control @error('name') is-invalid @enderror"
                                   value="{{ old('name', $customer->name ?? '') }}" readonly>
                            <label>Full Name</label>
                        </div>
                        @error('name') <small class="text-danger">{{ $message }}</small> @enderror

                        <!-- Phone -->
                        <div class="input-group mb-3">
                            <span class="input-group-text bg-light">+91</span>
                            <div class="form-floating">
                                <input type="text" name="phone"
                                       class="form-control @error('phone') is-invalid @enderror"
                                       value="{{ old('phone', $customer->phone ?? '') }}" readonly>
                                <label>Phone Number</label>
                            </div>
                        </div>
                        @error('phone') <small class="text-danger">{{ $message }}</small> @enderror

                        <!-- Address -->
                        <div class="form-floating mb-3">
                        <textarea name="address"
                                  class="form-control @error('address') is-invalid @enderror"
                                  style="height:100px">{{ old('address') }}</textarea>
                            <label>Delivery Address</label>
                        </div>
                        @error('address') <small class="text-danger">{{ $message }}</small> @enderror

                        <!-- Email -->
                        <div class="form-floating mb-3">
                            <input type="email" name="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   value="{{ old('email', $customer->email ?? '') }}" readonly>
                            <label>Email Address</label>
                        </div>
                        @error('email') <small class="text-danger">{{ $message }}</small> @enderror

                        <!-- Pincode -->
                        <div class="form-floating mb-3">
                            <input type="number" name="pincode"
                                   class="form-control @error('pincode') is-invalid @enderror"
                                   value="{{ old('pincode') }}">
                            <label>Pincode</label>
                        </div>
                        @error('pincode') <small class="text-danger">{{ $message }}</small> @enderror

                        <!-- Payment Type -->
                        <div class="mb-4">
                            <label class="fw-bold mb-2">Payment Method</label>

                            <label class="payment-option">
                                <input type="radio" name="payment_type" value="cod"
                                    {{ old('payment_type')=='cod'?'checked':'' }}>

                                <div class="payment-content">
                                    <strong>Cash on Delivery</strong>
                                    <small class="text-muted d-block">Pay when product arrives</small>
                                </div>
                            </label>

                            <label class="payment-option">
                                <input type="radio" name="payment_type" value="online"
                                    {{ old('payment_type')=='online'?'checked':'' }}>

                                <div class="payment-content">
                                    <strong>Online Payment</strong>
                                    <small class="text-muted d-block">Secure payment via Stripe</small>
                                </div>
                            </label>

                            @error('payment_type')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-3 fw-bold" id="placeOrderBtn">
                            Place Order
                        </button>

                    </form>
                </div>
            </div>

            <!-- ================= RIGHT: ORDER SUMMARY ================= -->

            <div class="col-lg-5">

                <div class="card border-0 shadow-lg rounded-4 p-4 position-sticky" style="top:20px">

                    <h5 class="fw-bold mb-3">Order Summary</h5>

                    @php $total = 0; @endphp

                    @foreach($cart as $item)
                        @php $total += $item['price'] * $item['qty']; @endphp

                        <div class="d-flex justify-content-between mb-2">
                            <span>{{ $item['name'] }} x{{ $item['qty'] }}</span>
                            <span>₹{{ $item['price'] * $item['qty'] }}</span>
                        </div>
                    @endforeach

                    <hr>

                    @php
                        $discount = 0;

                        if(session('coupon')){
                            $coupon = session('coupon');

                            $discount = $coupon['type']=='percentage'
                                ? ($total * $coupon['discount']) / 100
                                : $coupon['discount'];
                        }

                        $finalTotal = $total - $discount;
                    @endphp

                    <div class="d-flex justify-content-between">
                        <span>Subtotal</span>
                        <span>₹{{ $total }}</span>
                    </div>

                    <div class="d-flex justify-content-between text-success">
                        <span>Discount</span>
                        <span>- ₹{{ $discount }}</span>
                    </div>

                    <hr>

                    <h5 class="d-flex justify-content-between fw-bold">
                        <span>Total</span>
                        <span>₹{{ $finalTotal }}</span>
                    </h5>

                    <!-- Coupon -->
                    <form method="POST" action="{{ route('apply.coupon') }}" class="mt-3">
                        @csrf
                        <div class="input-group">
                            <input type="text" name="coupon_code" class="form-control" placeholder="Coupon code">
                            <button class="btn btn-success">Apply</button>
                        </div>
                    </form>

                    @if(session('coupon'))
                        <div class="alert alert-success mt-2">
                            Applied: {{ session('coupon')['code'] }}
                        </div>
                    @endif

                </div>
            </div>

        </div>
    </div>

    <!-- ================= STYLE ================= -->
    <style>
        .checkout-card:hover {
            transform: translateY(-3px);
            transition: 0.3s;
        }

        .payment-option {
            border: 1px solid #ddd;
            padding: 12px;
            border-radius: 10px;
            margin-bottom: 10px;
            cursor: pointer;
            transition: 0.3s;
        }

        .payment-option:hover {
            background: #f8f9fa;
        }
    </style>

    <!-- ================= SCRIPT ================= -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.getElementById('checkoutForm').addEventListener('submit', function(e) {

            const paymentType = document.querySelector('input[name="payment_type"]:checked');

            if (!paymentType) {
                e.preventDefault();

                Swal.fire({
                    icon: 'warning',
                    title: 'Select Payment Method',
                    text: 'Please choose COD or Online Payment'
                });
                return;
            }

            if (paymentType.value === 'online') {
                e.preventDefault();

                Swal.fire({
                    title: 'Secure Payment',
                    text: 'Proceed to Stripe payment?',
                    icon: 'info',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, Pay Now 💳'
                }).then((result) => {
                    if (result.isConfirmed) {

                        // Loading state
                        document.getElementById('placeOrderBtn').innerHTML = "Processing...";
                        document.getElementById('placeOrderBtn').disabled = true;

                        document.getElementById('checkoutForm').submit();
                    }
                });
            }
        });
    </script>
    <script>
        document.querySelectorAll('.payment-option').forEach(option => {
            option.addEventListener('click', function () {

                document.querySelectorAll('.payment-option').forEach(o => o.classList.remove('active'));

                this.classList.add('active');
            });
        });
    </script>
@endsection
