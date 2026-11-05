<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BudgetCode;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class BudgetCodeController extends Controller
{
    public function index(): JsonResponse
    {
        Log::info('API: Fetching all budget codes.');
        $budgetCodes = BudgetCode::all();
        return response()->json([
            'success' => true,
            'data' => $budgetCodes
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        Log::info('API: Attempting to store a new budget code.');
        try {
            $validatedData = $request->validate([
                'Kode_Anggaran' => 'required|integer|unique:budget_codes',
                'Nama_Anggaran' => 'required|string|max:50'
            ]);

            $budgetCode = BudgetCode::create($validatedData);
            Log::info("API: Budget code created successfully with ID: {$budgetCode->Kode_Anggaran}");

            return response()->json([
                'success' => true,
                'message' => 'Budget code created successfully',
                'data' => $budgetCode
            ], 201);
        } catch (ValidationException $e) {
            Log::warning('API: Budget code validation failed.', ['errors' => $e->errors()]);
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        }
    }

    public function show(string $id): JsonResponse
    {
        Log::info("API: Fetching budget code with ID: {$id}");
        $budgetCode = BudgetCode::find($id);

        if (!$budgetCode) {
            Log::warning("API: Budget code with ID: {$id} not found.");
            return response()->json([
                'success' => false,
                'message' => 'Budget code not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $budgetCode
        ]);
    }

    public function update(Request $request, string $id): JsonResponse
    {
        Log::info("API: Attempting to update budget code with ID: {$id}");
        $budgetCode = BudgetCode::find($id);

        if (!$budgetCode) {
            Log::warning("API: Update failed. Budget code with ID: {$id} not found.");
            return response()->json([
                'success' => false,
                'message' => 'Budget code not found'
            ], 404);
        }

        try {
            $validatedData = $request->validate([
                'Nama_Anggaran' => 'required|string|max:50'
            ]);

            $budgetCode->update($validatedData);
            Log::info("API: Budget code with ID: {$id} updated successfully.");

            return response()->json([
                'success' => true,
                'message' => 'Budget code updated successfully',
                'data' => $budgetCode
            ]);
        } catch (ValidationException $e) {
            Log::warning("API: Budget code update validation failed for ID: {$id}", ['errors' => $e->errors()]);
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        }
    }

    public function destroy(string $id): JsonResponse
    {
        Log::info("API: Attempting to delete budget code with ID: {$id}");
        $budgetCode = BudgetCode::find($id);

        if (!$budgetCode) {
            Log::warning("API: Delete failed. Budget code with ID: {$id} not found.");
            return response()->json([
                'success' => false,
                'message' => 'Budget code not found'
            ], 404);
        }

        $budgetCode->delete();
        Log::info("API: Budget code with ID: {$id} deleted successfully.");

        return response()->json([
            'success' => true,
            'message' => 'Budget code deleted successfully'
        ]);
    }
}