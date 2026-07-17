@extends('layouts.mobile')

@section('title', 'Tabungan')
@section('header_title', 'Tabungan Saya')

@section('content')
<div class="mb-4">
    <div class="primary-card p-4 text-center position-relative overflow-hidden">
        
        <p class="mb-1 text-sm text-white opacity-75 position-relative z-index-1">Saldo Tabungan Anda</p>
        <h2 class="fw-bold mb-3 text-white position-relative z-index-1" style="font-size: 2.2rem; letter-spacing: -1px;">Rp 1.250.000</h2>
        
        <div class="d-flex justify-content-center gap-2 position-relative z-index-1">
            <button class="btn btn-light btn-sm px-3 rounded-pill fw-semibold shadow-sm" data-bs-toggle="modal" data-bs-target="#infoSetorModal">
                <i class="bi bi-arrow-down-circle me-1 text-success"></i> Setor
            </button>
            <button class="btn btn-light btn-sm px-3 rounded-pill fw-semibold shadow-sm" data-bs-toggle="modal" data-bs-target="#infoTarikModal">
                <i class="bi bi-arrow-up-circle me-1 text-danger"></i> Tarik
            </button>
        </div>
    </div>
</div>

<div class="d-flex justify-content-between align-items-end mb-3 px-1">
    <h6 class="fw-bold mb-0 text-sm text-uppercase text-muted tracking-wide">Riwayat Transaksi</h6>
    <span class="badge bg-white text-muted border border-secondary border-opacity-25 rounded-1 px-2 py-1"><i class="bi bi-calendar3 me-1"></i> Bulan Ini</span>
</div>

<div class="surface-card p-3">
    <div class="history-item setor-tunai">
        <div class="overflow-hidden flex-grow-1 pe-2">
            <h6 class="mb-1 text-sm fw-bold text-truncate">Setor Tunai (Admin: Siti)</h6>
            <div class="text-muted text-xs text-truncate">Setor rutin mingguan</div>
        </div>
        <div class="text-end flex-shrink-0">
            <h6 class="amount mb-1 text-sm fw-bold">+ Rp 50.000</h6>
            <div class="text-muted text-xs">Hari ini, 10:00</div>
        </div>
    </div>
    
    <div class="history-item setor-tunai">
        <div class="overflow-hidden flex-grow-1 pe-2">
            <h6 class="mb-1 text-sm fw-bold text-truncate">Setor Tunai (Admin: Budi)</h6>
            <div class="text-muted text-xs text-truncate">Setor sisa belanja</div>
        </div>
        <div class="text-end flex-shrink-0">
            <h6 class="amount mb-1 text-sm fw-bold">+ Rp 25.000</h6>
            <div class="text-muted text-xs">15 Jul 2026, 14:30</div>
        </div>
    </div>

    <div class="history-item tarik-tunai">
        <div class="overflow-hidden flex-grow-1 pe-2">
            <h6 class="mb-1 text-sm fw-bold text-truncate">Tarik Tunai (Admin: Siti)</h6>
            <div class="text-muted text-xs text-truncate">Kebutuhan mendadak</div>
        </div>
        <div class="text-end flex-shrink-0">
            <h6 class="amount mb-1 text-sm fw-bold">- Rp 100.000</h6>
            <div class="text-muted text-xs">10 Jul 2026, 09:15</div>
        </div>
    </div>

    <div class="history-item setor-tunai">
        <div class="overflow-hidden flex-grow-1 pe-2">
            <h6 class="mb-1 text-sm fw-bold text-truncate">Setor Tunai (Admin: Ahmad)</h6>
            <div class="text-muted text-xs text-truncate">Setor bulanan</div>
        </div>
        <div class="text-end flex-shrink-0">
            <h6 class="amount mb-1 text-sm fw-bold">+ Rp 200.000</h6>
            <div class="text-muted text-xs">1 Jul 2026, 08:00</div>
        </div>
    </div>
</div>

<!-- Info Setor Modal -->
<div class="modal fade" id="infoSetorModal" tabindex="-1" aria-labelledby="infoSetorModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header border-0 pb-0">
        <h5 class="modal-title fw-bold" id="infoSetorModalLabel">Informasi Setor Tunai</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center pt-2 pb-4">
        <div class="bg-success bg-opacity-10 text-success rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
            <i class="bi bi-wallet2 fs-2"></i>
        </div>
        <p class="mb-0 text-muted text-sm">Untuk menyetorkan uang ke dalam tabungan, silakan berikan uang tunai langsung ke <strong>Admin Bank Sampah</strong> saat Anda datang. Admin akan memasukkan data setoran Anda ke dalam sistem.</p>
      </div>
    </div>
  </div>
</div>

<!-- Info Tarik Modal -->
<div class="modal fade" id="infoTarikModal" tabindex="-1" aria-labelledby="infoTarikModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header border-0 pb-0">
        <h5 class="modal-title fw-bold" id="infoTarikModalLabel">Informasi Tarik Tunai</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center pt-2 pb-4">
        <div class="bg-danger bg-opacity-10 text-danger rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
            <i class="bi bi-cash-coin fs-2"></i>
        </div>
        <p class="mb-0 text-muted text-sm">Untuk menarik uang dari tabungan, silakan temui <strong>Admin Bank Sampah</strong> dan sampaikan nominal yang ingin ditarik. Admin akan memproses dan memberikan uang tunainya kepada Anda.</p>
      </div>
    </div>
  </div>
</div>
@endsection
