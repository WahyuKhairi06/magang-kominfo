<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class KurvaController extends Controller

{
    //

    public function kurva1(Request $request)
    {
    //       $id_dusun = $request->id_dusun;
    // $kategori = $request->kategori;

    // $query = DB::table('kegiatan_pokja1s');

    // // FILTER DUSUN (OPSIONAL)
    // if ($id_dusun) {
    //     $query->where('id_dusun', $id_dusun);
    // }

    // $data = $query->orderBy('id','asc')->get();

    // $dusuns = DB::table('dusuns')->get();
    //      $kategoris_halaman=DB::table('kategori_halamen')->get();

    //     return view('kurva1',compact('data','dusuns','id_dusun','kategori','kategoris_halaman'));

   $id_dusun = $request->id_dusun;

    $query = DB::table('kegiatan_pokja1s');

    if ($id_dusun) {
        $query->where('id_dusun', $id_dusun);
    }

    $data = $query->orderBy('id','asc')->get();
    $dusuns = DB::table('dusuns')->get();

    // TOTAL SEMUA FIELD
    $total = $data->sum('kader_pkbn')
        + $data->sum('kader_pkdrt')
        + $data->sum('kader_pola_asuh')
        + $data->sum('pkbn_anggota')
        + $data->sum('pkdrt_anggota')
        + $data->sum('pola_asuh_anggota')
        + $data->sum('lansia_anggota')
        + $data->sum('kerja_bakti')
        + $data->sum('rukun_kematian')
        + $data->sum('keagamaan')
        + $data->sum('jimpitan')
        + $data->sum('arisan');
$kategoris_halaman=DB::table('kategori_halamen')->get();


 $data_tabel = DB::table('kegiatan_pokja1s')
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
    ->where('kegiatan_pokja1s.id_desa',2)
    ->orderBy('dusuns.nama_dusun')
    ->distinct()
    ->get();
    return view('kurva1', compact(
        'data',
        'dusuns',
        'id_dusun',
        'total',
       'data_tabel',
        'kategoris_halaman'
    ));
    }

    public function kurva2(Request $request)
{
    $id_dusun = $request->id_dusun;
    $tahun    = $request->tahun;

    $query = DB::table('kegiatan_pokja2s as k')
        ->leftJoin('dusuns as d', 'k.id_dusun', '=', 'd.id')
        ->leftJoin('umum_kegiatanpkks as u', function ($join) {
            $join->on('k.id_dusun', '=', 'u.dusun_id')
                 ->where('u.pokja_id', 2); // penting! biar sesuai pokja2
        })
        ->leftJoin('desas as ds', 'u.desa_id', '=', 'ds.id')
        ->leftJoin('kecamatans as kc', 'u.kecamatan_id', '=', 'kc.id')
        ->select(
            'k.*',
            'd.nama_dusun',
            'ds.nama_desa',
            'kc.nama_kecamatan',
            'u.tahun'
        );

    // FILTER DUSUN
    if ($id_dusun) {
        $query->where('k.id_dusun', $id_dusun);
    }

    // FILTER TAHUN
    if ($tahun) {
        $query->where('u.tahun', $tahun);
    }

    $data = $query
        ->orderBy('u.tahun', 'desc')
        ->get();

    // ambil list filter
    $dusuns = DB::table('dusuns')->get();
    $tahuns = DB::table('umum_kegiatanpkks')
        ->select('tahun')
        ->distinct()
        ->orderBy('tahun','desc')
        ->get();


        $data_tabel = DB::table('kegiatan_pokja2s as k')
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
        ->distinct()
        ->where('k.id_desa','=',2)
        ->get();
$kategoris_halaman=DB::table('kategori_halamen')->get();
    return view('kurva2', compact(
        'data',
        'dusuns',
        'tahuns',
        'id_dusun',
        'tahun',
        'kategoris_halaman',
        'data_tabel'
    ));
}

public function kurva3(Request $request)
{
    $id_dusun = $request->id_dusun;
    $tahun    = $request->tahun;

    $query = DB::table('kegiatan_pokja3reals as k')
        ->leftJoin('dusuns as d', 'k.id_dusun', '=', 'd.id')
        ->leftJoin('umum_kegiatanpkks as u', function ($join) {
            $join->on('k.id_dusun', '=', 'u.dusun_id')
                 ->where('u.pokja_id', 3);
        })
        ->select(
            'k.*',
            'd.nama_dusun',
            'u.tahun'
        );

    if ($id_dusun) {
        $query->where('k.id_dusun', $id_dusun);
    }

    if ($tahun) {
        $query->where('u.tahun', $tahun);
    }

    $data = $query->orderBy('u.tahun','asc')->get();


    $data_tabel = DB::table('kegiatan_pokja3reals as k')
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
        ->where('k.id_desa',2)
        ->get();
    // 🔥 TOTAL SEMUA FIELD
    $total = [
        'kader_pangan' => $data->sum('kader_pangan'),
        'kader_sandang' => $data->sum('kader_sandang'),
        'kader_tata_laksana_rumah_tangga' => $data->sum('kader_tata_laksana_rumah_tangga'),

        'pangan_beras' => $data->sum('pangan_beras'),
        'pangan_non_beras' => $data->sum('pangan_non_beras'),

        'peternakan' => $data->sum('peternakan'),
        'perikanan' => $data->sum('perikanan'),
        'warung_hidup' => $data->sum('warung_hidup'),
        'lumbung_hidup' => $data->sum('lumbung_hidup'),
        'toga' => $data->sum('toga'),
        'tanaman_keras' => $data->sum('tanaman_keras'),

        'industri_pangan' => $data->sum('industri_pangan'),
        'industri_sandang' => $data->sum('industri_sandang'),
        'industri_jasa' => $data->sum('industri_jasa'),

        'rumah_sehat_layak' => $data->sum('rumah_sehat_layak'),
        'rumah_tidak_sehat_tidak_layak' => $data->sum('rumah_tidak_sehat_tidak_layak'),
    ];

    $dusuns = DB::table('dusuns')->get();
    $tahuns = DB::table('umum_kegiatanpkks')
        ->select('tahun')->distinct()->orderBy('tahun','desc')->get();
$kategoris_halaman=DB::table('kategori_halamen')->get();

    return view('kurva3', compact(
        'data','total','dusuns','tahuns','id_dusun','tahun','kategoris_halaman','data_tabel'
    ));
}
public function kurva4(Request $request)
{
     $id_dusun = $request->id_dusun;
    $tahun    = $request->tahun;
    $kategori = $request->kategori;

    $query = DB::table('kegiatan_pokja3s as k')
        ->leftJoin('dusuns as d', 'k.id_dusun', '=', 'd.id')
        ->leftJoin('umum_kegiatanpkks as u', function ($join) {
            $join->on('k.id_dusun', '=', 'u.dusun_id')
                 ->where('u.pokja_id', 3);
        })
        ->select(
            'k.*',
            'd.nama_dusun',
            'u.tahun'
        );

    if ($id_dusun) {
        $query->where('k.id_dusun', $id_dusun);
    }

    if ($tahun) {
        $query->where('u.tahun', $tahun);
    }

    $data = $query->orderBy('u.tahun','asc')->get();

$data_tabel = DB::table('kegiatan_pokja3s as k')
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
    ->where('k.id_desa',2)
    ->get();

    $dusuns = DB::table('dusuns')->get();

    $tahuns = DB::table('umum_kegiatanpkks')
        ->where('pokja_id', 3)
        ->select('tahun')
        ->distinct()
        ->orderBy('tahun','desc')
        ->get();

    // return view('kurva3', compact(
    //     'data','dusuns','tahuns','id_dusun','tahun','kategori'
    // ));
$kategoris_halaman=DB::table('kategori_halamen')->get();

    return view('kurva4', compact(
        'data',
        'dusuns',
        'tahuns',
        'id_dusun',
        'tahun',
        'kategoris_halaman',
        'kategori',
        'data_tabel'
    ));
}


public function inovasipokja4(Request $r)
{
    $tahun = $r->tahun ?? 2025;
    $dasawisma = $r->dasawisma_id;

    // =========================================
    // PILIH TABEL
    // =========================================
    if ($tahun == 2025) {

        $table = 'dasawisma2025s';

        $stuntingField = 'balita_stunting';

        // FIELD KHUSUS 2025
        $tbcField = 'protokol_kesehatan';
        $mbgField = 'berpenghasilan_tetap';
        $ckgField = 'aktivitas_fisik';
        $sampahField = 'memiliki_bak_sampah';

    } else {

        $table = 'dasawisma2026s';

        $stuntingField = 'balita_stunting';

        // FIELD KHUSUS 2026
        $tbcField = 'tbc';
        $mbgField = 'b3_dapat_mbg';
        $ckgField = 'penghasilan_tetap';
        $sampahField = 'sampah_terpilah';
    }

    // =========================================
    // DATA UTAMA
    // =========================================
    $data = DB::table($table)
        ->leftJoin(
            'dasawismas',
            'dasawismas.id',
            '=',
            $table . '.dasawisma_id'
        )
        ->select(
            $table . '.*',
            'dasawismas.nama_dasawisma'
        )
        ->when($dasawisma, function ($q) use ($dasawisma, $table) {

            return $q->where(
                $table . '.dasawisma_id',
                $dasawisma
            );
        })
        ->get();

    // =========================================
    // RANKING STUNTING
    // =========================================
    $ranking = DB::table($table)
        ->leftJoin(
            'dasawismas',
            'dasawismas.id',
            '=',
            $table . '.dasawisma_id'
        )
        ->select(
            'dasawismas.nama_dasawisma',
            $stuntingField
        )
        ->orderByDesc($stuntingField)
        ->get();

    // =========================================
    // FILTER DASAWISMA
    // =========================================
    $dasawismas = DB::table('dasawismas')
        ->when($tahun, function ($q) use ($tahun) {

            return $q->where('tahun', $tahun);
        })
        ->get();

    // =========================================
    // KATEGORI HALAMAN
    // =========================================
    $kategoris_halaman = DB::table('kategori_halamen')->get();

    // =========================================
    // TBC TERTINGGI
    // =========================================
    $tbcTertinggi = DB::table($table)
        ->leftJoin(
            'dasawismas',
            'dasawismas.id',
            '=',
            $table . '.dasawisma_id'
        )
        ->select(
            'dasawismas.nama_dasawisma',
            $tbcField
        )
        ->orderByDesc($tbcField)
        ->first();

    // =========================================
    // MBG TERENDAH
    // =========================================
    $mbgTerendah = DB::table($table)
        ->leftJoin(
            'dasawismas',
            'dasawismas.id',
            '=',
            $table . '.dasawisma_id'
        )
        ->select(
            'dasawismas.nama_dasawisma',
            $mbgField
        )
        ->orderBy($mbgField)
        ->first();

    // =========================================
    // CKG TERENDAH
    // =========================================
    $ckgTerendah = DB::table($table)
        ->leftJoin(
            'dasawismas',
            'dasawismas.id',
            '=',
            $table . '.dasawisma_id'
        )
        ->select(
            'dasawismas.nama_dasawisma',
            $ckgField
        )
        ->orderBy($ckgField)
        ->first();

    // =========================================
    // SAMPAH TERENDAH
    // =========================================
    $sampahTerendah = DB::table($table)
        ->leftJoin(
            'dasawismas',
            'dasawismas.id',
            '=',
            $table . '.dasawisma_id'
        )
        ->select(
            'dasawismas.nama_dasawisma',
            $sampahField
        )
        ->orderBy($sampahField)
        ->first();

    // =========================================
    // LIST GRAFIK DINAMIS
    // =========================================
    if ($tahun == 2025) {

        $chartFields = [

            [
                'field' => 'protokol_kesehatan',
                'label' => 'Protokol Kesehatan',
                'color' => '#3b82f6'
            ],

            [
                'field' => 'jamban_sehat',
                'label' => 'Jamban Sehat',
                'color' => '#10b981'
            ],

            [
                'field' => 'bak_penampungan_air',
                'label' => 'Bak Penampungan Air',
                'color' => '#f59e0b'
            ],

            [
                'field' => 'penurunan_penyakit_diare',
                'label' => 'Penurunan Penyakit Diare',
                'color' => '#ef4444'
            ],

            [
                'field' => 'keluarga_sadar_gizi',
                'label' => 'Keluarga Sadar Gizi',
                'color' => '#8b5cf6'
            ],

            [
                'field' => 'rumah_tanpa_asap_rokok',
                'label' => 'Rumah Tanpa Asap Rokok',
                'color' => '#14b8a6'
            ],

            [
                'field' => 'bab_sembarangan',
                'label' => 'BAB Sembarangan',
                'color' => '#ec4899'
            ],

            [
                'field' => 'memiliki_bak_sampah',
                'label' => 'Memiliki Bak Sampah',
                'color' => '#22c55e'
            ],

            [
                'field' => 'spal',
                'label' => 'SPAL',
                'color' => '#6366f1'
            ],

            [
                'field' => 'persalinan_di_faskes',
                'label' => 'Persalinan di Faskes',
                'color' => '#0ea5e9'
            ],

            [
                'field' => 'asi_ekslusif',
                'label' => 'ASI Eksklusif',
                'color' => '#84cc16'
            ],

            [
                'field' => 'timbang_balita',
                'label' => 'Timbang Balita',
                'color' => '#f97316'
            ],

            [
                'field' => 'berantas_jentik',
                'label' => 'Berantas Jentik',
                'color' => '#06b6d4'
            ],

            [
                'field' => 'makan_buah_dan_sayur',
                'label' => 'Makan Buah dan Sayur',
                'color' => '#a855f7'
            ],

            [
                'field' => 'aktivitas_fisik',
                'label' => 'Aktivitas Fisik',
                'color' => '#eab308'
            ],

            [
                'field' => 'balita_stunting',
                'label' => 'Balita Stunting',
                'color' => '#dc2626'
            ],

            [
                'field' => 'kb',
                'label' => 'KB',
                'color' => '#16a34a'
            ],

            [
                'field' => 'berpenghasilan_tetap',
                'label' => 'Berpenghasilan Tetap',
                'color' => '#0f766e'
            ],

        ];

    } else {

        $chartFields = [

            [
                'field' => 'tbc',
                'label' => 'TBC',
                'color' => '#ef4444'
            ],

            [
                'field' => 'jamban_sehat',
                'label' => 'Jamban Sehat',
                'color' => '#22c55e'
            ],

            [
                'field' => 'bak_penampungan_air',
                'label' => 'Bak Penampungan Air',
                'color' => '#3b82f6'
            ],

            [
                'field' => 'penyakit_diare',
                'label' => 'Penyakit Diare',
                'color' => '#f97316'
            ],

            [
                'field' => 'keluarga_sadar_gizi',
                'label' => 'Keluarga Sadar Gizi',
                'color' => '#8b5cf6'
            ],

            [
                'field' => 'rumah_tanpa_asap_rokok',
                'label' => 'Rumah Tanpa Asap Rokok',
                'color' => '#06b6d4'
            ],

            [
                'field' => 'bab_sembarangan',
                'label' => 'BAB Sembarangan',
                'color' => '#ec4899'
            ],

            [
                'field' => 'b3_dapat_mbg',
                'label' => 'B3 Dapat MBG',
                'color' => '#facc15'
            ],

            [
                'field' => 'sampah_terpilah',
                'label' => 'Sampah Terpilah',
                'color' => '#14b8a6'
            ],

            [
                'field' => 'spal',
                'label' => 'SPAL',
                'color' => '#6366f1'
            ],

            [
                'field' => 'persalinan_ditolong_difaskes',
                'label' => 'Persalinan Ditolong Difaskes',
                'color' => '#0ea5e9'
            ],

            [
                'field' => 'asi_ekslusif',
                'label' => 'ASI Eksklusif',
                'color' => '#84cc16'
            ],

            [
                'field' => 'timbang_balita',
                'label' => 'Timbang Balita',
                'color' => '#f97316'
            ],

            [
                'field' => 'berantas_jentik',
                'label' => 'Berantas Jentik',
                'color' => '#06b6d4'
            ],

            [
                'field' => 'makan_buah_sayur',
                'label' => 'Makan Buah Sayur',
                'color' => '#a855f7'
            ],

            [
                'field' => 'balita_stunting',
                'label' => 'Balita Stunting',
                'color' => '#dc2626'
            ],

            [
                'field' => 'kb_aktif',
                'label' => 'KB Aktif',
                'color' => '#16a34a'
            ],

            [
                'field' => 'penghasilan_tetap',
                'label' => 'Penghasilan Tetap',
                'color' => '#0f766e'
            ],

        ];
    }

    return view('inovasipokja4', compact(
        'dasawismas',
        'data',
        'ranking',
        'tahun',
        'kategoris_halaman',
        'tbcTertinggi',
        'mbgTerendah',
        'ckgTerendah',
        'sampahTerendah',
        'chartFields'
    ));
}

public function cekapi()
{
    $response = Http::withHeaders([
        'X-SECRET-CODE' => '390V-kominfo'
    ])->get(
        'https://splp.pariamankota.go.id/api/nip/bappeda'
    );

    $data = $response->json();

    dd($data);
}
}
