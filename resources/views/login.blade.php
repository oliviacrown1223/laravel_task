{{--
<form action="/login" method="post">
    @csrf
    <input type="text" name="email" placeholder="email"><br><br>
    <input type="password" name="password" placeholder="password"><br><br>
    <button type="submit">Login</button>
</form>

@if(session('msg'))
    <h3>{{ session('msg') }}</h3>
@endif

--}}

    <!DOCTYPE html>

<html>
<head>
    <title>Admin Login</title>


    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/userlogin.css') }}">
</head>

<body>

<div class="login-box">

    <h3>Admin Login1</h3>

    <form method="POST" action="{{ route('admin.login.submit') }}">

    @csrf

        <input type="text" name="email" class="form-control mb-3" placeholder="Enter Email" required>

        <input type="password" name="password" class="form-control mb-3" placeholder="Enter Password" required>

        <button type="submit" class="btn btn-primary btn-login">Login</button>
    </form>

    @if(session('msg'))
        <div class="error-msg">
            {{ session('msg') }}
        </div>
    @endif


</div>

</body>
</html>
