@extends('layouts.app')

@section('title', 'Tambah RAB Baru - Sistem RAB UKM')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
    <h1 class="h2">Tambah RAB Baru</h1>
    <a href="{{ route('rab.index') }}" class="btn btn-sm btn-secondary">
        <i class="fas fa-arrow-left me-1"></i>Kembali
    </a>
</div>

<div class="card shadow">
    <div class="card-body">
        <form action="{{ route('rab.store') }}" method="POST">
            @csrf
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="NOMOR_RAB" class="form-label">Nomor RAB</label>
                    <input type="text" class="form-control" id="NOMOR_RAB" name="NOMOR_RAB" required>
                </div>
                <div class="col-md-8">
                    <label for="Kegiatan" class="form-label">Nama Kegiatan</label>
                    <input type="text" class="form-control" id="Kegiatan" name="Kegiatan" required>
                </div>
            </div>
             <div class="row mb-3">
                <div class="col-md-4">
                    <label for="TANGGAL_RAP" class="form-label">Tanggal RAB</label>
                    <input type="date" class="form-control" id="TANGGAL_RAP" name="TANGGAL_RAP" required>
                </div>
            </div>

            <hr>

            <h5>Detail Anggaran</h5>
            <div id="details-container">
                <div class="row detail-item mb-2">
                    <div class="col-md-2">
                        <input type="text" name="details[0][Kode_Anggaran]" class="form-control" placeholder="Kode Anggaran" required>
                    </div>
                    <div class="col-md-3">
                        <input type="text" name="details[0][Nama]" class="form-control" placeholder="Nama Item" required>
                    </div>
                    <div class="col-md-1">
                        <input type="number" name="details[0][Jumlah]" class="form-control" placeholder="Jumlah" required>
                    </div>
                    <div class="col-md-2">
                        <input type="text" name="details[0][Satuan]" class="form-control" placeholder="Satuan" required>
                    </div>
                    <div class="col-md-3">
                        <input type="number" name="details[0][Harga_Satuan]" class="form-control" placeholder="Harga Satuan" required>
                    </div>
                    <div class="col-md-1">
                        <button type="button" class="btn btn-sm btn-danger remove-detail-btn">Hapus</button>
                    </div>
                </div>
            </div>
            
            <button type="button" id="add-detail-btn" class="btn btn-sm btn-success mt-2">
                <i class="fas fa-plus me-1"></i>Tambah Detail
            </button>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">Simpan RAB</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    let detailIndex = 1;
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