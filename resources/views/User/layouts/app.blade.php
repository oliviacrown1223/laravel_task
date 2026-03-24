
<!DOCTYPE html>
<html>
<head>
    <title>Shop Products</title>

    @php
        $orderCount = \App\Models\Order::count(); // later filter by user
    @endphp

        <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    @stack('css')
</head>

<body>
@include('User.particles.header')

<div class="container py-4">
    @yield('content')
</div>

@include('User.particles.footer')
</body>
</html>

