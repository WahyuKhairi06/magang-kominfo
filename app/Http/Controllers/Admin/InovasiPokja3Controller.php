<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class InovasiPokja3Controller extends Controller
{

    // =========================
    // INDEX
    // =========================
    public function index()
    {

        $data = DB::table('inovasipokja1dan3')
            ->orderBy('id','desc')
            ->where('pokja_id',8)
            ->get();

        return view('admin.inovasipokja3.index', compact('data'));

    }

    // =========================
    // CREATE
    // =========================
    public function create()
    {

        return view('admin.inovasipokja3.create');

    }

    // =========================
    // STORE
    // =========================
    public function store(Request $request)
    {

        $request->validate([

            'file' => 'nullable|mimes:jpg,jpeg,png,pdf,doc,docx,xls,xlsx|max:10048',
            'keterangan' => 'nullable',

        ]);

        $namaFile = null;

        // =========================
        // UPLOAD FILE
        // =========================
       if($request->hasFile('file')){

    $file = $request->file('file');

    $namaFile = uniqid().'_'.time().'.'.$file->getClientOriginalExtension();

    // simpan ke: storage/app/public/inovasi
    $file->storeAs('inovasi3', $namaFile, 'public');

    // simpan ke DB dengan foldernya
    $namaFile = 'inovasi3/'.$namaFile;
}

        // =========================
        // INSERT DATABASE
        // =========================
        DB::table('inovasipokja1dan3')->insert([

            'file' => $namaFile,
            'keterangan' => $request->keterangan,
            'pokja_id' => 8,
            'created_at' => now(),
            'updated_at' => now()

        ]);

        Alert::success('Berhasil','Data berhasil ditambahkan');

        return redirect()->route('inovasipokja3.index');

    }

    // =========================
    // EDIT
    // =========================
    public function edit($id)
    {

        $data = DB::table('inovasipokja1dan3')
            ->where('id',$id)
            ->first();

        return view('admin.inovasipokja3.edit', compact('data'));

    }

    // =========================
    // UPDATE
    // =========================
    public function update(Request $request, $id)
    {

        $request->validate([

            'file' => 'nullable|mimes:jpg,jpeg,png,pdf,doc,docx,xls,xlsx|max:10048',
            'keterangan' => 'nullable',

        ]);

        $data = DB::table('inovasipokja1dan3')
            ->where('id',$id)
            ->first();

        $namaFile = $data->file;

        // =========================
        // JIKA FILE BARU DIUPLOAD
        // =========================
        if($request->hasFile('file')){

    if($data->file){
        Storage::disk('public')->delete($data->file);
    }

    $file = $request->file('file');

    $namaFileOnly = uniqid().'_'.time().'.'.$file->getClientOriginalExtension();

    $file->storeAs('inovasi3', $namaFileOnly, 'public');

    $namaFile = 'inovasi3/'.$namaFileOnly;
}

        // =========================
        // UPDATE DATABASE
        // =========================
        DB::table('inovasipokja1dan3')
            ->where('id',$id)
            ->update([

                'file' => $namaFile,
                'keterangan' => $request->keterangan,
                'pokja_id' => 8,
                'updated_at' => now()

            ]);

        Alert::success('Berhasil','Data berhasil diupdate');

        return redirect()->route('inovasipokja3.index');

    }

    // =========================
    // DELETE
    // =========================
    public function destroy($id)
    {

        $data = DB::table('inovasipokja1dan3')
            ->where('id',$id)
            ->first();

        if($data){

            // hapus file storage
            if($data->file){

                Storage::delete('public/inovasi2/'.$data->file);

            }

            // hapus database
            DB::table('inovasipokja1dan3')
                ->where('id',$id)
                ->delete();

        }

        Alert::success('Berhasil','Data berhasil dihapus');

        return redirect()->route('inovasipokja3.index');

    }

}