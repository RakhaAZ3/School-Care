<?php

namespace App\Http\Controllers;

use App\Models\LaporanKerusakan;
use Exception;
use Illuminate\Http\Request;

class LaporanKerusakanController extends Controller
{
    public function index()
    {
        try {
            $laporan = LaporanKerusakan::with(['sarana', 'ruangan', 'pelapor'])->latest()->get();
            return response()->json([
                'status' => true,
                'message' => 'Data laporan kerusakan berhasil diambil.',
                'data' => $laporan
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'judul' => 'required|string',
                'deskripsi' => 'required|string',
                'sarana_id' => 'required|exists:sarana,id',
                'ruangan_id' => 'required|exists:ruangan,id',
                'prioritas' => 'required|in:Rendah,Sedang,Tinggi',
            ]);

            $laporan = new LaporanKerusakan();
            $laporan->judul = $request->judul;
            $laporan->deskripsi = $request->deskripsi;
            $laporan->sarana_id = $request->sarana_id;
            $laporan->ruangan_id = $request->ruangan_id;
            // pelapor otomatis diisi dari user yang sedang login (token Sanctum)
            $laporan->pelapor_id = $request->user()->id;
            $laporan->prioritas = $request->prioritas;
            $laporan->status = 'Menunggu';
            $laporan->save();

            return response()->json([
                'status' => true,
                'message' => 'Laporan kerusakan berhasil disimpan.',
                'data' => $laporan->load(['sarana', 'ruangan', 'pelapor'])
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $laporan = LaporanKerusakan::with(['sarana', 'ruangan', 'pelapor'])->find($id);
            if (!$laporan) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data laporan tidak ditemukan.'
                ], 404);
            }

            return response()->json([
                'status' => true,
                'message' => 'Data laporan berhasil diambil.',
                'data' => $laporan
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $laporan = LaporanKerusakan::find($id);
            if (!$laporan) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data laporan tidak ditemukan.'
                ], 404);
            }

            $request->validate([
                'judul' => 'required|string',
                'deskripsi' => 'required|string',
                'sarana_id' => 'required|exists:sarana,id',
                'ruangan_id' => 'required|exists:ruangan,id',
                'prioritas' => 'required|in:Rendah,Sedang,Tinggi',
                'status' => 'required|in:Menunggu,Diverifikasi,Diproses,Selesai',
            ]);

            $laporan->judul = $request->judul;
            $laporan->deskripsi = $request->deskripsi;
            $laporan->sarana_id = $request->sarana_id;
            $laporan->ruangan_id = $request->ruangan_id;
            $laporan->prioritas = $request->prioritas;
            $laporan->status = $request->status;
            $laporan->save();

            return response()->json([
                'status' => true,
                'message' => 'Laporan berhasil diperbarui.',
                'data' => $laporan->load(['sarana', 'ruangan', 'pelapor'])
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Khusus untuk dropdown ubah status di tabel frontend
     * (tidak perlu kirim ulang semua field, cukup status-nya saja).
     */
    public function updateStatus(Request $request, $id)
    {
        try {
            $laporan = LaporanKerusakan::find($id);
            if (!$laporan) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data laporan tidak ditemukan.'
                ], 404);
            }

            $request->validate([
                'status' => 'required|in:Menunggu,Diverifikasi,Diproses,Selesai',
            ]);

            $laporan->status = $request->status;
            $laporan->save();

            return response()->json([
                'status' => true,
                'message' => 'Status laporan berhasil diperbarui.',
                'data' => $laporan
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $laporan = LaporanKerusakan::find($id);
            if (!$laporan) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data laporan tidak ditemukan.'
                ], 404);
            }

            $laporan->delete();

            return response()->json([
                'status' => true,
                'message' => 'Laporan berhasil dihapus.'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}