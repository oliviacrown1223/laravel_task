@extends('admin.panel')

@section('content')

    <!-- Add Brand Button -->
    <button class="btn btn-primary mb-3"
            data-bs-toggle="modal"
            data-bs-target="#brandModal"
            style="float:right;">
        Add Brand
    </button>

    <h3>Brand Data</h3>

    <link rel="stylesheet" href="{{ asset('css/table.css') }}">

    <table class="table table-hover align-middle" style="background:#fff; border-radius:12px; overflow:hidden; box-shadow:0 4px 20px rgba(0,0,0,0.1);">
        <thead style="background: linear-gradient(90deg,#667eea,#764ba2); color:white;">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Status</th>
            <th>Image</th>
            <th>Action</th>
        </tr>
        </thead>

        <tbody>
        @foreach($brands as $p)
            <tr>
                <td>{{ $p->id }}</td>
                <td>{{ $p->name }}</td>
                <td>
                    @if($p->status == 1)

                        <a href="{{ route('brand.status',$p->id) }}">
                            <span class="badge bg-success">Active</span>
                        </a>

                    @else

                        <a href="{{ route('brand.status',$p->id) }}">
                            <span class="badge bg-secondary">Inactive</span>
                        </a>

                    @endif
                </td>
                <td>
                    @if($p->image)
                        <img src="/products/{{ $p->image }}" width="60" height="60" style="border-radius:8px; object-fit:cover; border:1px solid #ddd;">
                    @else
                        <span class="text-muted">No Image</span>
                    @endif
                </td>
                <td>
                    <a href="/brand/edit/{{ $p->id }}" class="btn btn-warning btn-sm me-1" style="border-radius:6px; box-shadow:0 2px 6px rgba(0,0,0,0.15);">
                        <i class="fa fa-edit"></i> Edit
                    </a>
                    <a href="/brand/delete/{{ $p->id }}" class="btn btn-danger btn-sm" style="border-radius:6px; box-shadow:0 2px 6px rgba(0,0,0,0.15);">
                        <i class="fa fa-trash"></i> Delete
                    </a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>


    <!-- Add Brand Modal -->
    <div class="modal fade" id="brandModal">

        <div class="modal-dialog">

            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Add New Brand</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form action="{{ route('brand.store') }}" method="POST" enctype="multipart/form-data">

                    @csrf

                    <div class="modal-body">

                        <label>Brand Name</label>
                        <input type="text" name="name" class="form-control mb-3" required>

                        <label>Status</label>
                        <select name="status" class="form-control mb-3">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>

                        <label>Brand Image</label>
                        <input type="file" name="image" class="form-control">

                    </div>

                    <div class="modal-footer">

                        <button type="button" class="btn btn-warning" data-bs-dismiss="modal">
                            Close
                        </button>

                        <button type="submit" class="btn btn-primary">
                            Save Brand
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

@endsection
