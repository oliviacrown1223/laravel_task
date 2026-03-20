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

    ```
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body{
            background: linear-gradient(135deg,#667eea,#764ba2);
            height:100vh;
            display:flex;
            justify-content:center;
            align-items:center;
            font-family:Arial;
        }

        .login-box{
            background:white;
            padding:40px;
            border-radius:12px;
            width:350px;
            box-shadow:0 10px 30px rgba(0,0,0,0.2);
        }

        .login-box h3{
            text-align:center;
            margin-bottom:25px;
            font-weight:bold;
        }

        .form-control{
            border-radius:8px;
        }

        .btn-login{
            width:100%;
            border-radius:8px;
            font-weight:bold;
        }

        .error-msg{
            text-align:center;
            color:red;
            margin-top:10px;
        }
    </style>
    ```

</head>

<body>

<div class="login-box">

    ```
    <h3>Admin Login</h3>

    <form action="/login" method="post">
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
    ```

</div>

</body>
</html>
