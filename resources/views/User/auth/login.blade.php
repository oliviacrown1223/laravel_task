@extends('User.layouts.app')

@section('content')

    <style>
        body {
            background: linear-gradient( #667eea);
        }
        .card {
            border: none;
        }
        .form-control:focus {
            box-shadow: none;
            border-color: #764ba2;
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

    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card shadow-lg rounded-4 p-4" style="width: 420px;">

            <!-- Title -->
            <h3 class="text-center fw-bold mb-2">Welcome Back 👋</h3>
            <p class="text-center text-muted mb-4">Login to your account</p>

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
            <form method="POST" action="{{ route('user.login') }}">
                @csrf

                <!-- Email -->
                <div class="mb-3">
                    <div class="input-group">
                    <span class="input-group-text">
                        <i class="bi bi-envelope"></i>
                    </span>
                        <input type="email" name="email" class="form-control"
                               placeholder="Email Address" value="{{ old('email') }}" required>
                    </div>
                </div>

                <!-- Password -->
                <div class="mb-2">
                    <div class="input-group">
                    <span class="input-group-text">
                        <i class="bi bi-lock"></i>
                    </span>
                        <input type="password" name="password" class="form-control"
                               placeholder="Password" required>
                    </div>
                </div>

                <!-- Extra Options -->
                <div class="d-flex justify-content-between mb-3">
                    <div>
                        <input type="checkbox" name="remember"> Remember me
                    </div>
                    <a href="#" class="text-decoration-none">Forgot?</a>
                </div>

                <!-- Button -->
                <button type="submit" class="btn btn-custom w-100 py-2 rounded-3 fw-bold">
                    Login
                </button>

            </form>

            <!-- Footer -->
            <p class="text-center mt-3 mb-0">
                Don’t have an account?
                <a href="{{ route('register') }}" class="fw-bold text-decoration-none">
                    Register
                </a>
            </p>

        </div>
    </div>

@endsection
