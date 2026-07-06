<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class KecamatanController extends Controller
{
    public function index()
    {
        $data = DB::table('kecamatans')
            ->orderBy('id', 'desc')
            ->get();

        return view('admin.kecamatan.index', compact('data'));
    }

    public function create()
    {
        return view('admin.kecamatan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kecamatan' => 'required'
        ]);

        DB::table('kecamatans')->insert([
            'nama_kecamatan' => $request->nama_kecamatan,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Alert::success('Berhasil', 'Data kecamatan ditambahkan');
        return redirect()->route('kecamatan.index');
    }

    public function edit($id)
    {
        $kecamatan = DB::table('kecamatans')->where('id', $id)->first();

        return view('admin.kecamatan.edit', compact('kecamatan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_kecamatan' => 'required'
        ]);

        DB::table('kecamatans')->where('id', $id)->update([
            'nama_kecamatan' => $request->nama_kecamatan,
            'updated_at' => now(),
        ]);

        Alert::success('Berhasil', 'Data kecamatan diupdate');
        return redirect()->route('kecamatan.index');
    }

    public function destroy($id)
    {
        DB::table('kecamatans')->where('id', $id)->delete();

        Alert::success('Berhasil', 'Data kecamatan dihapus');
        return redirect()->back();
    }
}