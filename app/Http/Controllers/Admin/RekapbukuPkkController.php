<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Barryvdh\DomPDF\Facade\Pdf;

class RekapbukuPkkController extends Controller
{
    // 🔹 INDEX

    public function cetak($id)
{
    $data = DB::table('anggotabukupkks')
        ->leftJoin('buku_pkks','anggotabukupkks.buku_pkk_id','=','buku_pkks.id')
        ->leftJoin('desas','buku_pkks.desa_id','=','desas.id')
        ->leftJoin('kecamatans','buku_pkks.kecamatan_id','=','kecamatans.id')
        ->select(
            'anggotabukupkks.*',
            'desas.nama_desa as nama_buku',
            'kecamatans.nama_kecamatan',
            'buku_pkks.masa_mulai',
            'buku_pkks.masa_selesai'
        )
        ->where('anggotabukupkks.buku_pkk_id',$id)
        ->latest()
        ->get();

    $pdf = Pdf::loadView('admin.rekapbuku.laporan_pdf', compact('data'))
        ->setPaper('A4', 'landscape');

    return $pdf->stream('anggota-pkk.pdf');
}
    public function index($id)
    {
        $data = DB::table('anggotabukupkks')
            ->leftJoin('buku_pkks','anggotabukupkks.buku_pkk_id','=','buku_pkks.id')
            ->leftjoin('desas','buku_pkks.desa_id','=','desas.id')
            ->leftjoin('kecamatans','buku_pkks.kecamatan_id','=','kecamatans.id')
            ->select('anggotabukupkks.*','desas.nama_desa as nama_buku')
            ->where('anggotabukupkks.buku_pkk_id',$id)
            ->latest()
            ->get();

        return view('admin.rekapbuku.index', compact('data'));
    }

    // 🔹 CREATE
    public function create($id)
    {
        $buku=DB::table('buku_pkks')->where('id',$id)->first();
        return view('admin.rekapbuku.create', compact('buku'));
    }

    // 🔹 STORE
    public function store(Request $request)
    {
        $request->validate([
            'buku_pkk_id' => 'required',
            'nama' => 'required',
            'jenis_kelamin' => 'required',
        ]);

        DB::table('anggotabukupkks')->insert([
            'buku_pkk_id' => $request->buku_pkk_id,
            'nama' => $request->nama,
            'jenis_kelamin' => $request->jenis_kelamin,
            'dalam_keanggotaan_tp_pkk' => $request->dalam_keanggotaan_tp_pkk,
            'kader_umum' => $request->kader_umum,
            'kader_khusus' => $request->kader_khusus,
            'tanggal_lahir' => $request->tanggal_lahir,
            'status' => $request->status,
            'alamat' => $request->alamat,
            'pendidikan' => $request->pendidikan,
            'pekerjaan' => $request->pekerjaan,
            'keterangan' => $request->keterangan,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Alert::success('Berhasil','Data disimpan');
        return redirect()->route('rekapbuku.index');
    }

    // 🔹 EDIT
    public function edit($id)
    {
        $data = DB::table('anggotabukupkks')->where('id',$id)->first();
        $buku = DB::table('buku_pkks')->get();

        return view('admin.rekapbuku.edit', compact('data','buku'));
    }

    // 🔹 UPDATE
    public function update(Request $request, $id)
    {
        DB::table('anggotabukupkks')->where('id',$id)->update([
            'buku_pkk_id' => $request->buku_pkk_id,
            'nama' => $request->nama,
            'jenis_kelamin' => $request->jenis_kelamin,
            'dalam_keanggotaan_tp_pkk' => $request->dalam_keanggotaan_tp_pkk,
            'kader_umum' => $request->kader_umum,
            'kader_khusus' => $request->kader_khusus,
            'tanggal_lahir' => $request->tanggal_lahir,
            'status' => $request->status,
            'alamat' => $request->alamat,
            'pendidikan' => $request->pendidikan,
            'pekerjaan' => $request->pekerjaan,
            'keterangan' => $request->keterangan,
            'updated_at' => now(),
        ]);

        Alert::success('Berhasil','Data diupdate');
        return redirect()->route('rekapbuku.index');
    }

    // 🔹 DELETE
    public function destroy($id)
    {
        DB::table('anggotabukupkks')->where('id',$id)->delete();

        Alert::success('Berhasil','Data dihapus');
        return back();
    }
}