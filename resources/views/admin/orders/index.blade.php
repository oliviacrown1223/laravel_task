@extends('admin.panel')

@section('content')

    <div class="container py-4">

        <h4 class="mb-4">Orders</h4>

        <div class="card p-3 shadow-sm">

            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Customer</th>
                    <th>Phone</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                </thead>

                <tbody>
                @foreach($orders as $order)
                    <tr>
                        <td>{{ $order->order_id }}</td>
                        <td>{{ $order->customer_name }}</td>
                        <td>{{ $order->phone_no }}</td>
                        <td>₹ {{ $order->total_amount }}</td>

                        <td>
                        <span class="badge bg-{{ $order->payment_status == 'done' ? 'success' : 'warning' }}">
                            {{ $order->payment_status }}
                        </span>
                        </td>

                        <td>
                            <a href="{{ route('admin.orders.view', $order->id) }}" class="btn btn-sm btn-primary">
                                View
                            </a>
                            <a href="{{ route('admin.orders.delete', $order->id) }}" class="btn btn-danger btn-sm"
                               onclick="return confirm('Are you sure you want to delete this order?')">
                                Delete
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

        </div>

    </div>

@endsection
