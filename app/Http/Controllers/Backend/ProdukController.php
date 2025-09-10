<?php

namespace App\Http\Controllers\Backend;

use App\Models\Produk;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class ProdukController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!Auth::guard('admin')->check()) {
                return redirect()->route('admin.login');
            }
            return $next($request);
        });
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Produk::latest();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '
                        <button class="btn btn-sm btn-warning editBtn" data-id="' . $row->id . '" data-nama="' . $row->nama_produk . '">
                            <i class="bi bi-pencil-square"></i>
                        </button>
                        <button onclick="confirmDelete(\'' . route('produk.destroy', $row->id) . '\')" class="btn btn-sm btn-danger">
                            <i class="bi bi-trash"></i>
                        </button>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('backend.pages.produk.index');
    }

    public function store(Request $request)
    {

        try {
            $request->validate([
                'nama_produk' => 'required|string|max:255'
            ]);

            Produk::create([
                'nama_produk' => $request->nama_produk
            ]);
            return redirect()->back()->with('success', 'Produk berhasil ditambahkan!');
        } catch (\Throwable $th) {
            return redirect()->back()->with('failed', 'Produk gagal ditambahkan!');
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_produk' => 'required|string|max:255'
        ]);

        $produk = Produk::findOrFail($id);
        $produk->update([
            'nama_produk' => $request->nama_produk
        ]);

        return response()->json(['success' => 'Produk berhasil diupdate!']);
    }

    public function destroy($id)
    {
        $produk = Produk::findOrFail($id);
        $produk->delete();
        return redirect()->route('produk')->with('success', 'Produk berhasil dihapus!');
    }
}
