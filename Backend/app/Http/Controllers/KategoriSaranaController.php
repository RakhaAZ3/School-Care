<?php

namespace App\Http\Controllers;

use App\Models\KategoriSarana;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class KategoriSaranaController extends Controller
{
    public function index(): JsonResponse
    {
        $kategori = KategoriSarana::latest()->get();

        return response()->json([
            'data' => $kategori,
        ]);
    }

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

    // Nama parameter di sini WAJIB "kategori", sama seperti nama resource
    // di routes/api.php: Route::apiResource('kategori', ...)
    public function show(KategoriSarana $kategori): JsonResponse
    {
        return response()->json([
            'data' => $kategori->load('sarana'),
        ]);
    }

    public function update(Request $request, KategoriSarana $kategori): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'nama_kategori' => [
                'sometimes', 'string', 'max:255',
                'unique:kategori_sarana,nama_kategori,' . $kategori->id,
            ],
            'keterangan' => ['nullable', 'string'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal',
                'errors' => $validator->errors(),
            ], 422);
        }

        $kategori->update($validator->validated());

        return response()->json([
            'message' => 'Kategori sarana berhasil diperbarui',
            'data' => $kategori,
        ]);
    }

    public function destroy(KategoriSarana $kategori): JsonResponse
    {
        if ($kategori->sarana()->exists()) {
            return response()->json([
                'message' => 'Kategori tidak bisa dihapus karena masih dipakai oleh data sarana',
            ], 422);
        }

        $kategori->delete();

        return response()->json([
            'message' => 'Kategori sarana berhasil dihapus',
        ]);
    }
}