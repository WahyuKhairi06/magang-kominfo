<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Roleset;
use RealRashid\SweetAlert\Facades\Alert;

class RoleController extends Controller
{
    public function index()
    {
        try {
            $roles = Roleset::all();
            return view('admin.role.index', compact('roles'));
        } catch (\Exception $e) {
            Alert::toast('Gagal Memuat Halaman', 'error');
            return back();
        }
    }

    // 🔥 STORE
    public function store(Request $request)
    {
        $request->validate([
            'nama_role' => 'required',
            'keterangan' => 'nullable'
        ]);

        try {
            Roleset::create([
                'nama_role' => $request->nama_role,
                'keterangan' => $request->keterangan,
            ]);

            Alert::success('Berhasil', 'Role berhasil ditambahkan');
            return back();

        } catch (\Exception $e) {
            Alert::error('Error', $e->getMessage());
            return back();
        }
    }

    // 🔥 EDIT (ambil data)
    public function edit($id)
    {
        try {
            $role = Roleset::findOrFail($id);
            return view('admin.role.edit', compact('role'));
        } catch (\Exception $e) {
            Alert::error('Error', 'Data tidak ditemukan');
            return back();
        }
    }

    // 🔥 UPDATE
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_role' => 'required',
            'keterangan' => 'nullable'
        ]);

        try {
            $role = Roleset::findOrFail($id);

            $role->update([
                'nama_role' => $request->nama_role,
                'keterangan' => $request->keterangan,
            ]);

            Alert::success('Berhasil', 'Role berhasil diupdate');
            return redirect()->route('role.index');

        } catch (\Exception $e) {
            Alert::error('Error', $e->getMessage());
            return back();
        }
    }

    // 🔥 DELETE
    public function destroy($id)
    {
        try {
            $role = Roleset::findOrFail($id);
            $role->delete();

            Alert::success('Berhasil', 'Role berhasil dihapus');
            return back();

        } catch (\Exception $e) {
            Alert::error('Error', 'Gagal menghapus data');
            return back();
        }
    }
}