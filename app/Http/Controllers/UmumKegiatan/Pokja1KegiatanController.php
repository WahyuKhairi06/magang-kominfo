<?php

namespace App\Http\Controllers\UmumKegiatan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
    use Illuminate\Support\Facades\Crypt;

use Barryvdh\DomPDF\Facade\Pdf;

class Pokja1KegiatanController extends Controller
{
    //

    public function index($id)
    {


        $id = decrypt($id);

        $data = DB::table('umum_kegiatanpkks')
            ->leftJoin('desas','umum_kegiatanpkks.desa_id','=','desas.id')
            ->leftJoin('kecamatans','umum_kegiatanpkks.kecamatan_id','=','kecamatans.id')
            ->leftJoin('dusuns','umum_kegiatanpkks.dusun_id','=','dusuns.id')

            ->select(
                'umum_kegiatanpkks.*',
                'desas.nama_desa',
                'desas.id as id_desa',
                'kecamatans.nama_kecamatan',
                'dusuns.nama_dusun',
                'dusuns.id as dusunnya_id'
            )->where('umum_kegiatanpkks.pokja_id',$id)
            ->latest()
            ->get();
 $cek_pokja= Db::table('pokjas')->where('id',$id)->first();
        return view('kegiatan.pokja1.index', compact('data','cek_pokja','id'));
    }

    // CREATE
    public function create($id)
    {
        $desa = DB::table('desas')->get();
        $kecamatan = DB::table('kecamatans')->get();
        $dusun = DB::table('dusuns')->get();
        $pokjas= DB::table('pokjas')->where('id',$id)->first();


        return view('kegiatan.pokja1.create', compact('desa','kecamatan','dusun','pokjas'));
    }

