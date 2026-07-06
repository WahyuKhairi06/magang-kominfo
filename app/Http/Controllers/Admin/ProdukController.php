<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class ProdukController extends Controller
{
    public function index()
    {
        $data = DB::table('produks')->latest()->get();
        return view('admin.produk.index', compact('data'));
    }

    public function create()
    {
        return view('admin.produk.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_produk' => 'required',
            'harga' => 'required|numeric',
            'foto' => 'nullable|image'
        ]);

        $foto = null;
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto')->store('produk', 'public');
        }

        DB::table('produks')->insert([
            'nama_produk' => $request->nama_produk,
            'kode_produk' => $request->kode_produk,
            'deskripsi' => $request->deskripsi,
            'harga' => $request->harga,
            'harga_diskon' => $request->harga_diskon,
            'diskon_mulai' => $request->diskon_mulai,
            'diskon_selesai' => $request->diskon_selesai,
            'stok' => $request->stok ?? 0,
            'stok_minimum' => $request->stok_minimum ?? 0,
            'berat' => $request->berat ?? 0,
            'satuan' => $request->satuan,
            'foto' => $foto,
            'kategori' => $request->kategori,
            'status' => $request->status,
            'catatan' => $request->catatan,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Alert::success('Berhasil', 'Produk ditambahkan');
        return redirect()->route('produk.index');
    }

    public function edit($id)
    {
        $data = DB::table('produks')->where('id', $id)->first();
        return view('admin.produk.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $data = DB::table('produks')->where('id', $id)->first();

        $foto = $data->foto;
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto')->store('produk', 'public');
        }

        DB::table('produks')->where('id', $id)->update([
            'nama_produk' => $request->nama_produk,
            'kode_produk' => $request->kode_produk,
            'deskripsi' => $request->deskripsi,
            'harga' => $request->harga,
            'harga_diskon' => $request->harga_diskon,
            'diskon_mulai' => $request->diskon_mulai,
            'diskon_selesai' => $request->diskon_selesai,
            'stok' => $request->stok,
            'stok_minimum' => $request->stok_minimum,
            'berat' => $request->berat,
            'satuan' => $request->satuan,
            'foto' => $foto,
            'kategori' => $request->kategori,
            'status' => $request->status,
            'catatan' => $request->catatan,
            'updated_at' => now(),
        ]);

        Alert::success('Berhasil', 'Produk diupdate');
        return redirect()->route('produk.index');
    }

    public function destroy($id)
    {
        DB::table('produks')->where('id', $id)->delete();

        Alert::success('Berhasil', 'Produk dihapus');
        return back();
    }
}