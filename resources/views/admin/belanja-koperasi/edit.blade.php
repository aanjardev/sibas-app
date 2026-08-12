@extends('layouts.admin')

@section('title', 'Edit Transaksi — TRX-B089')
@section('header_title', 'Edit Transaksi Belanja')

@section('content')

<form action="#" method="POST" id="editForm">
    @csrf
    @method('PUT')

    {{-- Back & Save Bar --}}
    <div class="row g-3 mb-3 mb-md-4">
        <div class="col-12 d-flex align-items-center justify-content-between gap-2">
            <a href="{{ route('admin.belanja-koperasi.show', 1) }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                <i class="bi bi-arrow-left me-1"></i> Kembali ke Detail
            </a>
            <div class="d-flex gap-2">
                <button type="reset" class="btn btn-outline-secondary btn-sm px-3">
                    <i class="bi bi-arrow-counterclockwise me-1"></i>Reset
                </button>
                <button type="submit" class="btn btn-primary btn-sm text-white px-3 shadow-sm">
                    <i class="bi bi-check-lg me-1"></i>Simpan Perubahan
                </button>
            </div>
        </div>
    </div>

    {{-- Info Alert --}}
    <div class="row g-3 mb-3">
        <div class="col-12">
            <div class="d-flex align-items-start gap-2 p-3 rounded-3 border" style="background:#fffbf0; border-color:#f0d070 !important;">
                <i class="bi bi-exclamation-triangle-fill text-warning mt-0.5 flex-shrink-0"></i>
                <div class="text-xs text-muted">
                    <strong class="text-dark">Catatan:</strong> Halaman ini untuk koreksi data transaksi (pembeli, metode bayar, catatan).
                    Perubahan item belanja tidak dapat dilakukan di sini untuk menjaga integritas stok.
                    No. Transaksi: <strong class="text-dark">TRX-B089</strong>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-12 col-lg-7">

            {{-- Data Pembeli --}}
            <div class="admin-card border-0 shadow-sm mb-3">
                <div class="admin-card-header bg-transparent border-bottom p-3 p-md-4">
                    <h6 class="fw-bold mb-0"><i class="bi bi-person-circle me-2" style="color:var(--primary);"></i>Data Pembeli</h6>
                </div>
                <div class="admin-card-body p-3 p-md-4">
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-sm">Tipe Pembeli <span class="text-danger">*</span></label>
                        <div class="d-flex gap-3">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="tipe_pembeli" id="tipeAnggota" value="anggota" checked onchange="togglePembeli()">
                                <label class="form-check-label text-sm fw-medium" for="tipeAnggota">
                                    <i class="bi bi-person-badge me-1"></i>Anggota Koperasi
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="tipe_pembeli" id="tipeUmum" value="umum" onchange="togglePembeli()">
                                <label class="form-check-label text-sm fw-medium" for="tipeUmum">
                                    <i class="bi bi-person me-1"></i>Pelanggan Umum
                                </label>
                            </div>
                        </div>
                    </div>

                    <div id="sectionAnggota">
                        <label for="anggota_id" class="form-label fw-semibold text-sm">Anggota <span class="text-danger">*</span></label>
                        <select class="form-select text-sm" id="anggota_id" name="anggota_id">
                            <option value="">-- Pilih Anggota --</option>
                            <option value="1" selected>Budi Santoso (AGT-001)</option>
                            <option value="2">Siti Aminah (AGT-002)</option>
                            <option value="3">Ahmad Fauzan (AGT-003)</option>
                            <option value="4">Dewi Rahayu (AGT-004)</option>
                        </select>
                    </div>

                    <div id="sectionUmum" class="d-none">
                        <label for="nama_pembeli" class="form-label fw-semibold text-sm">Nama Pembeli</label>
                        <input type="text" class="form-control text-sm" id="nama_pembeli" name="nama_pembeli" value="">
                    </div>
                </div>
            </div>

            {{-- Metode Pembayaran --}}
            <div class="admin-card border-0 shadow-sm mb-3">
                <div class="admin-card-header bg-transparent border-bottom p-3 p-md-4">
                    <h6 class="fw-bold mb-0"><i class="bi bi-credit-card me-2" style="color:var(--primary);"></i>Metode Pembayaran</h6>
                </div>
                <div class="admin-card-body p-3 p-md-4">
                    <div class="mb-3">
                        <label for="metode_bayar" class="form-label fw-semibold text-sm">Metode <span class="text-danger">*</span></label>
                        <select class="form-select text-sm" id="metode_bayar" name="metode_bayar">
                            <option value="tunai">Tunai (Cash)</option>
                            <option value="tabungan" selected>Saldo Tabungan</option>
                            <option value="debit">Debit / QRIS</option>
                        </select>
                    </div>

                    <div class="mb-0">
                        <label for="no_ref" class="form-label fw-semibold text-sm">No. Referensi <span class="text-muted fw-normal text-xs">(Opsional)</span></label>
                        <input type="text" class="form-control text-sm" id="no_ref" name="no_ref" placeholder="No. struk, ref. debit, dll.">
                    </div>
                </div>
            </div>

            {{-- Status Transaksi --}}
            <div class="admin-card border-0 shadow-sm mb-3">
                <div class="admin-card-header bg-transparent border-bottom p-3 p-md-4">
                    <h6 class="fw-bold mb-0"><i class="bi bi-check-circle me-2" style="color:var(--primary);"></i>Status Transaksi</h6>
                </div>
                <div class="admin-card-body p-3 p-md-4">
                    <label for="status" class="form-label fw-semibold text-sm">Status <span class="text-danger">*</span></label>
                    <select class="form-select text-sm" id="status" name="status">
                        <option value="lunas" selected>Lunas</option>
                        <option value="pending">Pending</option>
                        <option value="batal">Dibatalkan</option>
                    </select>
                </div>
            </div>

            {{-- Catatan --}}
            <div class="admin-card border-0 shadow-sm">
                <div class="admin-card-header bg-transparent border-bottom p-3 p-md-4">
                    <h6 class="fw-bold mb-0"><i class="bi bi-chat-left-text me-2" style="color:var(--primary);"></i>Catatan</h6>
                </div>
                <div class="admin-card-body p-3 p-md-4">
                    <label for="catatan" class="form-label fw-semibold text-sm">Catatan Transaksi</label>
                    <textarea class="form-control text-sm" id="catatan" name="catatan" rows="3">Pembelian kebutuhan bulanan anggota.</textarea>
                </div>
            </div>
        </div>

        {{-- ── Right: Rincian Item (Read-only) ── --}}
        <div class="col-12 col-lg-5">
            <div class="admin-card border-0 shadow-sm" style="position: sticky; top: 1rem;">
                <div class="admin-card-header bg-transparent border-bottom p-3 p-md-4 d-flex align-items-center justify-content-between">
                    <h6 class="fw-bold mb-0">Rincian Item Belanja</h6>
                    <span class="badge bg-light text-muted border text-xs">Read-only</span>
                </div>
                <div class="admin-card-body p-0">
                    <div class="p-3 border-bottom">
                        <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                            <div>
                                <div class="text-sm fw-semibold">🛢️ Minyak Goreng Sawit 1L</div>
                                <div class="text-xs text-muted">PRD-001 · Rp 16.500 × 2</div>
                            </div>
                            <span class="fw-bold text-sm">Rp 33.000</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center py-2">
                            <div>
                                <div class="text-sm fw-semibold">🍬 Gula Pasir Premium 1kg</div>
                                <div class="text-xs text-muted">PRD-002 · Rp 17.500 × 1</div>
                            </div>
                            <span class="fw-bold text-sm">Rp 17.500</span>
                        </div>
                    </div>

                    <div class="p-3">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="text-muted text-sm">Subtotal</span>
                            <span class="fw-semibold text-sm">Rp 50.500</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="text-muted text-sm">Diskon</span>
                            <span class="fw-semibold text-sm text-danger">- Rp 0</span>
                        </div>
                        <hr class="my-2" style="border-color:#e8f0ea;">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="fw-bold">Total</span>
                            <span class="fw-bold fs-5" style="color:var(--primary);">Rp 50.500</span>
                        </div>

                        <button type="submit" form="editForm" class="btn btn-primary text-white w-100 fw-bold py-2 shadow-sm" style="border-radius: 10px;">
                            <i class="bi bi-check-lg me-2"></i>Simpan Perubahan
                        </button>
                        <a href="{{ route('admin.belanja-koperasi.show', 1) }}" class="btn btn-outline-secondary w-100 mt-2 text-sm py-2">
                            Batalkan Perubahan
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

@endsection

@section('scripts')
<script>
    function togglePembeli() {
        const isAnggota = document.getElementById('tipeAnggota').checked;
        document.getElementById('sectionAnggota').classList.toggle('d-none', !isAnggota);
        document.getElementById('sectionUmum').classList.toggle('d-none', isAnggota);
    }
</script>
@endsection
