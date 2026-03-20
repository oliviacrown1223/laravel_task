@extends('admin.panel')

@section('content')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div class="container-fluid">

        <h3 class="mb-4">📊 Dashboard Overview</h3>

        <!-- STAT CARDS -->
        <div class="row g-3">

            <div class="col-md-3">
                <div class="card p-3 shadow border-0">
                    <h6>Total Products</h6>
                    <h2>{{ $totalProducts }}</h2>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card p-3 shadow border-0">
                    <h6>Total Brands</h6>
                    <h2>{{ $totalBrands }}</h2>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card p-3 shadow border-0">
                    <h6>Total Categories</h6>
                    <h2>{{ $totalCategories }}</h2>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card p-3 shadow border-0">
                    <h6>Total Variants</h6>
                    <h2>{{ $totalVariants }}</h2>
                </div>
            </div>

        </div>

        <!-- CHART -->
        <div class="card mt-4 p-4 shadow border-0">
            <h5>Sales Overview</h5>

            <div style="height:300px; position: relative;">
                <canvas id="salesChart"></canvas>
            </div>
        </div>
        <!-- LOW STOCK -->
        <div class="card mt-4 p-4 shadow border-0">
            <h5 class="text-danger">⚠ Low Stock Products</h5>

            <table class="table">
                <tr>
                    <th>Product</th>
                    <th>Variant</th>
                    <th>Stock</th>
                </tr>

                @foreach($lowStockProducts as $v)
                    <tr>
                        <td>{{ $v->product->name ?? '-' }}</td>
                        <td>{{ $v->value->value ?? '-' }}</td>
                        <td class="text-danger">{{ $v->stock }}</td>
                    </tr>
                @endforeach

            </table>
        </div>

        <!-- RECENT PRODUCTS -->
        <div class="card mt-4 p-4 shadow border-0">
            <h5>📦 Recent Products</h5>

            <table class="table">
                <tr>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Price</th>
                </tr>

                @foreach($recentProducts as $p)
                    <tr>
                        <td>
                            <img src="{{ asset('uploads/products/'.$p->image) }}" width="50">
                        </td>
                        <td>{{ $p->name }}</td>
                        <td>₹{{ $p->price }}</td>
                    </tr>
                @endforeach

            </table>
        </div>

    </div>

    <!-- CHART SCRIPT -->
    <script>
        document.addEventListener("DOMContentLoaded", function(){

            const ctx = document.getElementById('salesChart');

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Jan','Feb','Mar','Apr','May','Jun'],
                    datasets: [{
                        label: 'Sales',
                        data: [10, 15, 36, 15, 30, 25, 40],
                        borderWidth: 2,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false, // 🔥 IMPORTANT
                    plugins: {
                        legend: {
                            display: true
                        }
                    }
                }
            });

        });
    </script>

@endsection
