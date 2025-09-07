@extends('backend.layouts-news.app')

@section('content')
<h4 class="page-title mb-4">DATA USERS</h4>
<button class="btn btn-inputdata mb-3" onclick="toggleForm()">
    <i class="bi bi-plus-circle me-1"></i> Input User
</button>

<div id="inputFormSection" style="display: none">
    <form class="form-section" method="POST" action="{{ route('admin.admins.store') }}">
        @csrf
        <div class="row g-0 mb-0">
            <div class="section-header mb-3 p-3 text-white rounded d-flex align-items-center">
                <i class="bi bi-person-plus me-2"></i>
                <span class="fw-bold">FORM INPUT USER</span>
            </div>
            <div class="container-fluid px-0">
                <div class="row gx-2 gy-2 mb-3">
                    <div class="col-md-6">
                        <input type="text" class="form-control form-control-sm" name="name" placeholder="Nama Lengkap" required>
                    </div>
                    <div class="col-md-6">
                        <input type="text" class="form-control form-control-sm" name="username" placeholder="Username" required>
                    </div>
                    <div class="col-md-6">
                        <input type="email" class="form-control form-control-sm" name="email" placeholder="Email" required>
                    </div>
                    <div class="col-md-6">
                        <select name="roles[]" class="form-control form-control-sm" required>
                            <option value="">-- Pilih Role --</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->name }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <input type="password" class="form-control form-control-sm" name="password" placeholder="Password" required>
                    </div>
                    <div class="col-md-6">
                        <input type="password" class="form-control form-control-sm" name="password_confirmation" placeholder="Konfirmasi Password" required>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-end">
            <button type="submit" class="btn btn-custom">Tambah User</button>
        </div>
    </form>
</div>

<div class="mt-5">
    <div class="section-header mb-3 p-3 text-white rounded d-flex align-items-center">
        <i class="bi bi-people me-2"></i>
        <span class="fw-bold">LIST USERS</span>
    </div>
    <div class="table-responsive">
        <table id="userTable" class="table table-bordered table-striped align-middle small">
            <thead class="table-primary">
                <tr>
                    <th style="width:5%">NO</th>
                    <th>NAMA</th>
                    <th>EMAIL</th>
                    <th>ROLE</th>
                    <th style="width:15%">AKSI</th>
                </tr>
            </thead>
            <tbody>
                @foreach($admins as $admin)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $admin->name }}</td>
                    <td>{{ $admin->email }}</td>
                    <td>
                        @foreach($admin->roles as $role)
                            <span class="badge bg-info">{{ $role->name }}</span>
                        @endforeach
                    </td>
                    <td>
                        <button class="btn btn-warning btn-sm editBtn" 
                            data-id="{{ $admin->id }}" 
                            data-name="{{ $admin->name }}" 
                            data-email="{{ $admin->email }}" 
                            data-username="{{ $admin->username }}"
                            data-role="{{ $admin->roles->pluck('name')->first() }}">
                            <i class="bi bi-pencil-square"></i>
                        </button>
                        <button class="btn btn-danger btn-sm" onclick="confirmDelete('{{ route('admin.admins.destroy',$admin->id) }}')">
                            <i class="bi bi-trash"></i>
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Edit -->
<div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog">
        <form id="formEdit" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="edit_id" name="id">
                    <div class="mb-2">
                        <input type="text" class="form-control" id="edit_name" name="name" placeholder="Nama Lengkap">
                    </div>
                    <div class="mb-2">
                        <input type="text" class="form-control" id="edit_username" name="username" placeholder="Username">
                    </div>
                    <div class="mb-2">
                        <input type="email" class="form-control" id="edit_email" name="email" placeholder="Email">
                    </div>
                    <div class="mb-2">
                        <select name="roles[]" id="edit_role" class="form-control">
                            @foreach ($roles as $role)
                                <option value="{{ $role->name }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-2">
                        <input type="password" class="form-control" name="password" placeholder="Password (kosongkan jika tidak diganti)">
                    </div>
                    <div class="mb-2">
                        <input type="password" class="form-control" name="password_confirmation" placeholder="Konfirmasi Password">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-warning">Update</button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection

@section('script')
<script>
$(document).ready(function(){
    $('#userTable').DataTable();

    // Edit
    $(document).on('click','.editBtn', function(){
        $('#edit_id').val($(this).data('id'));
        $('#edit_name').val($(this).data('name'));
        $('#edit_email').val($(this).data('email'));
        $('#edit_username').val($(this).data('username'));
        $('#edit_role').val($(this).data('role'));
        $('#formEdit').attr('action', "{{ url('admin/admins') }}/" + $(this).data('id'));
        $('#editModal').modal('show');
    });
});

// SweetAlert Delete
function confirmDelete(deleteUrl) {
    Swal.fire({
        title: "Yakin hapus user ini?",
        text: "Data tidak bisa dikembalikan!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Ya, hapus!",
        cancelButtonText: "Batal"
    }).then((result) => {
        if (result.isConfirmed) {
            var form = $('<form>', {
                'method': 'POST',
                'action': deleteUrl
            }).append('@csrf','@method("DELETE")');
            $('body').append(form);
            form.submit();
        }
    });
}
</script>
@endsection
