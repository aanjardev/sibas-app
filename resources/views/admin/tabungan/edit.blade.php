@extends('layouts.admin')

@section('title', 'Edit Transaksi Tabungan')
@section('header_title', 'Edit Transaksi Tabungan')

@section('content')
<form action="{{ route('admin.tabungan.update', $transaksi->id) }}" method="POST" id="edit-tabungan-form">
    @csrf
    @method('PUT')
    <!-- Top Header Bar with Back & Save Buttons on a single row -->
    <div class="row g-3 mb-3 mb-md-4">
        <div class="col-12 d-flex align-items-center justify-content-between gap-2">
            <a href="{{ route('admin.tabungan.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
            <div class="d-flex align-items-center gap-2">
                <span class="badge bg-light text-dark border d-none d-sm-inline-block">TRX-#{{ $transaksi->id }}</span>
                <button type="submit" class="btn btn-primary btn-sm text-white px-3 shadow-sm" id="submit-btn">
                    <i class="bi bi-check-lg me-1"></i> Simpan Perubahan
                </button>
            </div>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row g-3">
        <div class="col-12 col-lg-8 mx-auto">
            <!-- Readonly Member Card -->
            <div class="admin-card border-0 shadow-sm mb-3">
                <div class="admin-card-header bg-transparent border-bottom p-3 p-md-4 d-flex justify-content-between align-items-center">
                    <h5 class="admin-card-title mb-0 fw-bold fs-6">Anggota Nasabah</h5>
                    <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-1">Terkunci</span>
                </div>
                <div class="admin-card-body p-3 p-md-4">
                    <div class="d-flex align-items-center">
                        <div class="bg-success bg-opacity-10 text-success rounded-circle d-flex align-items-center justify-content-center me-3 flex-shrink-0" style="width: 48px; height: 48px;">
                            <span class="fw-bold fs-5">{{ strtoupper(substr($transaksi->user->name ?? 'A', 0, 1)) }}</span>
                        </div>
                        <div>
                            <h6 class="mb-0 fw-bold text-dark text-base">{{ $transaksi->user->name ?? '-' }}</h6>
                            <span class="text-muted text-xs">ID: {{ $transaksi->user->nomor_anggota ?? '-' }} | Saldo Saat Ini: Rp {{ number_format($transaksi->user->saldo_tabungan ?? 0, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Edit Form -->
            <div class="admin-card border-0 shadow-sm mb-3">
                <div class="admin-card-header bg-transparent border-bottom p-3 p-md-4">
                    <h5 class="admin-card-title mb-0 fw-bold fs-5">Edit Transaksi Tabungan</h5>
                </div>
                <div class="admin-card-body p-3 p-md-4">
                    <!-- Jenis Transaksi Info -->
                    <div class="mb-4">
                        <label class="form-label fw-semibold text-sm mb-2">Jenis Transaksi</label>
                        <div>
                            @if($transaksi->jenis === 'setor')
                                <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-3 py-2 fs-6 rounded-3">
                                    <i class="bi bi-arrow-down-left me-1"></i> Setor Tunai (Nabung)
                                </span>
                            @else
                                <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 px-3 py-2 fs-6 rounded-3">
                                    <i class="bi bi-arrow-up-right me-1"></i> Tarik Tunai (Penarikan)
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold text-sm">Tanggal Transaksi</label>
                        <input type="text" class="form-control text-sm bg-light" value="{{ $transaksi->created_at->translatedFormat('d F Y, H:i') }}" readonly style="max-width: 250px;">
                    </div>

                    <div class="mb-3">
                        <label for="nominal_display" class="form-label fw-semibold text-sm">Nominal Transaksi (Rp) <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-light text-muted text-sm">Rp</span>
                            <input type="text" class="form-control text-sm fw-bold text-dark fs-5" id="nominal_display" value="{{ number_format(old('nominal', $transaksi->nominal), 0, ',', '.') }}" required oninput="formatRupiah(this)">
                            <input type="hidden" id="nominal" name="nominal" value="{{ old('nominal', $transaksi->nominal) }}">
                        </div>
                        <div id="nominal_feedback" class="text-danger text-xs mt-1 d-none">Mohon maaf, nominal tabungan tidak boleh 0.</div>
                    </div>

                    <div class="mb-4">
                        <label for="keterangan" class="form-label fw-semibold text-sm">Catatan / Keterangan (Opsional)</label>
                        <textarea class="form-control text-sm" id="keterangan" name="keterangan" rows="2">{{ old('keterangan', $transaksi->keterangan) }}</textarea>
                    </div>

                    <!-- Projection Summary Card -->
                    <div class="p-3 p-md-4 rounded-3 border bg-light" id="projection-card">
                        <div class="row align-items-center g-3">
                            <div class="col-12 col-sm-6 border-end-sm">
                                <span class="text-muted text-xs text-uppercase tracking-wider fw-semibold d-block">Saldo Sebelum Transaksi</span>
                                <span class="fs-5 fw-bold text-dark" id="saldo_awal_display">Rp {{ number_format($transaksi->saldo_sebelum, 0, ',', '.') }}</span>
                            </div>
                            <div class="col-12 col-sm-6">
                                <span class="text-muted text-xs text-uppercase tracking-wider fw-semibold d-block">Penyesuaian Saldo Akhir</span>
                                <span class="fs-3 fw-bold {{ $transaksi->jenis === 'setor' ? 'text-success' : 'text-primary' }}" id="saldo_akhir_display">
                                    Rp {{ number_format($transaksi->saldo_sesudah, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

@section('scripts')
<script>
    const saldoSebelum = {{ (float) $transaksi->saldo_sebelum }};
    const jenisTransaksi = '{{ $transaksi->jenis }}';
    const submitBtn = document.getElementById('submit-btn');

    function formatRupiah(element) {
        let value = element.value.replace(/[^0-9]/g, '');
        document.getElementById('nominal').value = value;
        
        if (value) {
            element.value = new Intl.NumberFormat('id-ID').format(value);
        } else {
            element.value = '';
        }
        
        calculateEstimasi();
    }

    function calculateEstimasi() {
        const nominal = parseFloat(document.getElementById('nominal').value) || 0;
        const displayValue = document.getElementById('nominal_display').value;
        const feedback = document.getElementById('nominal_feedback');
        const displayEl = document.getElementById('saldo_akhir_display');
        let saldoAkhir = 0;

        if (jenisTransaksi === 'setor') {
            saldoAkhir = saldoSebelum + nominal;
            displayEl.className = 'fs-3 fw-bold text-success';
        } else {
            saldoAkhir = saldoSebelum - nominal;
            if (saldoAkhir < 0) {
                displayEl.className = 'fs-3 fw-bold text-danger';
            } else {
                displayEl.className = 'fs-3 fw-bold text-primary';
            }
        }

        displayEl.innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(saldoAkhir);

        // Validation & feedback
        if (displayValue !== '' && nominal <= 0) {
            feedback.innerText = 'Mohon maaf, nominal tabungan tidak boleh 0.';
            feedback.classList.remove('d-none');
            submitBtn.disabled = true;
        } else if (jenisTransaksi === 'tarik' && saldoAkhir < 0) {
            feedback.innerText = 'Saldo tabungan tidak mencukupi untuk penarikan sebesar ini.';
            feedback.classList.remove('d-none');
            submitBtn.disabled = true;
        } else if (nominal <= 0) {
            feedback.classList.add('d-none');
            submitBtn.disabled = true;
        } else {
            feedback.classList.add('d-none');
            submitBtn.disabled = false;
        }
    }

    // Run on init
    document.addEventListener('DOMContentLoaded', function() {
        calculateEstimasi();
    });
</script>
@endsection
@endsection
