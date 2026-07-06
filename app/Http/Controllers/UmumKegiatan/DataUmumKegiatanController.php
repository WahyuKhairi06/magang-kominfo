<?php

namespace App\Http\Controllers\UmumKegiatan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Barryvdh\DomPDF\Facade\Pdf;

class DataUmumKegiatanController extends Controller
{



public function pdf($id)
{
    $data = DB::table('data_umum_kegiatanpkks')
    ->leftJoin('dusuns','data_umum_kegiatanpkks.id_dusun','=','dusuns.id')

    ->leftJoin('umum_kegiatanpkks','data_umum_kegiatanpkks.id_dusun','=','umum_kegiatanpkks.dusun_id')

    ->leftJoin('desas','umum_kegiatanpkks.desa_id','=','desas.id')
    ->leftJoin('kecamatans','umum_kegiatanpkks.kecamatan_id','=','kecamatans.id')

    ->select(
        'data_umum_kegiatanpkks.*',
        'umum_kegiatanpkks.tahun',
        'dusuns.nama_dusun',
        'desas.nama_desa',
        'kecamatans.nama_kecamatan'
    )

    ->where('data_umum_kegiatanpkks.id_desa',$id)
    ->distinct()
    ->get();

    $info = $data->first();

    // TOTAL
    $total = [
        'pkk_rw' => $data->sum('pkk_rw'),
        'pkk_rt' => $data->sum('pkk_rt'),
        'dasawisma' => $data->sum('dasawisma'),
        'krt' => $data->sum('krt'),
        'kk' => $data->sum('kk'),
        'jiwa_l' => $data->sum('jiwa_l'),
        'jiwa_p' => $data->sum('jiwa_p'),

        'kader_tp_l' => $data->sum('kader_tp_l'),
        'kader_tp_p' => $data->sum('kader_tp_p'),

        'kader_umum_l' => $data->sum('kader_umum_l'),
        'kader_umum_p' => $data->sum('kader_umum_p'),

        'kader_khusus_l' => $data->sum('kader_khusus_l'),
        'kader_khusus_p' => $data->sum('kader_khusus_p'),

        'sekretariat_honorer_l' => $data->sum('sekretariat_honorer_l'),
        'sekretariat_honorer_p' => $data->sum('sekretariat_honorer_p'),

        'sekretariat_bantuan_l' => $data->sum('sekretariat_bantuan_l'),
        'sekretariat_bantuan_p' => $data->sum('sekretariat_bantuan_p'),
    ];

    $desa = DB::table('dusuns')->where('id',$id)->first();

    return Pdf::loadView('admin.dataumum.pdf', compact('data','desa','total'))
        ->setPaper('A4','landscape')
        ->stream('data-umum-pkk.pdf');
}


    // INDEX
    public function index($id)
    {
        $data = DB::table('data_umum_kegiatanpkks')
            ->leftJoin('dusuns','data_umum_kegiatanpkks.id_dusun','=','dusuns.id')
            ->select('data_umum_kegiatanpkks.*','dusuns.nama_dusun')
            // ->where('data_umum_kegiatanpkks.id_dusun',$id)
            ->where('data_umum_kegiatanpkks.id_desa',$id)
            ->latest()
            ->get();

        return view('admin.dataumum.index', compact('data','id'));
    }

    // CREATE
    public function create($id)
    {
        $dusun = DB::table('dusuns')->where('desa_id',$id)->get();
        $desas = DB::table('desas')->where('id',$id)->first();
        return view('admin.dataumum.create', compact('dusun','desas'));
    }

    // STORE
    public function store(Request $request)
    {
        $cek_table=DB::table('data_umum_kegiatanpkks')
        ->where('id_dusun',$request->id_dusun)
        ->where('id_desa',$request->id_desa)        
        ->first();
        if($cek_table){
            alert::info('Info','Data Dusun Sudah Ada');
                return redirect()->back();

        }

        DB::table('data_umum_kegiatanpkks')->insert([
            'id_dusun' => $request->id_dusun,
            'id_desa' => $request->id_desa,

            'pkk_rw' => $request->pkk_rw,
            'pkk_rt' => $request->pkk_rt,
            'dasawisma' => $request->dasawisma,

            'krt' => $request->krt,
            'kk' => $request->kk,

            'jiwa_l' => $request->jiwa_l,
            'jiwa_p' => $request->jiwa_p,

            'kader_tp_l' => $request->kader_tp_l,
            'kader_tp_p' => $request->kader_tp_p,

            'kader_umum_l' => $request->kader_umum_l,
            'kader_umum_p' => $request->kader_umum_p,

            'kader_khusus_l' => $request->kader_khusus_l,
            'kader_khusus_p' => $request->kader_khusus_p,

            'sekretariat_honorer_l' => $request->sekretariat_honorer_l,
            'sekretariat_honorer_p' => $request->sekretariat_honorer_p,

            'sekretariat_bantuan_l' => $request->sekretariat_bantuan_l,
            'sekretariat_bantuan_p' => $request->sekretariat_bantuan_p,

            'ket' => $request->ket,

            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Alert::success('Berhasil','Data berhasil ditambahkan');
        return redirect()->back();
    }

    // EDIT
    public function edit($id)
    {
        $data = DB::table('data_umum_kegiatanpkks')->where('id',$id)->first();
        $dusun = DB::table('dusuns')->get();

        return view('admin.dataumum.edit', compact('data','dusun'));
    }

    // UPDATE
    public function update(Request $request, $id)
    {
        DB::table('data_umum_kegiatanpkks')
            ->where('id',$id)
            ->update([
                'id_dusun' => $request->id_dusun,
    
                'pkk_rw' => $request->pkk_rw,
                'pkk_rt' => $request->pkk_rt,
                'dasawisma' => $request->dasawisma,

                'krt' => $request->krt,
                'kk' => $request->kk,

                'jiwa_l' => $request->jiwa_l,
                'jiwa_p' => $request->jiwa_p,

                'kader_tp_l' => $request->kader_tp_l,
                'kader_tp_p' => $request->kader_tp_p,

                'kader_umum_l' => $request->kader_umum_l,
                'kader_umum_p' => $request->kader_umum_p,

                'kader_khusus_l' => $request->kader_khusus_l,
                'kader_khusus_p' => $request->kader_khusus_p,

                'sekretariat_honorer_l' => $request->sekretariat_honorer_l,
                'sekretariat_honorer_p' => $request->sekretariat_honorer_p,

                'sekretariat_bantuan_l' => $request->sekretariat_bantuan_l,
                'sekretariat_bantuan_p' => $request->sekretariat_bantuan_p,

                'ket' => $request->ket,

                'updated_at' => now(),
            ]);

        Alert::success('Berhasil','Data berhasil diupdate');
        return redirect()->back();
    }

    // DELETE
    public function destroy($id)
    {
        DB::table('data_umum_kegiatanpkks')->where('id',$id)->delete();

        Alert::success('Berhasil','Data berhasil dihapus');
        return back();
    }
}