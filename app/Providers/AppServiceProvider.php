<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $setting = null;
        \Illuminate\Support\Facades\View::composer('*', function ($view) use (&$setting) {
            if ($setting === null) {
                try {
                    $setting = \App\Models\PuskesmasSetting::firstOrCreate(['id' => 1], [
                        'nama_puskesmas' => 'Puskesmas Marunggi',
                        'kabupaten_kota' => 'Kota Pariaman',
                        'alamat' => 'Jl. Puti Bungsu, Desa Marunggi, Kec. Pariaman Selatan, Kota Pariaman, Sumatera Barat.',
                        'no_telp' => '(0751) 123-456',
                        'email' => 'info@puskesmasmarunggi.pariamankota.go.id',
                        'logo' => null,
                        'jam_senin_kamis' => '08:00 - 14:00',
                        'jam_jumat' => '08:00 - 11:00',
                        'jam_sabtu' => '08:00 - 13:00',
                        'link_facebook' => 'https://www.facebook.com/hcmarunggi/',
                        'link_instagram' => 'https://www.instagram.com/puskesmasmarunggi/',
                    ]);
                } catch (\Exception $e) {
                    $setting = new \App\Models\PuskesmasSetting([
                        'nama_puskesmas' => 'Puskesmas Marunggi',
                        'kabupaten_kota' => 'Kota Pariaman',
                        'alamat' => 'Jl. Puti Bungsu, Desa Marunggi, Kec. Pariaman Selatan, Kota Pariaman, Sumatera Barat.',
                        'no_telp' => '(0751) 123-456',
                        'email' => 'info@puskesmasmarunggi.pariamankota.go.id',
                        'logo' => null,
                        'jam_senin_kamis' => '08:00 - 14:00',
                        'jam_jumat' => '08:00 - 11:00',
                        'jam_sabtu' => '08:00 - 13:00',
                        'link_facebook' => 'https://www.facebook.com/hcmarunggi/',
                        'link_instagram' => 'https://www.instagram.com/puskesmasmarunggi/',
                    ]);
                }
            }
            $view->with('puskesmasSetting', $setting);
        });
    }
}
