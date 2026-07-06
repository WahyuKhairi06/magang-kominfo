<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class HalamanController extends Controller
{
    //
    public function index($id){
        $id_cek = decrypt($id);
 $halaman=DB::table('halamen')->where('kategori_halaman_id',$id_cek)->first();
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
    $berita=DB::table('beritas')->limit(5)->get();


     $data = DB::table('profil_struktur_organisasi')
            ->orderBy('urutan','asc')
            ->get();
            
        return view('halaman',compact('halaman','kategoris_halaman','agendas','berita','data'));
    }

    public function berita()
    {
        $beritas = DB::table('beritas')
    ->leftJoin('kategori_beritas', 'beritas.kategori_id', '=', 'kategori_beritas.id')
    ->select('beritas.*', 'kategori_beritas.nama as kategori','kategori_beritas.id as kategori_id')
    ->latest()
    ->get();

$kategoris = DB::table('kategori_beritas')->get();
          $kategoris_halaman=DB::table('kategori_halamen')->get();

return view('berita',compact('beritas','kategoris','kategoris_halaman'));
    }
    

    public function detailberita($id)
{
    $id_cek = decrypt($id);
$kategoris = DB::table('kategori_beritas')->get();

    // 🔥 tambah views dulu
    DB::table('beritas')
        ->where('id', $id_cek)
        ->increment('views');

    // 📁 kategori halaman
    $kategoris_halaman = DB::table('kategori_halamen')->get();

    // 📰 ambil detail berita
    $beritas = DB::table('beritas')
        ->leftJoin('kategori_beritas', 'beritas.kategori_id', '=', 'kategori_beritas.id')
        ->select('beritas.*', 'kategori_beritas.nama as kategori')
        ->where('beritas.id', $id_cek)
        ->first();

    $beritas_isi = DB::table('beritas')
        ->leftJoin('kategori_beritas', 'beritas.kategori_id', '=', 'kategori_beritas.id')
        ->select('beritas.*', 'kategori_beritas.nama as kategori')
        ->get();

$berita_populer = DB::table('beritas')
    ->leftJoin('kategori_beritas', 'beritas.kategori_id', '=', 'kategori_beritas.id')
    ->select('beritas.*', 'kategori_beritas.nama as kategori')
    ->orderBy('views', 'desc')
    ->limit(3)
    ->get();



     $kategoris_berita = DB::table('kategori_beritas')
    ->leftJoin('beritas', 'kategori_beritas.id', '=', 'beritas.kategori_id')
    ->select(
        'kategori_beritas.id',
        'kategori_beritas.nama',
        DB::raw('COUNT(beritas.id) as total')
    )
    ->groupBy('kategori_beritas.id', 'kategori_beritas.nama')
    ->get();
    return view('detail_berita', compact('beritas_isi','beritas', 'kategoris_halaman','berita_populer','kategoris','kategoris_berita'));
}

public function galeri(){
   $galeri = DB::table('galeris')
    ->leftJoin('pokjas','galeris.pokja_id','=','pokjas.id')
    ->select('galeris.*','pokjas.nama_pokja')
    ->when(request('pokja_id'), function($q){
        $q->where('galeris.pokja_id', request('pokja_id'));
    })
    ->where('galeris.jenis',NULL)
    ->latest()
    ->get();
        $pokja=DB::table('pokjas')->get();
    $kategoris_halaman = DB::table('kategori_halamen')->get();
    
return view('galeri', compact('galeri','kategoris_halaman','pokja'));
}
public function infografis(){
   $galeri = DB::table('galeris')
    ->leftJoin('pokjas','galeris.pokja_id','=','pokjas.id')
    ->select('galeris.*','pokjas.nama_pokja')
    ->when(request('pokja_id'), function($q){
        $q->where('galeris.pokja_id', request('pokja_id'));
    })
    ->where('galeris.jenis','infografis')
    ->latest()
    ->get();
        $pokja=DB::table('pokjas')->get();
    $kategoris_halaman = DB::table('kategori_halamen')->get();
    
return view('infografis', compact('galeri','kategoris_halaman','pokja'));
}
public function dokumen(){
    $dokumen = DB::table('dokumen')->get();
    $kategoris_halaman = DB::table('kategori_halamen')->get();

return view('dokumen', compact('dokumen','kategoris_halaman'));
}
public function downloadDokumen($id)
{
    $dok = DB::table('dokumen')->where('id', $id)->first();

    if (!$dok) {
        abort(404);
    }

    // tambah counter 1x
    DB::table('dokumen')
        ->where('id', $id)
        ->increment('jumlah_download', 1);

    $filePath = storage_path('app/public/' . $dok->file);

    // ⚡ ini kunci: tetap trigger download + balik halaman
    return response()->download($filePath)->deleteFileAfterSend(false);
}
public function agenda()
{
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

    return view('agenda', compact('agendas','kategoris_halaman'));
}
}
