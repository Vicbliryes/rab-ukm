@extends('layouts.app')

@section('title', 'Detail RAB ' . $rab->NOMOR_RAB . ' - Sistem RAB UKM')

@section('content')
<div id="success-alert" class="alert alert-success fade-in-up" style="display: none;">
    <i class="fas fa-check-circle me-2"></i>
    <span id="success-message"></span>
</div>

<div class="page-header fade-in-up">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1><i class="fas fa-file-invoice me-3"></i>Detail RAB {{ $rab->NOMOR_RAB }}</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('rab.index') }}">Daftar RAB</a></li>
                    <li class="breadcrumb-item active">{{ $rab->NOMOR_RAB }}</li>
                </ol>
            </nav>
        </div>
        <div class="btn-toolbar">
            <div class="btn-group me-2">
                <a href="{{ route('report', $rab->NOMOR_RAB) }}" class="btn btn-success">
                    <i class="fas fa-chart-bar me-2"></i>Lihat Laporan
                </a>
                <a href="{{ route('rab.edit', $rab->NOMOR_RAB) }}" class="btn btn-warning">
                    <i class="fas fa-edit me-2"></i>Edit RAB
                </a>
            </div>
            <a href="{{ route('rab.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="stats-card">
            <div class="stats-icon">
                <i class="fas fa-file-invoice-dollar"></i>
            </div>
            <div class="stats-number">{{ $rab->NOMOR_RAB }}</div>
            <div class="stats-label">Nomor RAB</div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="stats-card success">
            <div class="stats-icon">
                <i class="fas fa-calendar"></i>
            </div>
            <div class="stats-number">{{ $rab->TANGGAL_RAP->format('d/m') }}</div>
            <div class="stats-label">{{ $rab->TANGGAL_RAP->format('M Y') }}</div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="stats-card warning">
            <div class="stats-icon">
                <i class="fas fa-money-bill-wave"></i>
            </div>
            <div class="stats-number">{{ number_format($rab->details->sum(function($d) { return $d->Jumlah * $d->Harga_Satuan; }) / 1000000, 1) }}M</div>
            <div class="stats-label">Total Anggaran</div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="stats-card danger">
            <div class="stats-icon">
                <i class="fas fa-clipboard-check"></i>
            </div>
            <div class="stats-number">{{ number_format($realizations->sum('total') / 1000000, 1) }}M</div>
            <div class="stats-label">Total Realisasi</div>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-8">
        <div class="card fade-in-up">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-info-circle me-2 text-primary"></i>Informasi RAB
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="info-item mb-3">
                            <label class="text-muted small">Nomor RAB</label>
                            <div class="fw-bold">{{ $rab->NOMOR_RAB }}</div>
                        </div>
                        <div class="info-item mb-3">
                            <label class="text-muted small">Kegiatan</label>
                            <div class="fw-bold">{{ $rab->Kegiatan }}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-item mb-3">
                            <label class="text-muted small">Tanggal RAB</label>
                            <div class="fw-bold">{{ $rab->TANGGAL_RAP->format('d F Y') }}</div>
                        </div>
                        <div class="info-item mb-3">
                            <label class="text-muted small">Total Anggaran</label>
                            <div class="fw-bold text-success fs-5">
                                Rp {{ number_format($rab->details->sum(function($d) { return $d->Jumlah * $d->Harga_Satuan; }), 0, ',', '.') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card fade-in-up">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-chart-pie me-2 text-info"></i>Progress
                </h5>
            </div>
            <div class="card-body text-center">
                @php
                    $totalRab = $rab->details->sum(function($d) { return $d->Jumlah * $d->Harga_Satuan; });
                    $totalRealization = $realizations->sum('total');
                    $percentage = $totalRab > 0 ? ($totalRealization / $totalRab) * 100 : 0;
                @endphp
                <div class="progress-circle mb-3">
                    <div class="progress-value">{{ number_format($percentage, 1) }}%</div>
                </div>
                <p class="text-muted mb-0">Realisasi dari Total Anggaran</p>
            </div>
        </div>
    </div>
</div>

<div class="card mb-4 fade-in-up">
    <div class="card-header">
        <h5 class="mb-0">
            <i class="fas fa-list me-2 text-primary"></i>Detail Anggaran
        </h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th><i class="fas fa-hashtag me-2"></i>Kode</th>
                        <th><i class="fas fa-tags me-2"></i>Kategori</th>
                        <th><i class="fas fa-box me-2"></i>Nama Item</th>
                        <th><i class="fas fa-sort-numeric-up me-2"></i>Jumlah</th>
                        <th><i class="fas fa-ruler me-2"></i>Satuan</th>
                        <th><i class="fas fa-money-bill me-2"></i>Harga Satuan</th>
                        <th><i class="fas fa-calculator me-2"></i>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($rab->details as $detail)
                    <tr>
                        <td><span class="badge bg-primary">{{ $detail->Kode_Anggaran }}</span></td>
                        <td>
                            <span class="fw-medium">{{ $detail->budgetCode->Nama_Anggaran }}</span>
                        </td>
                        <td>{{ $detail->Nama }}</td>
                        <td class="text-center">
                            <span class="badge bg-light text-dark">{{ $detail->Jumlah }}</span>
                        </td>
                        <td>{{ $detail->Satuan }}</td>
                        <td class="text-end">Rp {{ number_format($detail->Harga_Satuan, 0, ',', '.') }}</td>
                        <td class="text-end">
                            <strong class="text-success">Rp {{ number_format($detail->total, 0, ',', '.') }}</strong>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot class="table-light">
                    <tr>
                        <th colspan="6" class="text-end">Total Anggaran:</th>
                        <th class="text-end text-success">
                            Rp {{ number_format($rab->details->sum('total'), 0, ',', '.') }}
                        </th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<div class="card fade-in-up">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">
            <i class="fas fa-clipboard-list me-2 text-success"></i>Realisasi Biaya
        </h5>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addRealizationModal">
            <i class="fas fa-plus me-2"></i>Tambah Realisasi
        </button>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0" id="realization-table">
                <thead>
                    <tr>
                        <th><i class="fas fa-calendar me-2"></i>Tanggal</th>
                        <th><i class="fas fa-hashtag me-2"></i>Kode</th>
                        <th><i class="fas fa-tags me-2"></i>Kategori</th>
                        <th><i class="fas fa-box me-2"></i>Nama Item</th>
                        <th><i class="fas fa-sort-numeric-up me-2"></i>Jumlah</th>
                        <th><i class="fas fa-ruler me-2"></i>Satuan</th>
                        <th><i class="fas fa-money-bill me-2"></i>Harga Satuan</th>
                        <th><i class="fas fa-calculator me-2"></i>Total</th>
                    </tr>
                </thead>
                <tbody id="realization-table-body">
                    @forelse($realizations as $realization)
                    <tr id="realization-row-{{ $realization->ID }}">
                        <td>
                            <span class="badge bg-light text-dark">
                                <i class="fas fa-calendar-alt me-1"></i>
                                {{ $realization->Tanggal->format('d/m/Y') }}
                            </span>
                        </td>
                        <td><span class="badge bg-info">{{ $realization->Kode_Anggaran }}</span></td>
                        <td>{{ $realization->budgetCode->Nama_Anggaran }}</td>
                        <td>{{ $realization->Nama }}</td>
                        <td class="text-center">
                            <span class="badge bg-light text-dark">{{ $realization->Jumlah }}</span>
                        </td>
                        <td>{{ $realization->Satuan }}</td>
                        <td class="text-end">Rp {{ number_format($realization->Harga_Satuan, 0, ',', '.') }}</td>
                        <td class="text-end">
                            <strong class="text-success">Rp {{ number_format($realization->total, 0, ',', '.') }}</strong>
                        </td>
                    </tr>
                    @empty
                    <tr id="no-realization-row">
                        <td colspan="8" class="text-center py-5"> {{-- Colspan diubah dari 9 menjadi 8 --}}
                            <div class="empty-state-small">
                                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                <h6 class="text-muted">Belum ada realisasi biaya</h6>
                                <p class="text-muted mb-3">Mulai dengan menambahkan realisasi pertama</p>
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addRealizationModal">
                                    <i class="fas fa-plus me-1"></i>Tambah Realisasi
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
                <tfoot class="table-light">
                    <tr>
                        <th colspan="7" class="text-end">Total Realisasi:</th> {{-- Colspan diubah dari 7 menjadi 7 (sudah benar) --}}
                        <th class="text-end text-success" id="total-realization-footer">
                            Rp {{ number_format($realizations->sum('total'), 0, ',', '.') }}
                        </th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="addRealizationModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-plus me-2"></i>Tambah Realisasi Baru
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="addRealizationForm">
                <div class="modal-body">
                    <input type="hidden" name="NOMOR_RAB" value="{{ $rab->NOMOR_RAB }}">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="Tanggal" class="form-label">
                                <i class="fas fa-calendar me-1"></i>Tanggal
                            </label>
                            <input type="date" class="form-control" name="Tanggal" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="Kode_Anggaran" class="form-label">
                                <i class="fas fa-hashtag me-1"></i>Kode Anggaran
                            </label>
                            <select class="form-select" name="Kode_Anggaran" required>
                                <option value="">Pilih Kode Anggaran</option>
                                @foreach($rab->details->groupBy('Kode_Anggaran') as $kode => $details)
                                <option value="{{ $kode }}">{{ $kode }} - {{ $details->first()->budgetCode->Nama_Anggaran }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="Nama" class="form-label">
                            <i class="fas fa-box me-1"></i>Nama Item
                        </label>
                        <input type="text" class="form-control" name="Nama" required>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="Jumlah" class="form-label">
                                <i class="fas fa-sort-numeric-up me-1"></i>Jumlah
                            </label>
                            <input type="number" class="form-control" name="Jumlah" required min="1">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="Satuan" class="form-label">
                                <i class="fas fa-ruler me-1"></i>Satuan
                            </label>
                            <input type="text" class="form-control" name="Satuan" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="Harga_Satuan" class="form-label">
                                <i class="fas fa-money-bill me-1"></i>Harga Satuan
                            </label>
                            <input type="number" class="form-control" name="Harga_Satuan" required min="0">
                        </div>
                    </div>
                    <div id="add-errors" class="alert alert-danger" style="display:none;"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i>Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="editRealizationModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-edit me-2"></i>Edit Realisasi
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editRealizationForm">
                <div class="modal-body">
                    <input type="hidden" name="NOMOR_RAB" value="{{ $rab->NOMOR_RAB }}">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="edit_Tanggal" class="form-label">
                                <i class="fas fa-calendar me-1"></i>Tanggal
                            </label>
                            <input type="date" class="form-control" id="edit_Tanggal" name="Tanggal" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="edit_Kode_Anggaran" class="form-label">
                                <i class="fas fa-hashtag me-1"></i>Kode Anggaran
                            </label>
                            <select class="form-select" id="edit_Kode_Anggaran" name="Kode_Anggaran" required>
                                <option value="">Pilih Kode Anggaran</option>
                                @foreach($rab->details->groupBy('Kode_Anggaran') as $kode => $details)
                                <option value="{{ $kode }}">{{ $kode }} - {{ $details->first()->budgetCode->Nama_Anggaran }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="edit_Nama" class="form-label">
                            <i class="fas fa-box me-1"></i>Nama Item
                        </label>
                        <input type="text" class="form-control" id="edit_Nama" name="Nama" required>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="edit_Jumlah" class="form-label">
                                <i class="fas fa-sort-numeric-up me-1"></i>Jumlah
                            </label>
                            <input type="number" class="form-control" id="edit_Jumlah" name="Jumlah" required min="1">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="edit_Satuan" class="form-label">
                                <i class="fas fa-ruler me-1"></i>Satuan
                            </label>
                            <input type="text" class="form-control" id="edit_Satuan" name="Satuan" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="edit_Harga_Satuan" class="form-label">
                                <i class="fas fa-money-bill me-1"></i>Harga Satuan
                            </label>
                            <input type="number" class="form-control" id="edit_Harga_Satuan" name="Harga_Satuan" required min="0">
                        </div>
                    </div>
                    <div id="edit-errors" class="alert alert-danger" style="display:none;"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i>Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.info-item {
    padding: 0.75rem;
    background: rgba(102, 126, 234, 0.05);
    border-radius: 8px;
    border-left: 4px solid #667eea;
}
.progress-circle {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    background: conic-gradient(#667eea {{ $percentage }}%, #e9ecef {{ $percentage }}%);
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
    position: relative;
}
.progress-circle::before {
    content: '';
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background: white;
    position: absolute;
}
.progress-value {
    position: relative;
    z-index: 1;
    font-weight: 700;
    color: #2c3e50;
}
.empty-state-small {
    padding: 2rem;
}
.btn-group .btn {
    margin: 0 2px;
}
</style>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const addModal = new bootstrap.Modal(document.getElementById('addRealizationModal'));
    const editModal = new bootstrap.Modal(document.getElementById('editRealizationModal'));
    const addForm = document.getElementById('addRealizationForm');
    const editForm = document.getElementById('editRealizationForm');
    const tableBody = document.getElementById('realization-table-body');

    const formatCurrency = (number) => new Intl.NumberFormat('id-ID', { 
        style: 'currency', 
        currency: 'IDR', 
        minimumFractionDigits: 0 
    }).format(number);
    
    const formatDate = (dateString) => new Date(dateString).toLocaleDateString('id-ID', { 
        day: '2-digit', 
        month: '2-digit', 
        year: 'numeric' 
    });

    function showAlert(message) {
        const alertDiv = document.getElementById('success-alert');
        const messageSpan = document.getElementById('success-message');
        messageSpan.textContent = message;
        alertDiv.style.display = 'block';
        alertDiv.scrollIntoView({ behavior: 'smooth' });
        setTimeout(() => {
            alertDiv.style.display = 'none';
        }, 5000);
    }

    function renderRow(realization) {
        const total = realization.Jumlah * realization.Harga_Satuan;
        const budgetCodeName = realization.budget_code ? realization.budget_code.Nama_Anggaran : '(data baru)';
        
        return `
            <td>
                <span class="badge bg-light text-dark">
                    <i class="fas fa-calendar-alt me-1"></i>
                    ${formatDate(realization.Tanggal)}
                </span>
            </td>
            <td><span class="badge bg-info">${realization.Kode_Anggaran}</span></td>
            <td>${budgetCodeName}</td>
            <td>${realization.Nama}</td>
            <td class="text-center">
                <span class="badge bg-light text-dark">${realization.Jumlah}</span>
            </td>
            <td>${realization.Satuan}</td>
            <td class="text-end">${formatCurrency(realization.Harga_Satuan)}</td>
            <td class="text-end">
                <strong class="text-success">${formatCurrency(total)}</strong>
            </td>
        `;
    }
    
    function updateTotal() {
        let total = 0;
        tableBody.querySelectorAll('tr[id^="realization-row-"]').forEach(row => {
            const totalText = row.cells[7].textContent; 
            const number = parseFloat(totalText.replace(/[^0-9,-]+/g,"").replace(",", "."));
            if (!isNaN(number)) {
                total += number;
            }
        });
        document.getElementById('total-realization-footer').textContent = formatCurrency(total);
    }

    addForm.addEventListener('submit', function (e) {
        e.preventDefault();
        const formData = new FormData(this);
        const submitBtn = this.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        
        submitBtn.innerHTML = '<div class="spinner-border spinner-border-sm me-2" role="status"></div>Menyimpan...';
        submitBtn.disabled = true;

        fetch('/api/realizations', {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const noDataRow = document.getElementById('no-realization-row');
                if (noDataRow) noDataRow.remove();

                const newRow = document.createElement('tr');
                newRow.id = `realization-row-${data.data.ID}`;
                newRow.innerHTML = renderRow(data.data);
                tableBody.appendChild(newRow);
                
                addForm.reset();
                addModal.hide();
                showAlert(data.message);
                updateTotal();
                
                document.getElementById('add-errors').style.display = 'none';
            } else {
                const errorDiv = document.getElementById('add-errors');
                errorDiv.innerHTML = '';
                for (const error in data.errors) {
                    errorDiv.innerHTML += `<p class="mb-1"><i class="fas fa-exclamation-circle me-1"></i>${data.errors[error][0]}</p>`;
                }
                errorDiv.style.display = 'block';
            }
        }).catch(error => {
            console.error('Error:', error);
            showAlert('Terjadi kesalahan saat menyimpan data');
        }).finally(() => {
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        });
    });

});
</script>
@endsection