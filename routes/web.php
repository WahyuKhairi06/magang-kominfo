<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\BeritaController;
use App\Http\Controllers\Admin\KategorihalamanController;
use App\Http\Controllers\Admin\HalamanController;
use App\Http\Controllers\Admin\GaleriController;
use App\Http\Controllers\Admin\AgendaController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\DokumenController;
use App\Http\Controllers\Admin\PokjaController;
use App\Http\Controllers\Admin\HalamanpokjaController;
use App\Http\Controllers\LandingpageController;
use App\Http\Controllers\KurvaController;
use App\Http\Controllers\Admin\SambutanController;
use App\Http\Controllers\HalamanController as landinghalaman;
use App\Http\Controllers\Admin\DesaController;
use App\Http\Controllers\Admin\KecamatanController;
use App\Http\Controllers\Admin\DusunController;
use App\Http\Controllers\Admin\InfografisController;
use App\Http\Controllers\Admin\DasawismaController;
use App\Http\Controllers\Admin\PokjaVIController;
use App\Http\Controllers\Admin\ProdukController;
use App\Http\Controllers\Admin\BukupkkController;
use App\Http\Controllers\Admin\RekapbukuPkkController;
use App\Http\Controllers\Admin\BukuAgendaSuratController;
use App\Http\Controllers\Admin\AnggotaAgendaSuratController;
use App\Http\Controllers\Dasawisma\BukuController;
use App\Http\Controllers\Dasawisma\Buku2Controller;
use App\Http\Controllers\Dasawisma\Buku3Controller;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Dasawisma\RumahController;
use App\Http\Controllers\UmumKegiatan\UmumKegiatanController;
use App\Http\Controllers\UmumKegiatan\DataUmumKegiatanController;
use App\Http\Controllers\UmumKegiatan\Pokja1KegiatanController;
use App\Http\Controllers\UmumKegiatan\Pokja2KegiatanController;
use App\Http\Controllers\UmumKegiatan\Pokja3KegiatanController;
use App\Http\Controllers\UmumKegiatan\Pokja3realKegiatanController;
use App\Http\Controllers\Admin\InovasiPokja1Controller;
use App\Http\Controllers\Admin\InovasiPokja3Controller;
use App\Http\Controllers\Admin\InovasiSekretariatController;
use App\Http\Controllers\ProfilOrganisasiController;
use App\Http\Controllers\InovasiController;
use App\Http\Controllers\PengaduanController;
use App\Http\Controllers\Admin\FaqController;


Route::prefix('admin')->group(function () {
    Route::get('/faq', [FaqController::class, 'index'])->name('faq.index');
    Route::get('/faq/create', [FaqController::class, 'create'])->name('faq.create');
    Route::post('/faq', [FaqController::class, 'store'])->name('faq.store');
    Route::get('/faq/{id}/edit', [FaqController::class, 'edit'])->name('faq.edit');
    Route::put('/faq/{id}', [FaqController::class, 'update'])->name('faq.update');
    Route::delete('/faq/{id}', [FaqController::class, 'destroy'])->name('faq.delete');
});


Route::get('/faq', [LandingpageController::class, 'faq'])->name('faq');

Route::get('/pengaduan', [LandingpageController::class, 'pengaduan'])->name('pengaduan.form');
Route::post('/pengaduan', [LandingpageController::class, 'pengaduanStore'])->name('pengaduan.store');

// ADMIN
Route::get('/admin/pengaduan', [\App\Http\Controllers\Admin\PengaduanController::class, 'index'])
    ->name('pengaduan.index');

Route::delete('/admin/pengaduan/{id}', [\App\Http\Controllers\Admin\PengaduanController::class, 'destroy'])
    ->name('pengaduan.delete');

