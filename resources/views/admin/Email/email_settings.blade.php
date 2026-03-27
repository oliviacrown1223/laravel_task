@extends('admin.panel')

@section('content')
    <!DOCTYPE html>
<html>
<head>
    <title>Email Settings</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body style="background:#f5f6f7;">

<div class="container mt-5">

    <div class="card shadow-sm p-4">

        <h4 class="mb-4">Email Settings</h4>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        <form method="POST" action="{{route("admin.email-settings")}}">
            @csrf

            <input type="hidden" name="id" value="{{ $setting->id ?? '' }}">

            <!-- Mailer -->
            <div class="mb-3">
                <label class="form-label">Mailer</label>
                <select name="mailer" id="mailer" class="form-select">
                    <option value="smtp" {{ ($setting->mailer ?? '') == 'smtp' ? 'selected' : '' }}>SMTP</option>
                    <option value="sendmail" {{ ($setting->mailer ?? '') == 'sendmail' ? 'selected' : '' }}>Sendmail</option>
                </select>
            </div>

            <!-- SMTP Fields -->
            <div id="smtp_fields">

                <div class="mb-3">
                    <label>Host</label>
                    <input type="text" name="host" class="form-control"
                           value="{{ $setting->host ?? '' }}">
                </div>

                <div class="mb-3">
                    <label>Port</label>
                    <input type="text" name="port" class="form-control"
                           value="{{ $setting->port ?? '' }}">
                </div>

                <div class="mb-3">
                    <label>Username</label>
                    <input type="text" name="username" class="form-control"
                           value="{{ $setting->username ?? '' }}">
                </div>

                <div class="mb-3">
                    <label>Password</label>
                    <input type="text" name="password" class="form-control"
                           value="{{ $setting->password ?? '' }}">
                </div>

                <div class="mb-3">
                    <label>Encryption</label>
                    <input type="text" name="encryption" class="form-control"
                           value="{{ $setting->encryption ?? '' }}">
                </div>

            </div>

            <!-- Sendmail Fields -->
            <div id="sendmail_fields" style="display:none;">
                <div class="mb-3">
                    <label>Sendmail Path</label>
                    <input type="text" name="sendmail_path" class="form-control"
                           value="/usr/sbin/sendmail -bs -i">
                    <small class="text-muted">
                        Default: /usr/sbin/sendmail -bs -i
                    </small>
                </div>
            </div>

            <!-- Sender -->
            <div class="mb-3">
                <label>Sender name</label>
                <input type="text" name="from_name" class="form-control"
                       value="{{ $setting->from_name ?? '' }}">
            </div>

            <div class="mb-3">
                <label>Sender email</label>
                <input type="email" name="from_email" class="form-control"
                       value="{{ $setting->from_email ?? '' }}">
            </div>

            <!-- Buttons -->
            <div class="d-flex gap-2">
                <button class="btn btn-primary">Save settings</button>

                <a href="{{ route('email.test') }}" class="btn btn-info text-white">
                    Send mail
                </a>

            </div>

        </form>
    </div>

</div>

<!-- JS Toggle -->
<script>
    document.getElementById('mailer').addEventListener('change', function () {

        if (this.value === 'smtp') {
            document.getElementById('smtp_fields').style.display = 'block';
            document.getElementById('sendmail_fields').style.display = 'none';
        } else {
            document.getElementById('smtp_fields').style.display = 'none';
            document.getElementById('sendmail_fields').style.display = 'block';
        }

    });
</script>

</body>
</html>
@endsection
