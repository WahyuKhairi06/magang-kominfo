<?php

namespace App\Http\Controllers\Dasawisma;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Barryvdh\DomPDF\Facade\Pdf;

class Buku3Controller extends Controller
{


public function pdfbulan(Request $request,$id)
{
    $data = DB::table('buku3_kehamilans')
        ->join('dasawismas','buku3_kehamilans.id_dasawisma','=','dasawismas.id')
        ->leftJoin('desas','dasawismas.desa_id','=','desas.id')
        ->leftJoin('bulans','buku3_kehamilans.bulan_id','=','bulans.id')
        

        ->select('buku3_kehamilans.*','dasawismas.nama_dasawisma','desas.nama_desa','dasawismas.tahun as tahun_daswisma','bulans.nama_bulan')
        ->where('id_dasawisma',$id)
->when($request->bulan_id, function($q) use ($request){
    $q->where('buku3_kehamilans.bulan_id', $request->bulan_id);
})        ->get();

    // 🔥 REKAP
    $rekap = [
        'hamil' => $data->where('status','Hamil')->count(),
        'melahirkan' => $data->where('status','Melahirkan')->count(),
        'nifas' => $data->where('status','Nifas')->count(),

        'ibu_meninggal' => $data->where('status_meninggal','Ibu')->count(),
        'bayi_lahir' => $data->whereNotNull('nama_bayi')->count(),
        'bayi_meninggal' => $data->where('status_meninggal','Bayi')->count(),
        'balita_meninggal' => $data->where('status_meninggal','Balita')->count(),
    ];

    $pdf = Pdf::loadView('dasawisma.buku3.pdf_bulan', compact('data','rekap'))
        ->setPaper('A4','landscape');

    return $pdf->stream('buku3.pdf');
}
public function pdf($id)
{
    $data = DB::table('buku3_kehamilans')
        ->join('dasawismas','buku3_kehamilans.id_dasawisma','=','dasawismas.id')
        ->leftJoin('desas','dasawismas.desa_id','=','desas.id')
        ->leftJoin('bulans','buku3_kehamilans.bulan_id','=','bulans.id')
        

        ->select('buku3_kehamilans.*','dasawismas.nama_dasawisma','desas.nama_desa','dasawismas.tahun','bulans.nama_bulan')
        ->where('id_dasawisma',$id)
        ->get();

    // 🔥 REKAP
    $rekap = [
        'hamil' => $data->where('status','Hamil')->count(),
        'melahirkan' => $data->where('status','Melahirkan')->count(),
        'nifas' => $data->where('status','Nifas')->count(),

        'ibu_meninggal' => $data->where('status_meninggal','Ibu')->count(),
        'bayi_lahir' => $data->whereNotNull('nama_bayi')->count(),
        'bayi_meninggal' => $data->where('status_meninggal','Bayi')->count(),
        'balita_meninggal' => $data->where('status_meninggal','Balita')->count(),
    ];

    $pdf = Pdf::loadView('dasawisma.buku3.pdf', compact('data','rekap'))
        ->setPaper('A4','landscape');

    return $pdf->stream('buku3.pdf');
}

    // 🔥 INDEX
    public function index(Request $request, $id)
    {
        $data = DB::table('buku3_kehamilans')
                   ->leftJoin('bulans','buku3_kehamilans.bulan_id','=','bulans.id')
                  ->select('buku3_kehamilans.*','bulans.nama_bulan')
            ->where('id_dasawisma', $id)
              ->when($request->bulan_id, function($q) use ($request){
            $q->where('buku3_kehamilans.bulan_id', $request->bulan_id);
        })
            ->latest()
            ->get();
    $bulans = DB::table('bulans')->get();

        return view('dasawisma.buku3.index', compact('data','id','bulans'));
    }

    // 🔥 CREATE
    public function create($id)
    {
        $bulans=DB::table('bulans')->get();
        return view('dasawisma.buku3.create', compact('id','bulans'));
    }

