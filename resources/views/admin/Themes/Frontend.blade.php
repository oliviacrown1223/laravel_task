@extends('admin.panel')

@section('content')

    <div class="container-fluid">

        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0" style="color:#706f6c;">Menus Management</h4>

            <button class="btn btn-primary"
                    data-bs-toggle="modal"
                    data-bs-target="#menuModal">
                <i class="fa fa-plus"></i> Add Menu
            </button>
        </div>

        <!-- Card -->
        <div class="card border-0 shadow-sm" style="border-radius:12px;">
            <div class="card-body p-0">

                <table class="table table-hover align-middle mb-0">

                    <!-- Table Head -->
                    <thead style="background: linear-gradient(90deg,#667eea,#764ba2); color:white;">
                    <tr>
                        <th class="ps-3">ID</th>
                        <th>Name</th>
                        <th>Link</th>
                        <th>Type</th>
                        <th class="text-center">Action</th>
                    </tr>
                    </thead>

                    <!-- Table Body -->
                    <tbody>
                    @forelse($fronted as $p)
                        <tr>
                            <td class="ps-3">{{ $p->id }}</td>

                            <td>{{ $p->name }}</td>

                            <td>
                                <a href="{{ $p->link }}" target="_blank" class="text-primary">
                                    {{ $p->link }}
                                </a>
                            </td>

                            <td>
                            <span class="badge {{ $p->type == 'header' ? 'bg-primary' : 'bg-dark' }}">
                                {{ ucfirst($p->type) }}
                            </span>
                            </td>

                            <td class="text-center">

                                <a href="/menus/edit/{{$p->id}}"
                                   class="btn btn-warning btn-sm me-1">
                                    <i class="fa fa-edit"></i> Edit
                                </a>

                                <a href="/menus/delete/{{$p->id}}"
                                   class="btn btn-danger btn-sm"
                                   onclick="return confirm('Delete this menu?')">
                                    <i class="fa fa-trash"></i> Delete
                                </a>

                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center p-4">
                                No menus found
                            </td>
                        </tr>
                    @endforelse
                    </tbody>

                </table>

            </div>
        </div>

    </div>


    <!-- ================= MODAL ================= -->
    <div class="modal fade" id="menuModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0" style="border-radius:12px;">

                <!-- Header -->
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Add Menu</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <!-- Body -->
                <div class="modal-body">

                    <form action="{{ route('menus.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Menu Name</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Menu Link</label>
                            <input type="text" name="link" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Menu Type</label>
                            <select name="type" class="form-control">
                                <option value="header">Header</option>
                                <option value="footer">Footer</option>
                            </select>
                        </div>

                        <button class="btn btn-primary w-100">
                            <i class="fa fa-save"></i> Save Menu
                        </button>

                    </form>

                </div>

            </div>
        </div>
    </div>

@endsection
