<?php

namespace App\Http\Controllers;

use App\Models\Rab;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ReportController extends Controller
{
    public function report(string $nomor_rab)
    {
        Log::info("WEB: Report view accessed for NOMOR_RAB: {$nomor_rab}");
        $rabInfo = Rab::find($nomor_rab);

        if (!$rabInfo) {
            Log::error("WEB: Attempted to access non-existent report for RAB: {$nomor_rab}");
            abort(404, 'RAB not found');
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
            ->keyBy(function ($item) {
                return $item->Kode_Anggaran . '_' . $item->Nama;
            });

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
            ->keyBy(function ($item) {
                return $item->Kode_Anggaran . '_' . $item->Nama;
            });

        $reportData = [];
        $allKeys = collect($rabDetails->keys())->merge($realizations->keys())->unique();

        foreach ($allKeys as $key) {
            $rabItem = $rabDetails->get($key);
            $realizationItem = $realizations->get($key);

            $totalRab = $rabItem ? $rabItem->total_rab : 0;
            $totalRealization = $realizationItem ? $realizationItem->total_realization : 0;

            $reportData[] = (object) [
                'Kode_Anggaran' => $rabItem ? $rabItem->Kode_Anggaran : $realizationItem->Kode_Anggaran,
                'Nama' => $rabItem ? $rabItem->Nama : $realizationItem->Nama,
                'Nama_Anggaran' => $rabItem ? $rabItem->Nama_Anggaran : $realizationItem->Nama_Anggaran,
                'RAB' => $totalRab,
                'Realisasi' => $totalRealization,
                'Selisih' => $totalRab - $totalRealization
            ];
        }

        $reportData = collect($reportData)->sortBy('Kode_Anggaran')->values()->all();

        $totalRab = collect($reportData)->sum('RAB');
        $totalRealization = collect($reportData)->sum('Realisasi');
        $totalSelisih = $totalRab - $totalRealization;

        return view('report', compact('rabInfo', 'reportData', 'totalRab', 'totalRealization', 'totalSelisih'));
    }
}
