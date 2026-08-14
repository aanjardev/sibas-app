<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RiwayatSaldo extends Model
{
    protected $table = 'riwayat_saldo';

    protected $fillable = [
        'user_id',
        'jenis',
        'nominal',
        'saldo_sebelum',
        'saldo_sesudah',
        'reference_id',
        'keterangan',
    ];

    protected $casts = [
        'nominal'       => 'decimal:2',
        'saldo_sebelum' => 'decimal:2',
        'saldo_sesudah' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
