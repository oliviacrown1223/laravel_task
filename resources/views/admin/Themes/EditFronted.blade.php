@extends('admin.panel')

@section('content')

    <div class="container">
        <h3>Edit Menu</h3>

        <form action="{{ route('menus.update', $Fronted->id) }}" method="POST">
            @csrf
            @method('PUT')

            <label>Menu Name</label>
            <input type="text" name="name" value="{{ $Fronted->name }}" class="form-control mb-3">

            <label>Menu Link</label>
            <input type="text" name="link" value="{{ $Fronted->link }}" class="form-control mb-3">

            <label>Menu Type</label>
            <select name="type" class="form-control mb-3">
                <option value="header" {{ $Fronted->type == 'header' ? 'selected' : '' }}>Header</option>
                <option value="footer" {{ $Fronted->type == 'footer' ? 'selected' : '' }}>Footer</option>
            </select>

            <button class="btn btn-primary">Update</button>
        </form>
    </div>

@endsection
