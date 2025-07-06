<?php

namespace Modules\Pendaftaran\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Pendaftaran\App\Models\Daftar; // Perbaiki namespace model

class PendaftaranController extends Controller
{
    public function index()
    {
        return view('pendaftaran::index');
    }

    public function getData()
    {
        $pendaftarans = Daftar::latest()->get();
        return response()->json($pendaftarans);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'asal_sekolah' => 'required',
            'prodi_tujuan' => 'required',
        ]);

        Daftar::updateOrCreate(
            ['id' => $request->id],
            $request->only(['nama', 'asal_sekolah', 'prodi_tujuan'])
        );

        return response()->json(['success' => 'Data berhasil disimpan.']);
    }

    public function edit($id)
    {
        $pendaftaran = Daftar::find($id);
        return response()->json($pendaftaran);
    }

    public function destroy($id)
    {
        Daftar::find($id)->delete();
        return response()->json(['success' => 'Data berhasil dihapus.']);
    }

    public function show($id)
    {
        $pendaftaran = Daftar::find($id);
        if (!$pendaftaran) {
            return response()->json(['message' => 'Data tidak ditemukan.'], 404);
        }
        return response()->json($pendaftaran);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required',
            'asal_sekolah' => 'required',
            'prodi_tujuan' => 'required',
        ]);

        $pendaftaran = Daftar::find($id);
        if (!$pendaftaran) {
            return response()->json(['message' => 'Data tidak ditemukan.'], 404);
        }

        $pendaftaran->update($request->only(['nama', 'asal_sekolah', 'prodi_tujuan']));

        return response()->json(['success' => 'Data berhasil diupdate.']);
    }
}

