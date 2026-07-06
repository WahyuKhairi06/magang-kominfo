<?php

namespace App\Http\Controllers\UmumKegiatan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class UmumKegiatanController extends Controller
{
    // INDEX
    public function index()
    {
    
        $data = DB::table('umum_kegiatanpkks')
            ->leftJoin('desas','umum_kegiatanpkks.desa_id','=','desas.id')
            ->leftJoin('kecamatans','umum_kegiatanpkks.kecamatan_id','=','kecamatans.id')
            ->leftJoin('dusuns','umum_kegiatanpkks.dusun_id','=','dusuns.id')

            ->select(
                'umum_kegiatanpkks.*',
                'desas.nama_desa',
                'kecamatans.nama_kecamatan',
                'dusuns.nama_dusun',
                'dusuns.id as dusunnya_id'
            )
                ->whereNull('umum_kegiatanpkks.pokja_id') // INI KUNCINYA

            ->latest()
            ->get();

        return view('admin.umum_kegiatan.index', compact('data'));
    }

    // CREATE
    public function create()
    {
        $desa = DB::table('desas')->get();
        $kecamatan = DB::table('kecamatans')->get();
        $dusun = DB::table('dusuns')->get();

        return view('admin.umum_kegiatan.create', compact('desa','kecamatan','dusun'));
    }

    // STORE
    public function store(Request $request)
    {
        
        $request->validate([
            'desa_id' => 'required',
            'kecamatan_id' => 'required',
            'dusun_id' => 'required',
            'tahun' => 'required'
        ]);

        $cek = DB::table('umum_kegiatanpkks')
    ->where('desa_id', $request->desa_id)
    ->where('kecamatan_id', $request->kecamatan_id)
    ->where('dusun_id', $request->dusun_id)
    ->where('tahun', $request->tahun)
    ->where('pokja_id', Null)
    ->exists();

if ($cek) {
Alert::info('info','Data Sudah Ada');
        return redirect('umum');

}
        DB::table('umum_kegiatanpkks')->insert([
            'desa_id' => $request->desa_id,
            'kecamatan_id' => $request->kecamatan_id,
            'dusun_id' => $request->dusun_id,
            'tahun' => $request->tahun,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Alert::success('Berhasil', 'Data berhasil ditambahkan');
        return redirect()->route('umum.index');
    }

    // EDIT
    public function edit($id)
    {
        $data = DB::table('umum_kegiatanpkks')->where('id',$id)->first();

        $desa = DB::table('desas')->get();
        $kecamatan = DB::table('kecamatans')->get();
        $dusun = DB::table('dusuns')->get();
        $pokja = DB::table('pokjas')->get();

        return view('admin.umum_kegiatan.edit', compact('data','desa','kecamatan','dusun'));
    }

    // UPDATE
    public function update(Request $request, $id)
    {
        DB::table('umum_kegiatanpkks')
            ->where('id',$id)
            ->update([
                'desa_id' => $request->desa_id,
                'kecamatan_id' => $request->kecamatan_id,
                'dusun_id' => $request->dusun_id,
                'dusun_id' => $request->dusun_id,
                    'tahun' => $request->tahun,
                'updated_at' => now(),
            ]);

        Alert::success('Berhasil', 'Data berhasil diupdate');
        return redirect()->route('umum.index');
    }

    // DELETE
    public function destroy($id)
    {
        DB::table('umum_kegiatanpkks')->where('id',$id)->delete();

        Alert::success('Berhasil', 'Data berhasil dihapus');
        return back();
    }
}