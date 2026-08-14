<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetailTransaksiBelanja extends Model
{
    protected $table = 'detail_transaksi_belanja';

    protected $fillable = [
        'transaksi_belanja_id',
        'kategori_produk_id',
        'jumlah',
        'harga_satuan',
        'subtotal',
    ];

    protected $casts = [
        'jumlah'       => 'decimal:2',
        'harga_satuan' => 'decimal:2',
        'subtotal'     => 'decimal:2',
    ];

    public function transaksiBelanja(): BelongsTo
    {
        return $this->belongsTo(TransaksiBelanja::class);
    }

    public function kategoriProduk(): BelongsTo
    {
        return $this->belongsTo(KategoriProduk::class);
    }
}
