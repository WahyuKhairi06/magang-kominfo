<?php

namespace App\Http\Controllers\UmumKegiatan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class Pokja3realKegiatanController extends Controller
{

public function pdf($id_dusun)
{
    $data = DB::table('kegiatan_pokja3reals as k')
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

    $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('kegiatan.pokja3real.pdf', compact('data'))
        ->setPaper('A4','landscape');

    return $pdf->download('pokja3_pangan.pdf');
}


    // =========================
    // INDEX
    // =========================
    public function index($id_dusun)
    {
        $data = DB::table('kegiatan_pokja3reals')
            ->leftJoin('dusuns','kegiatan_pokja3reals.id_dusun','=','dusuns.id')
            ->select('kegiatan_pokja3reals.*','dusuns.nama_dusun')
            ->where('kegiatan_pokja3reals.id_desa',$id_dusun)
            ->orderBy('kegiatan_pokja3reals.id','desc')
            ->get();

        return view('kegiatan.pokja3real.index', compact('data','id_dusun'));
    }

    // =========================
    // CREATE
    // =========================
    public function create($id_dusun)
    {
                                $dusun = DB::table('dusuns')->where('desa_id',$id_dusun)->get();

        return view('kegiatan.pokja3real.create', compact('id_dusun','dusun'));
    }

    // =========================
    // STORE
    // =========================
    public function store(Request $r)
    {

    $cek_table=DB::table('kegiatan_pokja3reals')
        ->where('id_dusun',$r->id_dusun)
        ->where('id_desa',$r->id_desa)        
        ->first();
        if($cek_table){
            alert::info('Info','Data Dusun Sudah Ada');
                return redirect()->back();

        }
        DB::table('kegiatan_pokja3reals')->insert([
            'id_dusun' => $r->id_dusun,
            'id_desa' => $r->id_desa,

            'kader_pangan' => $r->kader_pangan,
            'kader_sandang' => $r->kader_sandang,
            'kader_tata_laksana_rumah_tangga' => $r->kader_tata_laksana_rumah_tangga,

            'pangan_beras' => $r->pangan_beras,
            'pangan_non_beras' => $r->pangan_non_beras,

            'peternakan' => $r->peternakan,
            'perikanan' => $r->perikanan,
            'warung_hidup' => $r->warung_hidup,
            'lumbung_hidup' => $r->lumbung_hidup,
            'toga' => $r->toga,
            'tanaman_keras' => $r->tanaman_keras,
            'tanaman_lainnya' => $r->tanaman_lainnya,

            'industri_pangan' => $r->industri_pangan,
            'industri_sandang' => $r->industri_sandang,
            'industri_jasa' => $r->industri_jasa,

            'rumah_sehat_layak' => $r->rumah_sehat_layak,
            'rumah_tidak_sehat_tidak_layak' => $r->rumah_tidak_sehat_tidak_layak,

            'keterangan' => $r->keterangan,

            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Alert::success('Berhasil', 'Data berhasil disimpan');
        return redirect('kegiatanpokja3real/'.$r->id_dusun);
    }

    // =========================
    // EDIT
    // =========================
    public function edit($id)
    {
        $data = DB::table('kegiatan_pokja3reals')->where('id',$id)->first();
        return view('kegiatan.pokja3real.edit', compact('data'));
    }

    // =========================
    // UPDATE
    // =========================
    public function update(Request $r, $id)
    {
        DB::table('kegiatan_pokja3reals')->where('id',$id)->update([

            'kader_pangan' => $r->kader_pangan,
            'kader_sandang' => $r->kader_sandang,
            'kader_tata_laksana_rumah_tangga' => $r->kader_tata_laksana_rumah_tangga,

            'pangan_beras' => $r->pangan_beras,
            'pangan_non_beras' => $r->pangan_non_beras,

            'peternakan' => $r->peternakan,
            'perikanan' => $r->perikanan,
            'warung_hidup' => $r->warung_hidup,
            'lumbung_hidup' => $r->lumbung_hidup,
            'toga' => $r->toga,
            'tanaman_keras' => $r->tanaman_keras,
            'tanaman_lainnya' => $r->tanaman_lainnya,

            'industri_pangan' => $r->industri_pangan,
            'industri_sandang' => $r->industri_sandang,
            'industri_jasa' => $r->industri_jasa,

            'rumah_sehat_layak' => $r->rumah_sehat_layak,
            'rumah_tidak_sehat_tidak_layak' => $r->rumah_tidak_sehat_tidak_layak,

            'keterangan' => $r->keterangan,

            'updated_at' => now(),
        ]);

        Alert::success('Berhasil', 'Data berhasil diupdate');
        return back();
    }

    // =========================
    // DELETE
    // =========================
    public function delete($id)
    {
        DB::table('kegiatan_pokja3reals')->where('id',$id)->delete();

        Alert::success('Berhasil', 'Data berhasil dihapus');
        return back();
    }
}