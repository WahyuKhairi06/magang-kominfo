<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class PokjaController extends Controller
{
    // ✅ INDEX
    public function index()
    {
        $data = DB::table('pokjas')->latest()->get();
        return view('admin.pokja.index', compact('data'));
    }

    // ✅ CREATE
    public function create()
    {
        return view('admin.pokja.create');
    }

    // ✅ STORE
    public function store(Request $request)
    {
        $request->validate([
            'nama_pokja' => 'required'
        ]);

        try {

            DB::table('pokjas')->insert([
                'nama_pokja' => $request->nama_pokja,
                'keterangan' => $request->keterangan,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            Alert::success('Berhasil', 'Data berhasil ditambahkan');
            return redirect()->route('pokja.index');

        } catch (\Exception $e) {

            Alert::error('Gagal', $e->getMessage());
            return back()->withInput();
        }
    }

    // ✅ EDIT
    public function edit($id)
    {
        $data = DB::table('pokjas')->where('id', $id)->first();
        return view('admin.pokja.edit', compact('data'));
    }

    // ✅ UPDATE
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_pokja' => 'required'
        ]);

        try {

            DB::table('pokjas')->where('id', $id)->update([
                'nama_pokja' => $request->nama_pokja,
                'keterangan' => $request->keterangan,
                'updated_at' => now()
            ]);

            Alert::success('Berhasil', 'Data berhasil diupdate');
            return redirect()->route('pokja.index');

        } catch (\Exception $e) {

            Alert::error('Gagal', $e->getMessage());
            return back()->withInput();
        }
    }

    // ✅ DELETE
    public function destroy($id)
    {
        try {

            DB::table('pokjas')->where('id', $id)->delete();

            Alert::success('Berhasil', 'Data berhasil dihapus');
            return redirect()->route('pokja.index');

        } catch (\Exception $e) {

            Alert::error('Gagal', $e->getMessage());
            return back();
        }
    }
}