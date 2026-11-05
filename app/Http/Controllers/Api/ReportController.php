<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Rab;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ReportController extends Controller
{
    public function summary(): JsonResponse
    {
        Log::info('API: Summary report accessed.');
        $summary = Rab::query()
            ->withSum('details as total_rab', DB::raw('Jumlah * Harga_Satuan'))
            ->withSum('realizations as total_realization', DB::raw('Jumlah * Harga_Satuan'))
            ->get()
            ->map(function ($rab) {
                $totalRab = $rab->total_rab ?? 0;
                $totalRealization = $rab->total_realization ?? 0;
                $rab->difference = $totalRab - $totalRealization;
                return $rab;
            });

        return response()->json([
            'success' => true,
            'data' => $summary
        ]);
    }

    public function report(string $nomor_rab): JsonResponse
    {
        Log::info("API: Detailed report accessed for NOMOR_RAB: {$nomor_rab}");
        $rab = Rab::find($nomor_rab);

        if (!$rab) {
            Log::warning("API: Report failed. RAB not found: {$nomor_rab}");
            return response()->json([
                'success' => false,
                'message' => 'RAB not found'
            ], 404);
        }

        $rabDetails = DB::table('rab_details as rd')
            ->join('budget_codes as bc', 'rd.Kode_Anggaran', '=', 'bc.Kode_Anggaran')
            ->where('rd.NOMOR_RAB', $nomor_rab)
            ->select(
                'rd.Kode_Anggaran',
                'rd.Nama',
                'bc.Nama_Anggaran',
                DB::raw('SUM(rd.Jumlah * rd.Harga_Satuan) as total_rab')
            )
            ->groupBy('rd.Kode_Anggaran', 'rd.Nama', 'bc.Nama_Anggaran')
            ->get()
            ->keyBy(fn ($item) => $item->Kode_Anggaran . '_' . $item->Nama);

        $realizations = DB::table('realization as r')
            ->join('budget_codes as bc', 'r.Kode_Anggaran', '=', 'bc.Kode_Anggaran')
            ->where('r.NOMOR_RAB', $nomor_rab)
            ->select(
                'r.Kode_Anggaran',
                'r.Nama',
                'bc.Nama_Anggaran',
                DB::raw('SUM(r.Jumlah * r.Harga_Satuan) as total_realization')
            )
            ->groupBy('r.Kode_Anggaran', 'r.Nama', 'bc.Nama_Anggaran')
            ->get()
            ->keyBy(fn ($item) => $item->Kode_Anggaran . '_' . $item->Nama);

        $reportData = collect($rabDetails->keys()->merge($realizations->keys())->unique())
            ->map(function ($key) use ($rabDetails, $realizations) {
                $rabItem = $rabDetails->get($key);
                $realizationItem = $realizations->get($key);

                $totalRab = $rabItem->total_rab ?? 0;
                $totalRealization = $realizationItem->total_realization ?? 0;

                return [
                    'Kode_Anggaran' => $rabItem->Kode_Anggaran ?? $realizationItem->Kode_Anggaran,
                    'Nama' => $rabItem->Nama ?? $realizationItem->Nama,
                    'Nama_Anggaran' => $rabItem->Nama_Anggaran ?? $realizationItem->Nama_Anggaran,
                    'RAB' => $totalRab,
                    'Realisasi' => $totalRealization,
                    'Selisih' => $totalRab - $totalRealization,
                ];
            })->sortBy('Kode_Anggaran')->values();

        $totalRab = $reportData->sum('RAB');
        $totalRealization = $reportData->sum('Realisasi');

        return response()->json([
            'success' => true,
            'data' => [
                'rab_info' => $rab,
                'report_items' => $reportData,
                'totals' => [
                    'total_rab' => $totalRab,
                    'total_realization' => $totalRealization,
                    'total_difference' => $totalRab - $totalRealization
                ]
            ]
        ]);
    }

    public function budgetAnalysis(string $nomor_rab): JsonResponse
    {
        Log::info("API: Budget analysis accessed for NOMOR_RAB: {$nomor_rab}");
        if (!Rab::where('NOMOR_RAB', $nomor_rab)->exists()) {
            Log::warning("API: Budget analysis failed. RAB not found: {$nomor_rab}");
            return response()->json([
                'success' => false,
                'message' => 'RAB not found'
            ], 404);
        }

        $analysis = DB::table('budget_codes as bc')
            ->leftJoin('rab_details as rd', fn ($join) => $join->on('bc.Kode_Anggaran', '=', 'rd.Kode_Anggaran')->where('rd.NOMOR_RAB', '=', $nomor_rab))
            ->leftJoin('realization as r', fn ($join) => $join->on('bc.Kode_Anggaran', '=', 'r.Kode_Anggaran')->where('r.NOMOR_RAB', '=', $nomor_rab))
            ->select(
                'bc.Kode_Anggaran',
                'bc.Nama_Anggaran',
                DB::raw('COALESCE(SUM(rd.Jumlah * rd.Harga_Satuan), 0) as total_rab'),
                DB::raw('COALESCE(SUM(r.Jumlah * r.Harga_Satuan), 0) as total_realization')
            )
            ->groupBy('bc.Kode_Anggaran', 'bc.Nama_Anggaran')
            ->get()
            ->map(function ($item) {
                $item->total_rab = (float)$item->total_rab;
                $item->total_realization = (float)$item->total_realization;
                $item->difference = $item->total_rab - $item->total_realization;
                $item->percentage_used = $item->total_rab > 0 ? round(($item->total_realization / $item->total_rab) * 100, 2) : 0;
                return $item;
            });
            
        return response()->json([
            'success' => true,
            'data' => [
                'rab_info' => Rab::find($nomor_rab),
                'budget_analysis' => $analysis
            ]
        ]);
    }
}