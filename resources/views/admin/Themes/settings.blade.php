@extends('admin.panel')

@section('content')

    <div class="container">
        <h3>Theme Settings</h3>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('themes.save') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Logo Upload -->
            <div class="mb-3">
                <label>Upload Logo</label>
                <input type="file" name="logo" class="form-control">
            </div>

            <!-- Show Logo -->
            @if(isset($setting->logo))
                <img src="{{ asset('uploads/products/'.$setting->logo) }}" width="100">
            @endif

            <!-- Theme Color -->
            <div class="mb-3 mt-3">
                <label>Theme Color</label>
                <input type="color" name="theme_color" class="form-control"
                       value="{{ $setting->theme_color ?? '#000000' }}">
            </div>

            <button class="btn btn-primary">Save</button>
        </form>
    </div>

@endsection
