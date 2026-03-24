<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="card p-4 shadow rounded-4" style="width: 400px;">

        <h4 class="text-center mb-3">Login</h4>

        {{-- ERROR MESSAGE --}}
        @if(session('error'))
            <div class="alert alert-danger text-center">
                {{ session('error') }}
            </div>
        @endif

        {{-- SUCCESS MESSAGE --}}
        @if(session('success'))
            <div class="alert alert-success text-center">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('user.login') }}">
            @csrf

            <input type="email" name="email" placeholder="Email" class="form-control mb-3" required>

            <input type="password" name="password" placeholder="Password" class="form-control mb-3" required>

            <button class="btn btn-primary w-100 rounded-pill">Login</button>
        </form>

        <p class="text-center mt-3">
            Don't have account? <a href="{{ route('register') }}">Register</a>
        </p>

    </div>
</div>

</body>
</html>

