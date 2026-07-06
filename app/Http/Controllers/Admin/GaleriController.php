<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Storage;

class GaleriController extends Controller
{
    // ✅ LIST DATA
    public function index()
    {
        $data = DB::table('galeris')->
        leftjoin('pokjas','galeris.pokja_id','=','pokjas.id')
        ->select('galeris.*','pokjas.nama_pokja')
        ->latest()->get();
        $pokja=DB::table('pokjas')->get();

        return view('admin.galeri.index', compact('data','pokja'));
    }

    // ✅ FORM TAMBAH
    public function create()
    {
        $pokja=DB::table('pokjas')->get();
        return view('admin.galeri.create',compact('pokja'));
    }

    // ✅ SIMPAN DATA
    public function store(Request $request)
    {
        $request->validate([
            'judul_kegiatan' => 'required',
            'tanggal' => 'required|date',
            'foto' => 'required|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        DB::beginTransaction();

        try {

            // upload gambar ke storage/galeri
            $path = $request->file('foto')->store('galeri', 'public');

            DB::table('galeris')->insert([
                'judul_kegiatan' => $request->judul_kegiatan,
                'tanggal' => $request->tanggal,
                 'jenis' => $request->jenis ?? null,
                'lokasi' => $request->lokasi,
                'deskripsi' => $request->deskripsi,
                'pokja_id' => $request->pokja_id,
                'foto' => $path,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            DB::commit();

            Alert::success('Berhasil', 'Data galeri berhasil ditambahkan');
            return redirect()->route('galeri.index');

        } catch (\Exception $e) {

            DB::rollBack();

            Alert::error('Gagal', $e->getMessage());
            return back()->withInput();
        }
    }

    // ✅ FORM EDIT
    public function edit($id)
    {
        $data = DB::table('galeris')->where('id', $id)->first();
        $pokja=DB::table('pokjas')->get();
        return view('admin.galeri.edit', compact('data','pokja'));
    }

    // ✅ UPDATE DATA
    public function update(Request $request, $id)
    {
        $request->validate([
            'judul_kegiatan' => 'required',
            'tanggal' => 'required|date',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        DB::beginTransaction();

        try {

            $data = DB::table('galeris')->where('id', $id)->first();

            $path = $data->foto;

            // jika upload gambar baru
            if ($request->hasFile('foto')) {

                // hapus gambar lama
                if ($data->foto && Storage::disk('public')->exists($data->foto)) {
                    Storage::disk('public')->delete($data->foto);
                }

                $path = $request->file('foto')->store('galeri', 'public');
            }

            DB::table('galeris')->where('id', $id)->update([
                'judul_kegiatan' => $request->judul_kegiatan,
                'tanggal' => $request->tanggal,
                'lokasi' => $request->lokasi,
                 'jenis' => $request->jenis ?? null,
                'deskripsi' => $request->deskripsi,
                 'pokja_id' => $request->pokja_id,
                'foto' => $path,
                'updated_at' => now()
            ]);

            DB::commit();

            Alert::success('Berhasil', 'Data berhasil diupdate');
            return redirect()->route('galeri.index');

        } catch (\Exception $e) {

            DB::rollBack();

            Alert::error('Gagal', $e->getMessage());
            return back()->withInput();
        }
    }

    // ✅ HAPUS DATA
    public function destroy($id)
    {
        DB::beginTransaction();

        try {

            $data = DB::table('galeris')->where('id', $id)->first();

            // hapus file gambar
            if ($data->foto && Storage::disk('public')->exists($data->foto)) {
                Storage::disk('public')->delete($data->foto);
            }

            DB::table('galeris')->where('id', $id)->delete();

            DB::commit();

            Alert::success('Berhasil', 'Data berhasil dihapus');
            return redirect()->route('galeri.index');

        } catch (\Exception $e) {

            DB::rollBack();

            Alert::error('Gagal', $e->getMessage());
            return back();
        }
    }
}