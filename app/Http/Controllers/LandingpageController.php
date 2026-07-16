<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\STR;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\Faq;
class LandingpageController extends Controller
{
    public function faq()
{
    $faqs = DB::table('faqs')->get();
    $kategoris_halaman = DB::table('kategori_halamen')->get();

    return view('faq', compact('faqs','kategoris_halaman'));
}

    public function pengaduan()
{
    $kategoris_halaman = DB::table('kategori_halamen')->get();

    return view('pengaduan', compact('kategoris_halaman'));
}

public function pengaduanStore(Request $request)
{
    $request->validate([
        'nama' => 'required',
        'no_hp' => 'required',
        'isi_pengaduan' => 'required',
    ]);

    $id = DB::table('pengaduans')->insertGetId([
        'nama' => $request->nama,
        'no_hp' => $request->no_hp,
        'isi_pengaduan' => $request->isi_pengaduan,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    \App\Jobs\ClassifyPengaduanJob::dispatch($id);

    return back()->with('success', 'Pengaduan berhasil dikirim');
}
    
    public function detail($id)
    {
    $inovasi = DB::table('inovasi1')
                ->where('id_inovasi', $id)
                ->first();
    $kategoris_halaman = DB::table('kategori_halamen')->get();

    return view('inovasiview', compact('inovasi','kategoris_halaman'));
}


    public function inovasiview()
    {
        $inovasi=DB::table('inovasi1')
        ->get();
        $kategoris_halaman = DB::table('kategori_halamen')->get();
        return view('inovasiview',compact('kategoris_halaman','inovasi'));
    }
    //

    public function index(Request $request)
    {
          $tanggal = now()->toDateString();

DB::table('visitors')->updateOrInsert(
    ['tanggal' => $tanggal],
    [
        'total' => DB::raw('total + 1'),
        'updated_at' => now(),
        'created_at' => now()
    ]
);

    // 🔢 HITUNG TOTAL
    $totalVisitor = DB::table('visitors')->count();
         $sliders=DB::table('sliders')->where('is_active',1)->get();
         $galeris = DB::table('galeris')->latest()->first();
         $galeris_double=DB::table('galeris')->where('jenis',NULL)->get();
         $beritas=DB::table('beritas')
                  ->leftjoin('kategori_beritas','beritas.kategori_id','=','beritas.id')
                  ->select('beritas.*','kategori_beritas.nama')
         ->limit('3')->latest()->get();



         $kategoris_halaman=DB::table('kategori_halamen')->get();

$agendas = DB::table('agendas')
        ->select(
            'id',
            'judul_agenda',
            'tanggal',
            'jam_mulai',
            'jam_selesai',
            'lokasi',
            'deskripsi',
            'status'
        )
        // ->where('status', 1) // kalau ada status aktif
        ->orderBy('tanggal', 'asc')
        ->get()
        ->map(function ($item) {
            // pastikan format tanggal konsisten (penting untuk JS map)
            $item->tanggal = date('Y-m-d', strtotime($item->tanggal));
            return $item;
        });
    $kategoris_halaman = DB::table('kategori_halamen')->get();

      $sambutan=DB::table('sambutans')->first();
         
         return view('landing',compact('sambutan','agendas','sliders','galeris','galeris_double','beritas','kategoris_halaman'));
        
    }
    public function produk(Request $request)
    {
        // =========================
        // Ambil kategori unik (tidak duplikat)
        // =========================
        $kategoris = DB::table('produks')
            ->select('kategori')
            ->whereNotNull('kategori')
            ->groupBy('kategori')
            ->orderBy('kategori')
            ->get();

        // =========================
        // Query produk
        // =========================
        $query = DB::table('produks')
            ->where('status', 'aktif');

        // =========================
        // Filter kategori (jika dipilih)
        // =========================
        if ($request->kategori) {
            $query->where('kategori', $request->kategori);
        }

        // =========================
        // Ambil data produk
        // =========================
        $produks = $query->orderBy('created_at', 'desc')->paginate(12);
    $kategoris_halaman = DB::table('kategori_halamen')->get();

        return view('produk', compact('produks', 'kategoris','kategoris_halaman'));
    }

    public function inovasipokja1()
    {
        $pokja1=DB::table('inovasipokja1dan3')
        ->where('pokja_id', 6)
        ->get();
    $kategoris_halaman = DB::table('kategori_halamen')->get();

        return view('inovasipokja1',compact('pokja1','kategoris_halaman'));
    }

    public function inovasi1()
    {
        $inovasi1=DB::table('inovasi1')->get(); 
        $kategoris_halaman = DB::table('kategori_halamen')->get();
        return view('inovasi1', compact('inovasi1','kategoris_halaman'));
    }
    public function sekre()
    {
        $pokja1=DB::table('inovasipokja1dan3')
        ->where('pokja_id', 10)
        ->get();
    $kategoris_halaman = DB::table('kategori_halamen')->get();

        return view('inovasisekre',compact('pokja1','kategoris_halaman'));
    }
    public function kegiatansekre()
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

    ->where('data_umum_kegiatanpkks.id_desa',2)
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

    $desa = DB::table('dusuns')->where('id',2)->first();
    $kategoris_halaman = DB::table('kategori_halamen')->get();

    return view('kegiatansekre', compact('data', 'info', 'total','desa','kategoris_halaman'));
    }
    public function inovasipokja3()
    {
        $pokja1=DB::table('inovasipokja1dan3')
        ->where('pokja_id', 8)
        ->get();
    $kategoris_halaman = DB::table('kategori_halamen')->get();

        return view('inovasipokja3',compact('pokja1','kategoris_halaman'));
    }

    public function dasawisma(Request $request)
{
    $dusuns = DB::table('dusuns')->get();

    $dasawismas = DB::table('dasawismas')
        ->when($request->dusun_id, function ($q) use ($request) {
            $q->where('dusun_id', $request->dusun_id);
        })
        ->where('tahun',2025)
        ->get();

    /*
    |--------------------------------------------------------------------------
    | FILTER DASAWISMA
    |--------------------------------------------------------------------------
    */

    $catatan = DB::table('buku_catatan_datas')
        ->join('dasawismas', 'dasawismas.id', '=', 'buku_catatan_datas.id_dasawisma')
        ->join('dusuns', 'dusuns.id', '=', 'dasawismas.dusun_id')

        ->when($request->dusun_id, function ($q) use ($request) {
            $q->where('dusuns.id', $request->dusun_id);
        })

        ->when($request->dasawisma_id, function ($q) use ($request) {
            $q->where('dasawismas.id', $request->dasawisma_id);
        })

        ->select(
            'dasawismas.nama_dasawisma',
            'dusuns.nama_dusun',
            DB::raw('SUM(total_l) as laki'),
            DB::raw('SUM(total_p) as perempuan'),
            DB::raw('SUM(total_l + total_p) as total')
        )
        ->groupBy(
            'dasawismas.nama_dasawisma',
            'dusuns.nama_dusun'
        )        ->where('dasawismas.tahun',2025)

        ->get();



    /*
    |--------------------------------------------------------------------------
    | TOTAL
    |--------------------------------------------------------------------------
    */

    $totalL = DB::table('buku_catatan_datas')
             ->join('dasawismas', 'dasawismas.id', '=', 'buku_catatan_datas.id_dasawisma')

        ->when($request->dasawisma_id, function ($q) use ($request) {
            $q->where('id_dasawisma', $request->dasawisma_id);
        })->where('dasawismas.tahun',2025)
        ->sum('total_l');

    $totalP = DB::table('buku_catatan_datas')
                 ->join('dasawismas', 'dasawismas.id', '=', 'buku_catatan_datas.id_dasawisma')

        ->when($request->dasawisma_id, function ($q) use ($request) {
            $q->where('id_dasawisma', $request->dasawisma_id);
        })->where('dasawismas.tahun',2025)

        ->sum('total_p');

    /*
    |--------------------------------------------------------------------------
    | KEHAMILAN
    |--------------------------------------------------------------------------
    */

    $kehamilan = DB::table('buku3_kehamilans')
                     ->join('dasawismas', 'dasawismas.id', '=', 'buku3_kehamilans.id_dasawisma')

        ->select(
            'status',
            DB::raw('COUNT(*) as total')
        )
        ->groupBy('status')
            ->where('dasawismas.tahun',2025)

        ->get();
    $kategoris_halaman = DB::table('kategori_halamen')->get();

/*
|--------------------------------------------------------------------------
| DATA KEGIATAN POKJA
|--------------------------------------------------------------------------
*/

$pokja1 = DB::table('kegiatan_pokja1s')
    ->join('dusuns', 'dusuns.id', '=', 'kegiatan_pokja1s.id_dusun')

    ->when($request->dusun_id, function ($q) use ($request) {
        $q->where('dusuns.id', $request->dusun_id);
    })

    ->select(
        'dusuns.nama_dusun',

        DB::raw('SUM(kader_pkbn) as kader_pkbn'),
        DB::raw('SUM(kader_pkdrt) as kader_pkdrt'),
        DB::raw('SUM(kader_pola_asuh) as kader_pola_asuh'),

        DB::raw('SUM(pkbn_kelompok) as pkbn_kelompok'),
        DB::raw('SUM(pkdrt_kelompok) as pkdrt_kelompok'),

        DB::raw('SUM(lansia_anggota) as lansia_anggota'),
        DB::raw('SUM(kerja_bakti) as kerja_bakti'),
        DB::raw('SUM(arisan) as arisan')
    )
    ->groupBy('dusuns.nama_dusun')
    ->get();


$pokja2 = DB::table('kegiatan_pokja2s')
    ->join('dusuns', 'dusuns.id', '=', 'kegiatan_pokja2s.id_dusun')

    ->when($request->dusun_id, function ($q) use ($request) {
        $q->where('dusuns.id', $request->dusun_id);
    })

    ->select(
        'dusuns.nama_dusun',

        DB::raw('SUM(jumlah_warga_masih_buta) as buta'),
        DB::raw('SUM(paud_sejenis) as paud'),
        DB::raw('SUM(taman_bacaan) as taman_bacaan'),

        DB::raw('SUM(kader_paud) as kader_paud'),
        DB::raw('SUM(kader_koperasi) as kader_koperasi'),

        DB::raw('SUM(lp3_pkk) as lp3_pkk'),
        DB::raw('SUM(damas_pkk) as damas_pkk')
    )
    ->groupBy('dusuns.nama_dusun')
    ->get();


$pokja3 = DB::table('kegiatan_pokja3s')
    ->join('dusuns', 'dusuns.id', '=', 'kegiatan_pokja3s.id_dusun')

    ->when($request->dusun_id, function ($q) use ($request) {
        $q->where('dusuns.id', $request->dusun_id);
    })

    ->select(
        'dusuns.nama_dusun',

        DB::raw('SUM(kader_posyandu) as kader_posyandu'),
        DB::raw('SUM(kader_gizi) as kader_gizi'),

        DB::raw('SUM(posyandu_jumlah) as posyandu'),
        DB::raw('SUM(lansia_jumlah_anggota) as lansia'),

        DB::raw('SUM(rumah_memiliki_jamban) as jamban'),
        DB::raw('SUM(rumah_memiliki_spal) as spal'),

        DB::raw('SUM(air_pdam) as air_pdam'),
        DB::raw('SUM(jumlah_pus) as pus'),
        DB::raw('SUM(jumlah_wus) as wus')
    )
    ->groupBy('dusuns.nama_dusun')
    ->get();


$pokja3real = DB::table('kegiatan_pokja3reals')
    ->join('dusuns', 'dusuns.id', '=', 'kegiatan_pokja3reals.id_dusun')

    ->when($request->dusun_id, function ($q) use ($request) {
        $q->where('dusuns.id', $request->dusun_id);
    })

    ->select(
        'dusuns.nama_dusun',

        DB::raw('SUM(kader_pangan) as kader_pangan'),
        DB::raw('SUM(kader_sandang) as kader_sandang'),

        DB::raw('SUM(pangan_beras) as pangan_beras'),
        DB::raw('SUM(pangan_non_beras) as pangan_non_beras'),

        DB::raw('SUM(peternakan) as peternakan'),
        DB::raw('SUM(perikanan) as perikanan'),

        DB::raw('SUM(toga) as toga'),
        DB::raw('SUM(warung_hidup) as warung_hidup'),

        DB::raw('SUM(rumah_sehat_layak) as rumah_sehat'),
        DB::raw('SUM(rumah_tidak_sehat_tidak_layak) as rumah_tidak_sehat')
    )
    ->groupBy('dusuns.nama_dusun')
    ->get();

    return view('dasawisma', compact(
        'dusuns',
        'dasawismas',
        'catatan',
        'totalL',
        'totalP',
        'kehamilan',
        'kategoris_halaman',
        'pokja1',
'pokja2',
'pokja3',
'pokja3real',
    ));
}
}
