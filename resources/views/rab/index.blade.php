@extends('layouts.app')

@section('title', 'Daftar RAB - Sistem RAB UKM')

@section('content')
<div class="page-header fade-in-up">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1><i class="fas fa-file-invoice-dollar me-3"></i>Daftar RAB</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Daftar RAB</li>
                </ol>
            </nav>
        </div>
        <div class="btn-toolbar">
            <a href="{{ route('rab.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Tambah RAB
            </a>
        </div>
    </div>
</div>

@if(session('success'))
<div class="alert alert-success fade-in-up">
    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
</div>
@endif

<!-- <div class="card mb-4 fade-in-up">
    <div class="card-body">
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="fas fa-search"></i>
                    </span>
                    <input type="text" class="form-control" placeholder="Cari RAB berdasarkan nomor atau kegiatan...">
                </div>
            </div>
            <div class="col-md-3">
                <select class="form-select">
                    <option>Semua Status</option>
                    <option>Belum Direalisasi</option>
                    <option>Hemat</option>
                    <option>Over Budget</option>
                    <option>Sesuai Budget</option>
                </select>
            </div>
            <div class="col-md-3">
                <select class="form-select">
                    <option>Urutkan: Terbaru</option>
                    <option>Urutkan: Terlama</option>
                    <option>Urutkan: Nama A-Z</option>
                    <option>Urutkan: Nama Z-A</option>
                </select>
            </div>
        </div>
    </div>
</div> -->

<div class="row">
    @foreach($rabs as $index => $rab)
    <div class="col-lg-6 col-xl-4 mb-4">
        <div class="card h-100 rab-card fade-in-up" style="animation-delay: {{ $index * 0.1 }}s;">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="mb-1">
                        <span class="badge bg-primary me-2">{{ $rab->NOMOR_RAB }}</span>
                    </h6>
                    <small class="text-muted">
                        <i class="fas fa-calendar me-1"></i>{{ $rab->TANGGAL_RAP->format('d M Y') }}
                    </small>
                </div>
                <div class="dropdown">
                    <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="dropdown">
                        <i class="fas fa-ellipsis-v"></i>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('rab.detail', $rab->NOMOR_RAB) }}">
                            <i class="fas fa-eye me-2"></i>Detail
                        </a></li>
                        <li><a class="dropdown-item" href="{{ route('report', $rab->NOMOR_RAB) }}">
                            <i class="fas fa-chart-bar me-2"></i>Laporan
                        </a></li>
                        <li><a class="dropdown-item" href="{{ route('rab.edit', $rab->NOMOR_RAB) }}">
                            <i class="fas fa-edit me-2"></i>Edit
                        </a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-danger" href="#" onclick="deleteRab('{{ $rab->NOMOR_RAB }}')">
                            <i class="fas fa-trash me-2"></i>Hapus
                        </a></li>
                    </ul>
                </div>
            </div>
            <div class="card-body">
                <h5 class="card-title text-truncate" title="{{ $rab->Kegiatan }}">
                    <i class="fas fa-tasks me-2 text-primary"></i>{{ $rab->Kegiatan }}
                </h5>
                
                <div class="row text-center mb-3">
                    <div class="col-4">
                        <div class="budget-stat">
                            <div class="budget-amount text-primary">
                                Rp {{ number_format($rab->total_rab / 1000, 0) }}K
                            </div>
                            <small class="text-muted">RAB</small>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="budget-stat">
                            <div class="budget-amount text-success">
                                Rp {{ number_format($rab->total_realization / 1000, 0) }}K
                            </div>
                            <small class="text-muted">Realisasi</small>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="budget-stat">
                            <div class="budget-amount {{ $rab->difference >= 0 ? 'text-success' : 'text-danger' }}">
                                Rp {{ number_format(abs($rab->difference) / 1000, 0) }}K
                            </div>
                            <small class="text-muted">{{ $rab->difference >= 0 ? 'Hemat' : 'Over' }}</small>
                        </div>
                    </div>
                </div>

                @php
                    $percentage = $rab->total_rab > 0 ? ($rab->total_realization / $rab->total_rab) * 100 : 0;
                    $progressClass = $percentage > 100 ? 'bg-danger' : ($percentage > 80 ? 'bg-warning' : 'bg-success');
                @endphp
                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <small class="text-muted">Progress Realisasi</small>
                        <small class="fw-bold">{{ number_format($percentage, 1) }}%</small>
                    </div>
                    <div class="progress" style="height: 8px;">
                        <div class="progress-bar {{ $progressClass }}" style="width: {{ min($percentage, 100) }}%"></div>
                    </div>
                </div>

                <div class="mb-3">
                    @if($rab->total_realization == 0)
                        <span class="badge bg-secondary">
                            <i class="fas fa-clock me-1"></i>Belum Direalisasi
                        </span>
                    @elseif($rab->difference > 0)
                        <span class="badge bg-success">
                            <i class="fas fa-check-circle me-1"></i>Hemat
                        </span>
                    @elseif($rab->difference < 0)
                        <span class="badge bg-danger">
                            <i class="fas fa-exclamation-triangle me-1"></i>Over Budget
                        </span>
                    @else
                        <span class="badge bg-info">
                            <i class="fas fa-balance-scale me-1"></i>Sesuai Budget
                        </span>
                    @endif
                </div>
            </div>
            <div class="card-footer bg-transparent">
                <div class="btn-group w-100" role="group">
                    <a href="{{ route('rab.detail', $rab->NOMOR_RAB) }}" class="btn btn-outline-info btn-sm">
                        <i class="fas fa-eye me-1"></i>Detail
                    </a>
                    <a href="{{ route('report', $rab->NOMOR_RAB) }}" class="btn btn-outline-success btn-sm">
                        <i class="fas fa-chart-bar me-1"></i>Laporan
                    </a>
                    <a href="{{ route('rab.edit', $rab->NOMOR_RAB) }}" class="btn btn-outline-warning btn-sm">
                        <i class="fas fa-edit me-1"></i>Edit
                    </a>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

