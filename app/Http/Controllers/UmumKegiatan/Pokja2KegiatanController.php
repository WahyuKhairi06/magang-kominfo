<?php

namespace App\Http\Controllers\UmumKegiatan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class Pokja2KegiatanController extends Controller
{
    // =========================
    // LIST DATA
    // =========================

public function exportPdf($id_dusun)
{
    $data = DB::table('kegiatan_pokja2s as k')
        ->leftJoin('dusuns as d','k.id_dusun','=','d.id')
        ->leftJoin('umum_kegiatanpkks as u', function($join){
            $join->on('k.id_dusun','=','u.dusun_id')
                 ->whereRaw('u.id = (SELECT MAX(id) FROM umum_kegiatanpkks WHERE dusun_id = k.id_dusun)');
        })
        ->leftJoin('desas as ds','u.desa_id','=','ds.id')
        ->leftJoin('kecamatans as kc','u.kecamatan_id','=','kc.id')
        ->select(
            'k.*',
            'd.nama_dusun',
            'ds.nama_desa',
            'kc.nama_kecamatan'
        )
        ->where('k.id_desa',$id_dusun)
        ->get();

    $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('kegiatan.pokja2.pdf', compact('data'))
        ->setPaper('A4','landscape');

    return $pdf->download('pokja2.pdf');
}

    public function index($id_dusun)
    {
       $data = DB::table('kegiatan_pokja2s')
    ->leftJoin('umum_kegiatanpkks','kegiatan_pokja2s.id_dusun','=','umum_kegiatanpkks.dusun_id')
    ->leftJoin('desas','umum_kegiatanpkks.desa_id','=','desas.id')
    ->leftJoin('kecamatans','umum_kegiatanpkks.kecamatan_id','=','kecamatans.id')
    ->leftJoin('dusuns','kegiatan_pokja2s.id_dusun','=','dusuns.id')
    ->select(
        'kegiatan_pokja2s.*',
        'dusuns.nama_dusun',
        'desas.nama_desa',
        'kecamatans.nama_kecamatan'
    )
    ->where('kegiatan_pokja2s.id_desa',$id_dusun)
    ->distinct()
    ->orderBy('kegiatan_pokja2s.id','desc')
    ->get();

        return view('kegiatan.pokja2.index', compact('data','id_dusun'));
    }

    // =========================
    // FORM TAMBAH
    // =========================
    public function create($id_dusun)
    {
                $dusun = DB::table('dusuns')->where('desa_id',$id_dusun)->get();

        return view('kegiatan.pokja2.create', compact('id_dusun','dusun'));
    }

    // =========================
    // SIMPAN DATA
    // =========================
    public function store(Request $request)
    {

       $cek_table=DB::table('kegiatan_pokja2s')
        ->where('id_dusun',$request->id_dusun)
        ->where('id_desa',$request->id_desa)        
        ->first();
        if($cek_table){
            alert::info('Info','Data Dusun Sudah Ada');
                return redirect()->back();

        }
        DB::table('kegiatan_pokja2s')->insert([
            'id_dusun' => $request->id_dusun,
            'id_desa' => $request->id_desa,

            'jumlah_warga_masih_buta' => $request->jumlah_warga_masih_buta,

            'paket_a_kelompok' => $request->paket_a_kelompok,
            'paket_a_warga' => $request->paket_a_warga,

            'paket_b_kelompok' => $request->paket_b_kelompok,
            'paket_b_warga' => $request->paket_b_warga,

            'paket_c_kelompok' => $request->paket_c_kelompok,
            'paket_c_warga' => $request->paket_c_warga,

            'kf_kelompok' => $request->kf_kelompok,
            'kf_warga' => $request->kf_warga,

            'paud_sejenis' => $request->paud_sejenis,
            'taman_bacaan' => $request->taman_bacaan,

            'bkb_kelompok' => $request->bkb_kelompok,
            'bkb_ibu' => $request->bkb_ibu,
            'bkb_ape' => $request->bkb_ape,
            'bkb_simulasi' => $request->bkb_simulasi,

            'kader_kf' => $request->kader_kf,
            'kader_paud' => $request->kader_paud,
            'kader_bkb' => $request->kader_bkb,
            'kader_koperasi' => $request->kader_koperasi,
            'kader_keterampilan' => $request->kader_keterampilan,

            'lp3_pkk' => $request->lp3_pkk,
            'tpk3_pkk' => $request->tpk3_pkk,
            'damas_pkk' => $request->damas_pkk,

            'koperasi_pemula_kelompok' => $request->koperasi_pemula_kelompok,
            'koperasi_pemula_peserta' => $request->koperasi_pemula_peserta,

            'koperasi_madya_kelompok' => $request->koperasi_madya_kelompok,
            'koperasi_madya_peserta' => $request->koperasi_madya_peserta,

            'koperasi_utama_kelompok' => $request->koperasi_utama_kelompok,
            'koperasi_utama_peserta' => $request->koperasi_utama_peserta,

            'koperasi_mandiri_kelompok' => $request->koperasi_mandiri_kelompok,
            'koperasi_mandiri_peserta' => $request->koperasi_mandiri_peserta,

            'koperasi_hukum_kelompok' => $request->koperasi_hukum_kelompok,
            'koperasi_hukum_anggota' => $request->koperasi_hukum_anggota,

            'ket' => $request->ket,

            'created_at' => now(),
            'updated_at' => now()
        ]);

        Alert::success('Berhasil', 'Data berhasil disimpan');
        return redirect('kegiatanpokja2'.'/'. $request->id_desa);
    }

