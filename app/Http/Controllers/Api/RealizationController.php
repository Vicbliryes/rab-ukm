<?php

namespace App\Http\Controllers;
use App\Models\Realization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class RealizationController extends Controller
{
    public function store(Request $request)
    {
        Log::info('AJAX: Attempting to store new realization.', ['NOMOR_RAB' => $request->input('NOMOR_RAB')]);
        $validator = Validator::make($request->all(), [
            'NOMOR_RAB' => 'required|exists:rab,NOMOR_RAB',
            'Tanggal' => 'required|date',
            'Kode_Anggaran' => 'required|exists:budget_codes,Kode_Anggaran',
            'Nama' => 'required|string|max:100',
            'Jumlah' => 'required|integer|min:1',
            'Satuan' => 'required|string|max:20',
            'Harga_Satuan' => 'required|numeric|min:0'
        ]);

        if ($validator->fails()) {
            Log::warning('AJAX: Realization store validation failed.', ['errors' => $validator->errors()]);
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $realization = Realization::create($request->all());
        $realization->load('budgetCode');

        Log::info("AJAX: Realization created successfully with ID: {$realization->ID} for RAB: {$realization->NOMOR_RAB}");
        return response()->json(['success' => true, 'message' => 'Realisasi berhasil ditambahkan!', 'data' => $realization]);
    }

    public function update(Request $request, Realization $realization)
    {
        Log::info("AJAX: Attempting to update realization with ID: {$realization->ID}.");
        $validator = Validator::make($request->all(), [
            'Tanggal' => 'required|date',
            'Kode_Anggaran' => 'required|exists:budget_codes,Kode_Anggaran',
            'Nama' => 'required|string|max:100',
            'Jumlah' => 'required|integer|min:1',
            'Satuan' => 'required|string|max:20',
            'Harga_Satuan' => 'required|numeric|min:0'
        ]);

        if ($validator->fails()) {
            Log::warning("AJAX: Realization update validation failed for ID: {$realization->ID}", ['errors' => $validator->errors()]);
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $realization->update($request->all());
        $realization->load('budgetCode');

        Log::info("AJAX: Realization updated successfully with ID: {$realization->ID}");
        return response()->json(['success' => true, 'message' => 'Realisasi berhasil diperbarui!', 'data' => $realization]);
    }

    public function destroy(Realization $realization)
    {
        Log::info("AJAX: Attempting to delete realization with ID: {$realization->ID}.");
        try {
            $realization->delete();
            Log::info("AJAX: Realization with ID: {$realization->ID} deleted successfully.");
            return response()->json(['success' => true, 'message' => 'Realisasi berhasil dihapus!']);
        } catch (\Exception $e) {
            Log::error("AJAX: Failed to delete realization with ID: {$realization->ID}", ['error' => $e->getMessage()]);
            return response()->json(['success' => false, 'message' => 'Gagal menghapus realisasi.'], 500);
        }
    }
}