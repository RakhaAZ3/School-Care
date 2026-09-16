<?php

namespace App\Http\Controllers;

use App\Models\Sarana;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class SaranaController extends Controller
{
    public function index(): JsonResponse
    {
        $sarana = Sarana::with(['kategori', 'ruangan'])->latest()->get();

        return response()->json([
            'data' => $sarana,
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        // "kode_sarana" TIDAK divalidasi/diminta dari request,
        // karena otomatis diisi oleh model (lihat Sarana::boot()).
        $validator = Validator::make($request->all(), [
            'nama_sarana' => ['required', 'string', 'max:255'],
            'kategori_id' => ['required', 'exists:kategori_sarana,id'],
            'ruangan_id' => ['nullable', 'exists:ruangan,id'],
            'jumlah' => ['required', 'integer', 'min:1'],
            'kondisi' => ['required', 'in:baik,rusak_ringan,rusak_berat'],
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
            'data' => $sarana->load(['kategori', 'ruangan']),
        ], 201);
    }

    public function show(Sarana $sarana): JsonResponse
    {
        return response()->json([
            'data' => $sarana->load(['kategori', 'ruangan', 'peminjaman', 'pemeliharaan']),
        ]);
    }

    public function update(Request $request, Sarana $sarana): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'nama_sarana' => ['sometimes', 'string', 'max:255'],
            'kategori_id' => ['sometimes', 'exists:kategori_sarana,id'],
            'ruangan_id' => ['nullable', 'exists:ruangan,id'],
            'jumlah' => ['sometimes', 'integer', 'min:1'],
            'kondisi' => ['sometimes', 'in:baik,rusak_ringan,rusak_berat'],
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
            'data' => $sarana->load(['kategori', 'ruangan']),
        ]);
    }

    public function destroy(Sarana $sarana): JsonResponse
    {
        $sarana->forceDelete();

        return response()->json([
            'message' => 'Sarana berhasil dihapus',
        ]);
    }
}