    // =========================
    // FORM EDIT
    // =========================
    public function edit($id)
    {
        $data = DB::table('kegiatan_pokja2s')->where('id',$id)->first();
        return view('kegiatan.pokja2.edit', compact('data'));
    }

    // =========================
    // UPDATE
    // =========================
    public function update(Request $request, $id)
    {
        DB::table('kegiatan_pokja2s')
            ->where('id',$id)
            ->update([
                'jumlah_warga_masih_buta' => $request->jumlah_warga_masih_buta,

                'paket_a_kelompok' => $request->paket_a_kelompok,
                'paket_a_warga' => $request->paket_a_warga,

                'paket_b_kelompok' => $request->paket_b_kelompok,
                'paket_b_warga' => $request->paket_b_warga,

                'paket_c_kelompok' => $request->paket_c_kelompok,
                'paket_c_warga' => $request->paket_c_warga,

                'kf_kelompok' => $request->kf_kelompok,
                'kf_warga' => $request->kf_warga,

                'paud_sejenis' => $request->paud_sejenis,
                'taman_bacaan' => $request->taman_bacaan,

                'bkb_kelompok' => $request->bkb_kelompok,
                'bkb_ibu' => $request->bkb_ibu,
                'bkb_ape' => $request->bkb_ape,
                'bkb_simulasi' => $request->bkb_simulasi,

                'kader_kf' => $request->kader_kf,
                'kader_paud' => $request->kader_paud,
                'kader_bkb' => $request->kader_bkb,
                'kader_koperasi' => $request->kader_koperasi,
                'kader_keterampilan' => $request->kader_keterampilan,

                'lp3_pkk' => $request->lp3_pkk,
                'tpk3_pkk' => $request->tpk3_pkk,
                'damas_pkk' => $request->damas_pkk,

                'koperasi_pemula_kelompok' => $request->koperasi_pemula_kelompok,
                'koperasi_pemula_peserta' => $request->koperasi_pemula_peserta,

                'koperasi_madya_kelompok' => $request->koperasi_madya_kelompok,
                'koperasi_madya_peserta' => $request->koperasi_madya_peserta,

                'koperasi_utama_kelompok' => $request->koperasi_utama_kelompok,
                'koperasi_utama_peserta' => $request->koperasi_utama_peserta,

                'koperasi_mandiri_kelompok' => $request->koperasi_mandiri_kelompok,
                'koperasi_mandiri_peserta' => $request->koperasi_mandiri_peserta,

                'koperasi_hukum_kelompok' => $request->koperasi_hukum_kelompok,
                'koperasi_hukum_anggota' => $request->koperasi_hukum_anggota,

                'ket' => $request->ket,

                'updated_at' => now()
            ]);

        Alert::success('Berhasil', 'Data berhasil diupdate');
        return redirect()->back();
    }

    // =========================
    // DELETE
    // =========================
    public function destroy($id)
    {
        DB::table('kegiatan_pokja2s')->where('id',$id)->delete();

        Alert::success('Berhasil', 'Data berhasil dihapus');
        return redirect()->back();
    }
}