@extends('User.layouts.app')

@section('content')

    <div class="container py-5">

        <h4 class="mb-4">My Orders</h4>

        <div class="card p-3 shadow-sm">

            <table class="table">
                <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Total</th>
                    <th>Payment</th>
                    <th>Order view</th>
                </tr>
                </thead>

                <tbody>
                @foreach($orders as $order)
                    <tr>
                        <td>{{ $order->order_id }}</td>
                        <td>₹ {{ $order->total_amount }}</td>

                        <td>
                        <span class="badge bg-{{ $order->payment_status == 'done' ? 'success' : 'warning' }}">
                            {{ $order->payment_status }}
                        </span>
                        </td>

                        <td>
                            <a href="{{ route('order.view', $order->id) }}" class="btn btn-sm btn-primary">
                                View
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>

            </table>

        </div>

    </div>

@endsection
