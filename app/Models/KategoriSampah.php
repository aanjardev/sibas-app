<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KategoriSampah extends Model
{
    protected $table = 'kategori_sampah';

    protected $fillable = [
        'nama',
        'satuan',
        'harga_beli',
        'is_active',
    ];

    protected $casts = [
        'harga_beli' => 'decimal:2',
        'is_active'  => 'boolean',
    ];

    public function transaksiSampah(): HasMany
    {
        return $this->hasMany(TransaksiSampah::class);
    }
}
