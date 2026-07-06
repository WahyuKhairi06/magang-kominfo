<?php

namespace App\Http\Controllers\Dasawisma;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class BukuController extends Controller
{

public function cetakPdfrumah(Request $request, $id)
{
    $query = DB::table('buku_catatan_keluargas as b')
    ->join('dasawismas as d', 'b.id_dasawisma', '=', 'd.id')
    ->leftJoin('dusuns as du', 'd.dusun_id', '=', 'du.id')
    ->leftJoin('desas as de', 'd.desa_id', '=', 'de.id')
    ->leftJoin('rumahs as do', 'b.rumah_id', '=', 'do.id')
    ->leftJoin('kecamatans as ke', 'd.kecamatan_id', '=', 'ke.id')
    ->select(
        'b.*',
        'do.nama_rumah',
        'd.nama_dasawisma',
        'du.nama_dusun',
        'de.nama_desa',
        'ke.nama_kecamatan'
    );
    // ->where('b.rumah_id', $id);

    // FILTER
    if ($request->rumah_id) {
        $query->where('rumah_id', $request->rumah_id);
    }

    // if ($request->jamban_keluarga) {
    //     $query->where('jamban_keluarga', $request->jamban_keluarga);
    // }

    // if ($request->sumber_air) {
    //     $query->where('sumber_air', $request->sumber_air);
    // }

    // if ($request->tempat_sampah) {
    //     $query->where('tempat_sampah', $request->tempat_sampah);
    // }

    $data = $query->get();

    $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('buku.dasawisma.pdf_rumah', compact('data'))
        ->setPaper('A4','landscape');

    return $pdf->stream();
}
public function cetakPdf(Request $request, $id)
{
    $query = DB::table('buku_catatan_keluargas as b')
    ->join('dasawismas as d', 'b.id_dasawisma', '=', 'd.id')
    ->leftJoin('dusuns as du', 'd.dusun_id', '=', 'du.id')
    ->leftJoin('desas as de', 'd.desa_id', '=', 'de.id')
    ->leftJoin('rumahs as do', 'b.rumah_id', '=', 'do.id')
    ->leftJoin('kecamatans as ke', 'd.kecamatan_id', '=', 'ke.id')
    ->select(
        'b.*',
        'do.nama_rumah',
        'd.nama_dasawisma',
        'du.nama_dusun',
        'de.nama_desa',
        'ke.nama_kecamatan'
    )
    ->where('b.id_dasawisma', $id);

    // FILTER
    if ($request->kriteria_rumah) {
        $query->where('kriteria_rumah', $request->kriteria_rumah);
    }

    if ($request->jamban_keluarga) {
        $query->where('jamban_keluarga', $request->jamban_keluarga);
    }

    if ($request->sumber_air) {
        $query->where('sumber_air', $request->sumber_air);
    }

    if ($request->tempat_sampah) {
        $query->where('tempat_sampah', $request->tempat_sampah);
    }

    $data = $query->get();

    $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('buku.dasawisma.pdf', compact('data'))
        ->setPaper('A4','landscape');

    return $pdf->stream();
}
    // 🔹 LIST DATA
    public function index(Request $request,$id)
    {
       $data = DB::table('buku_catatan_keluargas')
    ->join('dasawismas', 'buku_catatan_keluargas.id_dasawisma', '=', 'dasawismas.id')
    ->leftJoin('dusuns', 'dasawismas.dusun_id', '=', 'dusuns.id')
    ->leftJoin('desas', 'dasawismas.desa_id', '=', 'desas.id')
    ->leftJoin('rumahs', 'buku_catatan_keluargas.rumah_id', '=', 'rumahs.id')
    ->leftJoin('kecamatans', 'dasawismas.kecamatan_id', '=', 'kecamatans.id')

    ->when(request('search'), function($q){
        $q->where('buku_catatan_keluargas.nama_anggota_keluarga', 'like', '%'.request('search').'%');
    })
    ->when(request('kriteria_rumah'), function($q){
        $q->where('buku_catatan_keluargas.rumah_id', request('kriteria_rumah'));
    })

    ->select(
        'buku_catatan_keluargas.*',
        'dasawismas.nama_dasawisma',
        'dusuns.nama_dusun',
        'desas.nama_desa',
        'kecamatans.nama_kecamatan',
        'rumahs.nama_rumah'
    )
    ->where('buku_catatan_keluargas.id_dasawisma',$id)
    ->latest()
    ->get();

            $data_dasa=db::table('dasawismas')->where('id',$id)->first();
 
      $data_rumah=DB::table('rumahs')->get();
        return view('buku.dasawisma.index', compact('data','data_dasa','data_rumah'));
    }

