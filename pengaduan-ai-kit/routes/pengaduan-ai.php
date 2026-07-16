<?php

use App\Http\Controllers\Admin\PengaduanController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Route Klasifikasi Pengaduan
|--------------------------------------------------------------------------
| Tempelkan blok ini ke dalam grup route admin yang sudah ada (yang
| dilindungi middleware auth admin), JANGAN taruh di luar grup auth.
| Sesuaikan prefix/middleware dengan konvensi routes/web.php asli.
*/

Route::middleware(['auth', 'admin']) // sesuaikan nama middleware asli
    ->prefix('admin')
    ->group(function () {
        Route::patch('/pengaduan/{id}/klasifikasi', [PengaduanController::class, 'updateKlasifikasi'])
            ->name('admin.pengaduan.klasifikasi.update');
    });
