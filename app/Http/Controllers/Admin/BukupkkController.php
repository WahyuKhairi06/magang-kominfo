<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class BukupkkController extends Controller
{

    // 🔥 LIST DATA
    public function index()
    {
        $data = DB::table('buku_pkks')
            ->leftJoin('desas','buku_pkks.desa_id','=','desas.id')
            ->leftJoin('kecamatans','buku_pkks.kecamatan_id','=','kecamatans.id')
            ->leftJoin('dusuns','buku_pkks.dusun_id','=','dusuns.id')
            ->select(
                'buku_pkks.*',
                'desas.nama_desa',
                'kecamatans.nama_kecamatan',
                'dusuns.nama_dusun'
            )
            ->latest()
            ->get();

        return view('admin.bukupkk.index', compact('data'));
    }

    // 🔥 FORM CREATE
    public function create()
    {
        $desa = DB::table('desas')->get();
        $kecamatan = DB::table('kecamatans')->get();
        $dusun = DB::table('dusuns')->get();

        return view('admin.bukupkk.create', compact('desa','kecamatan','dusun'));
    }

    // 🔥 SIMPAN
    public function store(Request $request)
    {
        $request->validate([
            'desa_id' => 'required',
            'kecamatan_id' => 'required',
'masa_mulai'   => 'required|digits:4|integer|min:1900|max:2100',
'masa_selesai' => 'required|digits:4|integer|min:1900|max:2100|gte:masa_mulai',        ]);

        DB::table('buku_pkks')->insert([
            'desa_id' => $request->desa_id,
            'kecamatan_id' => $request->kecamatan_id,
            'dusun_id' => $request->dusun_id,
            'masa_mulai' => $request->masa_mulai,
            'masa_selesai' => $request->masa_selesai,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        Alert::success('Berhasil','Data ditambahkan');
        return redirect()->route('bukupkk.index');
    }

    // 🔥 FORM EDIT
    public function edit($id)
    {
        $data = DB::table('buku_pkks')->where('id',$id)->first();

        $desa = DB::table('desas')->get();
        $kecamatan = DB::table('kecamatans')->get();
        $dusun = DB::table('dusuns')->get();

        return view('admin.bukupkk.edit', compact('data','desa','kecamatan','dusun'));
    }

    // 🔥 UPDATE
    public function update(Request $request, $id)
    {
        $request->validate([
            'desa_id' => 'required',
            'kecamatan_id' => 'required',
'masa_mulai'   => 'required|digits:4|integer|min:1900|max:2100',
'masa_selesai' => 'required|digits:4|integer|min:1900|max:2100|gte:masa_mulai',
        ]);

        DB::table('buku_pkks')->where('id',$id)->update([
            'desa_id' => $request->desa_id,
            'kecamatan_id' => $request->kecamatan_id,
            'dusun_id' => $request->dusun_id,
             'masa_mulai' => $request->masa_mulai,
            'masa_selesai' => $request->masa_selesai,
            'updated_at' => now()
        ]);

        Alert::success('Berhasil','Data diupdate');
        return redirect()->route('bukupkk.index');
    }

    // 🔥 DELETE
    public function destroy($id)
    {
        DB::table('buku_pkks')->where('id',$id)->delete();

        Alert::success('Berhasil','Data dihapus');
        return back();
    }
}