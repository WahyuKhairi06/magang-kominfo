<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Storage;

class FaqController extends Controller
{
    public function index()
    {
        $data = DB::table('faqs')
            ->select('pertanyaan',
                     'jawaban', 'id')                      

            ->get();

        return view('admin.faq.index', compact('data'));
    }

    public function create()
    {
        return view('admin.faq.create');
    }

    public function store(Request $request)
{
    $request->validate([
        'pertanyaan' => 'required',
        'jawaban' => 'required',
    ]);

    DB::table('faqs')->insert([
        'pertanyaan' => $request->pertanyaan,
        'jawaban' => $request->jawaban,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    return redirect()->route('faq.index')
        ->with('success', 'FAQ berhasil ditambahkan');
}

    public function edit($id)
    {

        $data = DB::table('faqs')
            ->where('id',$id)
            ->first();

        return view('admin.faq.edit', compact('data'));

    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'pertanyaan' => 'required',
            'jawaban' => 'required',
        ]);

        DB::table('faqs')
            ->where('id', $id)
            ->update([
                'pertanyaan' => $request->pertanyaan,
                'jawaban' => $request->jawaban,
                'updated_at' => now(),
            ]);

        return redirect()->route('faq.index')
            ->with('success', 'FAQ berhasil diupdate');
    }

    public function destroy($id)
    {
        DB::table('faqs')->where('id', $id)->delete();

        return back()->with('success', 'Faq berhasil dihapus');
    }
}