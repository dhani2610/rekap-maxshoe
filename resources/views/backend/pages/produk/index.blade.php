@extends('backend.layouts-news.app')

@section('content')
    <h4 class="page-title mb-4">DATA PRODUK Maxshoe</h4>
    <button class="btn btn-inputdata mb-3" onclick="toggleForm()">
        <i class="bi bi-plus-circle me-1"></i> Input Produk
    </button>
    <div id="inputFormSection" style="display: none">
        <form class="form-section" method="POST" action="{{ route('produk.store') }}">
            @csrf
            <div class="row g-0 mb-0">
                <div class="section-header mb-3 p-3 text-white rounded d-flex align-items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" fill="currentColor" class="me-2"
                        viewBox="0 0 24 24">
                        <path
                            d="M21 16V8a1 1 0 0 0-.553-.894l-8-4a1 1 0 0 0-.894 0l-8 4A1 1 0 0 0 3 8v8a1 1 0 0 0 .553.894l8 4a1 1 0 0 0 .894 0l8-4A1 1 0 0 0 21 16ZM11 19.382 5 16.618V9.236l6 2.999Zm1-8.147-6-3L12 4.618l6 3Zm1 8.147v-7.147l6-2.999v7.382Z" />
                    </svg>
                    <span class="fw-bold">NAMA PRODUK</span>
                </div>
                <div class="container-fluid px-0">
                    <div class="row gx-2 gy-0 mb-3">
                        <div class="col-md-12">
                            <input type="text" class="form-control form-control-sm" name="nama_produk"
                                placeholder="Nama Produk" />
                        </div>
                    </div>
                </div>
            </div>
            <br /><br />
            <div class="text-end">
                <button type="submit" class="btn btn-custom">Tambah Data</button>
            </div>
        </form>
    </div>
    <div class="mt-5">
        <div class="section-header mb-3 p-3 text-white rounded d-flex align-items-center">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" fill="white" class="me-2" viewBox="0 0 16 16">
                <path d="M3 0h10a1 1 0 0 1 1 1v4H2V1a1 1 0 0 1 1-1z" />
                <path d="M2 7v7a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V7H2z" />
            </svg>
            <span class="fw-bold">LIST DATA PRODUK</span>
        </div>
        <div class="table-responsive">
            <table id="produkTable" class="table table-bordered table-striped align-middle small">
                <thead class="table-primary">
                    <tr>
                        <th style="width: 5%">NO</th>
                        <th>NAMA PRODUK (KODE/SERI)</th>
                        <th style="width: 10%">UBAH DATA</th>
                    </tr>
                </thead>
                <tbody>
                   
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal fade" id="editModal" tabindex="-1">
        <div class="modal-dialog">
            <form id="formEdit">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Produk</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" id="edit_id">
                        <input type="text" name="nama_produk" id="edit_nama" class="form-control" required>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-warning">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script>

 $(document).ready(function(){
    // Datatable
    var table = $('#produkTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('produk') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable:false, searchable:false},
            {data: 'nama_produk', name: 'nama_produk'},
            {data: 'action', name: 'action', orderable:false, searchable:false},
        ]
    });

    // Show Edit Modal
    $(document).on('click','.editBtn', function(){
        $('#edit_id').val($(this).data('id'));
        $('#edit_nama').val($(this).data('nama'));
        $('#editModal').modal('show');
    });

    // Update Data
    $('#formEdit').on('submit', function(e){
        e.preventDefault();
        var id = $('#edit_id').val();
        $.ajax({
            url: "{{url('admin/produk/update/')}}/"+id,
            method: "POST",
            data: $(this).serialize(),
            success: function(res){
                $('#editModal').modal('hide');
                table.ajax.reload();
                Swal.fire('Sukses', res.success, 'success');
            }
        });
    });
});

// SweetAlert Delete
function confirmDelete(deleteUrl) {
    Swal.fire({
        title: "Yakin hapus data ini?",
        text: "Data tidak bisa dikembalikan!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Ya, hapus!",
        cancelButtonText: "Batal"
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = deleteUrl;
        }
    });
}
</script>
@endsection

