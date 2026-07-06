<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Storage;

class SliderController extends Controller
{
    // ✅ LIST
    public function index()
    {
        $data = DB::table('sliders')->orderBy('urutan', 'asc')->get();
        return view('admin.slider.index', compact('data'));
    }

    // ✅ FORM CREATE
    public function create()
    {
        return view('admin.slider.create');
    }

    // ✅ STORE
    public function store(Request $request)
    {
        $request->validate([
            'gambar' => 'required|image|mimes:jpg,jpeg,png|max:5048'
        ]);

        DB::beginTransaction();

        try {

            // upload gambar
            $path = $request->file('gambar')->store('slider', 'public');

            DB::table('sliders')->insert([
                'judul' => $request->judul,
                'sub_judul' => $request->sub_judul,
                'gambar' => $path,
                'link' => $request->link,
                'urutan' => $request->urutan ?? 0,
                'is_active' => $request->is_active ?? 1,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            DB::commit();

            Alert::success('Berhasil', 'Slider berhasil ditambahkan');
            return redirect()->route('slider.index');

        } catch (\Exception $e) {

            DB::rollBack();

            Alert::error('Gagal', $e->getMessage());
            return back()->withInput();
        }
    }

    // ✅ EDIT
    public function edit($id)
    {
        $data = DB::table('sliders')->where('id', $id)->first();
        return view('admin.slider.edit', compact('data'));
    }

    // ✅ UPDATE
    public function update(Request $request, $id)
    {
        $request->validate([
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        DB::beginTransaction();

        try {

            $data = DB::table('sliders')->where('id', $id)->first();

            $path = $data->gambar;

            // jika upload gambar baru
            if ($request->hasFile('gambar')) {

                // hapus lama
                if ($data->gambar && Storage::disk('public')->exists($data->gambar)) {
                    Storage::disk('public')->delete($data->gambar);
                }

                $path = $request->file('gambar')->store('slider', 'public');
            }

            DB::table('sliders')->where('id', $id)->update([
                'judul' => $request->judul,
                'sub_judul' => $request->sub_judul,
                'gambar' => $path,
                'link' => $request->link,
                'urutan' => $request->urutan ?? 0,
                'is_active' => $request->is_active ?? 0,
                'updated_at' => now()
            ]);

            DB::commit();

            Alert::success('Berhasil', 'Slider berhasil diupdate');
            return redirect()->route('slider.index');

        } catch (\Exception $e) {

            DB::rollBack();

            Alert::error('Gagal', $e->getMessage());
            return back()->withInput();
        }
    }

    // ✅ DELETE
    public function destroy($id)
    {
        DB::beginTransaction();

        try {

            $data = DB::table('sliders')->where('id', $id)->first();

            // hapus file gambar
            if ($data->gambar && Storage::disk('public')->exists($data->gambar)) {
                Storage::disk('public')->delete($data->gambar);
            }

            DB::table('sliders')->where('id', $id)->delete();

            DB::commit();

            Alert::success('Berhasil', 'Slider berhasil dihapus');
            return redirect()->route('slider.index');

        } catch (\Exception $e) {

            DB::rollBack();

            Alert::error('Gagal', $e->getMessage());
            return back();
        }
    }
}