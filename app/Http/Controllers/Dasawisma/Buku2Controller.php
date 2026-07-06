<?php

namespace App\Http\Controllers\Dasawisma;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Barryvdh\DomPDF\Facade\Pdf;

class Buku2Controller extends Controller
{

public function cetak($id)
{
    $data = DB::table('buku_catatan_datas')
        ->join('dasawismas','buku_catatan_datas.id_dasawisma','=','dasawismas.id')
        ->leftJoin('desas as de', 'dasawismas.desa_id', '=', 'de.id')
        ->select(
            'buku_catatan_datas.*',
            'dasawismas.nama_dasawisma',
            'dasawismas.tahun as tahun_daswisma',
            'de.nama_desa'
        )
        ->where('buku_catatan_datas.id_dasawisma',$id)
        ->latest()
        ->get();

    $pdf = Pdf::loadView('dasawisma.buku2.pdf', compact('data'))
        ->setPaper('A4', 'landscape'); // penting biar muat

    return $pdf->stream('buku2.pdf');
}
    public function index($id)
    {
        $data = DB::table('buku_catatan_datas')
            ->join('dasawismas','buku_catatan_datas.id_dasawisma','=','dasawismas.id')
            ->leftJoin('desas as de', 'dasawismas.desa_id', '=', 'de.id')
            ->select('buku_catatan_datas.*','dasawismas.nama_dasawisma','de.nama_desa')
             ->where('buku_catatan_datas.id_dasawisma',$id)
            ->latest()
            ->get();

            $dasa=DB::table('dasawismas')->where('id',$id)->first();

        return view('dasawisma.buku2.index', compact('data','dasa'));
    }

    public function create($id)
    {
        $dasawisma = DB::table('dasawismas')->where('id',$id)->first();
        return view('dasawisma.buku2.create', compact('dasawisma'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_dasawisma' => 'required',
            'nama_kepala_rumah_tangga' => 'required',
        ]);

        DB::table('buku_catatan_datas')->insert([
            'id_dasawisma' => $request->id_dasawisma,
            'nama_kepala_rumah_tangga' => $request->nama_kepala_rumah_tangga,
            'jumlah_kk' => $request->jumlah_kk ?? 0,

            'total_l' => $request->total_l ?? 0,
            'total_p' => $request->total_p ?? 0,
            'balita_l' => $request->balita_l ?? 0,
            'balita_p' => $request->balita_p ?? 0,

            'pus' => $request->pus ?? 0,
            'wus' => $request->wus ?? 0,
            'ibu_hamil' => $request->ibu_hamil ?? 0,
            'ibu_menyusui' => $request->ibu_menyusui ?? 0,

            'lansia' => $request->lansia ,
            'buta' => $request->buta ,
            'berkebutuhan_khusus' => $request->berkebutuhan_khusus ,

            'sehat_layak_huni' => $request->sehat_layak_huni ,
            'tidak_sehat_layak_huni' => $request->tidak_sehat_layak_huni ,

           'ada_tempat_buang_sampah' => $request->has('ada_tempat_buang_sampah'),
'spal' => $request->has('spal'),
'mck_septik_tank' => $request->has('mck_septik_tank'),
            'pdam' => $request->pdam ,

            'sumber_air' => $request->sumber_air,
            'makanan_pokok' => $request->makanan_pokok,

            'up2k' => $request->up2k,
            'pemanfataan_perkarangan' => $request->pemanfataan_perkarangan ,
            'industri_rumah_tanggal' => $request->has('industri_rumah_tanggal') ,
            'kesehatan_lingkungan' => $request->kesehatan_lingkungan ,

            'ket' => $request->ket,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Alert::success('Sukses', 'Data berhasil ditambahkan');
        return redirect('buku2/create/' . $request->id_dasawisma);
    }

    public function edit($id)
    {
        $data = DB::table('buku_catatan_datas')->where('id',$id)->first();
        $dasawisma = DB::table('dasawismas')->get();

        return view('dasawisma.buku2.edit', compact('data','dasawisma'));
    }

    public function update(Request $request, $id)
    {
        DB::table('buku_catatan_datas')->where('id',$id)->update([
            'jumlah_kk' => $request->jumlah_kk ?? 0,

            'total_l' => $request->total_l ?? 0,
            'total_p' => $request->total_p ?? 0,
            'balita_l' => $request->balita_l ?? 0,
            'balita_p' => $request->balita_p ?? 0,

            'pus' => $request->pus ?? 0,
            'wus' => $request->wus ?? 0,
            'ibu_hamil' => $request->ibu_hamil ?? 0,
            'ibu_menyusui' => $request->ibu_menyusui ?? 0,

            'lansia' => $request->lansia ?? 0,
            'buta' => $request->buta ?? 0,
            'berkebutuhan_khusus' => $request->berkebutuhan_khusus ?? 0,

            'sehat_layak_huni' => $request->sehat_layak_huni ?? 0,
            'tidak_sehat_layak_huni' => $request->tidak_sehat_layak_huni ?? 0,

            'ada_tempat_buang_sampah' => $request->ada_tempat_buang_sampah ?? 0,
            'spal' => $request->spal ?? 0,
            'mck_septik_tank' => $request->mck_septik_tank ?? 0,
            'pdam' => $request->pdam ?? 0,

            'sumber_air' => $request->sumber_air,
            'makanan_pokok' => $request->makanan_pokok,

            'up2k' => $request->up2k ?? 0,
            'pemanfataan_perkarangan' => $request->pemanfataan_perkarangan ?? 0,
            'industri_rumah_tanggal' => $request->industri_rumah_tanggal ?? 0,
            'kesehatan_lingkungan' => $request->kesehatan_lingkungan ?? 0,

            'ket' => $request->ket,
            'updated_at' => now(),
        ]);

        Alert::success('Sukses', 'Data berhasil diupdate');
        return redirect('buku2/edit/'.$id);
    }

    public function delete($id)
    {
        DB::table('buku_catatan_datas')->where('id',$id)->delete();

        Alert::success('Sukses', 'Data berhasil dihapus');
        return back();
    }
}