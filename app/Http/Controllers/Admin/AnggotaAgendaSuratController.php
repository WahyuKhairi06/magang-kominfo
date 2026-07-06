<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Barryvdh\DomPDF\Facade\Pdf;

class AnggotaAgendaSuratController extends Controller
{


public function cetak($id)
{
    $data = DB::table('anggota_agenda_surats')
        ->leftJoin('buku_agenda_surats','anggota_agenda_surats.buku_agenda_id','=','buku_agenda_surats.id')
        ->leftJoin('desas','buku_agenda_surats.desa_id','=','desas.id')
        ->leftJoin('kecamatans','buku_agenda_surats.kecamatan_id','=','kecamatans.id')
        ->leftJoin('dusuns','buku_agenda_surats.dusun_id','=','dusuns.id')
        ->select(
            'anggota_agenda_surats.*',
            'desas.nama_desa',
            'kecamatans.nama_kecamatan',
            'dusuns.nama_dusun',
            'buku_agenda_surats.tahun'
        )
        ->where('anggota_agenda_surats.buku_agenda_id',$id)
        ->get();

    $pdf = Pdf::loadView('admin.agendaanggota.pdf', compact('data'))
        ->setPaper('A4','landscape');

    return $pdf->stream('agenda-surat.pdf');
}
    public function index($id)
    {
        $data = DB::table('anggota_agenda_surats')
        ->leftjoin('buku_agenda_surats','anggota_agenda_surats.buku_agenda_id','=','buku_agenda_surats.id')
          ->leftJoin('kecamatans','buku_agenda_surats.kecamatan_id','=','kecamatans.id')
            ->leftJoin('dusuns','buku_agenda_surats.dusun_id','=','dusuns.id')
                        ->leftJoin('desas','buku_agenda_surats.desa_id','=','desas.id')

        ->select('anggota_agenda_surats.*',
         'desas.nama_desa',
                'kecamatans.nama_kecamatan',
                'dusuns.nama_dusun'
        )
        ->where('anggota_agenda_surats.buku_agenda_id',$id)
        ->latest()->get();

        return view('admin.agendaanggota.index', compact('data'));
    }

    public function create($id)
    {
        $data=DB::table('buku_agenda_surats')->where('id',$id)->first();
        return view('admin.agendaanggota.create',compact('data'));
    }

    public function store(Request $request)
    {
        DB::table('anggota_agenda_surats')->insert([
            'tanggal_terima_surat' => $request->tanggal_terima_surat,
            'buku_agenda_id' => $request->buku_agenda_id,
            'tanggal_surat_masuk' => $request->tanggal_surat_masuk,
            'nomor_surat_diterima' => $request->nomor_surat_diterima,
            'dari' => $request->dari,
            'perihal_masuk' => $request->perihal_masuk,
            'lampiran_masuk' => $request->lampiran_masuk,
            'diteruskan_kepada' => $request->diteruskan_kepada,

            'nomor_surat' => $request->nomor_surat,
            'tanggal_surat_keluar' => $request->tanggal_surat_keluar,
            'kepada' => $request->kepada,
            'perihal_keluar' => $request->perihal_keluar,
            'lampiran_keluar' => $request->lampiran_keluar,
            'tembusan' => $request->tembusan,

            'created_at' => now(),
            'updated_at' => now()
        ]);

        Alert::success('Berhasil', 'Data berhasil disimpan');
        return redirect('agenda-surat'.'/'.$request->buku_agenda_id);
    }

    public function edit($id)
    {
        $data = DB::table('anggota_agenda_surats')->where('id', $id)->first();
        return view('admin.agendaanggota.edit', compact('data','id'));
    }

    public function update(Request $request, $id)
    {
        DB::table('anggota_agenda_surats')->where('id', $id)->update([
            'tanggal_terima_surat' => $request->tanggal_terima_surat,
            'tanggal_surat_masuk' => $request->tanggal_surat_masuk,
            'nomor_surat_diterima' => $request->nomor_surat_diterima,
            'dari' => $request->dari,
            'perihal_masuk' => $request->perihal_masuk,
            'lampiran_masuk' => $request->lampiran_masuk,
            'diteruskan_kepada' => $request->diteruskan_kepada,

            'nomor_surat' => $request->nomor_surat,
            'tanggal_surat_keluar' => $request->tanggal_surat_keluar,
            'kepada' => $request->kepada,
            'perihal_keluar' => $request->perihal_keluar,
            'lampiran_keluar' => $request->lampiran_keluar,
            'tembusan' => $request->tembusan,

            'updated_at' => now()
        ]);

        Alert::success('Berhasil', 'Data berhasil diupdate');
        return redirect('buku-agenda');
    }

    public function destroy($id)
    {
        DB::table('anggota_agenda_surats')->where('id', $id)->delete();

        Alert::success('Berhasil', 'Data berhasil dihapus');
        return back();
    }
}