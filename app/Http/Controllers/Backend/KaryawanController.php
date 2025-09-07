<?php

namespace App\Http\Controllers\Backend;

use App\Models\Karyawan;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class KaryawanController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $status = $request->get('status'); // active / nonactive
            $data = Karyawan::where('status', $status)->latest();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('sisa_kontrak', fn($row) => $row->sisa_kontrak)
                ->addColumn('action', function ($row) {
                    $statusBtn = $row->status == 'active'
                        ? '<button onclick="updateStatus(' . $row->id . ')" class="btn btn-sm btn-danger">Nonaktifkan</button>'
                        : '<button onclick="updateStatus(' . $row->id . ')" class="btn btn-sm btn-success">Aktifkan</button>';

                    return '
                    <button class="btn btn-sm btn-warning editBtn" 
                        data-id="' . $row->id . '" 
                        data-nama="' . $row->nama . '" 
                        data-hp="' . $row->nomor_hp . '" 
                        data-posisi="' . $row->posisi . '" 
                        data-status="' . $row->status_karyawan . '" 
                        data-foto="' . $row->foto . '" 
                        data-lama="' . $row->lama_kontrak . '">
                        <i class="bi bi-pencil-square"></i>
                    </button>
                    ' . $statusBtn . '
                    <button onclick="confirmDelete(\'' . route('karyawan.destroy', $row->id) . '\')" class="btn btn-sm btn-danger">
                        <i class="bi bi-trash"></i>
                    </button>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('backend.pages.karyawan.index');
    }


    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'nomor_hp' => 'required',
            'posisi' => 'required',
            'status_karyawan' => 'required',
            'lama_kontrak' => 'required',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->except('foto');
        // handle upload foto
        if ($request->hasFile('foto')) {
            $image = $request->file('foto');
            $name = time() . '-' . uniqid() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('assets/img/karyawan/');
            $image->move($destinationPath, $name);
            $data['foto'] = $name;
        }

        Karyawan::create($data);

        return back()->with('success', 'Karyawan berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'nomor_hp' => 'required',
            'posisi' => 'required',
            'status_karyawan' => 'required',
            'lama_kontrak' => 'required',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $karyawan = Karyawan::findOrFail($id);

        $data = $request->except('foto');

        if ($request->hasFile('foto')) {
            // hapus foto lama kalau ada
            if ($karyawan->foto && file_exists(public_path('assets/img/karyawan/' . $karyawan->foto))) {
                unlink(public_path('assets/img/karyawan/' . $karyawan->foto));
            }

            $image = $request->file('foto');
            $name = time() . '-' . uniqid() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('assets/img/karyawan/');
            $image->move($destinationPath, $name);
            $data['foto'] = $name;
        }

        $karyawan->update($data);

        return response()->json(['success' => 'Karyawan berhasil diupdate!']);
    }

    public function destroy($id)
    {
        Karyawan::findOrFail($id)->delete();
        return redirect()->route('karyawan')->with('success', 'Karyawan dihapus!');
    }

    public function updateStatus($id)
    {
        $karyawan = Karyawan::findOrFail($id);
        $karyawan->status = $karyawan->status == 'active' ? 'nonactive' : 'active';
        $karyawan->save();

        return response()->json(['success' => 'Status berhasil diubah!']);
    }
}
