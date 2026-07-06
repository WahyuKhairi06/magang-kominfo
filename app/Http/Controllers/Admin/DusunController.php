<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class DusunController extends Controller
{
    public function index()
    {
        $data = DB::table('dusuns')
            ->leftJoin('desas', 'dusuns.desa_id', '=', 'desas.id')
            ->select('dusuns.*', 'desas.nama_desa')
            ->orderBy('dusuns.id', 'desc')
            ->get();

        return view('admin.dusun.index', compact('data'));
    }

    public function create()
    {
        $desa = DB::table('desas')->get();
        return view('admin.dusun.create', compact('desa'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_dusun' => 'required',
            'desa_id' => 'required'
        ]);

        DB::table('dusuns')->insert([
            'nama_dusun' => $request->nama_dusun,
            'desa_id' => $request->desa_id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Alert::success('Berhasil', 'Dusun ditambahkan');
        return redirect()->route('dusun.index');
    }

    public function edit($id)
    {
        $dusun = DB::table('dusuns')->where('id', $id)->first();
        $desa = DB::table('desas')->get();

        return view('admin.dusun.edit', compact('dusun', 'desa'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_dusun' => 'required',
            'desa_id' => 'required'
        ]);

        DB::table('dusuns')->where('id', $id)->update([
            'nama_dusun' => $request->nama_dusun,
            'desa_id' => $request->desa_id,
            'updated_at' => now(),
        ]);

        Alert::success('Berhasil', 'Dusun diupdate');
        return redirect()->route('dusun.index');
    }

    public function destroy($id)
    {
        DB::table('dusuns')->where('id', $id)->delete();

        Alert::success('Berhasil', 'Dusun dihapus');
        return redirect()->back();
    }
}