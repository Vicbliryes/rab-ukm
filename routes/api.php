<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BudgetCodeController;
use App\Http\Controllers\Api\RabController;
use App\Http\Controllers\Api\RealizationController;
use App\Http\Controllers\Api\ReportController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('budget-codes', BudgetCodeController::class);

Route::apiResource('rab', RabController::class);

Route::apiResource('realizations', RealizationController::class);
Route::get('realizations/rab/{nomor_rab}', [RealizationController::class, 'getByRab']);

Route::get('reports/summary', [ReportController::class, 'summary']);
Route::get('reports/{nomor_rab}', [ReportController::class, 'report']);
Route::get('reports/{nomor_rab}/analysis', [ReportController::class, 'budgetAnalysis']);
