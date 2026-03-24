{{--
<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="card p-4 shadow rounded-4" style="width: 400px;">

        <h4 class="text-center mb-3">Create Account</h4>

        --}}
{{-- SUCCESS MESSAGE --}}{{--

        --}}
{{-- ERROR MESSAGE --}}{{--

        @if(session('error'))
            <div class="alert alert-danger text-center">
                {{ session('error') }}
            </div>
        @endif



        --}}
{{-- GLOBAL ERRORS --}}{{--

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf

            --}}
{{-- NAME --}}{{--

            <input type="text" name="name" value="{{ old('name') }}" placeholder="Full Name">
            @error('name')
            <div class="text-danger">{{ $message }}</div>
            @enderror


            --}}
{{-- PHONE --}}{{--

            <input type="text" name="phone" value="{{ old('phone') }}" placeholder="Phone Number">
            @error('phone')
            <div class="text-danger">{{ $message }}</div>
            @enderror


            --}}
{{-- EMAIL --}}{{--

            <input type="email" name="email" value="{{ old('email') }}" placeholder="Email Address">
            @error('email')
            <div class="text-danger">{{ $message }}</div>
            @enderror


            --}}
{{-- PASSWORD --}}{{--

            <input type="password" name="password" placeholder="Password">
            @error('password')
            <div class="text-danger">{{ $message }}</div>
            @enderror


            --}}
{{-- CONFIRM PASSWORD --}}{{--

            <input type="password" name="password_confirmation" placeholder="Confirm Password">


            <button type="submit">
                Register
            </button>
        </form>

        <p>
            Already have account?
            <a href="{{ route('user.login') }}" class="text-decoration-none fw-bold">Login</a>
        </p>

    </div>
</div>

</body>
</html>
--}}
<form method="POST" action="{{ route('register') }}">
    @csrf

    {{-- MESSAGE --}}
    @if(session('error'))
        <div style="color:red">{{ session('error') }}</div>
    @endif

    @if(session('success'))
        <div style="color:green">{{ session('success') }}</div>
    @endif

    <input type="text" name="name" placeholder="Name" value="{{ old('name') }}"><br><br>

    <input type="text" name="phone" placeholder="Phone" value="{{ old('phone') }}"><br><br>

    <input type="email" name="email" placeholder="Email" value="{{ old('email') }}"><br><br>

    <input type="password" name="password" placeholder="Password"><br><br>

    <button type="submit">Register</button>
</form>

<p>
    Already have account?
    <a href="{{ route('user.login') }}">Login</a>
</p>
