<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BudgetCode extends Model
{
    protected $table = 'budget_codes';
    protected $primaryKey = 'Kode_Anggaran';
    public $timestamps = false;

    protected $fillable = [
        'Kode_Anggaran',
        'Nama_Anggaran'
    ];

    public function rabDetails(): HasMany
    {
        return $this->hasMany(RabDetail::class, 'Kode_Anggaran', 'Kode_Anggaran');
    }

    public function realizations(): HasMany
    {
        return $this->hasMany(Realization::class, 'Kode_Anggaran', 'Kode_Anggaran');
    }
}