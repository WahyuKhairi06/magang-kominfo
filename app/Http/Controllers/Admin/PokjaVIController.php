<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Barryvdh\DomPDF\Facade\Pdf;

class PokjaVIController extends Controller
{
    //


  public function cetak(Request $request)
{

if (!$request->tahun) {
    Alert::error('Oops', 'Tahun wajib dipilih');
    return back();
}

if($request->tahun=='2025'){
    $dusun = DB::table('dusuns')->get();
    $desa = DB::table('desas')->get();
    $kecamatan = DB::table('kecamatans')->get();

    $query = DB::table('dasawisma2025s')
        ->leftJoin('dasawismas','dasawisma2025s.dasawisma_id','=','dasawismas.id')
        ->leftJoin('dusuns', 'dasawismas.dusun_id', '=', 'dusuns.id')
        ->leftJoin('desas', 'dasawismas.desa_id', '=', 'desas.id')
        ->leftJoin('kecamatans', 'dasawismas.kecamatan_id', '=', 'kecamatans.id')
        ->select(
            'dasawisma2025s.*',
            'dasawismas.nama_dasawisma',
            'dusuns.nama_dusun',
            'desas.nama_desa',
            'kecamatans.nama_kecamatan'
        );

    // 🔥 FILTER (optional)
    if ($request->kecamatan_id) {
        $query->where('kecamatans.id', $request->kecamatan_id);
    }

    if ($request->desa_id) {
        $query->where('desas.id', $request->desa_id);
    }

    if ($request->dusun_id) {
        $query->where('dusuns.id', $request->dusun_id);
    }

    $data = $query->get();


    $pdf = Pdf::loadView('admin.dasawisma.laporan_pdf', compact('data'))
        ->setPaper('A4', 'landscape'); // biar muat banyak kolom

    return $pdf->stream('laporan-phbs.pdf');
}else{
    
    $dusun = DB::table('dusuns')->get();
    $desa = DB::table('desas')->get();
    $kecamatan = DB::table('kecamatans')->get();

    $query = DB::table('dasawisma2026s')
        ->leftJoin('dasawismas','dasawisma2026s.dasawisma_id','=','dasawismas.id')
        ->leftJoin('dusuns', 'dasawismas.dusun_id', '=', 'dusuns.id')
        ->leftJoin('desas', 'dasawismas.desa_id', '=', 'desas.id')
        ->leftJoin('kecamatans', 'dasawismas.kecamatan_id', '=', 'kecamatans.id')
        ->select(
            'dasawisma2026s.*',
            'dasawismas.nama_dasawisma',
            'dusuns.nama_dusun',
            'desas.nama_desa',
            'kecamatans.nama_kecamatan'
        );

    // 🔥 FILTER (optional)
    if ($request->kecamatan_id) {
        $query->where('kecamatans.id', $request->kecamatan_id);
    }

    if ($request->desa_id) {
        $query->where('desas.id', $request->desa_id);
    }

    if ($request->dusun_id) {
        $query->where('dusuns.id', $request->dusun_id);
    }

    $data = $query->get();


    $pdf = Pdf::loadView('admin.dasawisma.laporan2026', compact('data'))
        ->setPaper('A4', 'landscape'); // biar muat banyak kolom

    return $pdf->stream('laporan-phbs.pdf');
}
        }
    public function simpan(Request $request, $id)
{
    $tahun = "2026";

    $request->validate([
        'tbc' => 'nullable|integer|min:0',
        'jamban_sehat' => 'nullable|integer|min:0',
        'bak_penampungan_air' => 'nullable|integer|min:0',
        'penyakit_diare' => 'nullable|integer|min:0',
        'keluarga_sadar_gizi' => 'nullable|integer|min:0',
        'rumah_tanpa_asap_rokok' => 'nullable|integer|min:0',
        'bab_sembarangan' => 'nullable|integer|min:0',
        'b3_dapat_mbg' => 'nullable|integer|min:0',
        'sampah_terpilah' => 'nullable|integer|min:0',
        'spal' => 'nullable|integer|min:0',
    ]);

    DB::table('dasawisma2026s')->updateOrInsert(
        [
            'dasawisma_id' => $id,
            'tahun' => $tahun
        ],
        [
            'tbc' => $request->tbc ?? 0,
            'jamban_sehat' => $request->jamban_sehat ?? 0,
            'bak_penampungan_air' => $request->bak_penampungan_air ?? 0,
            'penyakit_diare' => $request->penyakit_diare ?? 0,
            'keluarga_sadar_gizi' => $request->keluarga_sadar_gizi ?? 0,
            'rumah_tanpa_asap_rokok' => $request->rumah_tanpa_asap_rokok ?? 0,
            'bab_sembarangan' => $request->bab_sembarangan ?? 0,
            'b3_dapat_mbg' => $request->b3_dapat_mbg ?? 0,
            'sampah_terpilah' => $request->sampah_terpilah ?? 0,
            'spal' => $request->spal ?? 0,

            'persalinan_ditolong_difaskes' => $request->persalinan_ditolong_difaskes ?? 0,
            'asi_ekslusif' => $request->asi_ekslusif ?? 0,
            'timbang_balita' => $request->timbang_balita ?? 0,
            'berantas_jentik' => $request->berantas_jentik ?? 0,

            'makan_buah_sayur' => $request->makan_buah_sayur ?? 0,

            'balita_stunting' => $request->balita_stunting ?? 0,
            'kb_aktif' => $request->kb_aktif ?? 0,

            'penghasilan_tetap' => $request->penghasilan_tetap ?? 0,

            'ket' => $request->ket,
            'updated_at' => now(),
            'created_at' => now()
        ]
    );

    Alert::success('Berhasil', 'Data berhasil disimpan');

    return redirect()->back();
}
}
