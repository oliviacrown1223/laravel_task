
@extends('User.layouts.app')

@section('content')
    @php
        // Get the logged-in customer
        $customer = session()->get('customer');
    @endphp
    <div class="container py-5">

        <div class="row">

            <!-- LEFT: FORM -->
            <div class="col-lg-7">

                <div class="card p-4 shadow-sm border-0 rounded-4">

                    <h4 class="mb-3">Checkout</h4>

                    <!-- Display general error (like empty cart) -->
                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <!-- Display success message -->
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <form action="{{ route('checkout.place') }}" method="POST">
                        @csrf

                        <!-- Name -->
                        <label>Name</label>
                        <input type="text" name="name" class="form-control mb-2 @error('name') is-invalid @enderror"
                               value="{{ old('name', $customer->name ?? '') }}" readonly>
                        @error('name')
                        <div class="text-danger mb-2">{{ $message }}</div>
                        @enderror
                        <label>Phone</label>

                        <div class="input-group mb-2">
                            <span class="input-group-text">+91</span>
                            <input type="text"
                                   name="phone"
                                   class="form-control @error('phone') is-invalid @enderror"
                                   value="{{ old('phone', $customer->phone ?? '') }}" readonly
                                   maxlength="10"
                                   placeholder="Enter 10 digit number">
                        </div>

                        @error('phone')
                        <div class="text-danger mb-2">{{ $message }}</div>
                        @enderror

                        <!-- Address -->
                        <label>Address</label>
                        <textarea name="address" class="form-control mb-2 @error('address') is-invalid @enderror">{{ old('address') }}</textarea>
                        @error('address')
                        <div class="text-danger mb-2">{{ $message }}</div>
                        @enderror

                        <!-- Email -->
                        <label>Email</label>
                        <input type="email" name="email" class="form-control mb-2 @error('email') is-invalid @enderror"
                               value="{{ old('email', $customer->email ?? '') }}" readonly>
                        @error('email')
                        <div class="text-danger mb-2">{{ $message }}</div>
                        @enderror

                        <!-- Pincode -->
                        <label>Pincode</label>
                        <input type="number" name="pincode" class="form-control mb-2 @error('pincode') is-invalid @enderror"
                               value="{{ old('pincode') }}">
                        @error('pincode')
                        <div class="text-danger mb-2">{{ $message }}</div>
                        @enderror

                      {{--  <label>Payment Type</label>
                        <select name="payment_type" class="form-control mb-3 @error('payment_type') is-invalid @enderror">
                            <option value="">-- Select Payment Type --</option>
                            <option value="cod" {{ old('payment_type') == 'cod' ? 'selected' : '' }}>Cash on Delivery</option>
                            <option value="online" {{ old('payment_type') == 'online' ? 'selected' : '' }}>Online Payment</option>
                        </select>
--}}
                        <label>Payment Type</label>

                        <select name="payment_type" id="payment_type"
                                class="form-control mb-3 @error('payment_type') is-invalid @enderror">

                            <option value="">-- Select Payment Type --</option>

                            <option value="cod" {{ old('payment_type') == 'cod' ? 'selected' : '' }}>
                                Cash on Delivery
                            </option>

                            <option value="online" {{ old('payment_type') == 'online' ? 'selected' : '' }}>
                                Online Payment
                            </option>
                        </select>
                        @error('payment_type')
                        <div class="text-danger mb-2">{{ $message }}</div>
                        @enderror

                        <button type="submit" class="btn btn-primary w-100" id="placeOrderBtn">
                            Place Order
                        </button>

                    </form>

                </div>

            </div>

            <!-- RIGHT: ORDER SUMMARY -->
            <div class="col-lg-5">

                <div class="card p-4 shadow-sm border-0 rounded-4">

                    <h5>Order Summary</h5>
                    <hr>

                    @php $total = 0; @endphp

                    @foreach($cart as $item)
                        @php $total += $item['price'] * $item['qty']; @endphp

                        <p class="d-flex justify-content-between">
                            <span>{{ $item['name'] }} (x{{ $item['qty'] }})</span>
                            <span>₹ {{ $item['price'] * $item['qty'] }}</span>
                        </p>
                    @endforeach

                    <hr>

                    <h5 class="d-flex justify-content-between">
                        <span>Total</span>
                        <strong>₹ {{ $total }}</strong>
                    </h5>

                </div>

            </div>

        </div>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.getElementById('placeOrderBtn').addEventListener('click', function (e) {

            const paymentType = document.getElementById('payment_type').value;

            if (!paymentType) {
                e.preventDefault();

                Swal.fire({
                    icon: 'warning',
                    title: 'Select Payment Method',
                    text: 'Please choose COD or Online Payment'
                });
                return;
            }

            if (paymentType === 'online') {
                e.preventDefault();

                Swal.fire({
                    title: 'Confirm Payment',
                    text: 'Proceed to secure Stripe payment?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, Pay Now 💳'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // ✅ THIS IS THE FIX
                        document.querySelector('form').submit();
                    }
                });
            }

            // COD → normal submit
        });
    </script>
@endsection
