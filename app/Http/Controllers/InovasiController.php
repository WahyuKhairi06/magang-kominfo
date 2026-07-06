<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class InovasiController extends Controller
{

    // =========================
    // INDEX
    // =========================
public function inovasiview($id)
{
    $inovasi = Inovasi::where('id_inovasi', $id)->firstOrFail();

    return view('landing.inovasi.view', compact('inovasi'));
}

    public function index()
    {

        $data = DB::table('inovasi1')
            ->select('id_inovasi',
                     'judul_inovasi',
                     'foto',
                     'manual_book',
                     'kak',
                     'sop',
                     'makalah',
                     'linkvideo',
                     'sk',
                     'dokumen_lain',
                     'tahun_inovasi',
                     'deskripsi_inovasi')                      

            ->get();

        return view('admin.inovasi1.index', compact('data'));

    }

    // =========================
    // CREATE
    // =========================
    public function create()
    {

        return view('admin.inovasi1.create');

    }

    // =========================
    // STORE
    // =========================
    public function store(Request $request)
    {

        $request->validate([
            'judul' => 'required|string|max:255',
            'foto_inovasi' => 'nullable|mimes:jpg,jpeg,png,pdf,doc,docx,xls,xlsx|max:10048',
            'manual_book' => 'nullable|mimes:jpg,jpeg,png,pdf,doc,docx,xls,xlsx|max:10048',
            'kak' => 'nullable|mimes:jpg,jpeg,png,pdf,doc,docx,xls,xlsx|max:10048',
            'sop' => 'nullable|mimes:jpg,jpeg,png,pdf,doc,docx,xls,xlsx|max:10048',
            'makalah' => 'nullable|mimes:jpg,jpeg,png,pdf,doc,docx,xls,xlsx|max:10048',
            'link' => 'required|string|max:255',
            'skdpa' => 'nullable|mimes:jpg,jpeg,png,pdf,doc,docx,xls,xlsx|max:10048',
            'doklain' => 'nullable|mimes:jpg,jpeg,png,pdf,doc,docx,xls,xlsx|max:10048',
            'tahun' => 'required|string|max:255',
            'deskripsi' => 'nullable',

        ]);

            $namaManual = null;

            // =========================
            // UPLOAD FILE
            // =========================
        if($request->hasFile('manual_book')){

        $file = $request->file('manual_book');

        $namaManual = uniqid().'_'.time().'.'.$file->getClientOriginalExtension();

        // simpan ke: storage/app/public/inovasi
        $file->storeAs('manual-book', $namaManual, 'public');

        // simpan ke DB dengan foldernya
        $namaManual = 'manual-book/'.$namaManual;
    }
    $namaFoto = null;

            // =========================
            // UPLOAD FILE
            // =========================
        if($request->hasFile('foto_inovasi')){

        $file = $request->file('foto_inovasi');

        $namaFoto = uniqid().'_'.time().'.'.$file->getClientOriginalExtension();

        // simpan ke: storage/app/public/inovasi
        $file->storeAs('file-foto', $namaFoto, 'public');

        // simpan ke DB dengan foldernya
        $namaFoto = 'file-foto/'.$namaFoto;
    }
    $namaKak = null;

            // =========================
            // UPLOAD FILE
            // =========================
        if($request->hasFile('kak')){

        $file = $request->file('kak');

        $namaKak = uniqid().'_'.time().'.'.$file->getClientOriginalExtension();

        // simpan ke: storage/app/public/inovasi
        $file->storeAs('file-kak', $namaKak, 'public');

        // simpan ke DB dengan foldernya
        $namaKak = 'file-kak/'.$namaKak;
    }
    $namaSop = null;

            // =========================
            // UPLOAD FILE
            // =========================
        if($request->hasFile('sop')){

        $file = $request->file('sop');

        $namaSop = uniqid().'_'.time().'.'.$file->getClientOriginalExtension();

        // simpan ke: storage/app/public/inovasi
        $file->storeAs('file-sop', $namaSop, 'public');

        // simpan ke DB dengan foldernya
        $namaSop = 'file-sop/'.$namaSop;
    }
    $namaMakalah = null;

            // =========================
            // UPLOAD FILE
            // =========================
        if($request->hasFile('makalah')){

        $file = $request->file('makalah');

        $namaMakalah = uniqid().'_'.time().'.'.$file->getClientOriginalExtension();

        // simpan ke: storage/app/public/inovasi
        $file->storeAs('file-makalah', $namaMakalah, 'public');

        // simpan ke DB dengan foldernya
        $namaMakalah = 'file-makalah/'.$namaMakalah;
    }
    $namaSk = null;

            // =========================
            // UPLOAD FILE
            // =========================
        if($request->hasFile('skdpa')){

        $file = $request->file('skdpa');

        $namaSk = uniqid().'_'.time().'.'.$file->getClientOriginalExtension();

        // simpan ke: storage/app/public/inovasi
        $file->storeAs('file-sk', $namaSk, 'public');

        // simpan ke DB dengan foldernya
        $namaSk = 'file-sk/'.$namaSk;
    }

    $namaDoklain = null;

            // =========================
            // UPLOAD FILE
            // =========================
        if($request->hasFile('doklain')){

        $file = $request->file('doklain');

        $namaDoklain = uniqid().'_'.time().'.'.$file->getClientOriginalExtension();

        // simpan ke: storage/app/public/inovasi
        $file->storeAs('dokumen-lain', $namaDoklain, 'public');

        // simpan ke DB dengan foldernya
        $namaDoklain = 'dokumen-lain/'.$namaDoklain;
    }

        // =========================judul
        // INSERT DATABASE
        // =========================
       
        $data=DB::table('inovasi1')->insert([
            'judul_inovasi' => $request->judul,
            'manual_book' => $namaManual,
            'foto' => $namaFoto,
            'kak' => $namaKak,
            'sop' => $namaSop,
            'makalah' => $namaMakalah,
            'sk' => $namaSk,
            'linkvideo' => $request->link,
            'dokumen_lain' => $namaDoklain,
            'tahun_inovasi' => $request->tahun,
            'deskripsi_inovasi' => $request->deskripsi,
        ]);

        Alert::success('Berhasil','Data berhasil ditambahkan');

        return redirect()->route('inovasi1.index');

    }

    // =========================
    // EDIT
    // =========================
    public function edit($id)
    {

        $data = DB::table('inovasi1')
            ->where('id_inovasi',$id)
            ->first();

        return view('admin.inovasi1.edit', compact('data'));

    }

    // =========================
    // UPDATE
    // =========================
    public function update(Request $request, $id)
    {

        $request->validate([

            'judul' => 'required|string|max:255',
            'foto_inovasi' => 'nullable|mimes:jpg,jpeg,png,pdf,doc,docx,xls,xlsx|max:10048',
            'manual_book' => 'nullable|mimes:jpg,jpeg,png,pdf,doc,docx,xls,xlsx|max:10048',
            'kak' => 'nullable|mimes:jpg,jpeg,png,pdf,doc,docx,xls,xlsx|max:10048',
            'sop' => 'nullable|mimes:jpg,jpeg,png,pdf,doc,docx,xls,xlsx|max:10048',
            'makalah' => 'nullable|mimes:jpg,jpeg,png,pdf,doc,docx,xls,xlsx|max:10048',
            'link' => 'required|string|max:255',
            'skdpa' => 'nullable|mimes:jpg,jpeg,png,pdf,doc,docx,xls,xlsx|max:10048',
            'doklain' => 'nullable|mimes:jpg,jpeg,png,pdf,doc,docx,xls,xlsx|max:10048',
            'tahun' => 'required|string|max:255',
            'deskripsi' => 'nullable',

        ]);

        $data = DB::table('inovasi1')
            ->where('id_inovasi',$id)
            ->first();

        $namaManual = $data->manual_book;

        // =========================
        // JIKA FILE BARU DIUPLOAD
        // =========================
        if($request->hasFile('manual_book')){

    if($data->manual_book){
        Storage::disk('public')->delete($data->manual_book);
    }

    $file = $request->file('manual_book');

    $nama  = uniqid().'_'.time().'.'.$file->getClientOriginalExtension();

    $file->storeAs('manual-book', $nama , 'public');

    $namaManual = 'manual-book/'.$nama ;
}
$namaFoto = $data->foto;

        // =========================
        // JIKA FILE BARU DIUPLOAD
        // =========================
        if($request->hasFile('foto_inovasi')){

    if($data->foto){
        Storage::disk('public')->delete($data->foto);
    }

    $file = $request->file('foto_inovasi');

    $nama  = uniqid().'_'.time().'.'.$file->getClientOriginalExtension();

    $file->storeAs('file-foto', $nama , 'public');

    $namaFoto = 'file-foto/'.$nama ;
}
$namaKak = $data->kak;

        // =========================
        // JIKA FILE BARU DIUPLOAD
        // =========================
        if($request->hasFile('kak')){

    if($data->kak){
        Storage::disk('public')->delete($data->kak);
    }

    $file = $request->file('kak');

    $nama  = uniqid().'_'.time().'.'.$file->getClientOriginalExtension();

    $file->storeAs('file-kak', $nama , 'public');

    $namaKak = 'file-kak/'.$nama ;
}
$namaSop = $data->sop;

        // =========================
        // JIKA FILE BARU DIUPLOAD
        // =========================
        if($request->hasFile('sop')){

    if($data->sop){
        Storage::disk('public')->delete($data->sop);
    }

    $file = $request->file('sop');

    $nama  = uniqid().'_'.time().'.'.$file->getClientOriginalExtension();

    $file->storeAs('file-sop', $nama , 'public');

    $namaSop = 'file-sop/'.$nama ;
}
$namaMakalah = $data->makalah;

        // =========================
        // JIKA FILE BARU DIUPLOAD
        // =========================
        if($request->hasFile('makalah')){

    if($data->makalah){
        Storage::disk('public')->delete($data->makalah);
    }

    $file = $request->file('makalah');

    $nama  = uniqid().'_'.time().'.'.$file->getClientOriginalExtension();

    $file->storeAs('file-makalah', $nama , 'public');

    $namaMakalah = 'file-makalah/'.$nama ;
}
$namaSkdpa = $data->sk;

        // =========================
        // JIKA FILE BARU DIUPLOAD
        // =========================
        if($request->hasFile('skdpa')){

    if($data->sk){
        Storage::disk('public')->delete($data->sk);
    }

    $file = $request->file('skdpa');

    $nama  = uniqid().'_'.time().'.'.$file->getClientOriginalExtension();

    $file->storeAs('file-sk', $nama , 'public');

    $namaSkdpa = 'file-sk/'.$nama ;
}
$namaDoklain = $data->dokumen_lain;

        // =========================
        // JIKA FILE BARU DIUPLOAD
        // =========================
        if($request->hasFile('doklain')){

    if($data->dokumen_lain){
        Storage::disk('public')->delete($data->dokumen_lain);
    }

    $file = $request->file('doklain');

    $nama  = uniqid().'_'.time().'.'.$file->getClientOriginalExtension();

    $file->storeAs('dokumen-lain', $nama , 'public');

    $namaDoklain = 'dokumen-lain/'.$nama ;
}
        // =========================
        // UPDATE DATABASE
        // =========================
        DB::table('inovasi1')
            ->where('id_inovasi',$id)
            ->update([

            'judul_inovasi' => $request->judul,
            'manual_book' => $namaManual,
            'kak' => $namaKak,
            'sop' => $namaSop,
            'makalah' => $namaMakalah,
            'sk' => $namaSkdpa,
            'linkvideo' => $request->link,
            'dokumen_lain' => $namaDoklain,
            'tahun_inovasi' => $request->tahun,
            'deskripsi_inovasi' => $request->deskripsi,
            

            ]);

        Alert::success('Berhasil','Data berhasil diupdate');

        return redirect()->route('inovasi1.index');

    }

    public function show($id)
{
    $data = DB::table('inovasi1')
        ->where('id_inovasi', $id)
        ->first();

    return view('admin.inovasi1.show', compact('data'));
}

    // =========================
    // DELETE
    // =========================
    public function destroy($id)
    {

        $data = DB::table('inovasi1')
            ->where('id_inovasi',$id)
            ->first();

        if($data){

            // hapus file storage
            if($data->manual_book){

                Storage::delete('public/inovasi/'.$data->manual_book);

            }

            // hapus database
            DB::table('inovasi1')
                ->where('id_inovasi',$id)
                ->delete();

        }

        Alert::success('Berhasil','Data berhasil dihapus');

        return redirect()->route('inovasi1.index');

    }

}