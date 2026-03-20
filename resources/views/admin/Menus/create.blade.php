@extends('admin.panel')

@section('content')

    <div class="container">
        <h3>Add Menu</h3>

        <form action="{{ route('menus.store') }}" method="POST">
            @csrf

            <label>Menu Name</label>
            <input type="text" name="name" class="form-control mb-3">

            <label>Menu Link</label>
            <input type="text" name="link" class="form-control mb-3">

            <label>Menu Type</label>
            <select name="type" class="form-control mb-3">
                <option value="header">Header</option>
                <option value="footer">Footer</option>
            </select>

            <button class="btn btn-primary">Save</button>
        </form>
    </div>

@endsection
