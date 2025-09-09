@extends('backend.layouts-news.app')

@section('content')
    <style>
        <style>body {
            background: #f9fafc;
            font-family: 'Poppins', sans-serif;
        }

        .sidebar {
            width: 200px;
            background: #fff;
            min-height: 100vh;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
            position: fixed;
        }

        .sidebar a {
            padding: 12px;
            color: #333;
            display: block;
            text-decoration: none;
        }

        .sidebar a.active {
            background: #0a53be;
            color: white;
        }

        main {
            margin-left: 200px;
            padding: 20px;
        }

        .form-section {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .form-control:focus {
            border-color: #0a53be;
            box-shadow: 0 0 0 0.2rem rgba(10, 83, 190, 0.2);
        }

        .section-header {
            background: linear-gradient(90deg, #1e3c72, #2a5298);
            color: white;
            padding: 8px 16px;
            height: 45px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
        }

        .btn-custom {
            background: linear-gradient(90deg, #14532d, #166534);
            color: white;
            border: none;
            border-radius: 8px;
            padding: 10px 50px;
            font-weight: 600;
            font-size: 14px;
            transition: transform 0.2s ease, background 0.3s ease;
        }

        .btn-custom:hover {
            background: linear-gradient(90deg, #166534, #14532d);
            transform: scale(1.05);
            color: white;
        }

        .table-responsive {
            overflow-x: auto;
            width: 100%;
        }

        .table-responsive table {
            min-width: 1600px;
            white-space: nowrap;
        }

        .table th,
        .table td {
            vertical-align: middle;
        }

        #popupHover {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 90%;
            max-width: 400px;
            border-radius: 20px;
            backdrop-filter: blur(12px);
            background: rgba(15, 40, 80, 0.2);
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.15);
            transition: all 0.4s ease;
            overflow: hidden;
            z-index: 9999;
        }

        #popupHover.show {
            display: block;
            animation: fadeZoom 0.4s ease;
        }

        @keyframes fadeZoom {
            from {
                opacity: 0;
                transform: translate(-50%, -50%) scale(0.8);
            }

            to {
                opacity: 1;
                transform: translate(-50%, -50%) scale(1);
            }
        }

        #popupHover .popup-header {
            background: linear-gradient(to right, #1e3c72, #2a5298);
            color: white;
            padding: 14px 20px;
            font-weight: 700;
            font-size: 20px;
        }

        #popupHover .popup-body {
            padding: 16px;
            border: 1px solid #e0e0e0;
            background: white;
        }

        #popupHover .popup-body p {
            margin: 0;
            padding: 8px 12px;
            font-size: 13px;
            color: #333;
            line-height: 1.4;
            word-wrap: break-word;
            word-break: break-word;
            white-space: normal;
        }

        #popupHover .popup-body p:last-child {
            border-bottom: none;

        }

        #popupHover .popup-body p:nth-child(odd) {
            background: #ffffff;
        }

        #popupHover .popup-body p:nth-child(even) {
            background: #f1f1f1;
        }

        .popup-header {
            background: linear-gradient(90deg, #f9fafc, #e2e8f0);
            padding: 12px 16px;
            border-bottom: 1px solid #ddd;
            font-weight: 600;
            position: relative;

        }

        #popupHover {
            opacity: 0;
            transform: translate(-50%, -50%) scale(0.95);
            transition: all 0.3s ease;
            pointer-events: none;
        }

        #popupHover .popup-body p {
            background: rgba(255, 255, 255, 0.1);
            font-size: 13px;
            color: #000;
            border-radius: 5px;
        }

        #popupHover.show {
            opacity: 1;
            transform: translate(-50%, -50%) scale(1);
            pointer-events: auto;
            z-index: 9999;
        }

        .order-date {
            font-size: 15px;
            color: #fff;
        }

        .btn-detail {

            color: black !important;
            border: none !important;
            border-radius: 6px;
            padding: 4px 10px;
            font-weight: 600;
        }

        .btn-detail:hover {
            background-color: #084298 !important;
            color: white !important;
        }

        .search-wrapper {
            border: 1px solid #ccc;
            border-radius: 6px;
            padding: 4px 8px;
            background: white;
        }

        .search-wrapper input {
            border: none;
            outline: none;
            flex: 1;
        }

        .search-wrapper svg {
            color: #0a53be;
        }

        .btn-inputdata {
            background: linear-gradient(90deg, #1e3c72, #2a5298);
            color: white;
            border: none;
            padding: 8px 20px;
            font-weight: 600;
            border-radius: 8px;
            display: flex;
            align-items: center;
            gap: 6px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
            transition: 0.3s ease;
        }

        .btn-inputdata:hover {
            background: linear-gradient(90deg, #2a5298, #1e3c72);
            color: white;
        }

        /* Hilangkan spinner di Chrome, Safari, Edge */
        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Hilangkan spinner di Firefox */
        input[type=number] {
            -moz-appearance: textfield;
        }

        .section-body {
            margin-top: 12px;
            /* atau 16px sesuai kebutuhan */
        }

        .page-title {
            font-size: 26px;
            font-weight: 700;
            color: #1e3c72;
            text-transform: uppercase;
            letter-spacing: 1px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .page-title::before {
            content: "";
            width: 8px;
            height: 32px;
            background: linear-gradient(180deg, #1e3c72, #2a5298);
            border-radius: 4px;
        }

        .page-title {
            position: relative;
            font-size: 26px;
            font-weight: 700;
            color: #1e3c72;
            text-transform: uppercase;
            letter-spacing: 1px;
            overflow: hidden;
        }

        .page-title::after {
            content: "";
            position: absolute;
            top: 0;
            left: -75%;
            width: 50%;
            height: 100%;
            background: linear-gradient(120deg, rgba(255, 255, 255, 0) 0%, rgba(255, 255, 255, 0.4) 50%, rgba(255, 255, 255, 0) 100%);
            transform: skewX(-20deg);
            animation: shine 2s infinite;
        }

        @keyframes shine {
            0% {
                left: -75%;
            }

            100% {
                left: 125%;
            }
        }

        .pagination .page-link {
            border-radius: 8px;
            margin: 0 4px;
            color: #0a53be;

        }

        .pagination .page-item.active .page-link {
            background: linear-gradient(90deg, #1e3c72, #2a5298);
            color: white;
            border: none;
        }

        .pagination .page-link:hover {
            background: #2a5298;
            color: white;
        }

        .table th {
            background: linear-gradient(to bottom, #1e3c72, #2a5297);
            color: white;
            font-weight: 600;
            font-size: 13px;
            padding-top: 10px;
            padding-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border: 1px solid #ccc;
        }

        .table td {
            font-size: 13px;
            padding-top: 4px;
            padding-bottom: 4px;
        }

        .d-flex.flex-wrap.align-items-center.justify-content-between.mb-3 label,
        .d-flex.flex-wrap.align-items-center.justify-content-between.mb-3 select,
        .d-flex.flex-wrap.align-items-center.justify-content-between.mb-3 input {
            font-size: 12px !important;
            padding: 4px 6px !important;
        }

        th.gwhide,
        td.gwhide {
            width: 1px !important;
            max-width: 1px !important;
            padding: 0 !important;
            margin: 0 !important;
            overflow: hidden !important;
            border: none !important;
            background: transparent !important;
            color: transparent !important;
            font-size: 0 !important;
        }

        .produk-row {
            margin-top: 0px;
        }

        .badge-status {
            padding: 2px 4px;
            font-size: 10px;
            border-radius: 2px;
            display: inline-block;
            color: white;
        }

        .badge-status.lunas {
            background: linear-gradient(90deg, #22c55e, #16a34a);
        }

        .badge-status.down-payment {
            background: linear-gradient(90deg, #facc15, #eab308);
            color: #333;
        }

        .badge-status.pre-order {
            background: linear-gradient(90deg, #3b82f6, #1d4ed8);
            color: #fff;
        }

        .badge-status.shopee {
            background: linear-gradient(90deg, #ee4d2d, #d73211);
            color: #fff;
        }

        .popupHover {
            position: fixed !important;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 9999;
            background: #fff;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            max-width: 400px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
        }

        .dataTables_length {
            display: none;
        }

        .dataTables_filter {
            display: none;
        }
    </style>
    <h4 class="page-title mb-4">Rekap Order Maxshoe</h4>
    <button class="btn btn-inputdata mb-3" onclick="toggleForm()">
        <i class="bi bi-plus-circle me-1"></i> Input Data
    </button>
    <div id="inputFormSection" style="display: none;">
        <form class="form-section" method="POST" action="{{ route('order.store') }}">
            @csrf
            <!-- DATA TEAM -->
            <div class="row g-0 mb-0">
                <div class="section-header mb-3 p-3 text-white rounded d-flex align-items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" fill="currentColor" class="me-2"
                        viewBox="0 0 16 16">
                        <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3z" />
                        <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6z" />
                    </svg>
                    <span class="fw-bold">TEAM LIVE</span>
                </div>
                <div class="container-fluid px-0">
                    <div class="row gx-2 gy-0 mb-3">
                        <div class="col-md-4">
                            <select required name="host_id" class="form-select form-select-sm">
                                <option selected disabled value="">Host</option>
                                @foreach ($host as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4">
                            <select required name="co_host_id" class="form-select form-select-sm">
                                <option selected disabled value="">Co Host</option>
                                @foreach ($co_host as $itemco_host)
                                    <option value="{{ $itemco_host->id }}">{{ $itemco_host->nama }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4">
                            <select required name="cs_id" class="form-select form-select-sm">
                                <option selected disabled value="">Customer Service</option>
                                @foreach ($cs as $itemcs)
                                    <option value="{{ $itemcs->id }}">{{ $itemcs->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <!-- DATA ORDER -->
            <div class="row gx-3 gy-0 mb-0">
                <div class="col-md-8">
                    <div class="section-header mb-3 p-3 text-white rounded d-flex align-items-center">
                        <i class="bi bi-bag me-2"></i> <span class="fw-bold">ORDER</span>
                    </div>

                    <div id="order-items">
                        <div class="row gx-2 gy-0 mb-3 order-item">
                            <div class="col-md-8 col-12">
                                <select required name="produk_id[]" class="form-select form-select-sm">
                                    <option selected disabled value="">Produk</option>
                                    @foreach ($produk as $itemcspd)
                                        <option value="{{ $itemcspd->id }}">{{ $itemcspd->nama_produk }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2 col-4">
                                <input required type="number" name="jumlah[]" class="form-control form-control-sm"
                                    placeholder="Jumlah">
                            </div>
                            <div class="col-md-2 col-8 d-flex">
                                <input required type="number" name="harga[]" class="form-control form-control-sm me-1"
                                    placeholder="Harga">
                                <button type="button" class="btn btn-danger btn-sm remove-item">
                                    <i class="bi bi-x"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <button type="button" id="add-item" class="btn btn-sm btn-primary mb-3">
                        <i class="bi bi-plus-circle"></i> Tambah Produk
                    </button>
                </div>


                <!-- Kolom Ekspedisi -->

                <div class="col-md-4">
                    <div class="section-header mb-3 p-3 text-white rounded d-flex align-items-center">
                        <i class="bi bi-truck me-2"></i><span class="fw-bold"> EKSPEDISI</span>
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-md-4">
                            <select required name="ekspedisi" class="form-select form-select-sm">
                                <option selected disabled value="">Ekspedisi</option>
                                <option value="JNE">JNE</option>
                                <option value="J&T">J&T</option>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <div class="input-group input-group-sm">
                                <input required type="number" class="form-control" name="kg" placeholder="Berat">
                                <span class="input-group-text">Kg</span>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <input required type="number" id="ongkirInput" name="ongkir"
                                class="form-control form-control-sm" placeholder="Ongkir">
                        </div>
                    </div>
                </div>
            </div>

            <div class="row gx-3 gy-2 mb-3">
                <!-- TRANSAKSI -->
                <div class="col-md-4">
                    <div class="section-header mb-3 p-3 text-white rounded d-flex align-items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" fill="currentColor" class="me-2"
                            viewBox="0 0 16 16">
                            <path d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0zM4 8a4 4 0 1 1 8 0A4 4 0 0 1 4 8z" />
                        </svg>
                        <span class="fw-bold">TRANSAKSI</span>
                    </div>

                    <div class="section-body d-flex flex-column gap-2">
                        <input required type="number" name="total_transfer" class="form-control form-control-sm"
                            id="totalTransferInput" placeholder="Total Transfer">
                        <input required type="text" name="atas_nama" class="form-control form-control-sm"
                            placeholder="a/n Transfer">
                    </div>
                    <div class="row gx-2 gy-2 mb-2 produk-row">
                        <div class="col-md-7 col-12">
                            <input required type="text" name="bank_transfer" class="form-control form-control-sm"
                                placeholder="Bank Transfer">
                        </div>
                        <div class="col-md-5">
                            <select required name="status" class="form-select form-select-sm">
                                <option selected disabled value="">Status</option>
                                <option value="LUNAS">LUNAS</option>
                                <option value="DOWN PAYMENT">DOWN PAYMENT</option>
                                <option value="PRE ORDER">PRE ORDER</option>
                                <option value="SHOPEE">SHOPEE</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- CUSTOMER -->
                <div class="col-md-8">
                    <div class="section-header mb-3 p-3 text-white rounded d-flex align-items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" fill="white" class="me-2"
                            viewBox="0 0 16 16">
                            <path d="M3 0h10a1 1 0 0 1 1 1v4H2V1a1 1 0 0 1 1-1z" />
                            <path d="M2 7v7a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V7H2z" />
                        </svg>
                        <span class="fw-bold">CUSTOMER</span>
                    </div>

                    <div class="section-body row gx-2">
                        <div class="col-md-4 d-flex flex-column gap-2">
                            <input required type="text" name="nama_penerima" class="form-control form-control-sm"
                                placeholder="Nama Penerima">
                            <input required type="number" name="nomor_hp" class="form-control form-control-sm"
                                placeholder="Nomor HP">
                            <input required type="number" name="kodepos" class="form-control form-control-sm"
                                placeholder="Kodepos">
                        </div>
                        <div class="col-md-8 d-flex flex-column justify-content-between">
                            <textarea required name="alamat" class="form-control form-control-sm mb-2" placeholder="Alamat Lengkap Penerima"
                                style="height: 109px; resize: none;"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-end">
                <button type="submit" class="btn btn-custom">Tambah Data</button>

            </div>
        </form>
    </div>
    <div class="mt-5">
        <div class="section-header mb-3 p-3 text-white rounded d-flex align-items-center">
            <i class="bi bi-table me-2"></i>
            <span class="fw-bold">REKAP ORDER MAXSHOE</span>
        </div>

        <div class="d-flex flex-wrap align-items-center justify-content-between mb-3">
            <div class="d-flex align-items-center flex-wrap" style="column-gap: 32px;">
                <div class="d-flex align-items-center gap-2">
                    <label class="mb-0"><b>Show :</b></label>
                    <select class="form-select form-select-sm" id="showLength" style="width: 80px; min-width: 80px;">
                        <option>5</option>
                        <option>10</option>
                        <option>25</option>
                        <option>50</option>
                    </select>
                </div>

                <div class="d-flex align-items-center gap-2">
                    <label class="mb-0"><b>Start Date :</b></label>
                    <input required type="date" id="startDate" class="form-control form-control-sm"
                        style="width: 160px;">
                </div>

                <div class="d-flex align-items-center gap-2">
                    <label class="mb-0"><b>End Date :</b></label>
                    <input required type="date" id="endDate" class="form-control form-control-sm"
                        style="width: 160px;">
                </div>
            </div>

            <div class="search-wrapper d-flex align-items-center"
                style="border: 1px solid #ccc; border-radius: 6px; padding: 0px 8px; margin: 0px 5px;background: white; max-width: 220px; width: 100%;">
                <input required type="text" class="form-control form-control-sm border-0 shadow-none"
                    placeholder="Search...">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="#0a53be" class="ms-2"
                    viewBox="0 0 16 16">
                    <path
                        d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85zm-5.242 1.106a5 5 0 1 1 0-10 5 5 0 0 1 0 10z" />
                </svg>
            </div>
        </div>

        <!-- TABLE SECTION DENGAN FIX SCROLL -->

        <div class="table-responsive">
            <table id="orderTable" class="table table-bordered table-striped align-middle small">
                <thead class="table-primary">
                    <tr>
                        <th>NO</th>
                        <th>TGL</th>
                        <th>STATUS</th>
                        <th>HOST</th>
                        <th>AS HOST</th>
                        <th>CS</th>
                        <th>PRODUK</th>
                        <th>JML</th>
                        <th>HARGA</th>
                        <th>EKSP</th>
                        <th>B</th>
                        <th>ONGKIR</th>
                        <th>TOTAL TF</th>
                        <th>NAMA TF</th>
                        <th>BANK TF</th>
                        <th>NAMA PENERIMA</th>
                        <th>NO HP</th>
                        <th>ALAMAT LENGKAP</th>
                        <th>K.POS</th>
                        <th>UBAH DATA</th>
                    </tr>
                </thead>
            </table>
            <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

            <script>
                $(function() {
                    let table = $('#orderTable').DataTable({
                        processing: true,
                        serverSide: true,
                        ajax: {
                            url: "{{ route('order.data') }}",
                            data: function(d) {
                                d.start_date = $('#startDate').val();
                                d.end_date = $('#endDate').val();
                            }
                        },
                        lengthMenu: [5, 10, 25, 50], // default pilihan
                        pageLength: 5, // default pertama
                        columns: [{
                                data: 'DT_RowIndex',
                                name: 'DT_RowIndex',
                                orderable: false,
                                searchable: false,
                                render: function(data, type, row) {
                                    return `
                                        <button class="btn btn-sm btn-detail" onmouseenter="showPopup(${row.id})" onmouseleave="hidePopup(${row.id})">${data}</button>
                                        <div id="popup-${row.id}" class="popupHover" style="display:none; position:absolute; z-index:999; background:#fff; padding:10px; border:1px solid #ccc; border-radius:8px; max-width:300px;">
                                            <div class="popup-header">Detail Order No : ${data}</div>
                                            <div class="popup-body">
                                                <p><strong>Order ID :</strong> ${row.order_id}</p>
                                                <p><strong>Produk :</strong> ${row.produk}</p>
                                                <p><strong>Jumlah :</strong> ${row.jumlah}</p>
                                                <p><strong>Harga :</strong> ${row.harga}</p>
                                                <p><strong>Ekspedisi :</strong> ${row.ekspedisi}</p>
                                                <p><strong>Berat :</strong> ${row.berat}</p>
                                                <p><strong>Ongkir :</strong> ${row.ongkir}</p>
                                                <p><strong>Total TF :</strong> ${row.total_tf}</p>
                                                <p><strong>Nama TF :</strong> ${row.atas_nama}</p>
                                                <p><strong>Bank TF :</strong> ${row.bank_transfer}</p>
                                                <p><strong>Nama Penerima :</strong> ${row.nama_penerima}</p>
                                                <p><strong>No HP :</strong> ${row.nomor_hp}</p>
                                                <p><strong>Alamat Lengkap :</strong> ${row.alamat}</p>
                                                <p><strong>Kode Pos :</strong> ${row.kodepos}</p>
                                            </div>
                                        </div>
                                    `;
                                }

                            },
                            {
                                data: 'tgl',
                                name: 'tgl'
                            },
                            {
                                data: 'status',
                                name: 'status'
                            },
                            {
                                data: 'host',
                                name: 'host'
                            },
                            {
                                data: 'co_host',
                                name: 'co_host'
                            },
                            {
                                data: 'cs',
                                name: 'cs'
                            },
                            {
                                data: 'produk',
                                name: 'produk'
                            },
                            {
                                data: 'jumlah',
                                name: 'jumlah'
                            },
                            {
                                data: 'harga',
                                name: 'harga'
                            },
                            {
                                data: 'ekspedisi',
                                name: 'ekspedisi'
                            },
                            {
                                data: 'berat',
                                name: 'berat'
                            },
                            {
                                data: 'ongkir',
                                name: 'ongkir'
                            },
                            {
                                data: 'total_tf',
                                name: 'total_tf'
                            },
                            {
                                data: 'atas_nama',
                                name: 'atas_nama'
                            },
                            {
                                data: 'bank_transfer',
                                name: 'bank_transfer'
                            },
                            {
                                data: 'nama_penerima',
                                name: 'nama_penerima'
                            },
                            {
                                data: 'nomor_hp',
                                name: 'nomor_hp'
                            },
                            {
                                data: 'alamat',
                                name: 'alamat'
                            },
                            {
                                data: 'kodepos',
                                name: 'kodepos'
                            },

                            {
                                data: 'ubah',
                                name: 'ubah',
                                orderable: false,
                                searchable: false
                            }
                        ]
                    });
                    // 🔹 "Show" dropdown custom
                    $('select.form-select-sm').on('change', function() {
                        table.page.len($(this).val()).draw();
                    });

                    // 🔹 Date filter
                    $('#startDate, #endDate').on('change', function() {
                        table.draw();
                    });

                    // 🔹 Custom search box
                    $('.search-wrapper input').on('keyup', function() {
                        table.search(this.value).draw();
                    });
                });

                function showPopup(id) {
                    $("#popup-" + id).show();
                }

                function hidePopup(id) {
                    $("#popup-" + id).hide();
                }
            </script>
        </div>
        <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const container = document.getElementById("order-items");
                const addBtn = document.getElementById("add-item");

                addBtn.addEventListener("click", function() {
                    let newItem = document.createElement("div");
                    newItem.classList.add("row", "gx-2", "gy-0", "mb-3", "order-item");
                    newItem.innerHTML = `
            <div class="col-md-8 col-12">
                <select required name="produk_id[]" class="form-select form-select-sm">
                    <option selected disabled value="">Produk</option>
                    @foreach ($produk as $itemcspd)
                        <option value="{{ $itemcspd->id }}">{{ $itemcspd->nama_produk }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2 col-4">
                <input required type="number" name="jumlah[]" class="form-control form-control-sm" placeholder="Jumlah">
            </div>
            <div class="col-md-2 col-8 d-flex">
                <input required type="number" name="harga[]" class="form-control form-control-sm me-1" placeholder="Harga">
                <button type="button" class="btn btn-danger btn-sm remove-item">
                    <i class="bi bi-x"></i>
                </button>
            </div>
        `;
                    container.appendChild(newItem);
                });

                container.addEventListener("click", function(e) {
                    if (e.target.closest(".remove-item")) {
                        e.target.closest(".order-item").remove();
                    }
                });
            });
        </script>

        <script>
            $(document).ready(function() {
                $(".btn-detail").hover(function() {
                    $("#popupHover").addClass("show");
                }, function() {
                    $("#popupHover").removeClass("show");
                });
            });
        </script>
        <script>
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
        <script>
            function toggleForm() {
                const form = document.getElementById("inputFormSection");
                if (form.style.display === "none" || form.style.display === "") {
                    form.style.display = "block";
                } else {
                    form.style.display = "none";
                }
            }
        </script>
        <script>
            function toggleForm() {
                $("#inputFormSection").slideToggle(300);
            }
        </script>

        <script>
            function formatRupiah(input) {
                input.addEventListener("input", function(e) {
                    let angka = e.target.value.replace(/\./g, "").replace(/\D/g, "");
                    e.target.value = angka.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                });
            }

            formatRupiah(document.getElementById("hargaInput"));
            formatRupiah(document.getElementById("ongkirInput"));
            formatRupiah(document.getElementById("totalTransferInput"));
        </script>
        <script>
            $(document).ready(function() {
                $("table tbody tr").each(function() {
                    var produkCell = $(this).find("td").eq(6); // PRODUK
                    var hargaCell = $(this).find("td").eq(8); // HARGA

                    var produkText = produkCell.text().trim();
                    if (produkText.includes(",")) {
                        var produkList = produkText.split(",");
                        produkCell.html(produkList.map(item => item.trim()).join("<br>"));
                    }

                    var hargaText = hargaCell.text().trim();
                    if (hargaText.includes(",")) {
                        var hargaList = hargaText.split(",");
                        hargaCell.html(hargaList.map(item => item.trim()).join("<br>"));
                    }
                });
            });
        </script>
        <script>
            $(document).ready(function() {
                var popup = $("#popupHover");

                popup.find(".popup-body p").each(function() {
                    var text = $(this).html();
                    if (text.includes("Produk :")) {
                        var value = text.split("Produk :")[1].trim();
                        if (value.includes(",")) {
                            var items = value.split(",");
                            $(this).html("<strong>Produk :</strong><br>" + items.map(v => v.trim()).join(
                                "<br>"));
                        }
                    }
                    if (text.includes("Harga :")) {
                        var value = text.split("Harga :")[1].trim();
                        if (value.includes(",")) {
                            var items = value.split(",");
                            $(this).html("<strong>Harga :</strong><br>" + items.map(v => v.trim()).join(
                                "<br>"));
                        }
                    }
                });
            });
        </script>
    @endsection
