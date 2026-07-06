<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class HalamanController extends Controller
{
    public function index()
    {
        $data = DB::table('halamen')
                ->leftjoin('kategori_halamen','halamen.kategori_halaman_id','=','kategori_halamen.id')
                ->select('halamen.*','kategori_halamen.nama as nama_kategori')
                ->get();

                $kategori=DB::table('kategori_halamen')->get();
        return view('admin.halaman.index', compact('data','kategori'));
    }

    public function create()
    {
                        $kategori=DB::table('kategori_halamen')->get();

        return view('admin.halaman.create',compact('kategori'));
    }

    public function store(Request $request)
    {
        DB::table('halamen')->insert([
            'judul' => $request->judul,
            'kategori_halaman_id' => $request->kategori_halaman_id,
            'isi' => $request->isi,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Alert::success('Sukses', 'Data berhasil ditambahkan');
        return redirect('halaman');
    }

    public function edit($id)
    {
        $data = DB::table('halamen')->where('id', $id)->first();
                        $kategori=DB::table('kategori_halamen')->get();

        return view('admin.halaman.edit', compact('data','kategori'));
    }

    public function update(Request $request, $id)
    {
        DB::table('halamen')->where('id', $id)->update([
            'judul' => $request->judul,
            'kategori_halaman_id' => $request->kategori_halaman_id,
            'isi' => $request->isi,
            'updated_at' => now(),
        ]);

        Alert::success('Sukses', 'Data berhasil diupdate');
        return redirect('/halaman');
    }

    public function delete($id)
    {
        DB::table('halamen')->where('id', $id)->delete();

        Alert::success('Sukses', 'Data berhasil dihapus');
        return back();
    }

    // 🔥 UPLOAD CKEDITOR IMAGE
   public function uploadImage(Request $request)
{
    if ($request->hasFile('upload')) {

        $file = $request->file('upload');
        $filename = time() . '_' . $file->getClientOriginalName();

        $file->move(public_path('uploads'), $filename);

        $url = asset('uploads/' . $filename);

        return response()->json([
            'uploaded' => true,
            'url' => $url
        ]);
    }

    return response()->json([
        'uploaded' => false,
        'error' => [
            'message' => 'Upload gagal'
        ]
    ]);
}

    public function hapus($id)
    {

           $hapus= DB::table('halamen')->where('id', $id)->first();
           $hapus->delete();

           Alert::success('Berhasil','Data Berhasil Dihapus');
           return redirect('halaman');



    }
}