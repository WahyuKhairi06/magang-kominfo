<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PuskesmasSetting;
use Illuminate\Support\Facades\Storage;

class PuskesmasSettingController extends Controller
{
    public function index()
    {
        $setting = PuskesmasSetting::firstOrCreate(['id' => 1], [
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

        return view('admin.puskesmas-setting.index', compact('setting'));
    }

    public function update(Request $request)
    {
        $setting = PuskesmasSetting::first();

        $request->validate([
            'nama_puskesmas' => 'required|string|max:150',
            'kabupaten_kota' => 'required|string|max:150',
            'alamat' => 'required|string',
            'no_telp' => 'required|string|max:50',
            'email' => 'required|email|max:150',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'jam_senin_kamis' => 'required|string|max:100',
            'jam_jumat' => 'required|string|max:100',
            'jam_sabtu' => 'required|string|max:100',
            'link_facebook' => 'nullable|url|max:255',
            'link_instagram' => 'nullable|url|max:255',
        ]);

        $data = $request->except(['_token', '_method', 'logo']);

        if ($request->hasFile('logo')) {
            // Hapus logo lama jika ada
            if ($setting->logo && file_exists(public_path($setting->logo))) {
                @unlink(public_path($setting->logo));
            }

            $file = $request->file('logo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/puskesmas'), $filename);
            $data['logo'] = 'uploads/puskesmas/' . $filename;
        }

        $setting->update($data);

        return redirect()->route('puskesmas-setting.index')->with('success', 'Identitas Puskesmas berhasil diperbarui!');
    }
}
