<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PengaduanController extends Controller
{

    
    // LIST ADMIN
    public function index()
    {
        $data = DB::table('pengaduans')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.pengaduan.index', compact('data'));
    }

    // DELETE ADMIN
    public function destroy($id)
    {
        DB::table('pengaduans')->where('id', $id)->delete();

        return back()->with('success', 'Pengaduan berhasil dihapus');
    }
}