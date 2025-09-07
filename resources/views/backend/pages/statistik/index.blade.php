@extends('backend.layouts-news.app')

@section('content')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css">
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">


    <style>
        body {
            background: #f9fafc;
            font-family: 'Poppins', sans-serif;
        }

        .dashboard-filter {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            align-items: center;
            margin-bottom: 30px;
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
        }

        .page-title::before {
            content: "";
            width: 8px;
            height: 32px;
            background: linear-gradient(180deg, #1e3c72, #2a5298);
            border-radius: 4px;
        }

        .page-title span {
            background: linear-gradient(to right, #1e3c72, #2a5298);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .stats-box {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 16px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .stat-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 20px;
        }

        .stat-value {
            font-size: 20px;
            font-weight: 700;
            margin: 0;
        }

        .stat-label {
            font-size: 12px;
            margin: 0;
            color: #555;
        }

        .icon-orange {
            background: linear-gradient(90deg, #334155, #475569);
        }

        .icon-blue {
            background: linear-gradient(90deg, #78350f, #92400e);
        }

        .icon-yellow {
            background: linear-gradient(90deg, #7f1d1d, #991b1b);
        }

        .icon-green {
            background: linear-gradient(90deg, #14532d, #166534);
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

        .chart-box {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
            gap: 20px;
        }

        .chart-card {
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        .chart-card h6 {
            font-weight: 600;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
        }

        .custom-box {
            background: #1e3a8a;
            border-radius: 16px;
            padding: 24px;
            color: white;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
            position: relative;
            overflow: hidden;
            margin-top: 30px;
            margin-bottom: 3px;
        }

        .custom-box .title {
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 6px;
            letter-spacing: 1px;
            opacity: 0.9;
        }

        .custom-box .value {
            font-size: 28px;
            font-weight: 700;
        }

        .custom-box1 {
            background: linear-gradient(135deg, #3b82f6, #60a5fa);
            padding: 20px;
            border-radius: 16px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
            color: white;
            position: relative;
            overflow: hidden;
        }

        .custom-box1 .title {
            font-size: 14px;
            font-weight: 600;
            opacity: 0.9;
        }

        .custom-box1 .value {
            font-size: 22px;
            font-weight: 700;
        }

        .custom-box1 svg {
            position: absolute;
            bottom: -10px;
            right: -10px;
            width: 120px;
            opacity: 0.1;
        }

        .custom-box1 small {
            font-size: 12px;
            display: block;
            margin-top: 5px;
        }

        .card {
            border-radius: 16px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
            border: none;
        }

        .card-body {
            padding: 24px;
        }

        h6 {
            font-weight: 700;
            color: #1e3a8a;
            margin-bottom: 20px;
        }

        .progress {
            height: 10px;
            border-radius: 20px;
            background: #e5e7eb;
        }

        .progress-bar {
            border-radius: 20px;
            background: #1e3a8a;
        }

        #orderStatusChart {
            max-height: 250px;
            margin-top: 20px;
        }
    </style>

    <h4 class="page-title mb-4"><span>STATISTIK PENJUALAN Maxshoe </span></h4>
    <div class="dashboard-filter position-relative">
        <label class="fw-semibold">Filter Tanggal :</label>
        <button id="rangePickerBtn3" class="filter-button"></button>
        <input type="text" class="form-control d-none" id="rangePicker" placeholder="Pilih Tanggal">
    </div>
    <div class="stats-box">
        <div class="stat-card">
            <div class="stat-icon icon-orange"><i class="bi bi-bag"></i></div>
            <div>
                <p class="stat-value">1,250</p>
                <p class="stat-label">Total Produk Terjual</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon icon-green"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                    fill="currentColor" class="bi bi-wallet" viewBox="0 0 16 16">
                    <path
                        d="M0 3a2 2 0 0 1 2-2h12a1 1 0 0 1 1 1v1H2a1 1 0 0 0-1 1v1h14v7a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3zm14 3H2v6a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V6z" />
                </svg></div>
            <div>
                <p class="stat-value">Rp 75,000,000</p>
                <p class="stat-label">Total Omzet</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon icon-green"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                    fill="currentColor" class="bi bi-truck" viewBox="0 0 16 16">
                    <path
                        d="M0 1.5A.5.5 0 0 1 .5 1h10a.5.5 0 0 1 .5.5V5h1a1 1 0 0 1 .8.4l2.4 3.2c.2.27.3.6.3.9v3a.5.5 0 0 1-.5.5H14a2 2 0 1 1-4 0H6a2 2 0 1 1-4 0H.5a.5.5 0 0 1-.5-.5v-11ZM1 2v10h1a2 2 0 1 1 4 0h4a2 2 0 1 1 4 0h1v-3c0-.11-.03-.22-.09-.31l-2.4-3.2A.5.5 0 0 0 12 5h-1v2.5a.5.5 0 0 1-1 0V2H1Z" />
                </svg></i></div>
            <div>
                <p class="stat-value">Rp 75,000,000</p>
                <p class="stat-label">Total Ongkir</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon icon-blue"><i class="bi bi-people"></i></div>
            <div>
                <p class="stat-value">350</p>
                <p class="stat-label">Total Customer</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon icon-yellow"><i class="bi bi-clock-history"></i></div>
            <div>
                <p class="stat-value">20</p>
                <p class="stat-label">Pending (COD, PO, SHOPEE)</p>
            </div>
        </div>
    </div>

    <div class="chart-box">
        <div class="chart-card">
            <h6><i class="bi bi-graph-up"></i> Grafik Penjualan Harian</h6>
            <canvas id="dailyChart"></canvas>
        </div>
        <div class="chart-card">
            <h6><i class="bi bi-bar-chart"></i> Grafik Penjualan Bulanan</h6>
            <canvas id="monthlyChart"></canvas>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row g-4">
            <div class="col-md-4">
                <div class="custom-box">
                    <div class="title">Rata-rata ORDER Harian</div>
                    <hr style="border: 1px solid rgba(255,255,255,0.3); margin: 12px 0;">
                    <div class="value rata-rata-order-harian">12 Item</div>

                </div>
            </div>
            <div class="col-md-4">
                <div class="custom-box">
                    <div class="title">Rata-rata OMZET Harian</div>
                    <hr style="border: 1px solid rgba(255,255,255,0.3); margin: 12px 0;">
                    <div class="value rata-rata-omzet-harian">Rp 2.700.000</div>

                </div>
            </div>
            <div class="col-md-4">
                <div class="custom-box">
                    <div class="title">Best PRODUK Harian</div>
                    <hr style="border: 1px solid rgba(255,255,255,0.3); margin: 12px 0;">
                    <div class="value best-produk-harian">Produk A</div>

                </div>
            </div>
            <div class="col-md-4">
                <div class="custom-box1">
                    <div class="title">Best Performing HOST</div>
                    <hr style="border: 1px solid rgba(255,255,255,0.3); margin: 12px 0;">
                    <div class="value best-host">Rangga - Rp 15.000.000 <span style="font-size:15px">: 120 item</span></div>
                    {{-- <small>Ivan — Rp 2.000.000 : 45 item</small> --}}

                </div>
            </div>
            <div class="col-md-4">
                <div class="custom-box1">
                    <div class="title">Best Performing CO HOST</div>
                    <hr style="border: 1px solid rgba(255,255,255,0.3); margin: 12px 0;">
                    <div class="value best-co-host">Metha - Rp 12.700.000 <span style="font-size:15px">: 120 item</span></div>
                    {{-- <small>Budi — Rp 1.000.000 : 45 item</small> --}}

                </div>
            </div>
            <div class="col-md-4">
                <div class="custom-box1">
                    <div class="title">Best Performing CS</div>
                    <hr style="border: 1px solid rgba(255,255,255,0.3); margin: 12px 0;">
                    <div class="value best-cs">Wulan - Rp 10.200.000 <span style="font-size:15px">: 120 item</span></div>
                    {{-- <small>Rani — Rp 500.000 : 45 item</small> --}}

                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h6>Produk Terlaris</h6>
                        <div class="mb-3">
                            <div class="d-flex justify-content-between"><small>Produk A</small><small>80
                                    Item</small></div>
                            <div class="progress">
                                <div class="progress-bar" style="width: 80%"></div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="d-flex justify-content-between"><small>Produk B</small><small>60
                                    Item</small></div>
                            <div class="progress">
                                <div class="progress-bar" style="width: 60%"></div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="d-flex justify-content-between"><small>Produk C</small><small>40
                                    Item</small></div>
                            <div class="progress">
                                <div class="progress-bar" style="width: 40%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h6>Persentase Status Order</h6>
                        <canvas id="orderStatusChart"></canvas>
                        <div id="orderStatusDetail" class="text-center mt-3 fw-bold"></div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            loadStatistik();

            function loadStatistik(start = null, end = null) {
                fetch(`{{ route('statistik.data') }}?startDate=${start ?? ''}&endDate=${end ?? ''}`)
                    .then(res => res.json())
                    .then(data => renderStatistik(data));
            }

            function renderStatistik(data) {
                // --- Statistik box ---
                document.querySelector(".stat-card:nth-child(1) .stat-value").innerText = data.statistik
                .totalProduk;
                document.querySelector(".stat-card:nth-child(2) .stat-value").innerText = "Rp " + data.statistik
                    .totalOmzet.toLocaleString();
                document.querySelector(".stat-card:nth-child(3) .stat-value").innerText = "Rp " + data.statistik
                    .totalOngkir.toLocaleString();
                document.querySelector(".stat-card:nth-child(4) .stat-value").innerText = data.statistik
                    .totalCustomer;
                document.querySelector(".stat-card:nth-child(5) .stat-value").innerText = data.statistik.pending;

                document.querySelector(".rata-rata-order-harian").innerText = data.statistik.avgOrderDaily;
                document.querySelector(".rata-rata-omzet-harian").innerText = data.statistik.avgOmzetDaily.toLocaleString();
                document.querySelector(".best-produk-harian").innerText = data.bestProdukHarian[0].produk;

                // --- Grafik Harian ---
                const dailyLabels = Object.keys(data.daily);
                const dailyValues = Object.values(data.daily);
                updateDailyChart(dailyLabels, dailyValues);

                // --- Grafik Bulanan ---
                const monthlyLabels = Object.keys(data.monthly);
                const monthlyValues = Object.values(data.monthly);
                updateMonthlyChart(monthlyLabels, monthlyValues);

                // --- Produk Terlaris ---
                renderProdukTerlaris(data.produkTerlaris);

                // --- Best Host / CoHost / CS ---
                if (data.best.host.length > 0) {
                    document.querySelector(".best-host").innerHTML =
                        `${data.best.host[0].nama} - Rp ${data.best.host[0].omzet.toLocaleString()} <span style="font-size:15px">: ${data.best.host[0].jumlah} item</span>`;
                }
                if (data.best.coHost.length > 0) {
                    document.querySelector(".best-co-host").innerHTML =
                        `${data.best.coHost[0].nama} - Rp ${data.best.coHost[0].omzet.toLocaleString()} <span style="font-size:15px">: ${data.best.coHost[0].jumlah} item</span>`;
                }
                if (data.best.cs.length > 0) {
                    document.querySelector(".best-cs").innerHTML =
                        `${data.best.cs[0].nama} - Rp ${data.best.cs[0].omzet.toLocaleString()} <span style="font-size:15px">: ${data.best.cs[0].jumlah} item</span>`;
                }

                // --- Status Order ---
                updateStatusOrder(data.statusOrder);
            }

            // === Chart update functions ===
            let dailyChart, monthlyChart, orderStatusChart;

            function updateDailyChart(labels, values) {
                if (dailyChart) dailyChart.destroy();
                const ctxDaily = document.getElementById('dailyChart').getContext('2d');
                dailyChart = new Chart(ctxDaily, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Penjualan Harian',
                            data: values,
                            fill: true,
                            backgroundColor: 'rgba(15, 23, 42, 0.1)',
                            borderColor: '#1e3a8a',
                            tension: 0.4,
                            pointRadius: 2,
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                display: false
                            }
                        }
                    }
                });
            }

            function updateMonthlyChart(labels, values) {
                if (monthlyChart) monthlyChart.destroy();
                const ctxMonthly = document.getElementById('monthlyChart').getContext('2d');
                monthlyChart = new Chart(ctxMonthly, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Penjualan Bulanan',
                            data: values,
                            backgroundColor: '#1e3a8a',
                            borderRadius: 6
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                display: false
                            }
                        }
                    }
                });
            }

            function updateStatusOrder(statusData) {
                if (orderStatusChart) orderStatusChart.destroy();
                const ctxOrderStatus = document.getElementById('orderStatusChart').getContext('2d');
                const labels = Object.keys(statusData);
                const values = Object.values(statusData);
                orderStatusChart = new Chart(ctxOrderStatus, {
                    type: 'doughnut',
                    data: {
                        labels: labels,
                        datasets: [{
                            data: values,
                            backgroundColor: ['#1e3a8a', '#2c54b2', '#3d6dcc', '#4d86e5']
                        }]
                    },
                    options: {
                        cutout: '65%',
                        plugins: {
                            legend: {
                                position: 'bottom'
                            }
                        }
                    }
                });
            }

            function renderProdukTerlaris(list) {
                let container = document.querySelector(".card-body");
                container.innerHTML = "<h6>Produk Terlaris</h6>";
                const max = list.length > 0 ? list[0].jumlah : 1;
                list.forEach(item => {
                    let percent = (item.jumlah / max) * 100;
                    container.innerHTML += `
                <div class="mb-3">
                    <div class="d-flex justify-content-between"><small>${item.produk}</small><small>${item.jumlah} Item</small></div>
                    <div class="progress">
                        <div class="progress-bar" style="width:${percent}%"></div>
                    </div>
                </div>`;
                });
            }
        });
    </script>
@endsection
