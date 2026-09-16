<?php

namespace App\Http\Controllers;

use App\Models\Ruangan;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class RuanganController extends Controller
{
    /**
     * Tampilkan semua data ruangan.
     */
    public function index(): JsonResponse
    {
        $ruangan = Ruangan::latest()->get();

        return response()->json([
            'data' => $ruangan,
        ]);
    }

    /**
     * Simpan data ruangan baru.
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'nama_ruangan' => ['required', 'string', 'max:255'],
            'gedung' => ['nullable', 'string', 'max:255'],
            'lantai' => ['nullable', 'string', 'max:255'],
            'score' => ['nullable', 'integer', 'min:0'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal',
                'errors' => $validator->errors(),
            ], 422);
        }

        $ruangan = Ruangan::create($validator->validated());

        return response()->json([
            'message' => 'Ruangan berhasil ditambahkan',
            'data' => $ruangan,
        ], 201);
    }

    /**
     * Tampilkan detail satu ruangan beserta sarana di dalamnya.
     */
    public function show(Ruangan $ruangan): JsonResponse
    {
        return response()->json([
            'data' => $ruangan->load('sarana'),
        ]);
    }

    /**
     * Update data ruangan.
     */
    public function update(Request $request, Ruangan $ruangan): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'nama_ruangan' => ['sometimes', 'string', 'max:255'],
            'gedung' => ['nullable', 'string', 'max:255'],
            'lantai' => ['nullable', 'string', 'max:255'],
            'score' => ['nullable', 'integer', 'min:0'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal',
                'errors' => $validator->errors(),
            ], 422);
        }

        $ruangan->update($validator->validated());

        return response()->json([
            'message' => 'Ruangan berhasil diperbarui',
            'data' => $ruangan,
        ]);
    }

    /**
     * Hapus data ruangan.
     * Catatan: kolom ruangan_id di tabel sarana nullable, jadi kalau ruangan
     * dihapus, sarana yang ada di dalamnya tidak ikut terhapus — cuma
     * ruangan_id-nya jadi null (lihat onDelete di migration sarana).
     */
    public function destroy(Ruangan $ruangan): JsonResponse
    {
        $ruangan->delete();

        return response()->json([
            'message' => 'Ruangan berhasil dihapus',
        ]);
    }
}