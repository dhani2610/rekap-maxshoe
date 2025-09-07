@extends('backend.layouts-news.app')

@section('content')
    <h4 class="page-title mb-4">DATA KARYAWAN Maxshoe</h4>
    <button class="btn btn-inputdata mb-3" onclick="toggleForm()">
        <i class="bi bi-plus-circle me-1"></i> Input Karyawan Baru
    </button>
    <div id="inputFormSection" style="display: none">
        <form method="POST" action="{{ route('karyawan.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="row g-0 mb-0">
                <div class="section-header mb-3 p-3 text-white rounded d-flex align-items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" fill="currentColor" class="me-2"
                        viewBox="0 0 16 16">
                        <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3z" />
                        <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6z" />
                    </svg>
                    <span class="fw-bold">ROLE</span>
                </div>
                <div class="container-fluid px-0">
                    <div class="row gx-2 gy-0 mb-3">
                        <div class="col-md-2">
                            <input type="text" name="nama" class="form-control form-control-sm"
                                placeholder="Nama Karyawan" />
                        </div>
                        <div class="col-md-2">
                            <input type="text" name="nomor_hp" class="form-control form-control-sm"
                                placeholder="Nomor HP" />
                        </div>
                        <div class="col-md-2">
                            <select name="posisi" class="form-select form-select-sm">
                                <option selected hidden>Posisi</option>
                                <option value="Host">Host</option>
                                <option value="Co Host">Co Host</option>
                                <option value="CS">Customer Service</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select name="status_karyawan" class="form-select form-select-sm">
                                <option selected hidden>Status</option>
                                <option value="Training">Training</option>
                                <option value="Kontrak">Kontrak</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select name="lama_kontrak" class="form-select form-select-sm">
                                <option selected hidden>Lama</option>
                                <option value="2 Minggu">2 Minggu</option>
                                <option value="6 Bulan">6 Bulan</option>
                                <option value="12 Bulan">12 Bulan</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <input type="file" name="foto" class="form-control" accept="image/*" />
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
            <span class="fw-bold">DATA KARYAWAN AKTIF</span>
        </div>
        <div class="table-responsive">
            <table id="aktifTable" class="table table-bordered table-striped align-middle small">
                <thead class="table-primary">
                    <tr>
                        <th>NO</th>
                        <th>NAMA KARYAWAN</th>
                        <th>Nomor HP</th>
                        <th>POSISI</th>
                        <th>STATUS</th>
                        <th>SISA KONTRAK</th>
                        <th>UBAH DATA</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-5">
        <div class="section-header mb-3 p-3 text-white rounded d-flex align-items-center">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" fill="currentColor" class="me-2" viewBox="0 0 16 16">
                <path d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0zM4 8a4 4 0 1 1 8 0A4 4 0 0 1 4 8z" />
            </svg>
            <span class="fw-bold">DATA KARYAWAN NONAKTIF</span>
        </div>
        <div class="table-responsive">
            <table id="nonaktifTable" class="table table-bordered table-striped align-middle small">
                <thead class="table-primary">
                    <tr>
                        <th>NO</th>
                        <th>NAMA KARYAWAN</th>
                        <th>Nomor HP</th>
                        <th>POSISI</th>
                        <th>STATUS</th>
                        <th>SISA KONTRAK</th>
                        <th>UBAH DATA</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
    <!-- Modal Edit Karyawan -->
    <div class="modal fade" id="editKaryawanModal" tabindex="-1" aria-labelledby="editKaryawanModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form id="editKaryawanForm" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">Edit Karyawan</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" id="edit_id">

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label>Nama</label>
                                <input type="text" name="nama" id="edit_nama"
                                    class="form-control form-control-sm">
                            </div>
                            <div class="col-md-6">
                                <label>Nomor HP</label>
                                <input type="text" name="nomor_hp" id="edit_nomor_hp"
                                    class="form-control form-control-sm">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label>Posisi</label>
                                <select name="posisi" id="edit_posisi" class="form-select form-select-sm">
                                    <option value="Host">Host</option>
                                    <option value="Co Host">Co Host</option>
                                    <option value="Customer Service">Customer Service</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label>Status</label>
                                <select name="status_karyawan" id="edit_status_karyawan"
                                    class="form-select form-select-sm">
                                    <option value="Training">Training</option>
                                    <option value="Kontrak">Kontrak</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label>Lama Kontrak</label>
                                <select name="lama_kontrak" id="edit_lama_kontrak" class="form-select form-select-sm">
                                    <option value="2 Minggu">2 Minggu</option>
                                    <option value="6 Bulan">6 Bulan</option>
                                    <option value="12 Bulan">12 Bulan</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label>Foto</label>
                            <input type="file" name="foto" class="form-control form-control-sm" accept="image/*">
                            <div class="mt-2">
                                <img id="preview_foto" src="" alt="Foto Karyawan" class="img-thumbnail"
                                    width="120" style="display: none;">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

    <script>
        function toggleForm() {
            let form = document.getElementById("inputFormSection");
            form.style.display = (form.style.display === "none" || form.style.display === "") ? "block" : "none";
        }

        $(document).ready(function() {
            // Table Aktif
            let tableAktif = $("table#aktifTable").DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('karyawan') }}?status=active",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'nama',
                        name: 'nama'
                    },
                    {
                        data: 'nomor_hp',
                        name: 'nomor_hp'
                    },
                    {
                        data: 'posisi',
                        name: 'posisi'
                    },
                    {
                        data: 'status_karyawan',
                        name: 'status_karyawan'
                    },
                    {
                        data: 'sisa_kontrak',
                        name: 'sisa_kontrak'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });

            // Table Nonaktif
            let tableNon = $("table#nonaktifTable").DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('karyawan') }}?status=nonactive",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'nama',
                        name: 'nama'
                    },
                    {
                        data: 'nomor_hp',
                        name: 'nomor_hp'
                    },
                    {
                        data: 'posisi',
                        name: 'posisi'
                    },
                    {
                        data: 'status_karyawan',
                        name: 'status_karyawan'
                    },
                    {
                        data: 'sisa_kontrak',
                        name: 'sisa_kontrak'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });

            // Submit Form Tambah
            $(".form-section").on("submit", function(e) {
                e.preventDefault();
                $.ajax({
                    url: "{{ route('karyawan.store') }}",
                    method: "POST",
                    data: $(this).serialize(),
                    success: function(res) {
                        tableAktif.ajax.reload();
                        Swal.fire("Sukses", "Karyawan berhasil ditambahkan!", "success");
                    }
                });
            });

            // Update Status
            window.updateStatus = function(id) {
                $.post("{{ url('admin/karyawan/status') }}/" + id, {
                    _token: "{{ csrf_token() }}"
                }, function(res) {
                    tableAktif.ajax.reload();
                    tableNon.ajax.reload();
                    Swal.fire("Sukses", res.success, "success");
                });
            }

            // Hapus
            window.confirmDelete = function(url) {
                Swal.fire({
                    title: "Yakin hapus data?",
                    text: "Data tidak bisa dikembalikan!",
                    icon: "warning",
                    showCancelButton: true,
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: url,
                            type: "POST",
                            data: {
                                _token: "{{ csrf_token() }}"
                            },
                            success: function(res) {
                                tableAktif.ajax.reload();
                                tableNon.ajax.reload();
                                Swal.fire("Sukses", "Data dihapus", "success");
                            }
                        });
                    }
                });
            }

            // Klik tombol Edit
            $(document).on("click", ".editBtn", function() {
                let id = $(this).data("id");
                $("#edit_id").val(id);
                $("#edit_nama").val($(this).data("nama"));
                $("#edit_nomor_hp").val($(this).data("hp"));
                $("#edit_posisi").val($(this).data("posisi"));
                $("#edit_status_karyawan").val($(this).data("status"));
                $("#edit_lama_kontrak").val($(this).data("lama"));

                // foto preview (kalau ada)
                if ($(this).data("foto")) {
                    $("#preview_foto").attr("src", "/assets/img/karyawan/" + $(this).data("foto")).show();
                } else {
                    $("#preview_foto").hide();
                }

                $("#editKaryawanModal").modal("show");
            });

            // Submit Edit
            $("#editKaryawanForm").submit(function(e) {
                e.preventDefault();

                let id = $("#edit_id").val();
                let formData = new FormData(this);

                $.ajax({
                    url: "{{ url('admin/karyawan/update') }}/" + id,
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(res) {
                        $("#editKaryawanModal").modal("hide");
                        tableAktif.ajax.reload();
                        tableNon.ajax.reload();
                        Swal.fire("Sukses", res.success, "success");
                    },
                    error: function(xhr) {
                        Swal.fire("Error", "Gagal update data!", "error");
                    },
                });
            });
        });
    </script>
@endsection
