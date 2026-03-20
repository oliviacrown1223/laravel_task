@extends('layouts.app')

@section('content')

    <div class="container py-5">

        <div class="row">

            <!-- LEFT: FORM -->
            <div class="col-lg-7">

                <div class="card p-4 shadow-sm border-0 rounded-4">

                    <h4 class="mb-3">Checkout</h4>

                    <form action="{{ route('checkout.place') }}" method="POST">
                        @csrf

                        <label>Name</label>
                        <input type="text" name="name" class="form-control mb-3">

                        <label>Phone</label>
                        <input type="text" name="phone" class="form-control mb-3">

                        <label>Address</label>
                        <textarea name="address" class="form-control mb-3"></textarea>
                        <label>Email</label>
                        <input type="email" name="email" class="form-control mb-3">

                        <label>Pincode</label>
                        <input type="text" name="pincode" class="form-control mb-3">

                        <label>Payment Type</label>
                        <select name="payment_type" class="form-control mb-3">
                            <option value="offline">Cash on Delivery</option>
                            <option value="online">Online Payment</option>
                        </select>
                        <button class="btn btn-success w-100 rounded-pill">
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

@endsection
