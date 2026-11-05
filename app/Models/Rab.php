<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Rab extends Model
{
    protected $table = 'rab';
    protected $primaryKey = 'NOMOR_RAB';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'NOMOR_RAB',
        'Kegiatan',
        'TANGGAL_RAP'
    ];

    protected $casts = [
        'TANGGAL_RAP' => 'date'
    ];

    public function details(): HasMany
    {
        return $this->hasMany(RabDetail::class, 'NOMOR_RAB', 'NOMOR_RAB');
    }

    public function realizations(): HasMany
    {
        return $this->hasMany(Realization::class, 'NOMOR_RAB', 'NOMOR_RAB');
    }
}