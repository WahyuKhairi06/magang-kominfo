<?php

namespace App\Http\Controllers\Dasawisma;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class RumahController extends Controller
{
    // READ (List Data)
    public function index()
    {
        $data = DB::table('rumahs')->get();
        return view('buku.rumah.index', compact('data'));
    }

    // CREATE (Form tambah)
    public function create()
    {
        return view('buku.rumah.create');
    }

    // STORE (Simpan data)
    public function store(Request $request)
    {
        $request->validate([
            'nama_rumah' => 'required'
        ]);

        DB::table('rumahs')->insert([
            'nama_rumah' => $request->nama_rumah,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Alert::success('Berhasil', 'Data rumah berhasil ditambahkan');
        return redirect()->route('rumah.index');
    }

    // EDIT (Form edit)
    public function edit($id)
    {
        $rumah = DB::table('rumahs')->where('id', $id)->first();
        return view('buku.rumah.edit', compact('rumah'));
    }

    // UPDATE
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_rumah' => 'required'
        ]);

        DB::table('rumahs')
            ->where('id', $id)
            ->update([
                'nama_rumah' => $request->nama_rumah,
                'updated_at' => now(),
            ]);

        Alert::success('Berhasil', 'Data rumah berhasil diupdate');
        return redirect()->route('rumah.index');
    }

    // DELETE
    public function destroy($id)
    {
        DB::table('rumahs')->where('id', $id)->delete();

        Alert::success('Berhasil', 'Data rumah berhasil dihapus');
        return redirect()->route('rumah.index');
    }
}