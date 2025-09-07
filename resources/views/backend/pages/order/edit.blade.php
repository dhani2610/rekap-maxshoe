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
        <i class="bi bi-plus-circle me-1"></i> Edit Data
    </button>
        <form class="form-section" method="POST" action="{{ route('order.update',$order->id) }}">
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
                                <option selected hidden>Host</option>
                                @foreach ($host as $item)
                                    <option value="{{ $item->id }}" {{ $order->host_id == $item->id ? 'selected' : '' }} >{{ $item->nama }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4">
                            <select required name="co_host_id" class="form-select form-select-sm">
                                <option selected hidden>Co Host</option>
                                @foreach ($co_host as $itemco_host)
                                    <option value="{{ $itemco_host->id }}" {{ $order->co_host_id == $itemco_host->id ? 'selected' : '' }}>{{ $itemco_host->nama }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4">
                            <select required name="cs_id" class="form-select form-select-sm">
                                <option selected hidden>Customer Service</option>
                                @foreach ($cs as $itemcs)
                                    <option value="{{ $itemcs->id }}" {{ $order->cs_id == $itemcs->id ? 'selected' : '' }}>{{ $itemcs->nama }}</option>
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
                        @foreach ($orderDetail as $itemod)
                            <div class="row gx-2 gy-0 mb-3 order-item">
                                <div class="col-md-8 col-12">
                                    <select required name="produk_id[]" class="form-select form-select-sm">
                                        <option selected hidden>Produk</option>
                                        @foreach ($produk as $itemcspd)
                                            <option value="{{ $itemcspd->id }}" {{ $itemod->produk_id == $itemcspd->id ? 'selected' : '' }}>{{ $itemcspd->nama_produk }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2 col-4">
                                    <input required type="number" name="jumlah[]" value="{{ $itemod->jumlah }}" class="form-control form-control-sm"
                                        placeholder="Jumlah">
                                </div>
                                <div class="col-md-2 col-8 d-flex">
                                    <input required type="number" name="harga[]" value="{{ $itemod->harga }}" class="form-control form-control-sm me-1"
                                        placeholder="Harga">
                                    <button type="button" class="btn btn-danger btn-sm remove-item">
                                        <i class="bi bi-x"></i>
                                    </button>
                                </div>
                            </div>
                        @endforeach
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
                                <option selected hidden>Ekspedisi</option>
                                <option value="JNE" {{ $order->ekspedisi == 'JNE' ? 'selected' : '' }}>JNE</option>
                                <option value="J&T" {{ $order->ekspedisi == 'J&T' ? 'selected' : '' }}>J&T</option>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <div class="input-group input-group-sm">
                                <input required type="number" class="form-control" name="kg" value="{{ $order->berat }}" placeholder="Berat">
                                <span class="input-group-text">Kg</span>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <input required type="number" id="ongkirInput" name="ongkir" value="{{ $order->ongkir }}"
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
                        <input required type="number" value="{{ $order->total_transfer }}" name="total_transfer" class="form-control form-control-sm"
                            id="totalTransferInput" placeholder="Total Transfer">
                        <input required type="text" value="{{ $order->atas_nama }}" name="atas_nama" class="form-control form-control-sm"
                            placeholder="a/n Transfer">
                    </div>
                    <div class="row gx-2 gy-2 mb-2 produk-row">
                        <div class="col-md-7 col-12">
                            <input required type="text" name="bank_transfer" value="{{ $order->bank_transfer }}" class="form-control form-control-sm"
                                placeholder="Bank Transfer">
                        </div>
                        <div class="col-md-5">
                            <select required name="status" class="form-select form-select-sm">
                                <option selected hidden>Status</option>
                                <option value="LUNAS" {{ $order->status == 'LUNAS' ? 'selected' : '' }} >LUNAS</option>
                                <option value="DOWN PAYMENT" {{ $order->status == 'DOWN PAYMENT' ? 'selected' : '' }} >DOWN PAYMENT</option>
                                <option value="PRE ORDER" {{ $order->status == 'PRE ORDER' ? 'selected' : '' }} >PRE ORDER</option>
                                <option value="SHOPEE" {{ $order->status == 'SHOPEE' ? 'selected' : '' }} >SHOPEE</option>
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
                            <input required type="text" value="{{ $order->nama_penerima }}" name="nama_penerima" class="form-control form-control-sm"
                                placeholder="Nama Penerima">
                            <input required type="number" value="{{ $order->nomor_hp }}" name="nomor_hp" class="form-control form-control-sm"
                                placeholder="Nomor HP">
                            <input required type="number" value="{{ $order->kodepos }}" name="kodepos" class="form-control form-control-sm"
                                placeholder="Kodepos">
                        </div>
                        <div class="col-md-8 d-flex flex-column justify-content-between">
                            <textarea required name="alamat" class="form-control form-control-sm mb-2" placeholder="Alamat Lengkap Penerima"
                                style="height: 109px; resize: none;">{{ $order->alamat }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-end">
                <button type="submit" class="btn btn-custom">Simpan Data</button>

            </div>
        </form>
   

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
                    <option selected hidden>Produk</option>
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
