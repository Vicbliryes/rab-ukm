<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Rab;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class RabController extends Controller
{
    public function index(): JsonResponse
    {
        Log::info('API: Fetching all RABs.');
        $rabs = Rab::with('details.budgetCode')->get();
        return response()->json([
            'success' => true,
            'data' => $rabs
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        Log::info('API: Attempting to store a new RAB.');
        try {
            $validatedData = $request->validate([
                'NOMOR_RAB' => 'required|string|max:10|unique:rab',
                'Kegiatan' => 'required|string|max:50',
                'TANGGAL_RAP' => 'required|date',
                'details' => 'required|array',
                'details.*.Kode_Anggaran' => 'required|exists:budget_codes,Kode_Anggaran',
                'details.*.Nama' => 'required|string|max:100',
                'details.*.Jumlah' => 'required|integer|min:1',
                'details.*.Satuan' => 'required|string|max:20',
                'details.*.Harga_Satuan' => 'required|numeric|min:0'
            ]);
        } catch (ValidationException $e) {
            Log::warning('API: RAB store validation failed.', ['errors' => $e->errors()]);
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        }
        
        DB::beginTransaction();
        try {
            $rab = Rab::create($validatedData);

            foreach ($validatedData['details'] as $detail) {
                $rab->details()->create($detail);
            }

            DB::commit();
            Log::info("API: RAB created successfully with NOMOR_RAB: {$rab->NOMOR_RAB}");

            return response()->json([
                'success' => true,
                'message' => 'RAB created successfully',
                'data' => $rab->load('details.budgetCode')
            ], 201);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('API: Failed to create RAB during transaction.', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Failed to create RAB',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show(string $id): JsonResponse
    {
        Log::info("API: Fetching RAB with NOMOR_RAB: {$id}");
        $rab = Rab::with('details.budgetCode')->find($id);

        if (!$rab) {
            Log::warning("API: RAB with NOMOR_RAB: {$id} not found.");
            return response()->json([
                'success' => false,
                'message' => 'RAB not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $rab
        ]);
    }

    public function update(Request $request, string $id): JsonResponse
    {
        Log::info("API: Attempting to update RAB with NOMOR_RAB: {$id}");
        $rab = Rab::find($id);

        if (!$rab) {
            Log::warning("API: Update failed. RAB with NOMOR_RAB: {$id} not found.");
            return response()->json([
                'success' => false,
                'message' => 'RAB not found'
            ], 404);
        }
        
        try {
            $validatedData = $request->validate([
                'Kegiatan' => 'required|string|max:50',
                'TANGGAL_RAP' => 'required|date',
                'details' => 'required|array',
                'details.*.Kode_Anggaran' => 'required|exists:budget_codes,Kode_Anggaran',
                'details.*.Nama' => 'required|string|max:100',
                'details.*.Jumlah' => 'required|integer|min:1',
                'details.*.Satuan' => 'required|string|max:20',
                'details.*.Harga_Satuan' => 'required|numeric|min:0'
            ]);
        } catch (ValidationException $e) {
            Log::warning("API: RAB update validation failed for NOMOR_RAB: {$id}", ['errors' => $e->errors()]);
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        }

        DB::beginTransaction();
        try {
            $rab->update($validatedData);
            $rab->details()->delete();

            foreach ($validatedData['details'] as $detail) {
                $rab->details()->create($detail);
            }

            DB::commit();
            Log::info("API: RAB updated successfully with NOMOR_RAB: {$rab->NOMOR_RAB}");

            return response()->json([
                'success' => true,
                'message' => 'RAB updated successfully',
                'data' => $rab->load('details.budgetCode')
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error("API: Failed to update RAB during transaction for NOMOR_RAB: {$id}", ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Failed to update RAB',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy(string $id): JsonResponse
    {
        Log::info("API: Attempting to delete RAB with NOMOR_RAB: {$id}");
        $rab = Rab::find($id);

        if (!$rab) {
            Log::warning("API: Delete failed. RAB with NOMOR_RAB: {$id} not found.");
            return response()->json([
                'success' => false,
                'message' => 'RAB not found'
            ], 404);
        }

        DB::beginTransaction();
        try {
            $rab->realizations()->delete();
            $rab->details()->delete();
            $rab->delete();

            DB::commit();
            Log::info("API: RAB with NOMOR_RAB: {$id} deleted successfully.");

            return response()->json([
                'success' => true,
                'message' => 'RAB deleted successfully'
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error("API: Failed to delete RAB during transaction for NOMOR_RAB: {$id}", ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete RAB',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}