@if($rabs->isEmpty())
<div class="text-center py-5">
    <div class="empty-state">
        <i class="fas fa-file-invoice-dollar fa-5x text-muted mb-4"></i>
        <h4 class="text-muted">Belum Ada RAB</h4>
        <p class="text-muted mb-4">Mulai dengan membuat RAB pertama Anda</p>
        <a href="{{ route('rab.create') }}" class="btn btn-primary btn-lg">
            <i class="fas fa-plus me-2"></i>Buat RAB Pertama
        </a>
    </div>
</div>
@endif

<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">
                    <i class="fas fa-exclamation-triangle me-2"></i>Konfirmasi Hapus
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus RAB ini?</p>
                <p class="text-muted">Tindakan ini tidak dapat dibatalkan dan akan menghapus semua data terkait.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash me-1"></i>Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
.rab-card {
    transition: all 0.3s ease;
    border: 2px solid transparent;
}

.rab-card:hover {
    border-color: #667eea;
    transform: translateY(-5px);
}

.budget-stat {
    padding: 0.5rem;
    border-radius: 8px;
    background: rgba(102, 126, 234, 0.05);
}

.budget-amount {
    font-weight: 700;
    font-size: 1rem;
}

.empty-state {
    padding: 3rem;
    border-radius: 20px;
    background: white;
    box-shadow: var(--card-shadow);
}

.progress {
    border-radius: 10px;
    background-color: rgba(0,0,0,0.1);
}

.progress-bar {
    border-radius: 10px;
}
</style>
@endsection

@section('scripts')
<script>
function deleteRab(nomorRab) {
    const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
    const form = document.getElementById('deleteForm');
    form.action = `/rab/${nomorRab}`;
    modal.show();
}

document.querySelector('input[placeholder*="Cari RAB"]').addEventListener('input', function(e) {
    const searchTerm = e.target.value.toLowerCase();
    const cards = document.querySelectorAll('.rab-card');
    
    cards.forEach(card => {
        const title = card.querySelector('.card-title').textContent.toLowerCase();
        const badge = card.querySelector('.badge').textContent.toLowerCase();
        
        if (title.includes(searchTerm) || badge.includes(searchTerm)) {
            card.closest('.col-lg-6').style.display = 'block';
        } else {
            card.closest('.col-lg-6').style.display = 'none';
        }
    });
});
</script>
@endsection
