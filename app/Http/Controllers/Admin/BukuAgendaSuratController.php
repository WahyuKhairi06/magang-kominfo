<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class BukuAgendaSuratController extends Controller
{
    public function index()
    {
        $data = DB::table('buku_agenda_surats')
            ->leftJoin('desas','buku_agenda_surats.desa_id','=','desas.id')
            ->leftJoin('kecamatans','buku_agenda_surats.kecamatan_id','=','kecamatans.id')
            ->leftJoin('dusuns','buku_agenda_surats.dusun_id','=','dusuns.id')
            ->select(
                'buku_agenda_surats.*',
                'desas.nama_desa',
                'kecamatans.nama_kecamatan',
                'dusuns.nama_dusun'
            )
            ->latest()
            ->get();

        return view('admin.bukuagenda.index', compact('data'));
    }

    public function create()
    {
        $desa = DB::table('desas')->get();
        $kecamatan = DB::table('kecamatans')->get();
        $dusun = DB::table('dusuns')->get();

        return view('admin.bukuagenda.create', compact('desa','kecamatan','dusun'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'desa_id' => 'required',
            'kecamatan_id' => 'required',
            'tahun' => 'required'
        ]);

        DB::table('buku_agenda_surats')->insert([
            'desa_id' => $request->desa_id,
            'kecamatan_id' => $request->kecamatan_id,
            'dusun_id' => $request->dusun_id,
            'tahun' => $request->tahun,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        Alert::success('Berhasil','Data disimpan');
        return redirect()->route('bukuagenda.index');
    }

    public function edit($id)
    {
        $data = DB::table('buku_agenda_surats')->where('id',$id)->first();
        $desa = DB::table('desas')->get();
        $kecamatan = DB::table('kecamatans')->get();
        $dusun = DB::table('dusuns')->get();

        return view('admin.bukuagenda.edit', compact('data','desa','kecamatan','dusun'));
    }

    public function update(Request $request, $id)
    {
        DB::table('buku_agenda_surats')->where('id',$id)->update([
            'desa_id' => $request->desa_id,
            'kecamatan_id' => $request->kecamatan_id,
            'dusun_id' => $request->dusun_id,
            'tahun' => $request->tahun,
            'updated_at' => now()
        ]);

        Alert::success('Berhasil','Data diupdate');
        return redirect()->route('bukuagenda.index');
    }

    public function destroy($id)
    {
        DB::table('buku_agenda_surats')->where('id',$id)->delete();

        Alert::success('Berhasil','Data dihapus');
        return back();
    }
}