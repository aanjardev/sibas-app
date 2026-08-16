<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'nomor_anggota',
        'no_hp',
        'alamat',
        'saldo',
        'saldo_tabungan',
        'is_active',
        'last_notif_read_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at'  => 'datetime',
            'password'           => 'hashed',
            'saldo'              => 'decimal:2',
            'saldo_tabungan'     => 'decimal:2',
            'is_active'          => 'boolean',
            'last_notif_read_at' => 'datetime',
        ];
    }

    public function transaksiSampah(): HasMany
    {
        return $this->hasMany(TransaksiSampah::class);
    }

    public function transaksiBelanja(): HasMany
    {
        return $this->hasMany(TransaksiBelanja::class);
    }

    public function riwayatSaldo(): HasMany
    {
        return $this->hasMany(RiwayatSaldo::class);
    }

    public function riwayatTabungan(): HasMany
    {
        return $this->hasMany(RiwayatTabungan::class);
    }
}
