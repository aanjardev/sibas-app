@extends('layouts.mobile')

@section('title', 'Notifikasi')
@section('header_title', 'Notifikasi')

@section('content')

@php
    $hasAny = $hariIni->isNotEmpty() || $mingguIni->isNotEmpty() || $lebihLama->isNotEmpty();
@endphp

@if (!$hasAny)
<div class="text-center py-5 mt-3">
    <i class="bi bi-bell-slash text-muted" style="font-size: 3rem;"></i>
    <h6 class="fw-bold mt-3 mb-1">Belum Ada Notifikasi</h6>
    <p class="text-muted text-sm">Aktivitas transaksi Anda akan muncul di sini.</p>
</div>
@else

@if ($hariIni->isNotEmpty())
<h6 class="fw-bold mb-3 text-sm text-uppercase text-muted tracking-wide px-1 mt-2">Hari Ini</h6>

<div class="surface-card mb-4 p-0">
    @foreach ($hariIni as $notif)
    <div class="d-flex p-3 {{ !$loop->last ? 'border-bottom' : '' }}" style="border-color: var(--border-color) !important;">
        @if (isset($notif->is_db_notif) && $notif->is_db_notif)
        <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3 flex-shrink-0" style="width: 42px; height: 42px;">
            <i class="bi bi-info-circle text-primary fs-5"></i>
        </div>
        @elseif (in_array($notif->jenis, ['penukaran_sampah', 'deposit']))
        <div class="bg-success bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3 flex-shrink-0" style="width: 42px; height: 42px;">
            <i class="bi bi-{{ $notif->jenis === 'penukaran_sampah' ? 'recycle' : 'wallet2' }} text-success fs-5"></i>
        </div>
        @else
        <div class="bg-warning bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3 flex-shrink-0" style="width: 42px; height: 42px;">
            <i class="bi bi-{{ $notif->jenis === 'belanja' ? 'shop' : 'cash-coin' }}" style="color: #ea580c; font-size: 1.15rem;"></i>
        </div>
        @endif
        <div class="flex-grow-1" style="min-width: 0;">
            <div class="d-flex justify-content-between align-items-start mb-1">
                <h6 class="fw-bold mb-0 text-main" style="font-size: 0.95rem;">
                    @if (isset($notif->is_db_notif) && $notif->is_db_notif)
                        {{ $notif->title }}
                    @else
                        {{ match($notif->jenis) { 'penukaran_sampah' => 'Setoran Berhasil', 'belanja' => 'Transaksi Koperasi', 'deposit' => 'Setor Tunai', 'penarikan' => 'Tarik Tunai', default => ucfirst($notif->jenis) } }}
                    @endif
                </h6>
                <small class="text-muted text-xs ms-2">{{ $notif->created_at->format('H:i') }}</small>
            </div>
            <p class="text-muted text-sm mb-0" style="line-height: 1.4;">
                @if (isset($notif->is_db_notif) && $notif->is_db_notif)
                    {{ $notif->keterangan }}
                @elseif (in_array($notif->jenis, ['penukaran_sampah', 'deposit']))
                    Saldo Anda bertambah <span class="fw-bold text-success">+ Rp {{ number_format($notif->nominal, 0, ',', '.') }}</span>{{ $notif->keterangan ? ' dari ' . $notif->keterangan : '' }}.
                @else
                    Saldo Anda terpotong <span class="fw-bold" style="color: #ea580c;">- Rp {{ number_format($notif->nominal, 0, ',', '.') }}</span>{{ $notif->keterangan ? ' untuk ' . $notif->keterangan : '' }}.
                @endif
            </p>
        </div>
    </div>
    @endforeach
</div>
@endif

@if ($mingguIni->isNotEmpty())
<h6 class="fw-bold mb-3 text-sm text-uppercase text-muted tracking-wide px-1">Minggu Ini</h6>

