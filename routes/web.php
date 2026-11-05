<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RealizationController;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::get('/rab', [DashboardController::class, 'rabList'])->name('rab.index');
Route::get('/rab/create', [DashboardController::class, 'create'])->name('rab.create');
Route::post('/rab', [DashboardController::class, 'store'])->name('rab.store');
Route::get('/rab/{nomor_rab}', [DashboardController::class, 'rabDetail'])->name('rab.detail');
Route::get('/rab/{nomor_rab}/edit', [DashboardController::class, 'edit'])->name('rab.edit');
Route::put('/rab/{nomor_rab}', [DashboardController::class, 'update'])->name('rab.update');
Route::delete('/rab/{nomor_rab}', [DashboardController::class, 'destroy'])->name('rab.destroy');

Route::post('/realizations', [RealizationController::class, 'store'])->name('realizations.store');
Route::put('/realizations/{realization}', [RealizationController::class, 'update'])->name('realizations.update');
Route::delete('/realizations/{realization}', [RealizationController::class, 'destroy'])->name('realizations.destroy');

Route::get('/report/{nomor_rab}', [ReportController::class, 'report'])->name('report');