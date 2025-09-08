<?php

namespace App\Http\Controllers\Backend;

use App\Models\Order;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Karyawan;
use App\Models\OrderDetail;
use App\Models\Produk;
use Illuminate\Http\Request;

use Yajra\DataTables\Facades\DataTables;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function rekap()
    {
        $data['co_host'] = Karyawan::where('status', 'active')->where('posisi', 'Co Host')->orderBy('created_at', 'desc')->get();
        $data['host'] = Karyawan::where('status', 'active')->where('posisi', 'Host')->orderBy('created_at', 'desc')->get();
        $data['cs'] = Karyawan::where('status', 'active')->where('posisi', 'CS')->orderBy('created_at', 'desc')->get();
        $data['produk'] = Produk::orderBy('created_at', 'desc')->get();

        return view('backend.pages.order.rekap', $data);
    }
    public function index()
    {
        $data['co_host'] = Karyawan::where('status', 'active')->where('posisi', 'Co Host')->orderBy('created_at', 'desc')->get();
        $data['host'] = Karyawan::where('status', 'active')->where('posisi', 'Host')->orderBy('created_at', 'desc')->get();
        $data['cs'] = Karyawan::where('status', 'active')->where('posisi', 'CS')->orderBy('created_at', 'desc')->get();
        $data['produk'] = Produk::orderBy('created_at', 'desc')->get();

        return view('backend.pages.order.index', $data);
    }

    public function getData(Request $request)
    {
        $orders = Order::with(['host', 'coHost', 'cs', 'details.produk'])
            ->orderBy('created_at', 'desc');

        if ($request->start_date && $request->end_date) {
            $orders->whereBetween('created_at', [
                $request->start_date . " 00:00:00",
                $request->end_date . " 23:59:59"
            ]);
        }

        return DataTables::of($orders)
            ->addIndexColumn()
            ->addColumn('tgl', fn($row) => $row->created_at->format('d-m-Y'))
            ->addColumn('status', function ($row) {
                if ($row->status == 'S') {
                    # code...
                }
                return '<span class="badge-status ' . strtolower(str_replace(" ", "-", $row->status)) . '">' . $row->status . '</span>';
            })
            ->addColumn('host', fn($row) => $row->host->nama ?? '-')
            ->addColumn('co_host', fn($row) => $row->coHost->nama ?? '-')
            ->addColumn('cs', fn($row) => $row->cs->nama ?? '-')
            ->addColumn('produk', function ($row) {
                // Nama produk per baris
                return $row->details->pluck('produk.nama_produk')->implode('<br>');
            })
            ->addColumn('jumlah', function ($row) {
                // Total jumlah
                return $row->details->sum('jumlah');
            })
            ->addColumn('harga', function ($row) {
                // Hitung total harga (jumlah * harga)
                $total = $row->details->sum(function ($detail) {
                    return $detail->harga;
                });
                return 'Rp ' . number_format($total, 0, ',', '.');
            })

            ->addColumn('ekspedisi', fn($row) => $row->ekspedisi)
            ->addColumn('berat', fn($row) => $row->berat)
            ->addColumn('ongkir', fn($row) => number_format($row->ongkir, 0, ',', '.'))
            ->addColumn('total_tf', fn($row) => number_format($row->total_transfer, 0, ',', '.'))
            ->addColumn('atas_nama', fn($row) => $row->atas_nama)
            ->addColumn('bank_transfer', fn($row) => $row->bank_transfer)
            ->addColumn('nama_penerima', fn($row) => $row->nama_penerima)
            ->addColumn('nomor_hp', fn($row) => $row->nomor_hp)
            ->addColumn('alamat', fn($row) => $row->alamat)
            ->addColumn('kodepos', fn($row) => $row->kodepos)
            ->addColumn('order_id', fn($row) => str_pad($row->id, 4, '0', STR_PAD_LEFT))
            ->addColumn('ubah', function ($row) {
                return '
                <div class="d-flex gap-2">
                    <a href="' . route('order.edit', $row->id) . '" class="btn btn-sm btn-warning">
                        <i class="bi bi-pencil-square"></i>
                    </a>
                    <button onclick="confirmDelete(\'' . route('order.destroy', $row->id) . '\')" class="btn btn-sm btn-danger">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>';
            })
            ->addIndexColumn()
            ->rawColumns(['status', 'ubah', 'produk'])
            ->make(true);
    }
    public function getDataAll(Request $request)
    {
        $orders = Order::with(['host', 'coHost', 'cs', 'details.produk'])
            ->orderBy('created_at', 'desc');

        // 🔹 Filter tanggal
        if ($request->start_date && $request->end_date) {
            $orders->whereBetween('created_at', [
                $request->start_date . " 00:00:00",
                $request->end_date . " 23:59:59"
            ]);
        }

        // 🔹 Filter status
        if ($request->status && $request->status != 'all') {
            $orders->where('status', $request->status);
        }

        // 🔹 Filter CS
        if ($request->cs && $request->cs != 'all') {

            $orders->where('cs_id', $request->cs);
        }

        return DataTables::of($orders)
            ->addIndexColumn()
            ->addColumn('tgl', fn($row) => $row->created_at->format('d-m-Y'))
            ->addColumn(
                'status',
                fn($row) =>
                '<span class="badge-status ' . strtolower(str_replace(" ", "-", $row->status)) . '">' . $row->status . '</span>'
            )
            ->addColumn('host', fn($row) => $row->host->nama ?? '-')
            ->addColumn('co_host', fn($row) => $row->coHost->nama ?? '-')
            ->addColumn('cs', fn($row) => $row->cs->nama ?? '-')
            ->addColumn('produk', fn($row) => $row->details->pluck('produk.nama_produk')->implode('<br>'))
            ->addColumn('jumlah', fn($row) => $row->details->sum('jumlah'))
            ->addColumn('harga', function ($row) {
                $total = $row->details->sum(fn($detail) => $detail->harga);
                return 'Rp ' . number_format($total, 0, ',', '.');
            })
            ->addColumn('ekspedisi', fn($row) => $row->ekspedisi)
            ->addColumn('berat', fn($row) => $row->berat)
            ->addColumn('ongkir', fn($row) => number_format($row->ongkir, 0, ',', '.'))
            ->addColumn('total_tf', fn($row) => number_format($row->total_transfer, 0, ',', '.'))
            ->addColumn('atas_nama', fn($row) => $row->atas_nama)
            ->addColumn('bank_transfer', fn($row) => $row->bank_transfer)
            ->addColumn('nama_penerima', fn($row) => $row->nama_penerima)
            ->addColumn('nomor_hp', fn($row) => $row->nomor_hp)
            ->addColumn('alamat', fn($row) => $row->alamat)
            ->addColumn('kodepos', fn($row) => $row->kodepos)
            ->addColumn('order_id', fn($row) => str_pad($row->id, 4, '0', STR_PAD_LEFT))
            ->addColumn('ubah', function ($row) {
                return '
                <div class="d-flex gap-2">
                    <a href="' . route('order.edit', $row->id) . '" class="btn btn-sm btn-warning">
                        <i class="bi bi-pencil-square"></i>
                    </a>
                    <button onclick="confirmDelete(\'' . route('order.destroy', $row->id) . '\')" class="btn btn-sm btn-danger">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>';
            })
            ->rawColumns(['status', 'ubah', 'produk'])
            ->make(true);
    }

    public function rekapDataJson(Request $request)
    {
        $query = Order::with('details'); // pastikan relasi ada di model Order

        // Filter tanggal
        if ($request->start_date && $request->end_date) {
            $query->whereBetween('created_at', [
                $request->start_date . " 00:00:00",
                $request->end_date . " 23:59:59"
            ]);
        }

        // Filter CS
        if ($request->cs && $request->cs != 'all') {
            $query->where('cs_id', $request->cs);
        }

        // === Hitung jumlah order berdasarkan status ===
        $totalDiproses = (clone $query)->count();
        $lunas = (clone $query)->where('status', 'LUNAS')->count();
        $dp = (clone $query)->where('status', 'DOWN PAYMENT')->count();
        $po = (clone $query)->where('status', 'PRE ORDER')->count();
        $shopee = (clone $query)->where('status', 'SHOPEE')->count();

        // === Hitung omzet dari OrderDetail ===
        $hitungOmzet = function ($q) {
            return $q->get()->sum(function ($order) {
                return $order->details->sum(function ($detail) {
                    return $detail->harga; // sesuaikan field harga/qty
                });
            });
        };

        $omzetDiproses = $hitungOmzet(clone $query);
        $omzetLunas = $hitungOmzet((clone $query)->where('status', 'LUNAS'));
        $omzetDP = $hitungOmzet((clone $query)->where('status', 'DOWN PAYMENT'));
        $omzetPO = $hitungOmzet((clone $query)->where('status', 'PRE ORDER'));
        $omzetShopee = $hitungOmzet((clone $query)->where('status', 'SHOPEE'));

        return response()->json([
            'diproses' => [
                'count' => number_format($totalDiproses, 0, ',', '.'),
                'omzet' => number_format($omzetDiproses, 0, ',', '.')
            ],
            'lunas' => [
                'count' => number_format($lunas, 0, ',', '.'),
                'omzet' => number_format($omzetLunas, 0, ',', '.')
            ],
            'dp' => [
                'count' => number_format($dp, 0, ',', '.'),
                'omzet' => number_format($omzetDP, 0, ',', '.')
            ],
            'po' => [
                'count' => number_format($po, 0, ',', '.'),
                'omzet' => number_format($omzetPO, 0, ',', '.')
            ],
            'shopee' => [
                'count' => number_format($shopee, 0, ',', '.'),
                'omzet' => number_format($omzetShopee, 0, ',', '.')
            ],
        ]);
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // validasi basic
        $request->validate([
            'host_id'       => 'nullable|exists:karyawans,id',
            'co_host_id'    => 'nullable|exists:karyawans,id',
            'cs_id'         => 'nullable|exists:karyawans,id',

            'produk_id'     => 'required|array',
            'produk_id.*'   => 'exists:produks,id',

            'jumlah'        => 'required|array',
            'jumlah.*'      => 'integer|min:1',

            'harga'         => 'required|array',
            'harga.*'       => 'integer|min:0',
        ], [
            // TEAM
            'host_id.exists'     => 'Host tidak ditemukan.',
            'co_host_id.exists'  => 'Co Host tidak ditemukan.',
            'cs_id.exists'       => 'Customer Service tidak ditemukan.',

            // ORDER
            'produk_id.required' => 'Pilih minimal 1 produk.',
            'produk_id.*.exists' => 'Produk yang dipilih tidak valid.',

            'jumlah.required'    => 'Jumlah produk wajib diisi.',
            'jumlah.*.integer'   => 'Jumlah produk harus berupa angka.',
            'jumlah.*.min'       => 'Jumlah produk minimal 1.',

            'harga.required'     => 'Harga produk wajib diisi.',
            'harga.*.integer'    => 'Harga produk harus berupa angka.',
            'harga.*.min'        => 'Harga produk tidak boleh negatif.',
        ]);


        // simpan orders
        $order = Order::create([
            'host_id'       => $request->host_id,
            'co_host_id'    => $request->co_host_id,
            'cs_id'         => $request->cs_id,

            'ekspedisi'     => $request->ekspedisi,
            'berat'         => $request->kg,
            'ongkir'        => $request->ongkir,

            'total_transfer' => $request->total_transfer,
            'atas_nama'     => $request->atas_nama,
            'bank_transfer' => $request->bank_transfer,
            'status'        => $request->status,

            'nama_penerima' => $request->nama_penerima,
            'nomor_hp'      => $request->nomor_hp,
            'kodepos'       => $request->kodepos,
            'alamat'        => $request->alamat,
        ]);

        // simpan order_details
        $omzet = 0;
        $totalItem = 0;

        foreach ($request->produk_id as $i => $produkId) {
            $jumlah = (int) $request->jumlah[$i];
            $harga  = (int) $request->harga[$i];

            $order->details()->create([
                'produk_id' => $produkId,
                'jumlah'    => $jumlah,
                'harga'     => $harga,
            ]);

            // kalkulasi omzet & total item
            $omzet += $jumlah * $harga;
            $totalItem += $jumlah;
        }

        // hitung komisi
        $komisiHost    = floor($omzet * 0.01); // 1% dari omzet
        $komisiCoHost  = $totalItem * 2000;
        $komisiCS      = $totalItem * 2000;

        // update order dengan komisi
        $order->update([
            'komisi_host'     => $komisiHost,
            'komisi_co_host'  => $komisiCoHost,
            'komisi_cs'       => $komisiCS,
        ]);


        return redirect()->back()->with('success', 'Order berhasil ditambahkan');
    }


    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data['co_host'] = Karyawan::where('status', 'active')->where('posisi', 'Co Host')->orderBy('created_at', 'desc')->get();
        $data['host'] = Karyawan::where('status', 'active')->where('posisi', 'Host')->orderBy('created_at', 'desc')->get();
        $data['cs'] = Karyawan::where('status', 'active')->where('posisi', 'CS')->orderBy('created_at', 'desc')->get();
        $data['produk'] = Produk::orderBy('created_at', 'desc')->get();
        $data['order'] = Order::find($id);
        $data['orderDetail'] = OrderDetail::where('order_id', $id)->get();

        return view('backend.pages.order.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // validasi basic
        $request->validate([
            'host_id'       => 'nullable|exists:karyawans,id',
            'co_host_id'    => 'nullable|exists:karyawans,id',
            'cs_id'         => 'nullable|exists:karyawans,id',

            'produk_id'     => 'required|array',
            'produk_id.*'   => 'exists:produks,id',

            'jumlah'        => 'required|array',
            'jumlah.*'      => 'integer|min:1',

            'harga'         => 'required|array',
            'harga.*'       => 'integer|min:0',
        ], [
            // TEAM
            'host_id.exists'     => 'Host tidak ditemukan.',
            'co_host_id.exists'  => 'Co Host tidak ditemukan.',
            'cs_id.exists'       => 'Customer Service tidak ditemukan.',

            // ORDER
            'produk_id.required' => 'Pilih minimal 1 produk.',
            'produk_id.*.exists' => 'Produk yang dipilih tidak valid.',

            'jumlah.required'    => 'Jumlah produk wajib diisi.',
            'jumlah.*.integer'   => 'Jumlah produk harus berupa angka.',
            'jumlah.*.min'       => 'Jumlah produk minimal 1.',

            'harga.required'     => 'Harga produk wajib diisi.',
            'harga.*.integer'    => 'Harga produk harus berupa angka.',
            'harga.*.min'        => 'Harga produk tidak boleh negatif.',
        ]);

        try {
            $order = Order::findOrFail($id);

            // update order utama
            $order->update([
                'host_id'       => $request->host_id,
                'co_host_id'    => $request->co_host_id,
                'cs_id'         => $request->cs_id,

                'ekspedisi'     => $request->ekspedisi,
                'berat'         => $request->kg,
                'ongkir'        => $request->ongkir,

                'total_transfer' => $request->total_transfer,
                'atas_nama'     => $request->atas_nama,
                'bank_transfer' => $request->bank_transfer,
                'status'        => $request->status,

                'nama_penerima' => $request->nama_penerima,
                'nomor_hp'      => $request->nomor_hp,
                'kodepos'       => $request->kodepos,
                'alamat'        => $request->alamat,
            ]);

            // hapus semua detail lama
            $order->details()->delete();

            // insert ulang order_details
            $omzet = 0;
            $totalItem = 0;

            foreach ($request->produk_id as $i => $produkId) {
                $jumlah = (int) $request->jumlah[$i];
                $harga  = (int) $request->harga[$i];

                $order->details()->create([
                    'produk_id' => $produkId,
                    'jumlah'    => $jumlah,
                    'harga'     => $harga,
                ]);

                $omzet += $jumlah * $harga;
                $totalItem += $jumlah;
            }

            // hitung ulang komisi
            $komisiHost    = floor($omzet * 0.01);
            $komisiCoHost  = $totalItem * 2000;
            $komisiCS      = $totalItem * 2000;

            $order->update([
                'komisi_host'     => $komisiHost,
                'komisi_co_host'  => $komisiCoHost,
                'komisi_cs'       => $komisiCS,
            ]);

            return redirect()->route('order.data.rekap')->with('success', 'Order berhasil diperbarui');
        } catch (\Throwable $th) {
            return redirect()->route('order.data.rekap')->with('error', 'Gagal update order: ' . $th->getMessage());
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $order = Order::findOrFail($id);

            // hapus detail order
            $order->details()->delete();

            // hapus order
            $order->delete();

            return redirect()->back()->with('success', 'Order berhasil dihapus.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Gagal menghapus order: ' . $th->getMessage());
        }
    }

    public function komisi()
    {
        return view('backend.pages.komisi.index');
    }

    public function getDataKomisi(Request $request)
    {
        $query = Order::with('details'); // relasi: details

        // Filter tanggal
        if ($request->start_date && $request->end_date) {
            $query->whereBetween('created_at', [
                $request->start_date . " 00:00:00",
                $request->end_date . " 23:59:59"
            ]);
        }

        $orders = $query->get();

        $summary = [
            'total_omzet' => 0,
            'total_item' => 0,
            'total_komisi' => 0,
            'karyawan' => []
        ];

        foreach ($orders as $order) {
            $omzetOrder = $order->details->sum(fn($d) => $d->harga);
            $itemOrder = $order->details->sum('jumlah');

            $summary['total_omzet'] += $omzetOrder;
            $summary['total_item'] += $itemOrder;
            $summary['total_komisi'] += $order->komisi_host + $order->komisi_co_host + $order->komisi_cs;

            if ($order->host_id) {
                $summary['karyawan'][$order->host_id] = [
                    'id' => $order->host_id,
                    'posisi' => 'HOST',
                ];
            }
            if ($order->co_host_id) {
                $summary['karyawan'][$order->co_host_id] = [
                    'id' => $order->co_host_id,
                    'posisi' => 'CO HOST',
                ];
            }
            if ($order->cs_id) {
                $summary['karyawan'][$order->cs_id] = [
                    'id' => $order->cs_id,
                    'posisi' => 'CS',
                ];
            }
        }

        // Ambil data host & co-host dari tabel karyawan
        $karyawanIds = [];

        foreach ($summary['karyawan'] as $id => $data) {
            $karyawanIds[] = $id;
        }

        $karyawanList = \App\Models\Karyawan::whereIn('id', $karyawanIds)->get()->keyBy('id');

        $ranking = [];
        foreach ($summary['karyawan'] as $id => $data) {
            if (isset($karyawanList[$id])) {
                $kar = $karyawanList[$id];
                $nama = $kar->nama;
                $posisi = $kar->posisi;
                $foto = asset('assets/img/karyawan/' . ($kar->foto ?? 'default.png'));
            } else {
                $nama = "Unknown";
                $posisi = "-";
                $foto = asset('assets/img/karyawan/6646489.png');
            }

            // Hitung omzet, item, komisi sesuai posisi
            if ($data['posisi'] === 'HOST') {
                $getOrder = Order::where('host_id', $data['id'])->pluck('id');
                $getItemOrder = OrderDetail::whereIn('order_id', $getOrder)->sum('jumlah');
                $getOmzetOrder = OrderDetail::whereIn('order_id', $getOrder)->sum('harga');
                $getKomisiOrder = Order::whereIn('id', $getOrder)->sum('komisi_host');
            } elseif ($data['posisi'] === 'CO HOST') {
                $getOrder = Order::where('co_host_id', $data['id'])->pluck('id');
                $getItemOrder = OrderDetail::whereIn('order_id', $getOrder)->sum('jumlah');
                $getOmzetOrder = OrderDetail::whereIn('order_id', $getOrder)->sum('harga');
                $getKomisiOrder = Order::whereIn('id', $getOrder)->sum('komisi_co_host');
            } elseif ($data['posisi'] === 'CS') {
                $getOrder = Order::where('cs_id', $data['id'])->pluck('id');
                $getItemOrder = OrderDetail::whereIn('order_id', $getOrder)->sum('jumlah');
                $getOmzetOrder = OrderDetail::whereIn('order_id', $getOrder)->sum('harga');
                $getKomisiOrder = Order::whereIn('id', $getOrder)->sum('komisi_cs');
            } else {
                $getItemOrder = 0;
                $getOmzetOrder = 0;
                $getKomisiOrder = 0;
            }

            $ranking[] = [
                'id' => $id,
                'nama' => $nama,
                'posisi' => $posisi,
                'foto' => $foto,
                'omzet_raw' => $getOmzetOrder,
                'item' => $getItemOrder,
                'komisi_raw' => $getKomisiOrder,
            ];
        }

        // Urutkan berdasarkan omzet
        usort($ranking, fn($a, $b) => $b['omzet_raw'] <=> $a['omzet_raw']);

        // Ambil Top 2 & Top 3
        $topEmployees = array_slice($ranking, 0, 2);
        $rankingTop3 = array_slice($ranking, 0, 3);

        // Format angka setelah sorting
        $topEmployees = array_map(function ($r) {
            $r['omzet'] = number_format($r['omzet_raw'], 0, ',', '.');
            $r['komisi'] = number_format($r['komisi_raw'], 0, ',', '.');
            unset($r['omzet_raw'], $r['komisi_raw']);
            return $r;
        }, $topEmployees);

        $rankingTop3 = array_map(function ($r) {
            $r['omzet'] = number_format($r['omzet_raw'], 0, ',', '.');
            $r['komisi'] = number_format($r['komisi_raw'], 0, ',', '.');
            unset($r['omzet_raw'], $r['komisi_raw']);
            return $r;
        }, $rankingTop3);

        return response()->json([
            'summary' => [
                'total_omzet' => number_format($summary['total_omzet'], 0, ',', '.'),
                'total_item' => $summary['total_item'],
                'total_komisi' => number_format($summary['total_komisi'], 0, ',', '.'),
            ],
            'employee_card' => $topEmployees,
            'ranking' => $rankingTop3
        ]);
    }

    public function statistik()
    {
        return view('backend.pages.statistik.index');
    }

    public function getDatastatistik(Request $request)
    {
        $start = $request->startDate ?? now()->startOfMonth()->toDateString();
        $end   = $request->endDate ?? now()->endOfMonth()->toDateString();

        $orders = Order::with(['details.produk', 'host', 'coHost', 'cs'])
            ->whereBetween('created_at', [$start, $end])
            ->get();

        // --- Hitung Statistik ---
        $totalProduk = $orders->flatMap->details->sum('jumlah');
        $totalOmzet = $orders->flatMap->details->sum('harga');
        $totalOngkir = $orders->sum('ongkir');
        $totalCustomer = $orders->pluck('nama_penerima')->unique()->count();
        $pending = $orders->whereIn('status', ['COD', 'PO', 'SHOPEE'])->count();

        // === NEW: Rata-rata harian ===
        $days = \Carbon\Carbon::parse($start)->diffInDays(\Carbon\Carbon::parse($end)) + 1;
        $avgOrderDaily = $days > 0 ? ceil($totalProduk / $days) : 0;
        $avgOmzetDaily = $days > 0 ? ceil($totalOmzet / $days) : 0;


        // --- Grafik Harian ---
        $dailySales = $orders->groupBy(function ($q) {
            return \Carbon\Carbon::parse($q->created_at)->format('d-m-Y');
        })->map(function ($day) {
            return $day->flatMap->details->sum('jumlah');
        });

        // --- Grafik Bulanan (fix 12 bulan) ---
        $monthlySalesRaw = $orders->groupBy(function ($q) {
            return \Carbon\Carbon::parse($q->created_at)->format('M');
        })->map(function ($month) {
            return $month->flatMap->details->sum('jumlah');
        });

        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        $monthlySales = collect($months)->mapWithKeys(function ($m) use ($monthlySalesRaw) {
            return [$m => $monthlySalesRaw[$m] ?? 0];
        });

        // --- Produk Terlaris ---
        $produkTerlaris = $orders->flatMap->details
            ->groupBy('produk_id')
            ->map(function ($d) {
                return [
                    'produk' => $d->first()->produk->nama_produk,
                    'jumlah' => $d->sum('jumlah')
                ];
            })->sortByDesc('jumlah')->take(5)->values();

        // === NEW: Best Produk Harian ===
        $bestProdukHarian = $orders->flatMap->details
            ->groupBy('produk_id')
            ->map(function ($d) {
                return [
                    'produk' => $d->first()->produk->nama_produk,
                    'jumlah' => $d->sum('jumlah')
                ];
            })->sortByDesc('jumlah')->take(1)->values();

        // --- Best Host / CoHost / CS ---
        $bestHost = $orders->groupBy('host_id')->map(function ($q) {
            return [
                'nama' => $q->first()->host->nama ?? '-',
                'omzet' => $q->flatMap->details->sum('harga'),
                'jumlah' => $q->flatMap->details->sum('jumlah')
            ];
        })->sortByDesc('omzet')->take(1)->values();

        $bestCoHost = $orders->groupBy('co_host_id')->map(function ($q) {
            return [
                'nama' => $q->first()->coHost->nama ?? '-',
                'omzet' => $q->flatMap->details->sum('harga'),
                'jumlah' => $q->flatMap->details->sum('jumlah')
            ];
        })->sortByDesc('omzet')->take(1)->values();

        $bestCS = $orders->groupBy('cs_id')->map(function ($q) {
            return [
                'nama' => $q->first()->cs->nama ?? '-',
                'omzet' => $q->flatMap->details->sum('harga'),
                'jumlah' => $q->flatMap->details->sum('jumlah')
            ];
        })->sortByDesc('omzet')->take(1)->values();

        // --- Status Order ---
        $statusCount = $orders->groupBy('status')->map->count();

        return response()->json([
            'statistik' => [
                'totalProduk' => $totalProduk,
                'totalOmzet' => $totalOmzet,
                'totalOngkir' => $totalOngkir,
                'totalCustomer' => $totalCustomer,
                'pending' => $pending,
                'avgOrderDaily' => $avgOrderDaily,
                'avgOmzetDaily' => $avgOmzetDaily,
            ],
            'daily' => $dailySales,
            'monthly' => $monthlySales,
            'produkTerlaris' => $produkTerlaris,
            'bestProdukHarian' => $bestProdukHarian,
            'best' => [
                'host' => $bestHost,
                'coHost' => $bestCoHost,
                'cs' => $bestCS
            ],
            'statusOrder' => $statusCount,
        ]);
    }
}
