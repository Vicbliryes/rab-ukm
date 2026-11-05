@extends('layouts.app')

@section('title', 'Edit RAB ' . $rab->NOMOR_RAB . ' - Sistem RAB UKM')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
    <h1 class="h2">Edit RAB {{ $rab->NOMOR_RAB }}</h1>
    <a href="{{ route('rab.detail', $rab->NOMOR_RAB) }}" class="btn btn-sm btn-secondary">
        <i class="fas fa-arrow-left me-1"></i>Kembali
    </a>
</div>

<div class="card shadow">
    <div class="card-body">
        <form action="{{ route('rab.update', $rab->NOMOR_RAB) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="NOMOR_RAB" class="form-label">Nomor RAB</label>
                    <input type="text" class="form-control" id="NOMOR_RAB" name="NOMOR_RAB" value="{{ $rab->NOMOR_RAB }}" required disabled>
                </div>
                <div class="col-md-8">
                    <label for="Kegiatan" class="form-label">Nama Kegiatan</label>
                    <input type="text" class="form-control" id="Kegiatan" name="Kegiatan" value="{{ $rab->Kegiatan }}" required>
                </div>
            </div>
             <div class="row mb-3">
                <div class="col-md-4">
                    <label for="TANGGAL_RAP" class="form-label">Tanggal RAB</label>
                    <input type="date" class="form-control" id="TANGGAL_RAP" name="TANGGAL_RAP" value="{{ $rab->TANGGAL_RAP->format('Y-m-d') }}" required>
                </div>
            </div>

            <hr>

            <h5>Detail Anggaran</h5>
            <div id="details-container">
                @foreach($rab->details as $index => $detail)
                <div class="row detail-item mb-2">
                    <div class="col-md-2">
                        <input type="text" name="details[{{ $index }}][Kode_Anggaran]" class="form-control" placeholder="Kode Anggaran" value="{{ $detail->Kode_Anggaran }}" required>
                    </div>
                    <div class="col-md-3">
                        <input type="text" name="details[{{ $index }}][Nama]" class="form-control" placeholder="Nama Item" value="{{ $detail->Nama }}" required>
                    </div>
                    <div class="col-md-1">
                        <input type="number" name="details[{{ $index }}][Jumlah]" class="form-control" placeholder="Jumlah" value="{{ $detail->Jumlah }}" required>
                    </div>
                    <div class="col-md-2">
                        <input type="text" name="details[{{ $index }}][Satuan]" class="form-control" placeholder="Satuan" value="{{ $detail->Satuan }}" required>
                    </div>
                    <div class="col-md-3">
                        <input type="number" name="details[{{ $index }}][Harga_Satuan]" class="form-control" placeholder="Harga Satuan" value="{{ $detail->Harga_Satuan }}" required>
                    </div>
                    <div class="col-md-1">
                        <button type="button" class="btn btn-sm btn-danger remove-detail-btn">Hapus</button>
                    </div>
                </div>
                @endforeach
            </div>
            
            <button type="button" id="add-detail-btn" class="btn btn-sm btn-success mt-2">
                <i class="fas fa-plus me-1"></i>Tambah Detail
            </button>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">Update RAB</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    let detailIndex = {{ $rab->details->count() }};
    document.getElementById('add-detail-btn').addEventListener('click', function () {
        const container = document.getElementById('details-container');
        const newDetail = document.createElement('div');
        newDetail.classList.add('row', 'detail-item', 'mb-2');
        newDetail.innerHTML = `
            <div class="col-md-2"><input type="text" name="details[${detailIndex}][Kode_Anggaran]" class="form-control" placeholder="Kode Anggaran" required></div>
            <div class="col-md-3"><input type="text" name="details[${detailIndex}][Nama]" class="form-control" placeholder="Nama Item" required></div>
            <div class="col-md-1"><input type="number" name="details[${detailIndex}][Jumlah]" class="form-control" placeholder="Jumlah" required></div>
            <div class="col-md-2"><input type="text" name="details[${detailIndex}][Satuan]" class="form-control" placeholder="Satuan" required></div>
            <div class="col-md-3"><input type="number" name="details[${detailIndex}][Harga_Satuan]" class="form-control" placeholder="Harga Satuan" required></div>
            <div class="col-md-1"><button type="button" class="btn btn-sm btn-danger remove-detail-btn">Hapus</button></div>
        `;
        container.appendChild(newDetail);
        detailIndex++;
    });

    document.getElementById('details-container').addEventListener('click', function(e) {
        if (e.target && e.target.classList.contains('remove-detail-btn')) {
            e.target.closest('.detail-item').remove();
        }
    });
});
</script>
@endsection