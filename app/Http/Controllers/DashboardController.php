<?php

namespace App\Http\Controllers;

use App\Models\Rab;
use App\Models\BudgetCode;
use App\Models\Realization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    public function index()
    {
        Log::info('WEB: Dashboard view accessed.');
        $rabs = Rab::with('details')->get();
        $budgetCodes = BudgetCode::all();
        
        $totalRabs = $rabs->count();
        $totalBudgetCodes = $budgetCodes->count();
        $totalRealizations = Realization::count();
        
        $recentRabs = Rab::orderBy('TANGGAL_RAP', 'desc')->take(5)->get();
        
        return view('dashboard', compact('rabs', 'budgetCodes', 'totalRabs', 'totalBudgetCodes', 'totalRealizations', 'recentRabs'));
    }

    public function rabList()
    {
        Log::info('WEB: RAB list view accessed.');
        $rabs = Rab::with('details')->get()->map(function ($rab) {
            $totalRab = $rab->details->map(function ($detail) {
                return $detail->Jumlah * $detail->Harga_Satuan;
            })->sum();
            $totalRealization = Realization::where('NOMOR_RAB', $rab->NOMOR_RAB)->sum(DB::raw('Jumlah * Harga_Satuan'));
            
            $rab->total_rab = $totalRab;
            $rab->total_realization = $totalRealization;
            $rab->difference = $totalRab - $totalRealization;
            
            return $rab;
        });
        
        return view('rab.index', compact('rabs'));
    }

     public function rabDetail(string $nomor_rab)
    {
        Log::info("WEB: RAB detail view accessed for NOMOR_RAB: {$nomor_rab}");
        $rab = Rab::with('details.budgetCode')->find($nomor_rab);
        
        if (!$rab) {
            Log::error("WEB: Attempted to access non-existent RAB detail: {$nomor_rab}");
            abort(404, 'RAB not found');
        }
        
        $realizations = Realization::with('budgetCode')
            ->where('NOMOR_RAB', $nomor_rab)
            ->orderBy('Tanggal', 'desc')
            ->get();
        
        return view('rab.detail', compact('rab', 'realizations'));
    }

    public function create()
    {
        Log::info('WEB: Create RAB form view accessed.');
        return view('rab.create');
    }

    public function store(Request $request)
    {
        Log::info('WEB: Processing store RAB request from web form.');
        $validated = $request->validate([
            'NOMOR_RAB' => 'required|string|max:10|unique:rab,NOMOR_RAB',
            'Kegiatan' => 'required|string|max:50',
            'TANGGAL_RAP' => 'required|date',
            'details' => 'required|array|min:1',
            'details.*.Kode_Anggaran' => 'required|string',
            'details.*.Nama' => 'required|string|max:100',
            'details.*.Jumlah' => 'required|integer|min:1',
            'details.*.Satuan' => 'required|string|max:20',
            'details.*.Harga_Satuan' => 'required|numeric|min:0',
        ]);

        DB::transaction(function () use ($validated) {
            $rab = Rab::create([
                'NOMOR_RAB' => $validated['NOMOR_RAB'],
                'Kegiatan' => $validated['Kegiatan'],
                'TANGGAL_RAP' => $validated['TANGGAL_RAP'],
            ]);

            foreach ($validated['details'] as $detail) {
                $rab->details()->create($detail);
            }
            Log::info("WEB: RAB created from web form with NOMOR_RAB: {$rab->NOMOR_RAB}");
        });

        return redirect()->route('rab.index')->with('success', 'RAB berhasil dibuat!');
    }

    public function edit(string $nomor_rab)
    {
        Log::info("WEB: Edit RAB form view accessed for NOMOR_RAB: {$nomor_rab}");
        $rab = Rab::with('details')->findOrFail($nomor_rab);
        return view('rab.edit', compact('rab'));
    }

    public function update(Request $request, string $nomor_rab)
    {
        Log::info("WEB: Processing update RAB request from web form for NOMOR_RAB: {$nomor_rab}");
        $validated = $request->validate([
            'Kegiatan' => 'required|string|max:50',
            'TANGGAL_RAP' => 'required|date',
            'details' => 'required|array|min:1',
            'details.*.Kode_Anggaran' => 'required|string',
            'details.*.Nama' => 'required|string|max:100',
            'details.*.Jumlah' => 'required|integer|min:1',
            'details.*.Satuan' => 'required|string|max:20',
            'details.*.Harga_Satuan' => 'required|numeric|min:0',
        ]);

        $rab = Rab::findOrFail($nomor_rab);

        DB::transaction(function () use ($rab, $validated) {
            $rab->update([
                'Kegiatan' => $validated['Kegiatan'],
                'TANGGAL_RAP' => $validated['TANGGAL_RAP'],
            ]);
            
            $rab->details()->delete();

            foreach ($validated['details'] as $detail) {
                $rab->details()->create($detail);
            }
            Log::info("WEB: RAB updated from web form with NOMOR_RAB: {$rab->NOMOR_RAB}");
        });

        return redirect()->route('rab.detail', $rab->NOMOR_RAB)->with('success', 'RAB berhasil diperbarui!');
    }

    public function destroy(string $nomor_rab)
    {
        Log::info("WEB: Processing delete RAB request from web form for NOMOR_RAB: {$nomor_rab}");
        $rab = Rab::findOrFail($nomor_rab);
        
        DB::transaction(function () use ($rab) {
            $rab->realizations()->delete();
            $rab->details()->delete();
            $rab->delete();
            Log::info("WEB: RAB deleted from web form with NOMOR_RAB: {$rab->NOMOR_RAB}");
        });

        return redirect()->route('rab.index')->with('success', 'RAB berhasil dihapus!');
    }
}