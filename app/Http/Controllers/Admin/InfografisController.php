<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class InfografisController extends Controller
{
    // =====================
    // INDEX
    // =====================
    public function index()
    {
        $data = DB::table('infografis')
            ->orderBy('id', 'desc')
            ->get();

        return view('admin.infografis.index', compact('data'));
    }

    // =====================
    // CREATE
    // =====================
    public function create()
    {
        return view('admin.infografis.create');
    }

    // =====================
    // STORE
    // =====================
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'keterangan' => 'nullable',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
        ]);

        $fileName = null;

        if ($request->hasFile('foto')) {

            $file = $request->file('foto');

            // format: random_unix.jpg
            $fileName = uniqid().'_'.time().'.'.$file->getClientOriginalExtension();

            // simpan ke storage/app/public/infografis
            $file->storeAs('public/infografis', $fileName);
        }

        DB::table('infografis')->insert([
            'nama' => $request->nama,
            'keterangan' => $request->keterangan,
            'foto' => $fileName,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Alert::success('Berhasil', 'Data infografis berhasil ditambahkan');

        return redirect()->route('infografis.index');
    }

    // =====================
    // EDIT
    // =====================
    public function edit($id)
    {
        $data = DB::table('infografis')
            ->where('id', $id)
            ->first();

        return view('admin.infografis.edit', compact('data'));
    }

    // =====================
    // UPDATE
    // =====================
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required',
            'keterangan' => 'nullable',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
        ]);

        $data = DB::table('infografis')->where('id', $id)->first();

        $fileName = $data->foto;

        if ($request->hasFile('foto')) {

            // hapus file lama
            if ($fileName) {
                Storage::delete('public/infografis/'.$fileName);
            }

            $file = $request->file('foto');

            $fileName = uniqid().'_'.time().'.'.$file->getClientOriginalExtension();

            $file->storeAs('public/infografis', $fileName);
        }

        DB::table('infografis')
            ->where('id', $id)
            ->update([
                'nama' => $request->nama,
                'keterangan' => $request->keterangan,
                'foto' => $fileName,
                'updated_at' => now(),
            ]);

        Alert::success('Berhasil', 'Data berhasil diupdate');

        return redirect()->route('infografis.index');
    }

    // =====================
    // DELETE
    // =====================
    public function destroy($id)
    {
        $data = DB::table('infografis')->where('id', $id)->first();

        if ($data) {

            if ($data->foto) {
                Storage::delete('public/infografis/'.$data->foto);
            }

            DB::table('infografis')->where('id', $id)->delete();
        }

        Alert::success('Berhasil', 'Data berhasil dihapus');

        return redirect()->route('infografis.index');
    }
}