    // 🔥 STORE
    public function store(Request $request)
    {
        $request->validate([
            'id_dasawisma' => 'required',
            // 'nama_ibu' => 'required|string|max:255',
            // 'nama_suami' => 'nullable|string|max:255',
            // 'status' => 'nullable|in:Hamil,Melahirkan,Nifas',
            // 'bulan' => 'required',

            // 'nama_bayi' => 'nullable|string|max:255',
            // 'jenis_kelamin_bayi' => 'nullable|in:L,P',
            // 'tgl_lahir' => 'nullable|date',
            // 'akte_kelahiran' => 'nullable|in:Ada,Tidak Ada',

            // 'nama_meninggal' => 'nullable|string|max:255',
            // 'status_meninggal' => 'nullable|in:Ibu,Bayi,Balita',
            // 'jenis_kelamin_meninggal' => 'nullable|in:L,P',
            // 'tanggal_meninggal' => 'nullable|date',
            // 'sebab_meninggal' => 'nullable|string|max:255',
            // 'keterangan' => 'nullable|string',
        ]);

        DB::table('buku3_kehamilans')->insert([
            'id_dasawisma' => $request->id_dasawisma,
            'nama_ibu' => $request->nama_ibu,
            'nama_suami' => $request->nama_suami,
            'status' => $request->status,
            'bulan_id' =>$request->bulan_id,
            'nama_bayi' => $request->nama_bayi,
            'jenis_kelamin_bayi' => $request->jenis_kelamin_bayi,
            'tgl_lahir' => $request->tgl_lahir,
            'akte_kelahiran' => $request->akte_kelahiran,

            'nama_meninggal' => $request->nama_meninggal,
            'status_meninggal' => $request->status_meninggal,
            'jenis_kelamin_meninggal' => $request->jenis_kelamin_meninggal,
            'tanggal_meninggal' => $request->tanggal_meninggal,
            'sebab_meninggal' => $request->sebab_meninggal,
            'keterangan' => $request->keterangan,

            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Alert::success('Berhasil', 'Data berhasil ditambahkan');

        return redirect()->route('buku3.index', $request->id_dasawisma);
    }

    // 🔥 EDIT
    public function edit($id)
    {
        $data = DB::table('buku3_kehamilans')->where('id', $id)->first();
        $bulans=DB::table('bulans')->get();

        return view('dasawisma.buku3.edit', compact('data','bulans'));
    }

    // 🔥 UPDATE
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_ibu' => 'required|string|max:255',
            'bulan_id' => 'required',
            'status' => 'nullable|in:Hamil,Melahirkan,Nifas',
        ]);

        DB::table('buku3_kehamilans')->where('id', $id)->update([
            'nama_ibu' => $request->nama_ibu,
            'nama_suami' => $request->nama_suami,
            'status' => $request->status,

            'nama_bayi' => $request->nama_bayi,
            'jenis_kelamin_bayi' => $request->jenis_kelamin_bayi,
            'tgl_lahir' => $request->tgl_lahir,
            'akte_kelahiran' => $request->akte_kelahiran,
            'bulan_id' => $request->bulan,

            'nama_meninggal' => $request->nama_meninggal,
            'status_meninggal' => $request->status_meninggal,
            'jenis_kelamin_meninggal' => $request->jenis_kelamin_meninggal,
            'tanggal_meninggal' => $request->tanggal_meninggal,
            'sebab_meninggal' => $request->sebab_meninggal,
            'keterangan' => $request->keterangan,

            'updated_at' => now(),
        ]);

        Alert::success('Berhasil', 'Data berhasil diupdate');

        return redirect()->route('buku3.index', $request->id_dasawisma);
    }

    // 🔥 DELETE
    public function destroy($id)
    {
        DB::table('buku3_kehamilans')->where('id', $id)->delete();

        Alert::success('Berhasil', 'Data berhasil dihapus');

        return back();
    }
}