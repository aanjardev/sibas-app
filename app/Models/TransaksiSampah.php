<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TransaksiSampah extends Model
{
    protected $table = 'transaksi_sampah';

    protected $fillable = [
        'user_id',
        'kategori_sampah_id',
        'berat',
        'harga_satuan',
        'total',
        'keterangan',
    ];

    protected $casts = [
        'berat'        => 'decimal:2',
        'harga_satuan' => 'decimal:2',
        'total'        => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function kategoriSampah(): BelongsTo
    {
        return $this->belongsTo(KategoriSampah::class);
    }
}
