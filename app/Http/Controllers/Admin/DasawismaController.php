<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class DasawismaController extends Controller
{
    public function index()
    {
        $data = DB::table('dasawismas')
            ->leftJoin('dusuns', 'dasawismas.dusun_id', '=', 'dusuns.id')
            ->leftJoin('desas', 'dasawismas.desa_id', '=', 'desas.id')
            ->leftJoin('kecamatans', 'dasawismas.kecamatan_id', '=', 'kecamatans.id')
            ->select(
                'dasawismas.*',
                'dusuns.nama_dusun',
                'desas.nama_desa',
                'kecamatans.nama_kecamatan'
            )
            ->orderBy('dasawismas.id','desc')
            ->get();

             $dusun = DB::table('dusuns')->get();
        $desa = DB::table('desas')->get();
        $kecamatan = DB::table('kecamatans')->get();
        return view('admin.dasawisma.index', compact('data','dusun','desa','kecamatan'));
    }

    public function buku()
    {
        $data = DB::table('dasawismas')
            ->leftJoin('dusuns', 'dasawismas.dusun_id', '=', 'dusuns.id')
            ->leftJoin('desas', 'dasawismas.desa_id', '=', 'desas.id')
            ->leftJoin('kecamatans', 'dasawismas.kecamatan_id', '=', 'kecamatans.id')
            ->select(
                'dasawismas.*',
                'dusuns.nama_dusun',
                'desas.nama_desa',
                'kecamatans.nama_kecamatan'
            )
->orderByRaw("SUBSTRING_INDEX(dasawismas.nama_dasawisma, ' ', 1) ASC")
->orderByRaw("CAST(SUBSTRING_INDEX(dasawismas.nama_dasawisma, ' ', -1) AS UNSIGNED) ASC")            ->get();

             $dusun = DB::table('dusuns')->get();
        $desa = DB::table('desas')->get();
        $kecamatan = DB::table('kecamatans')->get();

        return view('admin.dasawisma.bukukelompok', compact('data','dusun','desa','kecamatan'));
    }

    public function create()
    {
        $dusun = DB::table('dusuns')->get();
        $desa = DB::table('desas')->get();
        $kecamatan = DB::table('kecamatans')->get();
        $pokja = DB::table('pokjas')->get();

        return view('admin.dasawisma.create', compact('dusun','desa','kecamatan','pokja'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_dasawisma' => 'required',
            'dusun_id' => 'required',
            'desa_id' => 'required',
            'kecamatan_id' => 'required',
            'tahun' => 'required'
        ]);

        DB::table('dasawismas')->insert([
            'nama_dasawisma' => $request->nama_dasawisma,
            'dusun_id' => $request->dusun_id,
            'desa_id' => $request->desa_id,
            'kecamatan_id' => $request->kecamatan_id,
            'pokja_id' => $request->pokja_id,
            'tahun' => $request->tahun,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Alert::success('Berhasil','Data ditambahkan');
        return redirect()->route('dasawisma.index');
    }

    public function edit($id)
    {
        $item = DB::table('dasawismas')->where('id',$id)->first();
        $dusun = DB::table('dusuns')->get();
        $desa = DB::table('desas')->get();
        $kecamatan = DB::table('kecamatans')->get();

        return view('admin.dasawisma.edit', compact('item','dusun','desa','kecamatan'));
    }

    public function update(Request $request, $id)
    {
        DB::table('dasawismas')->where('id',$id)->update([
            'nama_dasawisma' => $request->nama_dasawisma,
            'dusun_id' => $request->dusun_id,
            'desa_id' => $request->desa_id,
            'kecamatan_id' => $request->kecamatan_id,
            'pokja_id' => $request->pokja_id,
            'tahun' => $request->tahun,
            'updated_at' => now(),
        ]);

        Alert::success('Berhasil','Data diupdate');
        return redirect()->route('dasawisma.index');
    }

   public function destroy($id)
{
    // 🔍 cek apakah dipakai di tabel kuisioner
    $dipakai = DB::table('dasawisma2025s')
        ->where('dasawisma_id', $id)
        ->exists();

    if ($dipakai) {
        Alert::error('Gagal', 'Data tidak bisa dihapus karena sudah digunakan di kuisioner');
        return back();
    }

    // kalau aman → hapus
    DB::table('dasawismas')->where('id', $id)->delete();

    Alert::success('Berhasil', 'Data berhasil dihapus');
    return back();
}
    public function kuisioner($id, $tahun)
{
    if($tahun=="2025"){
    $data = DB::table('dasawisma2025s')
     ->leftjoin('dasawismas','dasawisma2025s.dasawisma_id','dasawismas.id')
     ->select('dasawisma2025s.*','dasawismas.nama_dasawisma')
        ->where('dasawisma_id', $id)
        ->where('dasawisma2025s.tahun', $tahun)
        ->first();
        $cek_id=DB::table('dasawismas')->where('id',$id)->first();

    return view('admin.dasawisma.kuisioner', compact('data','id','tahun','cek_id'));
    }else{
          $data = DB::table('dasawisma2026s')
     ->leftjoin('dasawismas','dasawisma2026s.dasawisma_id','dasawismas.id')
     ->select('dasawisma2026s.*','dasawismas.nama_dasawisma')
        ->where('dasawisma_id', $id)
        ->where('dasawisma2026s.tahun', $tahun)
        ->first();
        $cek_id=DB::table('dasawismas')->where('id',$id)->first();

    return view('admin.dasawisma.kuisioner2026', compact('data','id','tahun','cek_id'));
    }
}
public function simpanKuisioner(Request $request, $id)
{
    

    $tahun = '2025';

    DB::table('dasawisma2025s')->updateOrInsert(
        [
            'dasawisma_id' => $id,
            'tahun' => $tahun
        ],
        [
            'protokol_kesehatan' => $request->protokol_kesehatan ?? 0,
            'jamban_sehat' => $request->jamban_sehat ?? 0,
            'bak_penampungan_air' => $request->bak_penampungan_air ?? 0,
            'penurunan_penyakit_diare' => $request->penurunan_penyakit_diare ?? 0,
            'keluarga_sadar_gizi' => $request->keluarga_sadar_gizi ?? 0,
            'rumah_tanpa_asap_rokok' => $request->rumah_tanpa_asap_rokok ?? 0,
            'bab_sembarangan' => $request->bab_sembarangan ?? 0,
            'memiliki_bak_sampah' => $request->memiliki_bak_sampah ?? 0,
            'spal' => $request->spal ?? 0,

            'persalinan_di_faskes' => $request->persalinan_di_faskes ?? 0,
            'asi_ekslusif' => $request->asi_ekslusif ?? 0,
            'timbang_balita' => $request->timbang_balita ?? 0,
            'berantas_jentik' => $request->berantas_jentik ?? 0,

            'makan_buah_dan_sayur' => $request->makan_buah_dan_sayur ?? 0,
            'aktivitas_fisik' => $request->aktivitas_fisik ?? 0,

            'balita_stunting' => $request->balita_stunting ?? 0,
            'kb' => $request->kb ?? 0,

            'berpenghasilan_tetap' => $request->berpenghasilan_tetap ?? 0,
            'tbc' => $request->tbc ?? 0,
            'mbg' => $request->mbg ?? 0,
            'sampah_terpilah' => $request->sampah_terpilah ?? 0,
            'ckg' => $request->ckg ?? 0,

            'ket' => $request->ket,
            'updated_at' => now(),
            'created_at' => now()
        ]
    );

    Alert::success('Berhasil', 'Data kuisioner berhasil disimpan');

    return redirect('dasawisma');
}
}