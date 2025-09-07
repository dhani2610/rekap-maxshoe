@extends('backend.layouts-news.app')

@section('content')
    <h4 class="page-title mb-4">DATA ROLES</h4>
    <button class="btn btn-inputdata mb-3" onclick="toggleForm()">
        <i class="bi bi-plus-circle me-1"></i> Input Role
    </button>

    <!-- Form Tambah -->
    <div id="inputFormSection" style="display: none">
        <form class="form-section" method="POST" action="{{ route('admin.roles.store') }}">
            @csrf
            <div class="row g-0 mb-0">
                <div class="section-header mb-3 p-3 text-white rounded d-flex align-items-center">
                    <i class="bi bi-shield-lock me-2"></i>
                    <span class="fw-bold">FORM INPUT ROLE</span>
                </div>
                <div class="container-fluid px-0">
                    <div class="mb-3">
                        <input type="text" class="form-control form-control-sm" name="name"
                               placeholder="Nama Role" required>
                    </div>
                    <div class="form-group">
                        <label class="fw-bold">Permissions</label>
                        <table class="table table-bordered small">
                            <thead class="table-light">
                                <tr>
                                    <th>Menu</th>
                                    <th>Permissions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($permission_groups as $group)
                                    @php $permissions = App\User::getpermissionsByGroupName($group->name); @endphp
                                    <tr>
                                        <td class="fw-bold">{{ $group->name }}</td>
                                        <td>
                                            @foreach ($permissions as $permission)
                                                <div class="form-check form-check-inline">
                                                    <input type="checkbox" class="form-check-input"
                                                           id="create_permission_{{ $permission->id }}"
                                                           name="permissions[]" value="{{ $permission->name }}">
                                                    <label class="form-check-label small"
                                                           for="create_permission_{{ $permission->id }}">
                                                        {{ str_replace('.', ' ', $permission->name) }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="text-end">
                <button type="submit" class="btn btn-custom">Tambah Role</button>
            </div>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <!-- List Roles -->
    <div class="mt-5">
        <div class="section-header mb-3 p-3 text-white rounded d-flex align-items-center">
            <i class="bi bi-list-check me-2"></i>
            <span class="fw-bold">LIST ROLES</span>
        </div>
        <div class="table-responsive">
            <table id="rolesTable" class="table table-bordered table-striped align-middle small">
                <thead class="table-primary">
                    <tr>
                        <th style="width:5%">NO</th>
                        <th>NAMA ROLE</th>
                        <th style="width:15%">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($roles as $role)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $role->name }}</td>
                            <td>
                                <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#modalEdit{{ $role->id }}">
                                    <i class="bi bi-pencil-square"></i>
                                </button>

                                <!-- Modal Edit -->
                                <div class="modal fade" id="modalEdit{{ $role->id }}" tabindex="-1">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Edit Role</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('admin.roles.update', $role->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="mb-3">
                                                        <label for="name">Nama Role</label>
                                                        <input type="text" class="form-control"
                                                               name="name" value="{{ $role->name }}" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="fw-bold">Permissions</label>
                                                        <table class="table table-bordered small">
                                                            <thead class="table-light">
                                                                <tr>
                                                                    <th>Menu</th>
                                                                    <th>Permissions</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($permission_groups as $group)
                                                                    @php $permissions = App\User::getpermissionsByGroupName($group->name); @endphp
                                                                    <tr>
                                                                        <td class="fw-bold">{{ $group->name }}</td>
                                                                        <td>
                                                                            @foreach ($permissions as $permission)
                                                                                <div class="form-check form-check-inline">
                                                                                    <input type="checkbox"
                                                                                           class="form-check-input"
                                                                                           id="edit_permission_{{ $role->id }}_{{ $permission->id }}"
                                                                                           name="permissions[]"
                                                                                           value="{{ $permission->name }}"
                                                                                           {{ $role->hasPermissionTo($permission->name) ? 'checked' : '' }}>
                                                                                    <label class="form-check-label small"
                                                                                           for="edit_permission_{{ $role->id }}_{{ $permission->id }}">
                                                                                        {{ str_replace('.', ' ', $permission->name) }}
                                                                                    </label>
                                                                                </div>
                                                                            @endforeach
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <button type="submit" class="btn btn-primary mt-3 float-end">Update</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Delete -->
                                <button class="btn btn-danger btn-sm"
                                        onclick="confirmDelete('{{ route('admin.roles.destroy', $role->id) }}')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#rolesTable').DataTable();
        });

        function confirmDelete(deleteUrl) {
            Swal.fire({
                title: "Yakin hapus role ini?",
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
                    }).append('@csrf', '@method('DELETE')');
                    $('body').append(form);
                    form.submit();
                }
            });
        }
    </script>
@endsection
