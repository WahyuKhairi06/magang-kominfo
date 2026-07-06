<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Carbon\Carbon;

class BeritaController extends Controller
{
    public function index()
    {
        // try {
            $berita = DB::table('beritas')
                ->join('users', 'users.id', '=', 'beritas.user_id')
                ->leftJoin('kategori_beritas', 'kategori_beritas.id', '=', 'beritas.kategori_id')
                ->select(
                    'beritas.*',
                    'users.name as penulis',
                    'kategori_beritas.nama'
                )
                ->orderBy('beritas.id', 'desc')
                ->get();

            return view('admin.beritapage.index', compact('berita'));

        // } catch (\Exception $e) {
        //     Alert::error('Gagal', 'Tidak dapat memuat data berita');
        //     return back();
        // }
    }

    public function create()
    {
        try {
            $kategori = DB::table('kategori_beritas')->get();
            return view('admin.beritapage.tambah', compact('kategori'));
        } catch (\Exception $e) {
            Alert::error('Gagal', 'Tidak dapat membuka form');
            return back();
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'isi' => 'required',
            'kategori_id' => 'nullable',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'status' => 'required'
        ]);

        try {
            $gambar = null;

            if ($request->hasFile('gambar')) {
                $gambar = $request->file('gambar')->store('berita', 'public');
            }

            DB::table('beritas')->insert([
                'judul' => $request->judul,
                'slug' => Str::slug($request->judul),
                'isi' => $request->isi,
                'gambar' => $gambar,
                'user_id' => auth()->id(),
                'kategori_id' => $request->kategori_id,
                'status' => $request->status,
                'tanggal_publish' => $request->status == 'publish' ? Carbon::now() : null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            Alert::success('Berhasil', 'Berita berhasil ditambahkan');
            return redirect()->route('beritapage.index');

        } catch (\Exception $e) {
            Alert::error('Gagal', 'Data gagal disimpan'.$e);
            return back();
        }
    }

    public function edit($id)
    {
        try {
            $berita = DB::table('beritas')->where('id', $id)->first();
            $kategori = DB::table('kategori_beritas')->get();

            return view('admin.beritapage.edit', compact('berita', 'kategori'));

        } catch (\Exception $e) {
            Alert::error('Gagal', 'Data tidak ditemukan');
            return back();
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required',
            'isi' => 'required',
            'kategori_id' => 'nullable',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'status' => 'required'
        ]);

        try {
            $data = [
                'judul' => $request->judul,
                'slug' => Str::slug($request->judul),
                'isi' => $request->isi,
                'kategori_id' => $request->kategori_id,
                'status' => $request->status,
                'tanggal_publish' => $request->tanggal_publish,
                'updated_at' => now(),
            ];

            if ($request->hasFile('gambar')) {
                $data['gambar'] = $request->file('gambar')->store('berita', 'public');
            }

            DB::table('beritas')->where('id', $id)->update($data);

            Alert::success('Berhasil', 'Berita berhasil diupdate');
            return redirect()->route('beritapage.index');

        } catch (\Exception $e) {
            Alert::error('Gagal', 'Data gagal diupdate');
            return back();
        }
    }

    public function destroy($id)
    {
        try {
            DB::table('beritas')->where('id', $id)->delete();

            Alert::success('Berhasil', 'Berita berhasil dihapus');
            return back();

        } catch (\Exception $e) {
            Alert::error('Gagal', 'Data gagal dihapus');
            return back();
        }
    }

    // optional: detail berita + auto increment views
    public function show($id)
    {
        try {
            DB::table('beritas')->where('id', $id)->increment('views');

            $berita = DB::table('beritas')
                ->join('users', 'users.id', '=', 'beritas.user_id')
                ->leftJoin('kategoris', 'kategoris.id', '=', 'beritas.kategori_id')
                ->select(
                    'beritas.*',
                    'users.name as penulis',
                    'kategoris.nama_kategori'
                )
                ->where('beritas.id', $id)
                ->first();

            return view('admin.beritapage.show', compact('berita'));

        } catch (\Exception $e) {
            Alert::error('Gagal', 'Data tidak ditemukan');
            return back();
        }
    }
}