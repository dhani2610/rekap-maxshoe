@extends('backend.layouts-news.app')

@section('content')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        body {
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

        .page-title {
            font-size: 26px;
            font-weight: 700;
            color: #1e3c72;
            text-transform: uppercase;
            letter-spacing: 1px;
            display: flex;
            align-items: center;
            gap: 12px;
            position: relative;
            overflow: hidden;
        }

        .page-title::before {
            content: "";
            width: 8px;
            height: 32px;
            background: linear-gradient(180deg, #1e3c72, #2a5298);
            border-radius: 4px;
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

        h1 {
            text-align: center;
            color: #1e3a8a;
            margin-bottom: 40px;
            font-size: 1.8rem;
        }

        .card-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            width: 100%;
            margin-bottom: -15px;
        }

        .employee-card {
            flex: 1;
            min-width: 350px;
            background: linear-gradient(to right, #1e3a8a, #1e40af);
            border-radius: 12px;
            padding: 16px 20px;
            color: #ffffff;
            position: relative;
            box-shadow: 0 4px 18px rgba(0, 0, 0, 0.06);
        }

        .employee-card img {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            border: 2px solid #ffffff;
            object-fit: cover;
            position: absolute;
            top: 16px;
            right: 20px;
        }

        .info h3 {
            margin: 0;
            font-size: 1rem;
            font-weight: 600;
            color: #ffffff;
        }

        .badge-role {
            display: inline-block;
            background: rgba(255, 255, 255, 0.15);
            color: #ffffff;
            font-size: 0.7rem;
            padding: 3px 8px;
            border-radius: 999px;
            margin: 4px 0 8px;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            font-size: 0.82rem;
            margin: 6px 0;
            padding-bottom: 4px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }

        .info-row .value {
            font-weight: 600;
        }

        .ranking-table {
            margin-top: 20px;
            width: 100%;
            border-collapse: collapse;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.04);
        }

        .ranking-table th {
            background-color: #1e3a8a;
            color: white;
            text-align: left;
            padding: 12px 16px;
            font-size: 0.9rem;
        }

        .ranking-table td {
            padding: 12px 16px;
            border-bottom: 1px solid #e5e7eb;
            font-size: 0.88rem;
            color: #1f2937;
            position: relative;
        }

        .ranking-table tr:last-child td {
            border-bottom: none;
        }

        .ranking-table tbody tr:nth-child(1) td:first-child::before {
            content: '🥇 ';
        }

        .ranking-table tbody tr:nth-child(2) td:first-child::before {
            content: '🥈 ';
        }

        .ranking-table tbody tr:nth-child(3) td:first-child::before {
            content: '🥉 ';
        }

        .ranking-table tbody tr:nth-child(-n+3) td {
            animation: sparkle 1.4s infinite ease-in-out alternate;
        }

        @keyframes sparkle {
            0% {
                box-shadow: 0 0 5px gold;
            }

            100% {
                box-shadow: 0 0 15px gold;
            }
        }

        .summary-grid {
            display: flex;
            gap: 20px;
            margin-bottom: 30px;
            justify-content: space-between;
        }

        .summary-card {
            flex: 1;
            padding: 20px;
            border-radius: 12px;
            background: linear-gradient(to right, #1e3a8a, #1e40af);
            color: white;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
            text-align: center;
        }

        .summary-card h2 {
            font-size: 1.2rem;
        }

        .summary-card p {
            font-size: 1.6rem;
            font-weight: 600;
            margin: 0;
        }

        .card-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            width: 100%;
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
    </style>

    <h4 class="page-title mb-4">KOMISI KARYAWAN</h4>
    <div class="dashboard-filter position-relative">
        <label class="fw-semibold">Filter Tanggal :</label>
        <button id="rangePickerBtn2" class="filter-button"></button>
        <input type="text" class="form-control d-none" id="rangePicker" placeholder="Pilih Tanggal">
        <input type="hidden" id="startDate">
        <input type="hidden" id="endDate">
    </div>
    <div class="mt-5">
        <div class="summary-grid">
            <div class="summary-card">
                <h2>Total Omzet</h2>
                <p>Rp 0</p>
            </div>
            <div class="summary-card">
                <h2>Total Item</h2>
                <p>0</p>
            </div>
            <div class="summary-card">
                <h2>Total Komisi</h2>
                <p>Rp 0</p>
            </div>
        </div>
        <div class="section-header mb-3 p-3 text-white rounded d-flex align-items-center">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" fill="white" class="me-2" viewBox="0 0 16 16">
                <path d="M3 0h10a1 1 0 0 1 1 1v4H2V1a1 1 0 0 1 1-1z" />
                <path d="M2 7v7a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V7H2z" />
            </svg>
            <span class="fw-bold">KOMISI</span>
        </div>
        <div class="card-grid">
            <div class="employee-card">
                <img src="https://i.pravatar.cc/100?img=1" />
                <div class="info">
                    <h3>..</h3>
                    <div class="badge-role">CS Senior</div>
                    <div class="info-row"><span class="label">Total Omzet</span><span class="value">Rp 0</span>
                    </div>
                    <div class="info-row"><span class="label">Jumlah Item</span><span class="value">0</span></div>
                    <div class="info-row"><span class="label">Komisi</span><span class="value">Rp 0</span></div>
                </div>
            </div>

            <div class="employee-card">
                <img src="https://i.pravatar.cc/100?img=3" />
                <div class="info">
                    <h3>..</h3>
                    <div class="badge-role">Host Live</div>
                    <div class="info-row"><span class="label">Total Omzet</span><span class="value">Rp 0</span>
                    </div>
                    <div class="info-row"><span class="label">Jumlah Item</span><span class="value">0</span></div>
                    <div class="info-row"><span class="label">Komisi</span><span class="value">Rp 0</span></div>
                </div>
            </div>
        </div>
    </div>
    <div class="mt-5">
        <div class="section-header mb-3 p-3 text-white rounded d-flex align-items-center">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" fill="white" class="me-2" viewBox="0 0 24 24">
                <path
                    d="M17 3h-10v2H3v4c0 3.53 2.61 6.43 6 6.92V18H7v2h10v-2h-2v-2.08c3.39-.49 6-3.39 6-6.92V5h-4V3zm0 4h2v2c0 2.38-1.71 4.37-4 4.9V7h2zm-8 4.9c-2.29-.53-4-2.52-4-4.9V7h2v5.9zm4-6.9v8h-2V5h2z" />
            </svg>
            <span class="fw-bold">RANKING</span>
        </div>
        <table class="ranking-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Posisi</th>
                    <th>Total Omzet</th>
                    <th>Jumlah Item</th>
                    <th>Komisi</th>
                </tr>
            </thead>
            <tbody>
            
            </tbody>
        </table>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

    <script>
        function loadDataKomisi() {
            let startDate = $('#startDate').val();
            let endDate = $('#endDate').val();

            $.ajax({
                url: "{{ route('komisi.data') }}", // ganti sesuai route API kamu
                method: "GET",
                data: {
                    start_date: startDate,
                    end_date: endDate
                },
                success: function(res) {
                    // === Update Summary ===
                    $(".summary-card:eq(0) p").text("Rp " + res.summary.total_omzet);
                    $(".summary-card:eq(1) p").text(res.summary.total_item);
                    $(".summary-card:eq(2) p").text("Rp " + res.summary.total_komisi);

                    // === Update Employee Cards ===
                    let cardGrid = $(".card-grid");
                    cardGrid.empty(); // clear dulu
                    res.employee_card.forEach(emp => {
                        cardGrid.append(`
                        <div class="employee-card">
                            <img src="${emp.foto}" />
                            <div class="info">
                                <h3>${emp.nama}</h3>
                                <div class="badge-role">${emp.posisi}</div>
                                <div class="info-row"><span class="label">Total Omzet</span><span class="value">Rp ${emp.omzet}</span></div>
                                <div class="info-row"><span class="label">Jumlah Item</span><span class="value">${emp.item}</span></div>
                                <div class="info-row"><span class="label">Komisi</span><span class="value">Rp ${emp.komisi}</span></div>
                            </div>
                        </div>
                    `);
                    });

                    // === Update Ranking Table ===
                    let tbody = $(".ranking-table tbody");
                    tbody.empty();
                    res.ranking.forEach((rank, index) => {
                        tbody.append(`
                        <tr>
                            <td>${index + 1}</td>
                            <td>${rank.nama}</td>
                            <td>${rank.posisi}</td>
                            <td>Rp ${rank.omzet}</td>
                            <td>${rank.item}</td>
                            <td>Rp ${rank.komisi}</td>
                        </tr>
                    `);
                    });
                }
            });
        }

        // Trigger pertama kali saat load page
        $(document).ready(function() {
            loadDataKomisi();
        });

        // Trigger kalau ganti tanggal
        $('#rangePickerBtn2').on('apply.daterangepicker', function() {
            loadDataKomisi();
        });
    </script>
@endsection
