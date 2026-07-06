<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Storage;

class DokumenController extends Controller
{
    // ✅ LIST
    public function index()
    {
        $data = DB::table('dokumen')->latest()->get();
        return view('admin.dokumen.index', compact('data'));
    }

    // ✅ FORM CREATE
    public function create()
    {
        return view('admin.dokumen.create');
    }

    // ✅ STORE
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'file' => 'required|mimes:pdf,doc,docx,xls,xlsx,zip|max:5120'
        ]);

        DB::beginTransaction();

        try {

            // upload file ke storage/dokumen
            $path = $request->file('file')->store('dokumen', 'public');

            DB::table('dokumen')->insert([
                'judul' => $request->judul,
                'kategori' => $request->kategori,
                'deskripsi' => $request->deskripsi,
                'file' => $path,
                'jumlah_download' => 0,
                'is_active' => $request->is_active ?? 1,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            DB::commit();

            Alert::success('Berhasil', 'Dokumen berhasil ditambahkan');
            return redirect()->route('dokumen.index');

        } catch (\Exception $e) {

            DB::rollBack();

            Alert::error('Gagal', $e->getMessage());
            return back()->withInput();
        }
    }

    // ✅ EDIT
    public function edit($id)
    {
        $data = DB::table('dokumen')->where('id', $id)->first();
        return view('admin.dokumen.edit', compact('data'));
    }

    // ✅ UPDATE
    public function update(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required',
            'file' => 'nullable|mimes:pdf,doc,docx,xls,xlsx,zip|max:5120'
        ]);

        DB::beginTransaction();

        try {

            $data = DB::table('dokumen')->where('id', $id)->first();

            $path = $data->file;

            // jika upload file baru
            if ($request->hasFile('file')) {

                // hapus file lama
                if ($data->file && Storage::disk('public')->exists($data->file)) {
                    Storage::disk('public')->delete($data->file);
                }

                $path = $request->file('file')->store('dokumen', 'public');
            }

            DB::table('dokumen')->where('id', $id)->update([
                'judul' => $request->judul,
                'kategori' => $request->kategori,
                'deskripsi' => $request->deskripsi,
                'file' => $path,
                'is_active' => $request->is_active ?? 1,
                'updated_at' => now()
            ]);

            DB::commit();

            Alert::success('Berhasil', 'Dokumen berhasil diupdate');
            return redirect()->route('dokumen.index');

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

            $data = DB::table('dokumen')->where('id', $id)->first();

            // hapus file
            if ($data->file && Storage::disk('public')->exists($data->file)) {
                Storage::disk('public')->delete($data->file);
            }

            DB::table('dokumen')->where('id', $id)->delete();

            DB::commit();

            Alert::success('Berhasil', 'Dokumen berhasil dihapus');
            return redirect()->route('dokumen.index');

        } catch (\Exception $e) {

            DB::rollBack();

            Alert::error('Gagal', $e->getMessage());
            return back();
        }
    }

    // ✅ DOWNLOAD (bonus)
    public function download($id)
    {
        $data = DB::table('dokumen')->where('id', $id)->first();

        // tambah jumlah download
        DB::table('dokumen')->where('id', $id)->increment('jumlah_download');

        return response()->download(storage_path('app/public/' . $data->file));
    }
}