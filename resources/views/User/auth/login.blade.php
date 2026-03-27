@extends('User.layouts.app')

@section('content')

    <style>
        body {
            background: linear-gradient(135deg, #4facfe, #6a11cb);
            min-height: 100vh;
        }

        .login-card {
            border: none;
            border-radius: 20px;
            backdrop-filter: blur(10px);
            background: rgba(255,255,255,0.95);
        }

        .form-control {
            border-radius: 10px;
            padding-left: 40px;
        }

        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 8px rgba(102,126,234,0.4);
        }

        .input-icon {
            position: absolute;
            top: 50%;
            left: 12px;
            transform: translateY(-50%);
            color: #667eea;
            font-size: 14px;
        }

        .input-group {
            position: relative;
        }

        .btn-custom {
            background: linear-gradient(135deg, #667eea, #764ba2);
            border: none;
            border-radius: 10px;
            transition: 0.3s;
        }

        .btn-custom:hover {
            opacity: 0.9;
            transform: translateY(-1px);
        }

        .toggle-password {
            position: absolute;
            top: 50%;
            right: 12px;
            transform: translateY(-50%);
            cursor: pointer;
            color: #999;
        }
    </style>

    <div class="container d-flex justify-content-center align-items-center vh-100">

        <div class="card login-card shadow-lg p-4" style="width: 420px;">

            <!-- Title -->
            <h3 class="text-center fw-bold">Welcome Back 👋</h3>
            <p class="text-center text-muted mb-4">Login to your account</p>

            <!-- Alerts -->
            @if(session('success'))
                <div class="alert alert-success text-center rounded-3">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger text-center rounded-3">
                    {{ session('error') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger rounded-3">
                    <ul class="mb-0 small">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Form -->
            <form method="POST" action="{{ route('user.login') }}" onsubmit="return validateForm()">
                @csrf

                <!-- Email -->
                <div class="mb-3 input-group position-relative">
                    <i class="fa fa-envelope input-icon"></i>

                    <input type="email" name="email" id="email"
                           class="form-control"
                           placeholder="Email Address"
                           value="{{ old('email') }}" required>

                    <!-- Status Icon -->
                    <span id="emailStatus" class="status-icon"></span>
                </div>
                <small id="emailError" class="text-danger"></small>


                <!-- Password -->
                <div class="mb-3 input-group position-relative">
                    <i class="fa fa-lock input-icon"></i>

                    <input type="password" name="password" id="password"
                           class="form-control" placeholder="Password" required>

                    <!-- Show/Hide -->
                    <span class="toggle-password" onclick="togglePassword()">
        <i class="fa fa-eye" id="eyeIcon"></i>
    </span>

                    <!-- Status Icon -->
                    <span id="passwordStatus" class="status-icon"></span>
                </div>
                <small id="passwordError" class="text-danger"></small>

                <!-- Remember + Forgot -->


                <!-- Button -->
                <button type="submit" class="btn btn-custom w-100 py-2 fw-bold text-white">
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

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Script -->
    <script>
        function togglePassword() {
            let password = document.getElementById('password');
            let icon = document.getElementById('eyeIcon');

            if (password.type === "password") {
                password.type = "text";
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                password.type = "password";
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    </script>
    <script>
        const email = document.getElementById('email');
        const password = document.getElementById('password');

        const emailError = document.getElementById('emailError');
        const passwordError = document.getElementById('passwordError');

        // Email Validation
        email.addEventListener('input', function () {
            let value = email.value.trim();

            if (value === "") {
                emailError.innerText = "Email is required";
            } else if (!validateEmail(value)) {
                emailError.innerText = "Enter valid email (example@gmail.com)";
            } else {
                emailError.innerText = "";
            }
        });

        // Password Validation
        password.addEventListener('input', function () {
            let value = password.value.trim();

            if (value === "") {
                passwordError.innerText = "Password is required";
            } else if (value.length < 6) {
                passwordError.innerText = "Minimum 6 characters required";
            } else {
                passwordError.innerText = "";
            }
        });

        // Email regex function
        function validateEmail(email) {
            return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
        }
    </script>
    <script>
        function validateForm() {
            let valid = true;

            if (email.value.trim() === "") {
                emailError.innerText = "Email is required";
                valid = false;
            }

            if (password.value.trim() === "") {
                passwordError.innerText = "Password is required";
                valid = false;
            }

            return valid;
        }
    </script>
@endsection
