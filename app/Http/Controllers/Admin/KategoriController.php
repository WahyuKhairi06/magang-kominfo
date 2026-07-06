<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Kategori_berita;
use RealRashid\SweetAlert\Facades\Alert;

class KategoriController extends Controller
{
    //


     public function index()
    {
        try {
            $berita_kategori = Kategori_berita::all();
            return view('admin.berita.index', compact('berita_kategori'));
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
            Kategori_berita::create([
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
            $kategori_berita = Kategori_berita::findOrFail($id);
            return view('admin.berita.edit', compact('kategori_berita'));
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
            $Kategori = Kategori_berita::findOrFail($id);

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
            $kategori = Kategori_berita::findOrFail($id);
            $kategori->delete();

            Alert::success('Berhasil', 'Kategori Berhasil Dihapus');
            return back();

        } catch (\Exception $e) {
            Alert::error('Error', 'Gagal menghapus data');
            return back();
        }
    }
}
