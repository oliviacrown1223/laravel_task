{{--

@extends('layouts.app')

@section('content')

    <div class="container py-5">

        <!-- HEADER -->
        <div class="d-flex justify-content-between align-items-center mb-4">

            <h4>Order Details</h4>

            <div>
                <a href="{{ route('order.view', $order->id) }}" class="btn btn-primary me-2">
                    View
                </a>

                <button onclick="window.print()" class="btn btn-dark">
                    Print
                </button>
            </div>

        </div>

        <!-- ORDER INFO -->
        <div class="card p-4 shadow-sm border-0 rounded-4">

            <h5>Customer Details</h5>
            <p><strong>Customer Name:</strong> {{ $order->customer_name}}</p>
            <p><strong>Phone:</strong> {{ $order->phone_no}}</p>
            <p><strong>Address:</strong> {{ $order->address }}</p>
            <p><strong>Email:</strong> {{ $order->email }}</p>
            <p><strong>Pincode:</strong> {{ $order->pincode }}</p>
            <p><strong>Payment Status:</strong> {{ $order->payment_status }}</p>

            <hr>

            <h5>Order Items</h5>

            @php $total = 0; @endphp

            @foreach($order->items as $item)
                <p class="d-flex justify-content-between">
                    <span>{{ $item->name }} (x{{ $item->qty }})</span>
                    <span>₹ {{ $item->price * $item->qty }}</span>
                </p>
            @endforeach

            <hr>

            <h5 class="d-flex justify-content-between">
                <span>Total</span>
                <strong>₹ {{ $order->total_amount }}</strong>
            </h5>

        </div>

    </div>

@endsection


<style>
    @media print {
        button, a {
            display: none !important;
        }
    }
</style>
--}}
@extends('layouts.app')

@section('content')

    <div class="container py-5">

        <!-- HEADER -->
        <div class="d-flex justify-content-between mb-3">
            <h4>Order Details</h4>

            <div>
                <button onclick="window.print()" class="btn btn-dark">Print</button>
            </div>
        </div>

        <!-- CUSTOMER -->
        <div class="card p-4 mb-4 shadow-sm">
            <h5>Customer Details</h5>

            <p><strong>Name:</strong> {{ $order->customer_name }}</p>
            <p><strong>Phone:</strong> {{ $order->phone_no }}</p>
            <p><strong>Email:</strong> {{ $order->email }}</p>
            <p><strong>Address:</strong> {{ $order->address }}</p>
            <p><strong>Pincode:</strong> {{ $order->pincode }}</p>
        </div>

        <!-- ITEMS -->
        <div class="card p-4 shadow-sm">
            <h5>Order Items</h5>
            <hr>

            @foreach($order->items as $item)
                <div class="d-flex justify-content-between">
                    <span>{{ $item->name }} (x{{ $item->qty }})</span>
                    <span>₹ {{ $item->price * $item->qty }}</span>
                </div>
            @endforeach

            <hr>

            <h5 class="d-flex justify-content-between">
                <span>Total</span>
                <strong>₹ {{ $order->total_amount }}</strong>
            </h5>
        </div>

    </div>

    <style>
        @media print {
            button {
                display: none;
            }
        }
    </style>

@endsection
