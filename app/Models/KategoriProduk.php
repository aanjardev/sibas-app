<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KategoriProduk extends Model
{
    protected $table = 'kategori_produk';

    protected $fillable = [
        'nama',
        'satuan',
        'harga_jual',
        'stok',
        'is_active',
        'foto',
    ];

    protected $casts = [
        'harga_jual' => 'decimal:2',
        'stok'       => 'decimal:2',
        'is_active'  => 'boolean',
    ];

    public function detailTransaksiBelanja(): HasMany
    {
        return $this->hasMany(DetailTransaksiBelanja::class);
    }
}