Route::get('landing/inovasi/view/{id}', [LandingpageController::class, 'detail'])
    ->name('inovasiview.frontend');
    Route::get('/', [LandingpageController::class, 'index'])->name('landingpage');
    Route::get('landing/produk', [LandingpageController::class, 'produk'])->name('produk.frontend');
    Route::get('landing/inovasi/pokja1', [LandingpageController::class, 'inovasipokja1'])->name('inovasipokja1.frontend');
    Route::get('landing/inovasi/pokja3', [LandingpageController::class, 'inovasipokja3'])->name('inovasipokja3.frontend');
    Route::get('inovasi/sekre', [LandingpageController::class, 'sekre'])->name('sekre.frontend');
    Route::get('kegiatan/sekre', [LandingpageController::class, 'kegiatansekre'])->name('kegiatansekre.frontend');
    Route::get('landing/dasawisma', [LandingpageController::class, 'dasawisma'])->name('dasawisma.frontend');

    Route::get('landing/inovasi1', [LandingpageController::class, 'inovasi1'])->name('inovasi1.frontend');


 //kurva
    Route::get('pokja1/kurva', [KurvaController::class, 'kurva1'])->name('kurva1.frontend');
    Route::get('pokja2/kurva', [KurvaController::class, 'kurva2'])->name('kurva2.frontend');
    Route::get('pokja3/kurva', [KurvaController::class, 'kurva3'])->name('kurva3.frontend');
    Route::get('pokja4/kurva', [KurvaController::class, 'kurva4'])->name('kurva4.frontend');
    Route::get('inovasi/pokja4/kurva', [KurvaController::class, 'inovasipokja4'])->name('inovasipokja4.frontend');

 
Route::get('/inovasisekre/{id}/detail', [InovasiSekretariatController::class, 'open'])
    ->name('inovasisekre.show');