<div class="surface-card mb-4 p-0">
    @foreach ($mingguIni as $notif)
    <div class="d-flex p-3 {{ !$loop->last ? 'border-bottom' : '' }}" style="border-color: var(--border-color) !important;">
        @if (isset($notif->is_db_notif) && $notif->is_db_notif)
        <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3 flex-shrink-0" style="width: 42px; height: 42px;">
            <i class="bi bi-info-circle text-primary fs-5"></i>
        </div>
        @elseif (in_array($notif->jenis, ['penukaran_sampah', 'deposit']))
        <div class="bg-success bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3 flex-shrink-0" style="width: 42px; height: 42px;">
            <i class="bi bi-{{ $notif->jenis === 'penukaran_sampah' ? 'recycle' : 'wallet2' }} text-success fs-5"></i>
        </div>
        @else
        <div class="bg-warning bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3 flex-shrink-0" style="width: 42px; height: 42px;">
            <i class="bi bi-{{ $notif->jenis === 'belanja' ? 'shop' : 'cash-coin' }}" style="color: #ea580c; font-size: 1.15rem;"></i>
        </div>
        @endif
        <div class="flex-grow-1" style="min-width: 0;">
            <div class="d-flex justify-content-between align-items-start mb-1">
                <h6 class="fw-bold mb-0 text-main" style="font-size: 0.95rem;">
                    @if (isset($notif->is_db_notif) && $notif->is_db_notif)
                        {{ $notif->title }}
                    @else
                        {{ match($notif->jenis) { 'penukaran_sampah' => 'Setoran Berhasil', 'belanja' => 'Transaksi Koperasi', 'deposit' => 'Setor Tunai', 'penarikan' => 'Tarik Tunai', default => ucfirst($notif->jenis) } }}
                    @endif
                </h6>
                <small class="text-muted text-xs ms-2">{{ $notif->created_at->translatedFormat('d M') }}</small>
            </div>
            <p class="text-muted text-sm mb-0" style="line-height: 1.4;">
                @if (isset($notif->is_db_notif) && $notif->is_db_notif)
                    {{ $notif->keterangan }}
                @elseif (in_array($notif->jenis, ['penukaran_sampah', 'deposit']))
                    Saldo Anda bertambah <span class="fw-bold text-success">+ Rp {{ number_format($notif->nominal, 0, ',', '.') }}</span>{{ $notif->keterangan ? ' dari ' . $notif->keterangan : '' }}.
                @else
                    Saldo Anda terpotong <span class="fw-bold" style="color: #ea580c;">- Rp {{ number_format($notif->nominal, 0, ',', '.') }}</span>{{ $notif->keterangan ? ' untuk ' . $notif->keterangan : '' }}.
                @endif
            </p>
        </div>
    </div>
    @endforeach
</div>
@endif

@if ($lebihLama->isNotEmpty())
<h6 class="fw-bold mb-3 text-sm text-uppercase text-muted tracking-wide px-1">Sebelumnya</h6>

<div class="surface-card mb-4 p-0">
    @foreach ($lebihLama as $notif)
    <div class="d-flex p-3 {{ !$loop->last ? 'border-bottom' : '' }}" style="border-color: var(--border-color) !important;">
        @if (isset($notif->is_db_notif) && $notif->is_db_notif)
        <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3 flex-shrink-0" style="width: 42px; height: 42px;">
            <i class="bi bi-info-circle text-primary fs-5"></i>
        </div>
        @elseif (in_array($notif->jenis, ['penukaran_sampah', 'deposit']))
        <div class="bg-success bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3 flex-shrink-0" style="width: 42px; height: 42px;">
            <i class="bi bi-{{ $notif->jenis === 'penukaran_sampah' ? 'recycle' : 'wallet2' }} text-success fs-5"></i>
        </div>
        @else
        <div class="bg-warning bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3 flex-shrink-0" style="width: 42px; height: 42px;">
            <i class="bi bi-{{ $notif->jenis === 'belanja' ? 'shop' : 'cash-coin' }}" style="color: #ea580c; font-size: 1.15rem;"></i>
        </div>
        @endif
        <div class="flex-grow-1" style="min-width: 0;">
            <div class="d-flex justify-content-between align-items-start mb-1">
                <h6 class="fw-bold mb-0 text-main" style="font-size: 0.95rem;">
                    @if (isset($notif->is_db_notif) && $notif->is_db_notif)
                        {{ $notif->title }}
                    @else
                        {{ match($notif->jenis) { 'penukaran_sampah' => 'Setoran Berhasil', 'belanja' => 'Transaksi Koperasi', 'deposit' => 'Setor Tunai', 'penarikan' => 'Tarik Tunai', default => ucfirst($notif->jenis) } }}
                    @endif
                </h6>
                <small class="text-muted text-xs ms-2">{{ $notif->created_at->translatedFormat('d M') }}</small>
            </div>
            <p class="text-muted text-sm mb-0" style="line-height: 1.4;">
                @if (isset($notif->is_db_notif) && $notif->is_db_notif)
                    {{ $notif->keterangan }}
                @elseif (in_array($notif->jenis, ['penukaran_sampah', 'deposit']))
                    Saldo Anda bertambah <span class="fw-bold text-success">+ Rp {{ number_format($notif->nominal, 0, ',', '.') }}</span>{{ $notif->keterangan ? ' dari ' . $notif->keterangan : '' }}.
                @else
                    Saldo Anda terpotong <span class="fw-bold" style="color: #ea580c;">- Rp {{ number_format($notif->nominal, 0, ',', '.') }}</span>{{ $notif->keterangan ? ' untuk ' . $notif->keterangan : '' }}.
                @endif
            </p>
        </div>
    </div>
    @endforeach
</div>
@endif

@endif
@endsection
