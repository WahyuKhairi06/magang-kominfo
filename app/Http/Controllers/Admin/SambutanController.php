<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class SambutanController extends Controller
{
    public function index()
    {
        $data = DB::table('sambutans')->latest()->get();
        return view('admin.sambutan.index', compact('data'));
    }

    public function create()
    {
        return view('admin.sambutan.create');
    }

    public function store(Request $request)
    {
        $foto = null;

        if ($request->hasFile('foto')) {
            $foto = $request->file('foto')->store('sambutan', 'public');
        }

        DB::table('sambutans')->insert([
            'judul' => $request->judul,
            'isi' => $request->isi,
            'nama' => $request->nama,
            'motto' => $request->motto,
            'foto' => $foto,
            'created_at' => now()
        ]);

        Alert::success('Berhasil', 'Data berhasil ditambahkan');
        return redirect()->route('sambutan.index');
    }

    public function edit($id)
    {
        $data = DB::table('sambutans')->where('id', $id)->first();
        return view('admin.sambutan.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $data = DB::table('sambutans')->where('id', $id)->first();

        $foto = $data->foto;

        if ($request->hasFile('foto')) {
            $foto = $request->file('foto')->store('sambutan', 'public');
        }

        DB::table('sambutans')->where('id', $id)->update([
            'judul' => $request->judul,
            'isi' => $request->isi,
            'nama' => $request->nama,
            'motto' => $request->motto,
            'foto' => $foto,
            'updated_at' => now()
        ]);

        Alert::success('Berhasil', 'Data berhasil diupdate');
        return redirect()->route('sambutan.index');
    }

    public function destroy($id)
    {
        DB::table('sambutans')->where('id', $id)->delete();

        Alert::success('Berhasil', 'Data berhasil dihapus');
        return back();
    }
}