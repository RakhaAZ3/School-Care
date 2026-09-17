<?php

namespace App\Http\Controllers;

use App\Models\PengajuanBarang;
use Exception;
use Illuminate\Http\Request;

class PengajuanBarangController extends Controller
{
    public function index()
    {
        try {
            $pengajuan = PengajuanBarang::with(['pemohon'])->latest()->get();
            return response()->json([
                'status' => true,
                'message' => 'Data pengajuan barang berhasil diambil.',
                'data' => $pengajuan
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
                'nama_barang' => 'required|string',
                'jumlah' => 'required|integer|min:1',
                'estimasi_biaya' => 'nullable|numeric',
                'alasan' => 'nullable|string',
            ]);

            $pengajuan = new PengajuanBarang();
            $pengajuan->pemohon_id = $request->user()->id;
            $pengajuan->nama_barang = $request->nama_barang;
            $pengajuan->jumlah = $request->jumlah;
            $pengajuan->estimasi_biaya = $request->estimasi_biaya;
            $pengajuan->alasan = $request->alasan;
            $pengajuan->status = 'Menunggu';
            $pengajuan->save();

            return response()->json([
                'status' => true,
                'message' => 'Pengajuan barang berhasil dikirim.',
                'data' => $pengajuan->load('pemohon')
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
            $pengajuan = PengajuanBarang::with(['pemohon'])->find($id);
            if (!$pengajuan) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data pengajuan tidak ditemukan.'
                ], 404);
            }

            return response()->json([
                'status' => true,
                'message' => 'Data pengajuan berhasil diambil.',
                'data' => $pengajuan
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Dipakai tombol ✓ / ✕ di tabel frontend.
     * Body: { "status": "Disetujui" } atau { "status": "Ditolak" }
     */
    public function updateStatus(Request $request, $id)
    {
        try {
            $pengajuan = PengajuanBarang::find($id);
            if (!$pengajuan) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data pengajuan tidak ditemukan.'
                ], 404);
            }

            $request->validate([
                'status' => 'required|in:Disetujui,Ditolak',
            ]);

            $pengajuan->status = $request->status;
            $pengajuan->save();

            return response()->json([
                'status' => true,
                'message' => 'Status pengajuan berhasil diperbarui.',
                'data' => $pengajuan->load('pemohon')
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
            $pengajuan = PengajuanBarang::find($id);
            if (!$pengajuan) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data pengajuan tidak ditemukan.'
                ], 404);
            }

            $pengajuan->delete();

            return response()->json([
                'status' => true,
                'message' => 'Data pengajuan berhasil dihapus.'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}