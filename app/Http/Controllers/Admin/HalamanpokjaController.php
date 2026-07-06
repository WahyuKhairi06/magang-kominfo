<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class HalamanpokjaController extends Controller
{
    // ✅ INDEX
    public function index()
    {
        $data = DB::table('halaman_pokjas')
            ->join('pokjas', 'pokjas.id', '=', 'halaman_pokjas.pokja_id')
            ->select('halaman_pokjas.*', 'pokjas.nama_pokja')
            ->latest()
            ->get();

        return view('admin.halaman_pokja.index', compact('data'));
    }

    // ✅ CREATE
    public function create()
    {
        $pokja = DB::table('pokjas')->get();
        return view('admin.halaman_pokja.create', compact('pokja'));
    }

    // ✅ STORE
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'isi' => 'required',
            'pokja_id' => 'required'
        ]);

        DB::beginTransaction();

        try {

            DB::table('halaman_pokjas')->insert([
                'judul' => $request->judul,
                'isi' => $request->isi,
                'pokja_id' => $request->pokja_id,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            DB::commit();

            Alert::success('Berhasil', 'Data berhasil ditambahkan');
            return redirect()->route('halamanpokja.index');

        } catch (\Exception $e) {

            DB::rollBack();

            Alert::error('Gagal', $e->getMessage());
            return back()->withInput();
        }
    }

    // ✅ EDIT
    public function edit($id)
    {
        $data = DB::table('halaman_pokjas')->where('id', $id)->first();
        $pokja = DB::table('pokjas')->get();

        return view('admin.halaman_pokja.edit', compact('data', 'pokja'));
    }

    // ✅ UPDATE
    public function update(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required',
            'isi' => 'required',
            'pokja_id' => 'required'
        ]);

        DB::beginTransaction();

        try {

            DB::table('halaman_pokjas')->where('id', $id)->update([
                'judul' => $request->judul,
                'isi' => $request->isi,
                'pokja_id' => $request->pokja_id,
                'updated_at' => now()
            ]);

            DB::commit();

            Alert::success('Berhasil', 'Data berhasil diupdate');
            return redirect()->route('halamanpokja.index');

        } catch (\Exception $e) {

            DB::rollBack();

            Alert::error('Gagal', $e->getMessage());
            return back()->withInput();
        }
    }

    // ✅ DELETE
    public function destroy($id)
    {
        try {

            DB::table('halaman_pokjas')->where('id', $id)->delete();

            Alert::success('Berhasil', 'Data berhasil dihapus');
            return redirect()->route('halamanpokja.index');

        } catch (\Exception $e) {

            Alert::error('Gagal', $e->getMessage());
            return back();
        }
    }

    // ✅ UPLOAD CKEDITOR (gambar)
    public function upload(Request $request)
    {
        if ($request->hasFile('upload')) {

            $file = $request->file('upload');
            $path = $file->store('ckeditor', 'public');

            return response()->json([
                'url' => asset('storage/' . $path)
            ]);
        }
    }
}