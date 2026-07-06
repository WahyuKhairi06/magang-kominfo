<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Carbon\Carbon;

class AgendaController extends Controller
{
    // ✅ LIST DATA
    public function index()
    {
        $data = DB::table('agendas')->orderBy('tanggal', 'desc')->get();
        return view('admin.agenda.index', compact('data'));
    }

    // ✅ FORM CREATE
    public function create()
    {
        return view('admin.agenda.create');
    }

    // ✅ STORE
    public function store(Request $request)
    {
        $request->validate([
            'judul_agenda' => 'required',
            'tanggal' => 'required|date',
        ]);

        DB::beginTransaction();

        try {

            DB::table('agendas')->insert([
                'judul_agenda' => $request->judul_agenda,
                'tanggal' => $request->tanggal,
                'jam_mulai' => $request->jam_mulai,
                'jam_selesai' => $request->jam_selesai,
                'lokasi' => $request->lokasi,
                'deskripsi' => $request->deskripsi,
                'penyelenggara' => $request->penyelenggara,
                'status' => $request->status ?? 'upcoming',
                'created_at' => now(),
                'updated_at' => now()
            ]);

            DB::commit();

            Alert::success('Berhasil', 'Agenda berhasil ditambahkan');
            return redirect()->route('agenda.index');

        } catch (\Exception $e) {

            DB::rollBack();

            Alert::error('Gagal', $e->getMessage());
            return back()->withInput();
        }
    }

    // ✅ FORM EDIT
    public function edit($id)
    {
        $data = DB::table('agendas')->where('id', $id)->first();
        return view('admin.agenda.edit', compact('data'));
    }

    // ✅ UPDATE
    public function update(Request $request, $id)
    {
        $request->validate([
            'judul_agenda' => 'required',
            'tanggal' => 'required|date',
        ]);

        DB::beginTransaction();

        try {

            DB::table('agendas')->where('id', $id)->update([
                'judul_agenda' => $request->judul_agenda,
                'tanggal' => $request->tanggal,
                'jam_mulai' => $request->jam_mulai,
                'jam_selesai' => $request->jam_selesai,
                'lokasi' => $request->lokasi,
                'deskripsi' => $request->deskripsi,
                'penyelenggara' => $request->penyelenggara,
                'status' => $request->status,
                'updated_at' => now()
            ]);

            DB::commit();

            Alert::success('Berhasil', 'Agenda berhasil diupdate');
            return redirect()->route('agenda.index');

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

            DB::table('agendas')->where('id', $id)->delete();

            DB::commit();

            Alert::success('Berhasil', 'Agenda berhasil dihapus');
            return redirect()->route('agenda.index');

        } catch (\Exception $e) {

            DB::rollBack();

            Alert::error('Gagal', $e->getMessage());
            return back();
        }
    }
}