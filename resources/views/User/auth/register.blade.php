@extends('User.layouts.app')

@section('content')

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(#667eea );
            height: 100vh;
        }
        .card {
            border: none;
        }
        .form-control:focus {
            box-shadow: none;
            border-color: #273eec;
        }
        .input-group-text {
            background: #273eec;
        }
        .btn-custom {
            background: #273eec;
            color: #fff;
        }
        .btn-custom:hover {
            background: #273eec;
        }
    </style>
</head>

<body>

<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="card shadow-lg rounded-4 p-4" style="width: 420px;">

        <!-- Title -->
        <h3 class="text-center mb-3 fw-bold">Create Account</h3>
        <p class="text-center text-muted mb-4">Join us today 🚀</p>

        <!-- Success Message -->
        @if(session('success'))
            <div class="alert alert-success text-center">
                {{ session('success') }}
            </div>
        @endif

        <!-- Error Message -->
        @if(session('error'))
            <div class="alert alert-danger text-center">
                {{ session('error') }}
            </div>
        @endif

        <!-- Validation Errors -->
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Form -->
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div class="mb-3">
                <div class="input-group">

                    <input type="text" name="name" class="form-control"
                           placeholder="Full Name" value="{{ old('name') }}">
                </div>
            </div>

            <!-- Phone -->
            <div class="mb-3">
                <div class="input-group">

                    <input type="number" name="phone" class="form-control"
                           placeholder="Phone Number" value="{{ old('phone') }}">
                </div>
            </div>

            <!-- Email -->
            <div class="mb-3">
                <div class="input-group">

                    <input type="email" name="email" class="form-control"
                           placeholder="Email Address" value="{{ old('email') }}">
                </div>
            </div>

            <!-- Password -->
            <div class="mb-3">
                <div class="input-group">

                    <input type="password" name="password" class="form-control"
                           placeholder="Password">
                </div>
            </div>

            <!-- Confirm Password -->
            <div class="mb-3">
                <div class="input-group">

                    <input type="password" name="password_confirmation" class="form-control"
                           placeholder="Confirm Password">
                </div>
            </div>

            <!-- Button -->
            <button type="submit" class="btn btn-custom w-100 py-2 rounded-3 fw-bold">
                Register
            </button>
        </form>

        <!-- Footer -->
        <p class="text-center mt-3 mb-0">
            Already have an account?
            <a href="{{ route('user.login') }}" class="fw-bold text-decoration-none">
                Login
            </a>
        </p>

    </div>
</div>

</body>
</html>
@endsection
