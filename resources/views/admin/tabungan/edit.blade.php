@extends('layouts.admin')

@section('title', 'Edit Transaksi Tabungan')
@section('header_title', 'Edit Transaksi Tabungan')

@section('content')
<form action="#" method="POST" id="edit-tabungan-form">
    @csrf
    <!-- Top Header Bar with Back & Save Buttons on a single row -->
    <div class="row g-3 mb-3 mb-md-4">
        <div class="col-12 d-flex align-items-center justify-content-between gap-2">
            <a href="{{ route('admin.tabungan.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
            <div class="d-flex align-items-center gap-2">
                <span class="badge bg-light text-dark border d-none d-sm-inline-block">TRX-T102</span>
                <button type="submit" class="btn btn-primary btn-sm text-white px-3 shadow-sm">
                    <i class="bi bi-check-lg me-1"></i> Simpan Perubahan
                </button>
            </div>
        </div>
    </div>

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
                            <span class="fw-bold fs-5">B</span>
                        </div>
                        <div>
                            <h6 class="mb-0 fw-bold text-dark text-base">Budi Santoso</h6>
                            <span class="text-muted text-xs">ID: AGT-001 | Saldo Tabungan: Rp 450.000</span>
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
                    <!-- Radio Choice: Setor vs Tarik (Strong Active Contrast) -->
                    <div class="mb-4">
                        <label class="form-label fw-semibold text-sm mb-2">Pilih Jenis Transaksi <span class="text-danger">*</span></label>
                        <div class="btn-group w-100 p-1 bg-light rounded-3 border" role="group">
                            <input type="radio" class="btn-check" name="jenis_transaksi" id="jenis_setor" value="setor" checked onchange="calculateEstimasi()">
                            <label class="btn btn-sm rounded-2 fw-bold border-0 py-2.5 shadow-sm bg-success text-white" for="jenis_setor" id="label_setor">
                                <i class="bi bi-arrow-down-left me-1"></i> Setor Tunai (Nabung)
                            </label>

                            <input type="radio" class="btn-check" name="jenis_transaksi" id="jenis_tarik" value="tarik" onchange="calculateEstimasi()">
                            <label class="btn btn-sm rounded-2 fw-bold border-0 py-2.5 text-secondary opacity-75" for="jenis_tarik" id="label_tarik">
                                <i class="bi bi-arrow-up-right me-1"></i> Tarik Tunai (Penarikan)
                            </label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="tanggal" class="form-label fw-semibold text-sm">Tanggal Transaksi <span class="text-danger">*</span></label>
                        <input type="date" class="form-control text-sm" id="tanggal" name="tanggal" value="2026-07-15" style="max-width: 250px;" required>
                    </div>

                    <div class="mb-3">
                        <label for="nominal" class="form-label fw-semibold text-sm">Nominal Transaksi (Rp) <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-light text-muted text-sm">Rp</span>
                            <input type="number" step="1000" min="1000" class="form-control text-sm fw-bold text-dark fs-5" id="nominal" name="nominal" value="200000" required oninput="calculateEstimasi()">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="keterangan" class="form-label fw-semibold text-sm">Catatan / Keterangan (Opsional)</label>
                        <textarea class="form-control text-sm" id="keterangan" name="keterangan" rows="2">Setor tunai tabungan bulanan anggota</textarea>
                    </div>

                    <!-- Projection Summary Card -->
                    <div class="p-3 p-md-4 rounded-3 border bg-light" id="projection-card">
                        <div class="row align-items-center g-3">
                            <div class="col-12 col-sm-6 border-end-sm">
                                <span class="text-muted text-xs text-uppercase tracking-wider fw-semibold d-block">Saldo Sebelum TRX Ini</span>
                                <span class="fs-5 fw-bold text-dark" id="saldo_awal_display">Rp 250.000</span>
                            </div>
                            <div class="col-12 col-sm-6">
                                <span class="text-muted text-xs text-uppercase tracking-wider fw-semibold d-block">Penyesuaian Saldo Akhir</span>
                                <span class="fs-3 fw-bold text-success" id="saldo_akhir_display">Rp 450.000</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    let saldoAwal = 250000;

    function calculateEstimasi() {
        const isSetor = document.getElementById('jenis_setor').checked;
        const nominal = parseFloat(document.getElementById('nominal').value) || 0;
        const labelSetor = document.getElementById('label_setor');
        const labelTarik = document.getElementById('label_tarik');
        let saldoAkhir = 0;

        if (isSetor) {
            labelSetor.className = 'btn btn-sm rounded-2 fw-bold border-0 py-2.5 shadow-sm bg-success text-white';
            labelTarik.className = 'btn btn-sm rounded-2 fw-bold border-0 py-2.5 text-secondary opacity-75';
            saldoAkhir = saldoAwal + nominal;
            document.getElementById('saldo_akhir_display').className = 'fs-3 fw-bold text-success';
        } else {
            labelTarik.className = 'btn btn-sm rounded-2 fw-bold border-0 py-2.5 shadow-sm bg-danger text-white';
            labelSetor.className = 'btn btn-sm rounded-2 fw-bold border-0 py-2.5 text-secondary opacity-75';
            saldoAkhir = saldoAwal - nominal;
            if (saldoAkhir < 0) {
                document.getElementById('saldo_akhir_display').className = 'fs-3 fw-bold text-danger';
            } else {
                document.getElementById('saldo_akhir_display').className = 'fs-3 fw-bold text-primary';
            }
        }

        document.getElementById('saldo_akhir_display').innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(saldoAkhir);
    }
</script>
@endsection
