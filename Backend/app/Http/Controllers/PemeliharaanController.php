<?php

namespace App\Http\Controllers;

use App\Models\Pemeliharaan;
use Exception;
use Illuminate\Http\Request;

class PemeliharaanController extends Controller
{
    public function index()
    {
        try {
            $pemeliharaan = Pemeliharaan::with('sarana')->latest('tanggal_pemeliharaan')->get();
            return response()->json([
                'status' => true,
                'message' => 'Data pemeliharaan berhasil diambil.',
                'data' => $pemeliharaan
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
                'sarana_id' => 'required|exists:sarana,id',
                'jenis_perawatan' => 'required|string',
                'teknisi' => 'required|string',
                'biaya' => 'nullable|numeric',
                'tanggal_pemeliharaan' => 'required|date',
                'pemeriksaan_berikutnya' => 'nullable|date|after_or_equal:tanggal_pemeliharaan',
                'status' => 'nullable|in:Proses,Selesai',
            ]);

            $pemeliharaan = new Pemeliharaan();
            $pemeliharaan->sarana_id = $request->sarana_id;
            $pemeliharaan->jenis_perawatan = $request->jenis_perawatan;
            $pemeliharaan->teknisi = $request->teknisi;
            $pemeliharaan->biaya = $request->biaya;
            $pemeliharaan->tanggal_pemeliharaan = $request->tanggal_pemeliharaan;
            $pemeliharaan->pemeriksaan_berikutnya = $request->pemeriksaan_berikutnya;
            $pemeliharaan->status = $request->status ?? 'Selesai';
            $pemeliharaan->save();

            return response()->json([
                'status' => true,
                'message' => 'Data pemeliharaan berhasil disimpan.',
                'data' => $pemeliharaan->load('sarana')
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
            $pemeliharaan = Pemeliharaan::with('sarana')->find($id);
            if (!$pemeliharaan) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data pemeliharaan tidak ditemukan.'
                ], 404);
            }

            return response()->json([
                'status' => true,
                'message' => 'Data pemeliharaan berhasil diambil.',
                'data' => $pemeliharaan
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
            $pemeliharaan = Pemeliharaan::find($id);
            if (!$pemeliharaan) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data pemeliharaan tidak ditemukan.'
                ], 404);
            }

            $request->validate([
                'sarana_id' => 'required|exists:sarana,id',
                'jenis_perawatan' => 'required|string',
                'teknisi' => 'required|string',
                'biaya' => 'nullable|numeric',
                'tanggal_pemeliharaan' => 'required|date',
                'pemeriksaan_berikutnya' => 'nullable|date|after_or_equal:tanggal_pemeliharaan',
                'status' => 'required|in:Proses,Selesai',
            ]);

            $pemeliharaan->sarana_id = $request->sarana_id;
            $pemeliharaan->jenis_perawatan = $request->jenis_perawatan;
            $pemeliharaan->teknisi = $request->teknisi;
            $pemeliharaan->biaya = $request->biaya;
            $pemeliharaan->tanggal_pemeliharaan = $request->tanggal_pemeliharaan;
            $pemeliharaan->pemeriksaan_berikutnya = $request->pemeriksaan_berikutnya;
            $pemeliharaan->status = $request->status;
            $pemeliharaan->save();

            return response()->json([
                'status' => true,
                'message' => 'Data pemeliharaan berhasil diperbarui.',
                'data' => $pemeliharaan->load('sarana')
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
            $pemeliharaan = Pemeliharaan::find($id);
            if (!$pemeliharaan) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data pemeliharaan tidak ditemukan.'
                ], 404);
            }

            $pemeliharaan->delete();

            return response()->json([
                'status' => true,
                'message' => 'Data pemeliharaan berhasil dihapus.'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}