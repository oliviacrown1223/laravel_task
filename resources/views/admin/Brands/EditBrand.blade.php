@extends('admin.panel')

@section('content')

    <div class="container mt-4">

        <h3>Edit Brand</h3>

        <form action="{{ route('brand.update',$Brand->id) }}" method="POST" enctype="multipart/form-data">

            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Category Name</label>
                <input type="text" name="name" class="form-control" value="{{ $Brand->name }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Status</label>

                <select name="status" class="form-control">

                    <option value="1" {{ $Brand->status==1 ? 'selected':'' }}>Active</option>
                    <option value="0" {{ $Brand->status==0 ? 'selected':'' }}>Inactive</option>

                </select>

            </div>

            <div class="mb-3">

                <label class="form-label">Current Image</label><br>

                @if($Brand->image)
                    <img src="/products/{{ $Brand->image }}" width="120" class="mb-3">
                @endif

            </div>

            <div class="mb-3">

                <label class="form-label">Change Image</label>

                <input type="file" name="image" class="form-control">

            </div>

            <button type="submit" class="btn btn-success">Update $Brand</button>

            <a href="/catagory" class="btn btn-secondary">Back</a>

        </form>

    </div>

@endsection
