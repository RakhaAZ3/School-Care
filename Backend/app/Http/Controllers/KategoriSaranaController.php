<?php

namespace App\Http\Controllers;

use App\Models\KategoriSarana;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class KategoriSaranaController extends Controller
{
    /**
     * Tampilkan semua data kategori sarana.
     */
    public function index(): JsonResponse
    {
        $kategori = KategoriSarana::latest()->get();

        return response()->json([
            'data' => $kategori,
        ]);
    }

    /**
     * Simpan data kategori sarana baru.
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'nama_kategori' => ['required', 'string', 'max:255', 'unique:kategori_sarana,nama_kategori'],
            'keterangan' => ['nullable', 'string'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal',
                'errors' => $validator->errors(),
            ], 422);
        }

        $kategori = KategoriSarana::create($validator->validated());

        return response()->json([
            'message' => 'Kategori sarana berhasil ditambahkan',
            'data' => $kategori,
        ], 201);
    }

    /**
     * Tampilkan detail satu kategori sarana beserta sarana di dalamnya.
     */
    public function show(KategoriSarana $kategoriSarana): JsonResponse
    {
        return response()->json([
            'data' => $kategoriSarana->load('sarana'),
        ]);
    }

    /**
     * Update data kategori sarana.
     */
    public function update(Request $request, KategoriSarana $kategoriSarana): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'nama_kategori' => [
                'sometimes', 'string', 'max:255',
                'unique:kategori_sarana,nama_kategori,' . $kategoriSarana->id,
            ],
            'keterangan' => ['nullable', 'string'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal',
                'errors' => $validator->errors(),
            ], 422);
        }

        $kategoriSarana->update($validator->validated());

        return response()->json([
            'message' => 'Kategori sarana berhasil diperbarui',
            'data' => $kategoriSarana,
        ]);
    }

    /**
     * Hapus data kategori sarana.
     * Catatan: akan gagal kalau kategori ini masih dipakai oleh data sarana
     * (karena foreign key kategori_id di tabel sarana tidak nullable).
     */
    public function destroy(KategoriSarana $kategoriSarana): JsonResponse
    {
        if ($kategoriSarana->sarana()->exists()) {
            return response()->json([
                'message' => 'Kategori tidak bisa dihapus karena masih dipakai oleh data sarana',
            ], 422);
        }

        $kategoriSarana->delete();

        return response()->json([
            'message' => 'Kategori sarana berhasil dihapus',
        ]);
    }
}