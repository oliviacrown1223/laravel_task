@extends('admin.panel')

@section('content')

    <div class="container py-4">

        <div class="d-flex justify-content-between mb-3">
            <h4>Order Details</h4>

            <button onclick="window.print()" class="btn btn-dark">Print</button>
        </div>

        <!-- CUSTOMER -->
        <div class="card p-3 mb-3">
            <h5>Customer Info</h5>

            <p><strong>Name:</strong> {{ $order->customer_name }}</p>
            <p><strong>Phone:</strong> {{ $order->phone_no }}</p>
            <p><strong>Email:</strong> {{ $order->email }}</p>
            <p><strong>Address:</strong> {{ $order->address }}</p>
        </div>

        <!-- ITEMS -->
        <div class="card p-3 mb-3">
            <h5>Items</h5>

            @foreach($order->items as $item)
                <div class="d-flex justify-content-between">
                    <span>{{ $item->name }} (x{{ $item->qty }})</span>
                    <span>₹ {{ $item->price * $item->qty }}</span>
                </div>
            @endforeach

            <hr>

            <h5>Total: ₹ {{ $order->total_amount }}</h5>
        </div>

        <!-- STATUS UPDATE -->
        <div class="card p-3">
            <h5>Update Status</h5>

            <form action="{{ route('admin.orders.status', $order->id) }}" method="POST">
                @csrf

                <select name="status" class="form-control mb-2">
                    <option value="pending" {{ $order->payment_status == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="done" {{ $order->payment_status == 'done' ? 'selected' : '' }}>Done</option>
                </select>

                <button class="btn btn-success">Update</button>
            </form>
        </div>

    </div>

    <style>
        @media print {
            button, form {
                display: none;
            }
        }
    </style>

@endsection