    // 🔹 FORM TAMBAH
    public function create($id)
    {
              $data_rumah=DB::table('rumahs')->get();

        $dasawisma = DB::table('dasawismas')->where('id',$id)->first();
        return view('buku.dasawisma.create', compact('dasawisma','data_rumah'));
    }

    // 🔹 SIMPAN DATA
    public function store(Request $request)
    {
        $request->validate([
            'id_dasawisma' => 'required|exists:dasawismas,id',
            'nama_anggota_keluarga' => 'required|string|max:255',
            'jenis_kelamin' => 'required',
            'status_perkawinan' => 'nullable',
            'tempat_lahir' => 'nullable',
            'tgl_lahir' => 'nullable|date',
        ]);

        DB::table('buku_catatan_keluargas')->insert([
            'id_dasawisma' => $request->id_dasawisma,
            'nama_anggota_keluarga' => $request->nama_anggota_keluarga,
            'jenis_kelamin' => $request->jenis_kelamin,
            'status_perkawinan' => $request->status_perkawinan,
            'tempat_lahir' => $request->tempat_lahir,
            'tgl_lahir' => $request->tgl_lahir,
            'rumah_id' => $request->rumah_id,
            'agama' => $request->agama,
            'pendidikan' => $request->pendidikan,
            'pekerjaan' => $request->pekerjaan,
            'berkebutuhan_khusus' => $request->berkebutuhan_khusus ?? 0,
            'pancasila' => $request->pancasila ?? 0,
            'goro' => $request->goro ?? 0,
            'pendidikan_keterampilan' => $request->pendidikan_keterampilan ?? 0,
            'penghidupan_berkoperasi' => $request->penghidupan_berkoperasi ?? 0,
            'pangan' => $request->pangan ?? 0,
            'sandang' => $request->sandang ?? 0,
            'kesehatan' => $request->kesehatan ?? 0,
            'perencanaan_sehat' => $request->perencanaan_sehat ?? 0,
            'kriteria_rumah' => $request->kriteria_rumah,
            'jamban_keluarga' => $request->jamban_keluarga,
            'sumber_air' => $request->sumber_air,
            'tempat_sampah' => $request->tempat_sampah,
            'ket' => $request->ket,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Alert::success('Berhasil', 'Data berhasil disimpan');
        return redirect('dasawisma');
    }

    // 🔹 FORM EDIT
    public function edit($id)
    {
        $data = DB::table('buku_catatan_keluargas')->where('id', $id)->first();
        $dasawisma = DB::table('dasawismas')->get();
                      $data_rumah=DB::table('rumahs')->get();


        return view('buku.dasawisma.edit', compact('data', 'dasawisma','data_rumah'));
    }

    // 🔹 UPDATE
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_anggota_keluarga' => 'required|string|max:255',
            'jenis_kelamin' => 'required',
        ]);

        DB::table('buku_catatan_keluargas')->where('id', $id)->update([
            'nama_anggota_keluarga' => $request->nama_anggota_keluarga,
            'jenis_kelamin' => $request->jenis_kelamin,
            'status_perkawinan' => $request->status_perkawinan,
            'tempat_lahir' => $request->tempat_lahir,
            'tgl_lahir' => $request->tgl_lahir,
            'agama' => $request->agama,
                        'rumah_id' => $request->rumah_id,

            'pendidikan' => $request->pendidikan,
            'pekerjaan' => $request->pekerjaan,
            'berkebutuhan_khusus' => $request->berkebutuhan_khusus ?? 0,
            'pancasila' => $request->pancasila ?? 0,
            'goro' => $request->goro ?? 0,
            'pendidikan_keterampilan' => $request->pendidikan_keterampilan ?? 0,
            'penghidupan_berkoperasi' => $request->penghidupan_berkoperasi ?? 0,
            'pangan' => $request->pangan ?? 0,
            'sandang' => $request->sandang ?? 0,
            'kesehatan' => $request->kesehatan ?? 0,
            'perencanaan_sehat' => $request->perencanaan_sehat ?? 0,
            'kriteria_rumah' => $request->kriteria_rumah,
            'jamban_keluarga' => $request->jamban_keluarga,
            'sumber_air' => $request->sumber_air,
            'tempat_sampah' => $request->tempat_sampah,
            'ket' => $request->ket,
            'updated_at' => now(),
        ]);

        Alert::success('Berhasil', 'Data berhasil diupdate');
        return redirect('dasawisma');
    }

    // 🔹 DELETE
    public function destroy($id)
    {
        DB::table('buku_catatan_keluargas')->where('id', $id)->delete();

        Alert::success('Berhasil', 'Data berhasil dihapus');
        return back();
    }
}