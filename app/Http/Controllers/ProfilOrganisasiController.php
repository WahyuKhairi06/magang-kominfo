<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class ProfilOrganisasiController extends Controller
{
    // =========================
    // INDEX
    // =========================
    public function index()
    {
        $data = DB::table('profil_struktur_organisasi')
            ->orderBy('urutan','asc')
            ->get();

        return view('admin.profil_organisasi.index', compact('data'));
    }

    // =========================
    // CREATE
    // =========================
    public function create()
    {
        return view('admin.profil_organisasi.create');
    }

    // =========================
    // STORE
    // =========================
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'jabatan' => 'required',
            'urutan' => 'nullable|integer',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $fileName = null;

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');

            $fileName = uniqid().'_'.time().'.'.$file->getClientOriginalExtension();

            $file->storeAs('public/organisasi', $fileName);
        }

        DB::table('profil_struktur_organisasi')->insert([
            'nama' => $request->nama,
            'jabatan' => $request->jabatan,
            'urutan' => $request->urutan ?? 0,
            'foto' => $fileName,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Alert::success('Berhasil', 'Data organisasi berhasil ditambahkan');

        return redirect()->route('organisasi.index');
    }

    // =========================
    // EDIT
    // =========================
    public function edit($id)
    {
        $data = DB::table('profil_struktur_organisasi')
            ->where('id',$id)
            ->first();

        return view('admin.profil_organisasi.edit', compact('data'));
    }

    // =========================
    // UPDATE
    // =========================
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required',
            'jabatan' => 'required',
            'urutan' => 'nullable|integer',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $data = DB::table('profil_struktur_organisasi')
            ->where('id',$id)
            ->first();

        $fileName = $data->foto;

        if ($request->hasFile('foto')) {

            if ($data->foto) {
                Storage::delete('public/organisasi/'.$data->foto);
            }

            $file = $request->file('foto');
            $fileName = uniqid().'_'.time().'.'.$file->getClientOriginalExtension();

            $file->storeAs('public/organisasi', $fileName);
        }

        DB::table('profil_struktur_organisasi')
            ->where('id',$id)
            ->update([
                'nama' => $request->nama,
                'jabatan' => $request->jabatan,
                'urutan' => $request->urutan ?? 0,
                'foto' => $fileName,
                'updated_at' => now(),
            ]);

        Alert::success('Berhasil', 'Data berhasil diupdate');

        return redirect()->route('organisasi.index');
    }

    // =========================
    // DELETE
    // =========================
    public function destroy($id)
    {
        $data = DB::table('profil_struktur_organisasi')
            ->where('id',$id)
            ->first();

        if ($data) {

            if ($data->foto) {
                Storage::delete('public/organisasi/'.$data->foto);
            }

            DB::table('profil_struktur_organisasi')
                ->where('id',$id)
                ->delete();
        }

        Alert::success('Berhasil', 'Data berhasil dihapus');

        return redirect()->route('organisasi.index');
    }
}