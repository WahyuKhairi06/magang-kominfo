<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class DesaController extends Controller
{
    public function index()
    {
        $data = DB::table('desas')
            ->leftJoin('kecamatans', 'desas.kecamatan_id', '=', 'kecamatans.id')
            ->select('desas.*', 'kecamatans.nama_kecamatan')
            ->orderBy('desas.id', 'desc')
            ->get();

        return view('admin.desa.index', compact('data'));
    }

    public function create()
    {
        $kecamatan = DB::table('kecamatans')->get();
        return view('admin.desa.create', compact('kecamatan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_desa' => 'required',
            'kecamatan_id' => 'required'
        ]);

        DB::table('desas')->insert([
            'nama_desa' => $request->nama_desa,
            'kecamatan_id' => $request->kecamatan_id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Alert::success('Berhasil', 'Data desa ditambahkan');
        return redirect()->route('desa.index');
    }

    public function edit($id)
    {
        $desa = DB::table('desas')->where('id', $id)->first();
        $kecamatan = DB::table('kecamatans')->get();

        return view('admin.desa.edit', compact('desa', 'kecamatan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_desa' => 'required',
            'kecamatan_id' => 'required'
        ]);

        DB::table('desas')->where('id', $id)->update([
            'nama_desa' => $request->nama_desa,
            'kecamatan_id' => $request->kecamatan_id,
            'updated_at' => now(),
        ]);

        Alert::success('Berhasil', 'Data desa diupdate');
        return redirect()->route('desa.index');
    }

    public function destroy($id)
    {
        DB::table('desas')->where('id', $id)->delete();

        Alert::success('Berhasil', 'Data desa dihapus');
        return redirect()->back();
    }
}