<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TransaksiBelanja extends Model
{
    protected $table = 'transaksi_belanja';

    protected $fillable = [
        'user_id',
        'total_belanja',
        'bayar_saldo',
        'bayar_tunai',
        'status',
        'keterangan',
    ];

    protected $casts = [
        'total_belanja' => 'decimal:2',
        'bayar_saldo'   => 'decimal:2',
        'bayar_tunai'   => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function details(): HasMany
    {
        return $this->hasMany(DetailTransaksiBelanja::class);
    }
}
