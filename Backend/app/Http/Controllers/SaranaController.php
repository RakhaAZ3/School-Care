<?php

namespace App\Http\Controllers;

use App\Models\Sarana;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class SaranaController extends Controller
{
    /**
     * Tampilkan semua data sarana.
     */
    public function index(): JsonResponse
    {
        $sarana = Sarana::with(['kategori', 'ruangan'])->latest()->get();

        return response()->json([
            'data' => $sarana,
        ]);
    }

    /**
     * Simpan data sarana baru.
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'kode_sarana' => ['required', 'string', 'unique:sarana,kode_sarana'],
            'nama_sarana' => ['required', 'string', 'max:255'],
            'kategori_id' => ['required', 'exists:kategori_sarana,id'],
            'ruangan_id' => ['nullable', 'exists:ruangan,id'],
            'jumlah' => ['required', 'integer', 'min:1'],
            'kondisi' => ['required', 'in:baik,rusak_ringan,rusak_berat'],
            'tahun_pengadaan' => ['nullable', 'integer'],
            'sumber_dana' => ['nullable', 'string', 'max:255'],
            'harga' => ['nullable', 'numeric'],
            'keterangan' => ['nullable', 'string'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal',
                'errors' => $validator->errors(),
            ], 422);
        }

        $sarana = Sarana::create($validator->validated());

        return response()->json([
            'message' => 'Sarana berhasil ditambahkan',
            'data' => $sarana,
        ], 201);
    }

    /**
     * Tampilkan detail satu data sarana.
     */
    public function show(Sarana $sarana): JsonResponse
    {
        return response()->json([
            'data' => $sarana->load(['kategori', 'ruangan', 'peminjaman', 'pemeliharaan']),
        ]);
    }

    /**
     * Update data sarana.
     */
    public function update(Request $request, Sarana $sarana): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'kode_sarana' => ['sometimes', 'string', 'unique:sarana,kode_sarana,' . $sarana->id],
            'nama_sarana' => ['sometimes', 'string', 'max:255'],
            'kategori_id' => ['sometimes', 'exists:kategori_sarana,id'],
            'ruangan_id' => ['nullable', 'exists:ruangan,id'],
            'jumlah' => ['sometimes', 'integer', 'min:1'],
            'kondisi' => ['sometimes', 'in:baik,rusak_ringan,rusak_berat'],
            'status' => ['sometimes', 'in:tersedia,dipinjam,dalam_perbaikan,tidak_aktif'],
            'tahun_pengadaan' => ['nullable', 'integer'],
            'sumber_dana' => ['nullable', 'string', 'max:255'],
            'harga' => ['nullable', 'numeric'],
            'keterangan' => ['nullable', 'string'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal',
                'errors' => $validator->errors(),
            ], 422);
        }

        $sarana->update($validator->validated());

        return response()->json([
            'message' => 'Sarana berhasil diperbarui',
            'data' => $sarana,
        ]);
    }

    /**
     * Hapus data sarana (soft delete).
     */
    public function destroy(Sarana $sarana): JsonResponse
    {
        $sarana->delete();

        return response()->json([
            'message' => 'Sarana berhasil dihapus',
        ]);
    }
}