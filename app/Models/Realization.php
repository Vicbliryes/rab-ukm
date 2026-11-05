<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Realization extends Model
{
    protected $table = 'realization';
    protected $primaryKey = 'ID';
    public $timestamps = false;

    protected $fillable = [
        'NOMOR_RAB',
        'Tanggal',
        'Kode_Anggaran',
        'Nama',
        'Jumlah',
        'Satuan',
        'Harga_Satuan'
    ];

    protected $casts = [
        'Tanggal' => 'date',
        'Harga_Satuan' => 'decimal:2'
    ];

    public function rab(): BelongsTo
    {
        return $this->belongsTo(Rab::class, 'NOMOR_RAB', 'NOMOR_RAB');
    }

    public function budgetCode(): BelongsTo
    {
        return $this->belongsTo(BudgetCode::class, 'Kode_Anggaran', 'Kode_Anggaran');
    }

    public function getTotalAttribute()
    {
        return $this->Jumlah * $this->Harga_Satuan;
    }
}