Route::get('/dashboard', [DashboardController::class,'index'])
->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {

//info grafis

// INDEX
Route::get('/admin/infografis', [InfografisController::class, 'index'])
    ->name('infografis.index');

// CREATE
Route::get('/admin/infografis/create', [InfografisController::class, 'create'])
    ->name('infografis.create');

// STORE
Route::post('/admin/infografis/store', [InfografisController::class, 'store'])
    ->name('infografis.store');

// EDIT
Route::get('/admin/infografis/edit/{id}', [InfografisController::class, 'edit'])
    ->name('infografis.edit');

// UPDATE
Route::post('/admin/infografis/update/{id}', [InfografisController::class, 'update'])
    ->name('infografis.update');

// DELETE
Route::delete('/admin/infografis/delete/{id}', [InfografisController::class, 'destroy'])
    ->name('infografis.delete');

//LOGOUT


//profil organinsai

Route::get('/organisasi', [ProfilOrganisasiController::class, 'index'])->name('organisasi.index');

Route::get('/organisasi/create', [ProfilOrganisasiController::class, 'create'])->name('organisasi.create');

Route::post('/organisasi/store', [ProfilOrganisasiController::class, 'store'])->name('organisasi.store');

Route::get('/organisasi/edit/{id}', [ProfilOrganisasiController::class, 'edit'])->name('organisasi.edit');

Route::post('/organisasi/update/{id}', [ProfilOrganisasiController::class, 'update'])->name('organisasi.update');

Route::delete('/organisasi/delete/{id}', [ProfilOrganisasiController::class, 'destroy'])->name('organisasi.delete');


//inovasi pokja 3

Route::get('/inovasisekre', [InovasiSekretariatController::class,'index'])->name('inovasisekre.index');

Route::get('/inovasisekre/create', [InovasiSekretariatController::class,'create'])->name('inovasisekre.create');

Route::post('/inovasisekre/store', [InovasiSekretariatController::class,'store'])->name('inovasisekre.store');

Route::get('/inovasisekre/edit/{id}', [InovasiSekretariatController::class,'edit'])->name('inovasisekre.edit');

Route::put('/inovasisekre/update/{id}', [InovasiSekretariatController::class,'update'])->name('inovasisekre.update');

Route::delete('/inovasisekre/delete/{id}', [InovasiSekretariatController::class,'destroy'])->name('inovasisekre.delete');

//inovasi pokja 3

Route::get('/inovasipokja3', [InovasiPokja3Controller::class,'index'])->name('inovasipokja3.index');

Route::get('/inovasipokja3/create', [InovasiPokja3Controller::class,'create'])->name('inovasipokja3.create');

Route::post('/inovasipokja3/store', [InovasiPokja3Controller::class,'store'])->name('inovasipokja3.store');

Route::get('/inovasipokja3/edit/{id}', [InovasiPokja3Controller::class,'edit'])->name('inovasipokja3.edit');

Route::put('/inovasipokja3/update/{id}', [InovasiPokja3Controller::class,'update'])->name('inovasipokja3.update');

Route::delete('/inovasipokja3/delete/{id}', [InovasiPokja3Controller::class,'destroy'])->name('inovasipokja3.delete');

//inovasi pokja 1

Route::get('/inovasipokja1', [InovasiPokja1Controller::class,'index'])->name('inovasipokja1.index');

Route::get('/inovasipokja1/create', [InovasiPokja1Controller::class,'create'])->name('inovasipokja1.create');

Route::post('/inovasipokja1/store', [InovasiPokja1Controller::class,'store'])->name('inovasipokja1.store');

Route::get('/inovasipokja1/edit/{id}', [InovasiPokja1Controller::class,'edit'])->name('inovasipokja1.edit');

Route::put('/inovasipokja1/update/{id}', [InovasiPokja1Controller::class,'update'])->name('inovasipokja1.update');

Route::delete('/inovasipokja1/delete/{id}', [InovasiPokja1Controller::class,'destroy'])->name('inovasipokja1.delete');

//inovasi 1

Route::get('/inovasi1', [InovasiController::class,'index'])->name('inovasi1.index');

Route::get('/inovasi1/create', [InovasiController::class,'create'])->name('inovasi1.create');

Route::post('/inovasi1/store', [InovasiController::class,'store'])->name('inovasi1.store');

Route::get('/inovasi1/edit/{id}', [InovasiController::class,'edit'])->name('inovasi1.edit');

Route::put('/inovasi1/update/{id}', [InovasiController::class,'update'])->name('inovasi1.update');

Route::delete('/inovasi1/delete/{id}', [InovasiController::class,'destroy'])->name('inovasi1.delete');

Route::get('/inovasi1/{id}', [InovasiController::class, 'show'])->name('inovasi1.show');

//kegiatna pokja III ral 

Route::get('kegiatanpokja3real/{id_dusun}', [Pokja3realKegiatanController::class, 'index']);
Route::get('kegiatanpokja3real/pdf/{id_dusun}', [Pokja3realKegiatanController::class, 'pdf']);
Route::get('kegiatanpokja3real/create/{id_dusun}', [Pokja3realKegiatanController::class, 'create']);
Route::post('kegiatanpokja3real/store', [Pokja3realKegiatanController::class, 'store']);
Route::get('kegiatanpokja3real/edit/{id}', [Pokja3realKegiatanController::class, 'edit']);
Route::post('kegiatanpokja3real/update/{id}', [Pokja3realKegiatanController::class, 'update']);
Route::get('kegiatanpokja3real/delete/{id}', [Pokja3realKegiatanController::class, 'delete']);


//kegiatna pokja III ini pokja 4 sebenarnya

Route::get('kegiatanpokja3/{id_dusun}', [Pokja3KegiatanController::class, 'index']);
Route::get('kegiatanpokja3/pdf/{id_dusun}', [Pokja3KegiatanController::class, 'pdf']);
Route::get('kegiatanpokja3/create/{id_dusun}', [Pokja3KegiatanController::class, 'create']);
Route::post('kegiatanpokja3/store', [Pokja3KegiatanController::class, 'store']);
Route::get('kegiatanpokja3/edit/{id}', [Pokja3KegiatanController::class, 'edit']);
Route::post('kegiatanpokja3/update/{id}', [Pokja3KegiatanController::class, 'update']);
Route::get('kegiatanpokja3/delete/{id}', [Pokja3KegiatanController::class, 'delete']);

//keigatan pokja II
Route::prefix('kegiatanpokja2')->group(function () {
    Route::get('/{id_dusun}', [Pokja2KegiatanController::class, 'index']);
    Route::get('/pdf/{id_dusun}', [Pokja2KegiatanController::class, 'exportPdf']);
    Route::get('/create/{id_dusun}', [Pokja2KegiatanController::class, 'create']);
    Route::post('/store', [Pokja2KegiatanController::class, 'store']);
    Route::get('/edit/{id}', [Pokja2KegiatanController::class, 'edit']);
    Route::post('/update/{id}', [Pokja2KegiatanController::class, 'update']);
    Route::get('/delete/{id}', [Pokja2KegiatanController::class, 'destroy']);
});


//kegiatan buat
Route::prefix('kegiatanpokja1')->group(function(){

    Route::get('/{id}', [Pokja1KegiatanController::class,'kegiatanpokja1Index'])->name('kegiatanpokja1.index');
    Route::get('/pdf/{id}', [Pokja1KegiatanController::class,'exportPdf'])->name('kegiatanpokja1.exportPdf');

    Route::get('/create/{id}', [Pokja1KegiatanController::class,'kegiatanpokja1Create'])->name('kegiatanpokja1.create');

    Route::post('/store', [Pokja1KegiatanController::class,'kegiatanpokja1Store'])->name('kegiatanpokja1.store');

    Route::get('/edit/{id}', [Pokja1KegiatanController::class,'kegiatanpokja1Edit'])->name('kegiatanpokja1.edit');

    Route::put('/update/{id}', [Pokja1KegiatanController::class,'kegiatanpokja1Update'])->name('kegiatanpokja1.update');

    Route::delete('/delete/{id}', [Pokja1KegiatanController::class,'kegiatanpokja1Delete'])->name('kegiatanpokja1.delete');

});


//kegaitan pokja 1

Route::prefix('pokja')->group(function(){

   

    Route::get('/create', [Pokja1KegiatanController::class,'create'])->name('pokja.create');

    Route::post('/storedata', [Pokja1KegiatanController::class,'store'])->name('pokja.storedata');

    Route::get('/edit/{id}', [Pokja1KegiatanController::class,'edit'])->name('pokja.edit');

    Route::put('/update/{id}', [Pokja1KegiatanController::class,'update'])->name('pokja.update');

    Route::delete('/delete/{id}', [Pokja1KegiatanController::class,'destroy'])->name('pokja.delete');

     Route::get('/', [Pokja1KegiatanController::class,'index'])->name('pokja.index');
});


// dataumum

// INDEX
Route::get('/wilayah/{id}', [DataUmumKegiatanController::class, 'index'])
    ->name('wilayah.index');
Route::get('/wilayah/pdf/{id}', [DataUmumKegiatanController::class, 'pdf'])
    ->name('wilayah.pdf');

// CREATE
Route::get('/wilayah/create/{id}', [DataUmumKegiatanController::class, 'create'])
    ->name('wilayah.create');

// STORE
Route::post('/wilayah/store', [DataUmumKegiatanController::class, 'store'])
    ->name('wilayah.store');

// EDIT
Route::get('/wilayah/edit/{id}', [DataUmumKegiatanController::class, 'edit'])
    ->name('wilayah.edit');

// UPDATE
Route::post('/wilayah/update/{id}', [DataUmumKegiatanController::class, 'update'])
    ->name('wilayah.update');

// DELETE
Route::delete('/wilayah/delete/{id}', [DataUmumKegiatanController::class, 'destroy'])
    ->name('wilayah.delete');

//umum

Route::get('/umum', [UmumKegiatanController::class, 'index'])->name('umum.index');
Route::get('/umum/create', [UmumKegiatanController::class, 'create'])->name('umum.create');
Route::post('/umum/store', [UmumKegiatanController::class, 'store'])->name('umum.store');
Route::get('/umum/edit/{id}', [UmumKegiatanController::class, 'edit'])->name('umum.edit');
Route::post('/umum/update/{id}', [UmumKegiatanController::class, 'update'])->name('umum.update');
Route::delete('/umum/delete/{id}', [UmumKegiatanController::class, 'destroy'])->name('umum.delete');



//rumah kategori

// index
Route::get('/rumah', [RumahController::class, 'index'])->name('rumah.index');

// create
Route::get('/rumah/create', [RumahController::class, 'create'])->name('rumah.create');

// store
Route::post('/rumah/store', [RumahController::class, 'store'])->name('rumah.store');

// edit
Route::get('/rumah/edit/{id}', [RumahController::class, 'edit'])->name('rumah.edit');

// update
Route::post('/rumah/update/{id}', [RumahController::class, 'update'])->name('rumah.update');

// delete
Route::get('/rumah/delete/{id}', [RumahController::class, 'destroy'])->name('rumah.delete');


//buku3
Route::get('/buku3/pdf/{id}', [Buku3Controller::class,'pdf'])->name('buku3.pdf');
Route::get('/buku3/pdfbulan/{id}', [Buku3Controller::class,'pdfbulan'])->name('buku3.pdfbulan');
Route::prefix('buku3')->group(function(){

    Route::get('/{id}', [Buku3Controller::class,'index'])->name('buku3.index');
    Route::get('/create/{id}', [Buku3Controller::class,'create'])->name('buku3.create');

    Route::post('/store', [Buku3Controller::class,'store'])->name('buku3.store');

    Route::get('/edit/{id}', [Buku3Controller::class,'edit'])->name('buku3.edit');
    Route::put('/update/{id}', [Buku3Controller::class,'update'])->name('buku3.update');

    Route::delete('/delete/{id}', [Buku3Controller::class,'destroy'])->name('buku3.delete');

});


//buku2

Route::get('/buku2/{id}', [Buku2Controller::class, 'index'])->name('buku2.index');
Route::get('/buku2/create/{id}', [Buku2Controller::class, 'create'])->name('buku2.create');
Route::post('/buku2/store', [Buku2Controller::class, 'store'])->name('buku2.store');

Route::get('/buku2/edit/{id}', [Buku2Controller::class, 'edit'])->name('buku2.edit');
Route::put('/buku2/update/{id}', [Buku2Controller::class, 'update'])->name('buku2.update');

Route::delete('/buku2/delete/{id}', [Buku2Controller::class, 'delete'])->name('buku2.delete');
Route::get('/buku2/cetak/{id}', [Buku2Controller::class, 'cetak'])->name('buku2.cetak');


//buku 1 dasawisma

Route::prefix('buku')->name('buku.')->group(function () {
    Route::get('/{id}', [BukuController::class, 'index'])->name('index');
    Route::get('/create/{id}', [BukuController::class, 'create'])->name('create');
    Route::post('/store', [BukuController::class, 'store'])->name('store');
    Route::get('/edit/{id}', [BukuController::class, 'edit'])->name('edit');
    Route::put('/update/{id}', [BukuController::class, 'update'])->name('update');
    Route::delete('/delete/{id}', [BukuController::class, 'destroy'])->name('delete');
    
});
Route::get('/buku/pdf/{id}', [BukuController::class, 'cetakpdf'])->name('buku.pdf.all');
Route::get('/buku/cetakPdfrumah/{id}', [BukuController::class, 'cetakPdfrumah'])->name('buku.cetakPdfrumah.all');
//anggota buku agenda


Route::get('/agenda-surat/{id}', [AnggotaAgendaSuratController::class, 'index'])->name('agendaanggota.index');
Route::get('/agenda-surat/cetak/{id}', [AnggotaAgendaSuratController::class, 'cetak'])->name('agendaanggota.cetak');

Route::get('/agenda-surat/create/{id}', [AnggotaAgendaSuratController::class, 'create'])->name('agendaanggota.create');

Route::post('/agenda-surat/store', [AnggotaAgendaSuratController::class, 'store'])->name('agendaanggota.store');

Route::get('/agenda-surat/edit/{id}', [AnggotaAgendaSuratController::class, 'edit'])->name('agendaanggota.edit');

Route::post('/agenda-surat/update/{id}', [AnggotaAgendaSuratController::class, 'update'])->name('agendaanggota.update');

Route::delete('/agenda-surat/delete/{id}', [AnggotaAgendaSuratController::class, 'destroy'])->name('agendaanggota.destroy');
//buku agenda

Route::get('/buku-agenda', [BukuAgendaSuratController::class, 'index'])->name('bukuagenda.index');

Route::get('/buku-agenda/create', [BukuAgendaSuratController::class, 'create'])->name('bukuagenda.create');

Route::post('/buku-agenda/store', [BukuAgendaSuratController::class, 'store'])->name('bukuagenda.store');

Route::get('/buku-agenda/edit/{id}', [BukuAgendaSuratController::class, 'edit'])->name('bukuagenda.edit');

Route::post('/buku-agenda/update/{id}', [BukuAgendaSuratController::class, 'update'])->name('bukuagenda.update');

Route::delete('/buku-agenda/delete/{id}', [BukuAgendaSuratController::class, 'destroy'])->name('bukuagenda.destroy');

//tambah anggota buku pkk
Route::prefix('rekapbuku')->group(function(){
    Route::get('/index/{id}', [RekapbukuPkkController::class,'index'])->name('rekapbuku.index');
    Route::get('/cetak/{id}', [RekapbukuPkkController::class,'cetak'])->name('rekapbuku.cetak');
    Route::get('/create/{id}', [RekapbukuPkkController::class,'create'])->name('rekapbuku.create');
    Route::post('/store', [RekapbukuPkkController::class,'store'])->name('rekapbuku.store');
    Route::get('/edit/{id}', [RekapbukuPkkController::class,'edit'])->name('rekapbuku.edit');
    Route::post('/update/{id}', [RekapbukuPkkController::class,'update'])->name('rekapbuku.update');
    Route::delete('/delete/{id}', [RekapbukuPkkController::class,'destroy'])->name('rekapbuku.delete');
});

//buku pkk
Route::prefix('bukupkk')->controller(BukupkkController::class)->group(function () {
    Route::get('/', 'index')->name('bukupkk.index');
    Route::get('/create', 'create')->name('bukupkk.create');
    Route::post('/store', 'store')->name('bukupkk.store');
    Route::get('/edit/{id}', 'edit')->name('bukupkk.edit');
    Route::post('/update/{id}', 'update')->name('bukupkk.update');
    Route::delete('/delete/{id}', 'destroy')->name('bukupkk.destroy');
});


//produk


Route::prefix('admin/produk')->group(function () {
    Route::get('/pokja II', [ProdukController::class, 'index'])->name('produk.index');
    Route::get('/create', [ProdukController::class, 'create'])->name('produk.create');
    Route::post('/store', [ProdukController::class, 'store'])->name('produk.store');
    Route::get('/edit/{id}', [ProdukController::class, 'edit'])->name('produk.edit');
    Route::post('/update/{id}', [ProdukController::class, 'update'])->name('produk.update');
    Route::delete('/delete/{id}', [ProdukController::class, 'destroy'])->name('produk.delete');
});













//endproduk




    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


//desa admin
  Route::get('/desa', [DesaController::class, 'index'])->name('desa.index');

    // CREATE (form tambah)
    Route::get('/desa/create', [DesaController::class, 'create'])->name('desa.create');

    // STORE (simpan data)
    Route::post('/desa/store', [DesaController::class, 'store'])->name('desa.store');

    // EDIT (form edit)
    Route::get('/desa/edit/{id}', [DesaController::class, 'edit'])->name('desa.edit');

    // UPDATE (update data)
    Route::post('/desa/update/{id}', [DesaController::class, 'update'])->name('desa.update');

    // DELETE (hapus)
    Route::delete('/desa/delete/{id}', [DesaController::class, 'destroy'])->name('desa.destroy');

//kecataman
 Route::get('/kecamatan', [KecamatanController::class, 'index'])->name('kecamatan.index');
    Route::get('/kecamatan/create', [KecamatanController::class, 'create'])->name('kecamatan.create');
    Route::post('/kecamatan/store', [KecamatanController::class, 'store'])->name('kecamatan.store');
    Route::get('/kecamatan/edit/{id}', [KecamatanController::class, 'edit'])->name('kecamatan.edit');
    Route::post('/kecamatan/update/{id}', [KecamatanController::class, 'update'])->name('kecamatan.update');
    Route::delete('/kecamatan/delete/{id}', [KecamatanController::class, 'destroy'])->name('kecamatan.destroy');


//dusun
  Route::get('/dusun', [DusunController::class, 'index'])->name('dusun.index');
    Route::get('/dusun/create', [DusunController::class, 'create'])->name('dusun.create');
    Route::post('/dusun/store', [DusunController::class, 'store'])->name('dusun.store');
    Route::get('/dusun/edit/{id}', [DusunController::class, 'edit'])->name('dusun.edit');
    Route::post('/dusun/update/{id}', [DusunController::class, 'update'])->name('dusun.update');
    Route::delete('/dusun/delete/{id}', [DusunController::class, 'destroy'])->name('dusun.destroy');

//dasawisma
 Route::get('/dasawisma', [DasawismaController::class, 'index'])->name('dasawisma.index');
 Route::get('/data/buku/dasawisma', [DasawismaController::class, 'buku'])->name('buku.dasawisma.index');
    Route::get('/dasawisma/create', [DasawismaController::class, 'create'])->name('dasawisma.create');
    Route::post('/dasawisma/store', [DasawismaController::class, 'store'])->name('dasawisma.store');
    Route::get('/dasawisma/edit/{id}', [DasawismaController::class, 'edit'])->name('dasawisma.edit');
    Route::post('/dasawisma/update/{id}', [DasawismaController::class, 'update'])->name('dasawisma.update');
    Route::delete('/dasawisma/delete/{id}', [DasawismaController::class, 'destroy'])->name('dasawisma.destroy');
Route::get('/dasawisma/kuisioner/{id}/{tahun}', [DasawismaController::class, 'kuisioner'])->name('dasawisma.kuisioner');
Route::post('/dasawisma/simpan/{id}', [DasawismaController::class, 'simpanKuisioner'])->name('dasawisma.simpan');
Route::post('/pokjaIV/simpan/{id}', [PokjaVIController::class, 'simpan'])->name('pokjaIV.simpan');
Route::get('/pokjaiv/rekap', [PokjaVIController::class, 'cetak'])->name('pokjaIV.rekap');


    


// tampilkan data role
Route::get('/role', [RoleController::class, 'index'])->name('role.index');
Route::post('/role', [RoleController::class, 'store'])->name('role.store');
Route::get('/role/{id}/edit', [RoleController::class, 'edit'])->name('role.edit');
Route::put('/role/{id}', [RoleController::class, 'update'])->name('role.update');
Route::delete('/role/{id}', [RoleController::class, 'destroy'])->name('role.destroy');

//kategori berita
Route::get('/kategori-berita', [KategoriController::class, 'index'])->name('kategori-berita.index');
Route::post('/kategori-berita', [KategoriController::class, 'store'])->name('kategori-berita.store');
Route::get('/kategori-berita/{id}/edit', [KategoriController::class, 'edit'])->name('kategori-berita.edit');
Route::put('/kategori-berita/{id}', [KategoriController::class, 'update'])->name('kategori-berita.update');
Route::delete('/kategori-berita/{id}', [KategoriController::class, 'destroy'])->name('kategori-berita.destroy');



// berita page
Route::get('/berita', [BeritaController::class, 'index'])->name('beritapage.index');
Route::post('/berita', [BeritaController::class, 'store'])->name('beritapage.store');
Route::get('/berita/tambah', [BeritaController::class, 'create'])->name('beritapage.create');
Route::get('/berita/{id}/edit', [BeritaController::class, 'edit'])->name('beritapage.edit');
Route::put('/berita/{id}', [BeritaController::class, 'update'])->name('beritapage.update');
Route::delete('/berita/{id}', [BeritaController::class, 'destroy'])->name('beritapage.destroy');


// kategori Halaman
Route::get('/kategori-halaman', [KategorihalamanController::class, 'index'])->name('kategori-halaman.index');
Route::post('/kategori-halaman', [KategorihalamanController::class, 'store'])->name('kategori-halaman.store');
Route::get('/kategori-halaman/tambah', [KategorihalamanController::class, 'create'])->name('kategori-halaman.create');
Route::get('/kategori-halaman/{id}/edit', [KategorihalamanController::class, 'edit'])->name('kategori-halaman.edit');
Route::put('/kategori-halaman/{id}', [KategorihalamanController::class, 'update'])->name('kategori-halaman.update');
Route::delete('/kategori-halaman/{id}', [KategorihalamanController::class, 'destroy'])->name('kategori-halaman.destroy');



//halaman
 Route::get('halaman', [HalamanController::class, 'index']);
    Route::get('halaman/create', [HalamanController::class, 'create']);
    Route::post('halaman/store', [HalamanController::class, 'store']);
    Route::get('halaman/edit/{id}', [HalamanController::class, 'edit']);
    Route::post('halaman/update/{id}', [HalamanController::class, 'update']);
    Route::delete('halaman/delete/{id}', [HalamanController::class, 'hapus']);

    // upload CKEditor
    Route::post('upload-image', [HalamanController::class, 'uploadImage'])->name('upload.image');



    // galeri

// 📌 tampil data
Route::get('/galeri', [GaleriController::class, 'index'])->name('galeri.index');

// 📌 form tambah
Route::get('/galeri/create', [GaleriController::class, 'create'])->name('galeri.create');

// 📌 simpan data
Route::post('/galeri/store', [GaleriController::class, 'store'])->name('galeri.store');

// 📌 form edit
Route::get('/galeri/edit/{id}', [GaleriController::class, 'edit'])->name('galeri.edit');

// 📌 update data
Route::put('/galeri/update/{id}', [GaleriController::class, 'update'])->name('galeri.update');

// 📌 hapus data
Route::delete('/galeri/delete/{id}', [GaleriController::class, 'destroy'])->name('galeri.destroy');



//agenda
Route::get('/agenda', [AgendaController::class, 'index'])->name('agenda.index');
Route::get('/agenda/create', [AgendaController::class, 'create'])->name('agenda.create');
Route::post('/agenda/store', [AgendaController::class, 'store'])->name('agenda.store');
Route::get('/agenda/edit/{id}', [AgendaController::class, 'edit'])->name('agenda.edit');
Route::put('/agenda/update/{id}', [AgendaController::class, 'update'])->name('agenda.update');
Route::delete('/agenda/delete/{id}', [AgendaController::class, 'destroy'])->name('agenda.destroy');


//slider

// 📌 tampil data
Route::get('/slider', [SliderController::class, 'index'])->name('slider.index');

// 📌 form create
Route::get('/slider/create', [SliderController::class, 'create'])->name('slider.create');

// 📌 simpan data
Route::post('/slider/store', [SliderController::class, 'store'])->name('slider.store');

// 📌 form edit
Route::get('/slider/edit/{id}', [SliderController::class, 'edit'])->name('slider.edit');

// 📌 update data
Route::put('/slider/update/{id}', [SliderController::class, 'update'])->name('slider.update');

// 📌 hapus data
Route::delete('/slider/delete/{id}', [SliderController::class, 'destroy'])->name('slider.destroy');


//dokumen
Route::get('/dokumen', [DokumenController::class, 'index'])->name('dokumen.index');
Route::get('/dokumen/create', [DokumenController::class, 'create'])->name('dokumen.create');
Route::post('/dokumen/store', [DokumenController::class, 'store'])->name('dokumen.store');
Route::get('/dokumen/edit/{id}', [DokumenController::class, 'edit'])->name('dokumen.edit');
Route::put('/dokumen/update/{id}', [DokumenController::class, 'update'])->name('dokumen.update');
Route::delete('/dokumen/delete/{id}', [DokumenController::class, 'destroy'])->name('dokumen.destroy');

// download
Route::get('/dokumen/download/{id}', [DokumenController::class, 'download'])->name('dokumen.download');




// 📌 tampil data
Route::get('/pokja', [PokjaController::class, 'index'])->name('pokja.index');

// 📌 form create
Route::get('/pokja/create', [PokjaController::class, 'create'])->name('pokja.create');

// 📌 simpan data
Route::post('/pokja/store', [PokjaController::class, 'store'])->name('pokja.store');

// 📌 form edit
Route::get('/pokja/edit/{id}', [PokjaController::class, 'edit'])->name('pokja.edit');

// 📌 update data
Route::put('/pokja/update/{id}', [PokjaController::class, 'update'])->name('pokja.update');

// 📌 hapus data
Route::delete('/pokja/delete/{id}', [PokjaController::class, 'destroy'])->name('pokja.destroy');




Route::get('/halamanpokja', [HalamanpokjaController::class, 'index'])->name('halamanpokja.index');
Route::get('/halamanpokja/create', [HalamanpokjaController::class, 'create'])->name('halamanpokja.create');
Route::post('/halamanpokja/store', [HalamanpokjaController::class, 'store'])->name('halamanpokja.store');
Route::get('/halamanpokja/edit/{id}', [HalamanpokjaController::class, 'edit'])->name('halamanpokja.edit');
Route::put('/halamanpokja/update/{id}', [HalamanpokjaController::class, 'update'])->name('halamanpokja.update');
Route::delete('/halamanpokja/delete/{id}', [HalamanpokjaController::class, 'destroy'])->name('halamanpokja.destroy');

// upload ckeditor
Route::post('/upload-ckeditor', [HalamanpokjaController::class, 'upload']);

//sambutan
 Route::get('/sambutan', [SambutanController::class, 'index'])->name('sambutan.index');
    Route::get('/sambutan/create', [SambutanController::class, 'create'])->name('sambutan.create');
    Route::post('/sambutan/store', [SambutanController::class, 'store'])->name('sambutan.store');

    Route::get('/sambutan/edit/{id}', [SambutanController::class, 'edit'])->name('sambutan.edit');
    Route::post('/sambutan/update/{id}', [SambutanController::class, 'update'])->name('sambutan.update');

    Route::get('/sambutan/delete/{id}', [SambutanController::class, 'destroy'])->name('sambutan.destroy');



// AI Chatbot Setting
Route::get('/admin/chatbot-setting', [\App\Http\Controllers\Admin\ChatbotSettingController::class, 'index'])
    ->name('chatbot-setting.index');
Route::put('/admin/chatbot-setting', [\App\Http\Controllers\Admin\ChatbotSettingController::class, 'update'])
    ->name('chatbot-setting.update');

});

require __DIR__.'/auth.php';


//landingpage
Route::get('/landing/halaman/{id}', [landinghalaman::class, 'index']);
Route::get('/landing/berita', [landinghalaman::class, 'berita']);
Route::get('/landing/berita/{id}', [landinghalaman::class, 'detailberita']);
Route::get('/landing/galeri', [landinghalaman::class, 'galeri']);
Route::get('/landing/infografis', [landinghalaman::class, 'infografis']);
Route::get('/landing/dokumen', [landinghalaman::class, 'dokumen']);
Route::get('/landing/agenda', [landinghalaman::class, 'agenda']);
Route::get('/download/{id}', [landinghalaman::class, 'downloadDokumen']);

Route::get('/chat', function () {
    $kategoris_halaman = \Illuminate\Support\Facades\DB::table('kategori_halamen')->get();
    $chatbotSetting = \Illuminate\Support\Facades\DB::table('chatbot_settings')->first();
    return view('chat', compact('kategoris_halaman', 'chatbotSetting'));
})->name('chat');

Route::post('/chat/send', [\App\Http\Controllers\ChatbotController::class, 'send'])->name('chat.send');
