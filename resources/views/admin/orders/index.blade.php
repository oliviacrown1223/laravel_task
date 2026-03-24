@extends('admin.panel')

@section('content')
    @if(session('success'))
        <script>
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true
            });
        </script>
    @endif
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <div class="container py-4">

        <h4 class="mb-4">Orders</h4>

        {{-- Success Message --}}
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="card shadow-sm border-0">
            <div class="card-body">

                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle">

                        <thead class="table-dark">
                        <tr>
                            <th>#ID</th>
                            <th>Customer</th>
                            <th>Phone</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th width="200">Action</th>
                        </tr>
                        </thead>

                        <tbody>
                        @forelse($orders as $order)
                            <tr>

                                <td>{{ $order->order_id }}</td>
                                <td>{{ $order->customer_name }}</td>
                                <td>{{ $order->phone_no }}</td>
                                <td>₹ {{ number_format($order->total_amount, 2) }}</td>

                                {{-- Status (Clickable Toggle) --}}
                                <td>
                                    <form id="status-form-{{ $order->id }}"
                                          action="{{ route('admin.orders.status', $order->id) }}"
                                          method="POST"
                                          style="display:inline;">
                                        @csrf
                                        @method('PUT')

                                        <button type="button"
                                                onclick="confirmStatus({{ $order->id }}, '{{ $order->payment_status }}')"
                                                style="border:none; background:none; padding:0;">

                                            @if($order->payment_status == 'done')
                                                <span class="badge bg-success px-3 py-2">Done</span>
                                            @else
                                                <span class="badge bg-warning text-dark px-3 py-2">Pending</span>
                                            @endif

                                        </button>
                                    </form>
                                </td>
                                {{-- Actions --}}
                                <td>

                                    <a href="{{ route('admin.orders.view', $order->id) }}"
                                       class="btn btn-sm btn-primary">
                                        View
                                    </a>

                                    <a href="{{ route('admin.orders.delete', $order->id) }}"
                                       class="btn btn-sm btn-danger"
                                       onclick="return confirm('Are you sure you want to delete this order?')">
                                        Delete
                                    </a>

                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">
                                    No orders found
                                </td>
                            </tr>
                        @endforelse
                        </tbody>

                    </table>
                </div>

            </div>
        </div>

    </div>

@endsection
<script>
    function confirmStatus(id, currentStatus) {

        let newStatus = currentStatus === 'pending' ? 'Done' : 'Pending';

        Swal.fire({
            title: 'Are you sure?',
            text: "Change status to " + newStatus + "?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, change it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('status-form-' + id).submit();
            }
        });
    }
</script>
