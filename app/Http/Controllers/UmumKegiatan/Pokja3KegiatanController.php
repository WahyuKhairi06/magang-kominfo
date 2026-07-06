<?php

namespace App\Http\Controllers\UmumKegiatan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class Pokja3KegiatanController extends Controller
{


public function pdf($id_dusun)
{
  $data = DB::table('kegiatan_pokja3s as k')
    ->leftJoin('dusuns as d','k.id_dusun','=','d.id')

    ->leftJoin('umum_kegiatanpkks as u', function($join){
        $join->on('k.id_dusun','=','u.dusun_id')
             ->whereRaw('u.id = (
                SELECT MAX(id) 
                FROM umum_kegiatanpkks 
                WHERE dusun_id = k.id_dusun
             )');
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

    $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('kegiatan.pokja3.pdf', compact('data'))
        ->setPaper('A4','landscape');

    return $pdf->download('pokja3.pdf');
}

    // =========================
    // INDEX
    // =========================
    public function index($id_dusun)
    {
        $data = DB::table('kegiatan_pokja3s')
            ->leftJoin('umum_kegiatanpkks','kegiatan_pokja3s.id_dusun','=','umum_kegiatanpkks.dusun_id')
            ->leftJoin('desas','umum_kegiatanpkks.desa_id','=','desas.id')
            ->leftJoin('kecamatans','umum_kegiatanpkks.kecamatan_id','=','kecamatans.id')
            ->leftJoin('dusuns','kegiatan_pokja3s.id_dusun','=','dusuns.id')
            ->select(
                'kegiatan_pokja3s.*',
                'dusuns.nama_dusun',
                'desas.nama_desa',
                'kecamatans.nama_kecamatan'
            )
            ->where('kegiatan_pokja3s.id_desa',$id_dusun)
            ->distinct()
            ->orderBy('kegiatan_pokja3s.id','desc')
            ->get();

        return view('kegiatan.pokja3.index', compact('data','id_dusun'));
    }

    // =========================
    // CREATE
    // =========================
    public function create($id_dusun)
    {
                        $dusun = DB::table('dusuns')->where('desa_id',$id_dusun)->get();

        return view('kegiatan.pokja3.create', compact('id_dusun','dusun'));
    }

    // =========================
    // STORE
    // =========================
    public function store(Request $r)
    {
        $cek_table=DB::table('kegiatan_pokja3s')
        ->where('id_dusun',$r->id_dusun)
        ->where('id_desa',$r->id_desa)        
        ->first();
        if($cek_table){
            alert::info('Info','Data Dusun Sudah Ada');
                return redirect()->back();

        }
        DB::table('kegiatan_pokja3s')->insert([
            'id_dusun' => $r->id_dusun,
            'id_desa' => $r->id_desa,

            'kader_posyandu' => $r->kader_posyandu,
            'kader_gizi' => $r->kader_gizi,
            'kader_kesling' => $r->kader_kesling,
            'kader_penyuluhan_narkoba' => $r->kader_penyuluhan_narkoba,
            'kader_phbs' => $r->kader_phbs,
            'kader_kb' => $r->kader_kb,

            'posyandu_jumlah' => $r->posyandu_jumlah,
            'posyandu_terintegrasi' => $r->posyandu_terintegrasi,

            'lansia_jumlah_kelompok' => $r->lansia_jumlah_kelompok,
            'lansia_jumlah_anggota' => $r->lansia_jumlah_anggota,
            'lansia_memiliki_kartu_obat_gratis' => $r->lansia_memiliki_kartu_obat_gratis,

            'rumah_memiliki_jamban' => $r->rumah_memiliki_jamban,
            'rumah_memiliki_spal' => $r->rumah_memiliki_spal,
            'rumah_memiliki_tempat_sampah' => $r->rumah_memiliki_tempat_sampah,

            'jumlah_mck' => $r->jumlah_mck,

            'air_pdam' => $r->air_pdam,
            'air_sumur' => $r->air_sumur,
            'air_lainnya' => $r->air_lainnya,

            'jumlah_pus' => $r->jumlah_pus,
            'jumlah_wus' => $r->jumlah_wus,

            'akseptor_kb_l' => $r->akseptor_kb_l,
            'akseptor_kb_p' => $r->akseptor_kb_p,

            'kk_memiliki_tabungan_keluarga' => $r->kk_memiliki_tabungan_keluarga,

            'ket' => $r->ket,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Alert::success('Berhasil','Data disimpan');
        return redirect('kegiatanpokja3/'.$r->id_dusun);
    }

    // =========================
    // EDIT
    // =========================
    public function edit($id)
    {
        $data = DB::table('kegiatan_pokja3s')->where('id',$id)->first();
        return view('kegiatan.pokja3.edit', compact('data'));
    }

    // =========================
    // UPDATE
    // =========================
    public function update(Request $r, $id)
    {
        DB::table('kegiatan_pokja3s')->where('id',$id)->update([
            'kader_posyandu' => $r->kader_posyandu,
            'kader_gizi' => $r->kader_gizi,
            'kader_kesling' => $r->kader_kesling,
            'kader_penyuluhan_narkoba' => $r->kader_penyuluhan_narkoba,
            'kader_phbs' => $r->kader_phbs,
            'kader_kb' => $r->kader_kb,

            'posyandu_jumlah' => $r->posyandu_jumlah,
            'posyandu_terintegrasi' => $r->posyandu_terintegrasi,

            'lansia_jumlah_kelompok' => $r->lansia_jumlah_kelompok,
            'lansia_jumlah_anggota' => $r->lansia_jumlah_anggota,
            'lansia_memiliki_kartu_obat_gratis' => $r->lansia_memiliki_kartu_obat_gratis,

            'rumah_memiliki_jamban' => $r->rumah_memiliki_jamban,
            'rumah_memiliki_spal' => $r->rumah_memiliki_spal,
            'rumah_memiliki_tempat_sampah' => $r->rumah_memiliki_tempat_sampah,

            'jumlah_mck' => $r->jumlah_mck,

            'air_pdam' => $r->air_pdam,
            'air_sumur' => $r->air_sumur,
            'air_lainnya' => $r->air_lainnya,

            'jumlah_pus' => $r->jumlah_pus,
            'jumlah_wus' => $r->jumlah_wus,

            'akseptor_kb_l' => $r->akseptor_kb_l,
            'akseptor_kb_p' => $r->akseptor_kb_p,

            'kk_memiliki_tabungan_keluarga' => $r->kk_memiliki_tabungan_keluarga,

            'ket' => $r->ket,
            'updated_at' => now(),
        ]);

        Alert::success('Berhasil','Data diupdate');
        return back();
    }

    // =========================
    // DELETE
    // =========================
    public function delete($id)
    {
        DB::table('kegiatan_pokja3s')->where('id',$id)->delete();

        Alert::success('Berhasil','Data dihapus');
        return back();
    }
}