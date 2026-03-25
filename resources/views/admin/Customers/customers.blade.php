@extends('admin.panel') <!-- assuming you have an admin panel layout -->

@section('content')
    <div class="container py-4">
        <h3>All Customers</h3>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Total Order</th>
            </tr>
            </thead>
            <tbody>
            @forelse($customers as $customer)
                <tr>
                    <td>{{ $customer->id }}</td>
                    <td>{{ $customer->name }}</td>
                    <td>{{ $customer->phone }}</td>
                    <td>{{ $customer->email }}</td>
                 {{--   <td>{{ $customer->total_orders }}</td>--}}
                     <td>{{ $customer->orders_count}}</td>

                </tr>
            @empty
                <tr>
                    <td colspan="4">No customers found.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
@endsection
