@extends('admin.panel')

@section('content')

    @if(session('success'))
        <div class="alert alert-success shadow-sm rounded-3">
            {{ session('success') }}
        </div>
    @endif

    <style>
        body {
            background: #f1f5f9;
        }

        /* ===== Card ===== */
        .main-card {
            border-radius: 20px;
            overflow: hidden;
            background: #ffffff;
        }

        /* ===== Header ===== */
        .card-header-custom {
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            color: #fff;
            padding: 18px 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .card-header-custom h5 {
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        /* ===== Add Button ===== */
        .btn-add {
            background: #fff;
            color: #4f46e5;
            border-radius: 12px;
            font-weight: 600;
            padding: 6px 14px;
            transition: 0.3s;
        }

        .btn-add:hover {
            background: #eef2ff;
            transform: translateY(-2px);
        }

        /* ===== Table ===== */
        .table {
            margin-bottom: 0;
        }

        .table thead th {
            font-size: 12px;
            text-transform: uppercase;
            color: #94a3b8;
            border-bottom: 1px solid #e2e8f0;
        }

        .table tbody td {
            vertical-align: middle;
            font-size: 14px;
        }

        /* ===== Row Hover ===== */
        .table-row:hover {
            background: #f8fafc;
            transition: 0.2s;
        }

        /* ===== Badge ===== */
        .badge {
            border-radius: 10px;
            padding: 5px 10px;
            font-size: 11px;
        }

        /* ===== Status ===== */
        .status {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-weight: 500;
        }

        .dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
        }

        .active-dot {
            background: #22c55e;
        }

        .expired-dot {
            background: #ef4444;
        }

        /* ===== Action Buttons ===== */
        .btn-action {
            border-radius: 10px;
            padding: 5px 10px;
            font-size: 12px;
            transition: 0.3s;
        }

        .btn-edit {
            background: #facc15;
            color: #000;
        }

        .btn-edit:hover {
            background: #eab308;
            transform: translateY(-1px);
        }

        .btn-delete {
            background: #ef4444;
            color: #fff;
        }

        .btn-delete:hover {
            background: #dc2626;
            transform: translateY(-1px);
        }

        /* ===== Animation ===== */
        .fade-in {
            animation: fadeIn 0.4s ease-in-out;
        }

        @keyframes fadeIn {
            from {opacity:0; transform: translateY(10px);}
            to {opacity:1; transform: translateY(0);}
        }

    </style>

    <div class="container py-4 fade-in">

        <div class="card main-card shadow-sm border-0">

            <!-- HEADER -->
            <div class="card-header-custom">
                <h5>🎟️ Coupon Management</h5>

                <a href="{{ route('coupon.create') }}" class="btn btn-add">
                    + Add Coupon
                </a>
            </div>

            <!-- TABLE -->
            <div class="card-body table-responsive">

                <table class="table text-center align-middle">

                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Code</th>
                        <th>Type</th>
                        <th>Discount</th>
                        <th>Usage</th>
                        <th>Expiry</th>
                        <th>Status</th>
                        <th>Count</th>
                        <th>Action</th>
                    </tr>
                    </thead>

                    <tbody>
                    @forelse($coupons as $key => $coupon)

                        @php
                            $isExpired = $coupon->expiry_date
                                ? \Carbon\Carbon::parse($coupon->expiry_date)->isPast()
                                : false;
                        @endphp

                        <tr class="table-row">

                            <td>{{ $key + 1 }}</td>

                            <td><strong>{{ $coupon->name }}</strong></td>

                            <td>
                            <span >
                                {{ $coupon->code }}
                            </span>
                            </td>

                            <td>
                                @if($coupon->type == 'percentage')
                                    <span >%</span>
                                @else
                                    <span >₹</span>
                                @endif
                            </td>

                            <td>
                                {{ $coupon->type == 'percentage'
                                    ? $coupon->discount.'%'
                                    : '₹'.$coupon->discount }}
                            </td>

                            <td>{{ $coupon->usage_limit ?? '-' }}</td>

                            <td>{{ $coupon->expiry_date ?? '--' }}</td>

                            <td>
                                @if($isExpired)
                                    <span class="status text-danger">
                                    <span class="dot expired-dot"></span> Expired
                                </span>
                                @else
                                    <span class="status text-success">
                                    <span class="dot active-dot"></span> Active
                                </span>
                                @endif
                            </td>

                            <td>
                            <span >
                                {{ $coupon->used_count }}
                            </span>
                            </td>

                            <td>
                                <a href="{{ route('coupon.edit',$coupon->id) }}"
                                   class="btn btn-action btn-edit me-1">
                                    ✏ Edit
                                </a>

                                <a href="/admin/coupon/delete/{{ $coupon->id }}"
                                   class="btn btn-action btn-delete delete-btn">
                                    🗑 Delete
                                </a>
                            </td>

                        </tr>

                    @empty
                        <tr>
                            <td colspan="10" class="py-4 text-muted">
                                🚫 No coupons found
                            </td>
                        </tr>
                    @endforelse
                    </tbody>

                </table>

            </div>
        </div>

    </div>

@endsection
