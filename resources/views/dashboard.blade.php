@extends('layouts.app')

@section('title', 'Dashboard - Sistem RAB UKM')

@section('content')
<div class="page-header fade-in-up">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1><i class="fas fa-tachometer-alt me-3"></i>Dashboard</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="row mb-5">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="stats-card">
            <div class="stats-icon"><i class="fas fa-file-invoice-dollar"></i></div>
            <div class="stats-number">{{ $totalRabs }}</div>
            <div class="stats-label">Total RAB</div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="stats-card success">
            <div class="stats-icon"><i class="fas fa-tags"></i></div>
            <div class="stats-number">{{ $totalBudgetCodes }}</div>
            <div class="stats-label">Kode Anggaran</div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="stats-card warning">
            <div class="stats-icon"><i class="fas fa-clipboard-list"></i></div>
            <div class="stats-number">{{ $totalRealizations }}</div>
            <div class="stats-label">Total Realisasi</div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="stats-card danger">
            <div class="stats-icon"><i class="fas fa-chart-line"></i></div>
            <div class="stats-number">98%</div>
            <div class="stats-label">Efisiensi</div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-8 mb-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fas fa-clock me-2 text-primary"></i>RAB Terbaru</h5>
                <a href="{{ route('rab.index') }}" class="btn btn-sm btn-primary">
                    <i class="fas fa-eye me-1"></i>Lihat Semua
                </a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th><i class="fas fa-hashtag me-2"></i>Nomor RAB</th>
                                <th><i class="fas fa-tasks me-2"></i>Kegiatan</th>
                                <th><i class="fas fa-calendar me-2"></i>Tanggal</th>
                                <th><i class="fas fa-money-bill-wave me-2"></i>Total</th>
                                <th><i class="fas fa-cogs me-2"></i>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentRabs as $rab)
                            <tr>
                                <td><span class="badge bg-primary">{{ $rab->NOMOR_RAB }}</span></td>
                                <td><strong>{{ $rab->Kegiatan }}</strong></td>
                                <td>
                                    <i class="fas fa-calendar-alt me-2 text-muted"></i>
                                    {{ $rab->TANGGAL_RAP->format('d/m/Y') }}
                                </td>
                                <td>
                                    <span class="text-success fw-bold">
                                        Rp {{ number_format($rab->details->sum(fn($d) => $d->Jumlah * $d->Harga_Satuan), 0, ',', '.') }}
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('rab.detail', $rab->NOMOR_RAB) }}" class="btn btn-sm btn-outline-info" title="Detail"><i class="fas fa-eye"></i></a>
                                        <a href="{{ route('report', $rab->NOMOR_RAB) }}" class="btn btn-sm btn-outline-success" title="Laporan"><i class="fas fa-chart-bar"></i></a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-tags me-2 text-primary"></i>Kode Anggaran</h5>
            </div>
            <div class="card-body">
                @foreach($budgetCodes as $code)
                <div class="d-flex align-items-center justify-content-between mb-3 p-3 rounded" style="background: rgba(102, 126, 234, 0.05);">
                    <div class="d-flex align-items-center">
                        <div class="badge bg-primary me-3" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; font-size: 1rem;">
                            {{ $code->Kode_Anggaran }}
                        </div>
                        <span class="fw-medium">{{ $code->Nama_Anggaran }}</span>
                    </div>
                    <!-- <i class="fas fa-chevron-right text-muted"></i> -->
                </div>
                @endforeach
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-bolt me-2 text-warning"></i>Quick Actions</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('rab.create') }}" class="btn btn-primary"><i class="fas fa-plus me-2"></i>Buat RAB Baru</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection