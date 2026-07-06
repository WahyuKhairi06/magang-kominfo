<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class DashboardController extends Controller
{
    //

   public function index()
{
    // STATISTIK
    $totalProduk = DB::table('produks')->count();
    $produkAktif = DB::table('produks')->where('status','aktif')->count();

    $totalAnggota = DB::table('anggotabukupkks')->count();
    $totalBukuPkk = DB::table('buku_pkks')->count();

    $suratMasuk = DB::table('anggota_agenda_surats')
        ->whereNotNull('tanggal_surat_masuk')->count();

    $suratKeluar = DB::table('anggota_agenda_surats')
        ->whereNotNull('tanggal_surat_keluar')->count();

    // CHART PRODUK PER KATEGORI
    $kategori = DB::table('produks')
        ->select('kategori', DB::raw('count(*) as total'))
        ->groupBy('kategori')
        ->pluck('total','kategori');

    // DATA TERBARU
    $inovasiTerbaru = DB::table('inovasi1')->latest()->limit(5)->get();
    $produkTerbaru = DB::table('produks')->latest()->limit(5)->get();
    $anggotaTerbaru = DB::table('anggotabukupkks')->latest()->limit(5)->get();

    // WARNING
    $stokMenipis = DB::table('produks')
        ->whereColumn('stok','<=','stok_minimum')
        ->count();

        $totalVisitor = DB::table('visitors')->sum('total');

$todayVisitor = DB::table('visitors')
    ->whereDate('tanggal', today())
    ->value('total') ?? 0;
    return view('dashboard', compact(
        'totalProduk','produkAktif','totalAnggota','totalBukuPkk',
        'suratMasuk','suratKeluar','kategori','inovasiTerbaru',
        'produkTerbaru','anggotaTerbaru','stokMenipis','totalVisitor','todayVisitor'
    ));
}
}