    // STORE
    public function store(Request $request)
    {
        $request->validate([
            'desa_id' => 'required',
            'kecamatan_id' => 'required',
            'dusun_id' => 'required',
            'tahun' => 'required',
            'pokja_id' => 'required'
        ]);

        DB::table('umum_kegiatanpkks')->insert([
            'desa_id' => $request->desa_id,
            'kecamatan_id' => $request->kecamatan_id,
            'dusun_id' => $request->dusun_id,
            'pokja_id' => $request->pokja_id,
            'tahun' => $request->tahun,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Alert::success('Berhasil', 'Data berhasil ditambahkan');
        return redirect()->back();
    }

    // EDIT
    public function edit($id)
    {
        $data = DB::table('umum_kegiatanpkks')->where('id',$id)->first();

        $desa = DB::table('desas')->get();
        $kecamatan = DB::table('kecamatans')->get();
        $dusun = DB::table('dusuns')->get();
        $pokja = DB::table('pokjas')->get();

        return view('kegiatan.pokja1.edit', compact('data','desa','kecamatan','dusun','pokja'));
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
                            'pokja_id' => $request->pokja_id,

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


//table pokja
public function kegiatanpokja1Index($id)
    {
        $data = DB::table('kegiatan_pokja1s')
            ->leftJoin('dusuns','kegiatan_pokja1s.id_dusun','=','dusuns.id')
             ->leftJoin('desas','kegiatan_pokja1s.id_desa','=','desas.id')

            ->select(
                'kegiatan_pokja1s.*',
                'dusuns.nama_dusun',
            )->where('kegiatan_pokja1s.id_desa',$id)
            ->latest()
            ->get();

        return view('crudkegiaatan.pokja1.index', compact('data','id'));
    }

    // =========================
    // CREATE
    // =========================
    public function kegiatanpokja1Create($id)
    {
        $dusun = DB::table('dusuns')->where('desa_id',$id)->get();
        $desas = DB::table('desas')->where('id',$id)->first();

        return view('crudkegiaatan.pokja1.create', compact('dusun','desas'));
    }

    // =========================
    // STORE
    // =========================
    public function kegiatanpokja1Store(Request $request)
    {
        $request->validate([
            'id_dusun' => 'required',
        ]);

        $cek_table=DB::table('kegiatan_pokja1s')
        ->where('id_dusun',$request->id_dusun)
        ->where('id_desa',$request->id_desa)        
        ->first();
        if($cek_table){
            alert::info('Info','Data Dusun Sudah Ada');
                return redirect()->back();

        }

        DB::table('kegiatan_pokja1s')->insert([
            'id_dusun' => $request->id_dusun,
            'id_desa' => $request->id_desa,

            'kader_pkbn' => $request->kader_pkbn ?? 0,
            'kader_pkdrt' => $request->kader_pkdrt ?? 0,
            'kader_pola_asuh' => $request->kader_pola_asuh ?? 0,

            'pkbn_kelompok' => $request->pkbn_kelompok ?? 0,
            'pkbn_anggota' => $request->pkbn_anggota ?? 0,

            'pkdrt_kelompok' => $request->pkdrt_kelompok ?? 0,
            'pkdrt_anggota' => $request->pkdrt_anggota ?? 0,

            'pola_asuh_kelompok' => $request->pola_asuh_kelompok ?? 0,
            'pola_asuh_anggota' => $request->pola_asuh_anggota ?? 0,

            'lansia_kelompok' => $request->lansia_kelompok ?? 0,
            'lansia_anggota' => $request->lansia_anggota ?? 0,

            'kerja_bakti' => $request->kerja_bakti ?? 0,
            'rukun_kematian' => $request->rukun_kematian ?? 0,
            'keagamaan' => $request->keagamaan ?? 0,
            'jimpitan' => $request->jimpitan ?? 0,
            'arisan' => $request->arisan ?? 0,

            'ket' => $request->ket,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Alert::success('Berhasil','Data ditambahkan');
return redirect('kegiatanpokja1/'.$request->id_dusun);
    }

    // =========================
    // EDIT
    // =========================
    public function kegiatanpokja1Edit($id)
    {
        $data = DB::table('kegiatan_pokja1s')->where('id',$id)->first();
        $dusun = DB::table('dusuns')->get();
        $pokja = DB::table('pokjas')->get();

        return view('crudkegiaatan.pokja1.edit', compact('data','dusun','pokja'));
    }

    // =========================
    // UPDATE
    // =========================
    public function kegiatanpokja1Update(Request $request,$id)
    {
        DB::table('kegiatan_pokja1s')->where('id',$id)->update([

            'kader_pkbn' => $request->kader_pkbn ?? 0,
            'kader_pkdrt' => $request->kader_pkdrt ?? 0,
            'kader_pola_asuh' => $request->kader_pola_asuh ?? 0,

            'pkbn_kelompok' => $request->pkbn_kelompok ?? 0,
            'pkbn_anggota' => $request->pkbn_anggota ?? 0,

            'pkdrt_kelompok' => $request->pkdrt_kelompok ?? 0,
            'pkdrt_anggota' => $request->pkdrt_anggota ?? 0,

            'pola_asuh_kelompok' => $request->pola_asuh_kelompok ?? 0,
            'pola_asuh_anggota' => $request->pola_asuh_anggota ?? 0,

            'lansia_kelompok' => $request->lansia_kelompok ?? 0,
            'lansia_anggota' => $request->lansia_anggota ?? 0,

            'kerja_bakti' => $request->kerja_bakti ?? 0,
            'rukun_kematian' => $request->rukun_kematian ?? 0,
            'keagamaan' => $request->keagamaan ?? 0,
            'jimpitan' => $request->jimpitan ?? 0,
            'arisan' => $request->arisan ?? 0,

            'ket' => $request->ket,
            'updated_at' => now(),
        ]);

        Alert::success('Berhasil','Data diupdate');
        return redirect()->back();
    }

    // =========================
    // DELETE
    // =========================
    public function kegiatanpokja1Delete($id)
    {
        DB::table('kegiatan_pokja1s')->where('id',$id)->delete();

        Alert::success('Berhasil','Data dihapus');
        return back();
    }    

public function exportPdf($id)
{
    $data = DB::table('kegiatan_pokja1s')
    ->leftJoin('dusuns', 'kegiatan_pokja1s.id_dusun', '=', 'dusuns.id')

    ->leftJoin('umum_kegiatanpkks as u', function($join){
        $join->on('kegiatan_pokja1s.id_dusun','=','u.dusun_id')
             ->whereRaw('u.id = (SELECT MAX(id) FROM umum_kegiatanpkks WHERE dusun_id = kegiatan_pokja1s.id_dusun)');
    })

    ->leftJoin('desas','u.desa_id','=','desas.id')
    ->leftJoin('kecamatans','u.kecamatan_id','=','kecamatans.id')

    ->select(
        'kegiatan_pokja1s.*',
        'dusuns.nama_dusun',
        'desas.nama_desa',
        'kecamatans.nama_kecamatan'
    )
    ->where('kegiatan_pokja1s.id_desa',$id)
    ->orderBy('dusuns.nama_dusun')
    ->get();

    $pdf = Pdf::loadView('crudkegiaatan.pokja1.pdf', compact('data'))
        ->setPaper('A4', 'landscape');

    return $pdf->download('kegiatan_pokja1.pdf');
}

}
