<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\KategoriHalaman;
use RealRashid\SweetAlert\Facades\Alert;
class KategorihalamanController extends Controller
{
    //

     public function index()
    {
        try {
            $kategori_halaman = KategoriHalaman::all();
            return view('admin.kategorihalaman.index', compact('kategori_halaman'));
        } catch (\Exception $e) {
            Alert::toast('Gagal Memuat Halaman', 'error');
            return back();
        }
    }

    // 🔥 STORE
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'keterangan' => 'nullable'
        ]);

        try {
            KategoriHalaman::create([
                'nama' => $request->nama,
                'keterangan' => $request->keterangan,
            ]);

            Alert::success('Berhasil', 'Kategori Berita berhasil ditambahkan');
            return back();

        } catch (\Exception $e) {
            Alert::error('Error', $e->getMessage());
            return back();
        }
    }

    // 🔥 EDIT (ambil data)
    public function edit($id)
    {
        try {
            $KategoriHalaman = KategoriHalaman::findOrFail($id);
            return view('admin.kategorihalaman.edit', compact('KategoriHalaman'));
        } catch (\Exception $e) {
            Alert::error('Error', 'Data tidak ditemukan');
            return back();
        }
    }

    // 🔥 UPDATE
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required',
            'keterangan' => 'nullable'
        ]);

        try {
            $Kategori = KategoriHalaman::findOrFail($id);

            $Kategori->update([
                'nama' => $request->nama,
                'keterangan' => $request->keterangan,
            ]);

            Alert::success('Berhasil', 'Kategori berhasil diupdate');
            return redirect()->back();

        } catch (\Exception $e) {
            Alert::error('Error', $e->getMessage());
            return back();
        }
    }

    // 🔥 DELETE
    public function destroy($id)
    {
        try {
            $kategori = KategoriHalaman::findOrFail($id);
            $kategori->delete();

            Alert::success('Berhasil', 'kategori berhasil dihapus');
            return back();

        } catch (\Exception $e) {
            Alert::error('Error', 'Gagal menghapus data');
            return back();
        }
    }
}
