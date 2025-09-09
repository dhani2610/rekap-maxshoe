@extends('backend.layouts-news.app')

@section('content')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.min.css" rel="stylesheet">

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

        .badge-status.dp {
            background: linear-gradient(90deg, #facc15, #eab308);
            color: #333;
            /* Biar kontras karena kuning */
        }

        .badge-status.po {
            background: linear-gradient(90deg, #3b82f6, #1d4ed8);
        }

        .badge-status.cod {
            background: linear-gradient(90deg, #f43f5e, #b91c1c);
            color: #fff;
        }

        body {
            background: #f9fafc;
            font-family: 'Poppins', sans-serif;
            margin: 0;
        }

        .dashboard-filter {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            align-items: center;
            margin-bottom: 20px;
        }

        .summary-wrapper {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 20px;
            width: 100%;
        }

        .summary-card {
            position: relative;
            border-radius: 12px;
            padding: 15px;
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.1);
            text-align: left;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            justify-content: center;
            width: 100%;
            transition: box-shadow 0.3s ease;
        }

        .summary-card:hover {
            box-shadow: 0 16px 32px rgba(0, 0, 0, 0.15);
        }

        .summary-card svg {
            position: absolute;
            bottom: 0;
            right: 0;
            opacity: 0.1;
            width: 120px;
            height: 120px;
            pointer-events: none;
        }

        .summary-card:nth-child(1) {
            background: linear-gradient(to right, #1e3c72, #2a5298);
            color: white;
        }

        .summary-card:nth-child(2) {
            background: linear-gradient(to right, #22c55e, #16a34a);
            color: white;
        }

        .summary-card:nth-child(3) {
            background: linear-gradient(to right, #ffc107, #ffb300);
            color: white;
        }

        .summary-card:nth-child(4) {
            background: linear-gradient(to right, #0d6efd, #0056b3);
            color: white;
        }

        .luxury-style:nth-child(5) {
            background: linear-gradient(90deg, #f43f5e, #b91c1c);
        }

        .summary-text h6 {
            margin: 0;
            font-size: 14px;
            font-weight: 600;
        }

        .summary-text h4 {
            margin: 0;
            font-size: 28px;
            font-weight: 700;
        }

        .filter-button {
            background: linear-gradient(90deg, #1e3c72, #2a5298);
            color: white;
            border: none;
            border-radius: 8px;
            padding: 8px 20px;
            font-weight: 600;
            cursor: pointer;
            position: relative;
        }

        .filter-button:hover {
            background: linear-gradient(90deg, #2a5298, #1e3c72);
        }

        .filter-button2 {
            background: linear-gradient(90deg, #22c55e, #16a34a);
            color: white;
            border: none;
            border-radius: 8px;
            padding: 8px 20px;
            font-weight: 600;
            cursor: pointer;
            position: relative;
        }

        .filter-button2:hover {
            background: linear-gradient(90deg, #15803d, #14532d);
        }

        .daterangepicker {
            left: 220px !important;
            transform: translateY(10px) !important;
            z-index: 1050 !important;
        }

        .container-fluid {
            max-width: 100%;
            padding-left: 0;
            padding-right: 0;
        }

        .luxury-style {
            position: relative;
            background: linear-gradient(135deg, #1a2a6c, #b21f1f, #fdbb2d);
            color: white;
            border-radius: 16px;
            padding: 20px;
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.2);
            overflow: hidden;
        }

        .luxury-content {
            position: relative;
            z-index: 2;
        }

        .luxury-count h3 {
            margin: 0;
            font-size: 28px;
            font-weight: 700;
            letter-spacing: 1px;
        }

        .luxury-count span {
            font-size: 12px;
            font-weight: 500;
            text-transform: uppercase;
            opacity: 0.8;
        }

        .luxury-line {
            height: 2px;
            width: 100%;
            background: white;
            opacity: 0.3;
            margin: 10px 0;
        }

        .luxury-omzet p {
            margin: 12px 0 4px;
            font-size: 14px;
            opacity: 0.8;
        }

        .luxury-omzet h4 {
            margin: 0;
            font-size: 22px;
            font-weight: 700;
        }

        .luxury-svg {
            position: absolute;
            right: -20px;
            bottom: -20px;
            width: 120px;
            height: 120px;
            opacity: 0.3;
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
    <h4 class="page-title mb-4">DATA Order Maxshoe</h4>
    <div class="dashboard-filter position-relative">
        <label class="fw-semibold">Filter Tanggal :</label>
        <button id="rangePickerBtn" class="filter-button"></button>
        <input type="text" class="form-control d-none" id="rangePicker" placeholder="Pilih Tanggal">
        <label class="fw-semibold">Show :</label>
        <select class="form-select w-auto" id="showLength">
            <option value="25">25</option>
            <option value="50">50</option>
            <option value="100">100</option>
        </select>
        <label class="fw-semibold">Status :</label>
        <select class="form-select w-auto" id="statusFilter">
            <option value="all">SEMUA</option>
            <option value="LUNAS">LUNAS</option>
            <option value="DOWN PAYMENT">DOWN PAYMENT</option>
            <option value="PRE ORDER">PRE ORDER</option>
            <option value="SHOPEE">SHOPEE</option>
        </select>
        <label class="fw-semibold">CS :</label>
        <select class="form-select w-auto" id="csFilter">
            <option value="all">Semua</option>
            @foreach ($cs as $itemcs)
                <option value="{{ $itemcs->id }}">{{ $itemcs->name }}</option>
            @endforeach
        </select>

        <input type="hidden" id="startDate">
        <input type="hidden" id="endDate">
    </div>
    <div class="container-fluid py-4">

        <div class="summary-wrapper">
            <!-- Item Diproses -->
            <div class="summary-card luxury-style">
                <div class="luxury-content">
                    <div class="luxury-count">
                        <h3>0 <span>Item <b>Diproses</b></span></h3>
                        <div class="luxury-line"></div>
                    </div>
                    <div class="luxury-omzet">
                        <h4>Rp 0</h4>
                    </div>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" fill="white" viewBox="1 2 15 15">
                    <path
                        d="M3 5h13v10h-3a3 3 0 0 0-6 0H3V5Zm14 0h4l2 4v6h-2a3 3 0 0 0-6 0h-2V5Zm-7 9a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Zm8 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Z" />
                </svg>
            </div>

            <!-- Item Lunas -->
            <div class="summary-card luxury-style">
                <div class="luxury-content">
                    <div class="luxury-count">
                        <h3>0 <span>Item <b>LUNAS</b></span></h3>
                        <div class="luxury-line"></div>
                    </div>
                    <div class="luxury-omzet">
                        <h4>Rp 0</h4>
                    </div>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" fill="white" viewBox="2 2 15 15">
                    <path d="M12 2a10 10 0 1 0 0 20 10 10 0 0 0 0-20zm-1 14.7l-5-5
                                                  1.4-1.4L11 13.9l5.6-5.6 1.4 1.4-7 7z" />
                </svg>
            </div>

            <!-- Down Payment -->
            <div class="summary-card luxury-style">
                <div class="luxury-content">
                    <div class="luxury-count">
                        <h3>0 <span>Item <b>DOWN PAYMENT</b></span></h3>
                        <div class="luxury-line"></div>
                    </div>
                    <div class="luxury-omzet">
                        <h4>Rp 0</h4>
                    </div>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" fill="white" viewBox="2 2 15 15">
                    <path
                        d="M12 2a10 10 0 1 1-7.07 2.93A10 10 0 0 1 12 2Zm0 2a8 8 0 1 0 5.66 2.34A8 8 0 0 0 12 4Zm.5 3h-1v5l4.3 2.6.5-.87-3.8-2.23V7Z" />
                </svg>
            </div>

            <!-- Pre Order -->
            <div class="summary-card luxury-style">
                <div class="luxury-content">
                    <div class="luxury-count">
                        <h3>0 <span>Item <b>PRE ORDER</b></span></h3>
                        <div class="luxury-line"></div>
                    </div>
                    <div class="luxury-omzet">
                        <h4>Rp 0</h4>
                    </div>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" fill="white" viewBox="2 2 15 15">
                    <path d="M4 4h16v16H4V4Zm2 4v8h12V8H6Zm4 1h4v2h-4V9Zm0 4h4v2h-4v-2Z" />
                </svg>
            </div>

            <!-- COD -->
            <div class="summary-card luxury-style">
                <div class="luxury-content">
                    <div class="luxury-count">
                        <h3>0 <span>Item <b>SHOPEE</b></span></h3>
                        <div class="luxury-line"></div>
                    </div>
                    <div class="luxury-omzet">
                        <h4>Rp 0</h4>
                    </div>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" fill="white" viewBox="0 0 24 24">
                    <path d="M2 4h20v16H2z" fill="white" />
                </svg>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-center flex-wrap" style="margin-top: 4px; margin-bottom: -30px;">
        <div class="search-wrapper d-flex align-items-center"
            style="border: 1px solid #ccc; border-radius: 6px; padding: 0px 8px; margin: 0px 5px;background: white; max-width: 220px; width: 100%;">
            <input type="text" class="form-control form-control-sm border-0 shadow-none" placeholder="Search...">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="#0a53be" class="ms-2"
                viewBox="0 0 16 16">
                <path
                    d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85zm-5.242 1.106a5 5 0 1 1 0-10 5 5 0 0 1 0 10z">
                </path>
            </svg>
        </div>

        <button class="filter-button2">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="white" viewBox="0 0 24 24">
                <path
                    d="M5 20h14v-2H5Zm7-18a1 1 0 0 1 1 1v12.17l3.59-3.58L18 13l-6 6-6-6 1.41-1.41L11 15.17V3a1 1 0 0 1 1-1Z">
                </path>
            </svg>
            Download Data
        </button>
    </div>

    <div class="mt-5">
        <div class="section-header mb-3 p-3 text-white rounded d-flex align-items-center">
            <i class="bi bi-table me-2"></i>
            <span class="fw-bold">DATA ORDER MAXSHOE</span>
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
                    loadRekap();
                    let table = $('#orderTable').DataTable({
                        processing: true,
                        serverSide: true,
                        ajax: {
                            url: "{{ route('order.data-all') }}",
                            data: function(d) {
                                d.start_date = $('#startDate').val();
                                d.end_date = $('#endDate').val();
                                d.status = $('#statusFilter').val();
                                d.cs = $('#csFilter').val();
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
                    $('#showLength').on('change', function() {
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


                    // 🔹 Trigger filter
                    $('#startDate, #endDate, #statusFilter, #csFilter').on('change', function() {
                        table.draw();
                        loadRekap();
                    });
                });

                function loadRekap() {
                    $.ajax({
                        url: "{{ route('order.rekap.data.json') }}",
                        data: {
                            start_date: $('#startDate').val(),
                            end_date: $('#endDate').val(),
                            status: $('#statusFilter').val(),
                            cs: $('#csFilter').val()
                        },
                        success: function(res) {
                            console.log(res);

                            $('.summary-card:contains("Diproses") h3').html(res.diproses.count +
                                " <span>Item <b>Diproses</b></span>");
                            $('.summary-card:contains("Diproses") h4').text("Rp " + res.diproses.omzet
                                .toLocaleString());

                            $('.summary-card:contains("LUNAS") h3').html(res.lunas.count +
                                " <span>Item <b>LUNAS</b></span>");
                            $('.summary-card:contains("LUNAS") h4').text("Rp " + res.lunas.omzet
                                .toLocaleString());

                            $('.summary-card:contains("DOWN PAYMENT") h3').html(res.dp.count +
                                " <span>Item <b>DOWN PAYMENT</b></span>");
                            $('.summary-card:contains("DOWN PAYMENT") h4').text("Rp " + res.dp.omzet
                                .toLocaleString());

                            $('.summary-card:contains("PRE ORDER") h3').html(res.po.count +
                                " <span>Item <b>PRE ORDER</b></span>");
                            $('.summary-card:contains("PRE ORDER") h4').text("Rp " + res.po.omzet
                                .toLocaleString());

                            $('.summary-card:contains("SHOPEE") h3').html(res.shopee.count +
                                " <span>Item <b>SHOPEE</b></span>");
                            $('.summary-card:contains("SHOPEE") h4').text("Rp " + res.shopee.omzet
                                .toLocaleString());
                        }
                    });
                }


                function showPopup(id) {
                    $("#popup-" + id).show();
                }

                function hidePopup(id) {
                    $("#popup-" + id).hide();
                }
            </script>
        </div>
        <script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
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
    @endsection
