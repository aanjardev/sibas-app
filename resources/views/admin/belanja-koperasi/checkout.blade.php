@extends('layouts.admin')

@section('title', 'Checkout Belanja Koperasi')
@section('header_title', 'Checkout Transaksi')

@section('content')

{{-- Back Bar --}}
<div class="row g-3 mb-3 mb-md-4">
    <div class="col-12 d-flex align-items-center justify-content-between">
        <a href="{{ route('admin.belanja-koperasi.pos') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
            <i class="bi bi-arrow-left me-1"></i> Kembali ke Kasir
        </a>
        <span class="badge bg-light text-dark border fw-semibold px-3 py-2">TRX-B090</span>
    </div>
</div>

<div class="row g-3">
    {{-- ── Left: Form Data Pembeli & Pembayaran ── --}}
    <div class="col-12 col-lg-7">
        <form id="checkoutForm" action="#" method="POST">
            @csrf
            {{-- Identitas Pembeli --}}
            <div class="admin-card border-0 shadow-sm mb-3">
                <div class="admin-card-header bg-transparent border-bottom p-3 p-md-4">
                    <h6 class="fw-bold mb-0"><i class="bi bi-person-circle me-2 text-primary" style="color: var(--primary) !important;"></i>Data Pembeli</h6>
                </div>
                <div class="admin-card-body p-3 p-md-4">
                    {{-- Tipe Pembeli --}}
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

                    {{-- Pilih Anggota (jika anggota) --}}
                    <div id="sectionAnggota" class="mb-3">
                        <label for="anggota_id" class="form-label fw-semibold text-sm">Pilih Anggota <span class="text-danger">*</span></label>
                        {{-- Tom Select will enhance this into a searchable input --}}
                        <select class="form-select text-sm" id="anggota_id" name="anggota_id" onchange="updateSaldoInfo()" placeholder="Ketik nama atau ID anggota...">
                            <option value="1" data-saldo="450000" data-id="AGT-001">Budi Santoso (AGT-001) · Saldo: Rp 450.000</option>
                            <option value="2" data-saldo="1200000" data-id="AGT-002">Siti Aminah (AGT-002) · Saldo: Rp 1.200.000</option>
                            <option value="3" data-saldo="75000" data-id="AGT-003">Ahmad Fauzan (AGT-003) · Saldo: Rp 75.000</option>
                            <option value="4" data-saldo="820000" data-id="AGT-004">Dewi Rahayu (AGT-004) · Saldo: Rp 820.000</option>
                        </select>
                        {{-- Info saldo anggota terpilih --}}
                        <div id="anggotaInfo" class="mt-2 p-2 px-3 rounded-3 border d-none" style="background: #f0f7f3; border-color: #c3dece !important;">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-xs text-muted">Saldo Tabungan Tersedia</span>
                                <span class="fw-bold text-sm" id="anggotaSaldo" style="color: var(--primary);">Rp 0</span>
                            </div>
                        </div>
                    </div>

                    {{-- Nama Umum (jika umum) --}}
                    <div id="sectionUmum" class="mb-0 d-none">
                        <label for="nama_pembeli" class="form-label fw-semibold text-sm">Nama Pembeli <span class="text-muted fw-normal text-xs">(Opsional)</span></label>
                        <input type="text" class="form-control text-sm" id="nama_pembeli" name="nama_pembeli" placeholder="Nama pelanggan atau kosongkan...">
                    </div>
                </div>
            </div>

            {{-- Metode Pembayaran --}}
            <div class="admin-card border-0 shadow-sm mb-3">
                <div class="admin-card-header bg-transparent border-bottom p-3 p-md-4">
                    <h6 class="fw-bold mb-0"><i class="bi bi-credit-card me-2 text-primary" style="color: var(--primary) !important;"></i>Metode Pembayaran</h6>
                </div>
                <div class="admin-card-body p-3 p-md-4">
                    {{-- Pilih Metode --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-sm">Metode <span class="text-danger">*</span></label>
                        <div class="row g-2">
                            <div class="col-4">
                                <div class="payment-method-card active" id="pm_tunai" onclick="selectPayment('tunai')">
                                    <i class="bi bi-cash-stack fs-4 mb-1"></i>
                                    <div class="fw-semibold text-sm">Tunai</div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="payment-method-card" id="pm_tabungan" onclick="selectPayment('tabungan')">
                                    <i class="bi bi-wallet2 fs-4 mb-1"></i>
                                    <div class="fw-semibold text-sm">Tabungan</div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="payment-method-card" id="pm_debit" onclick="selectPayment('debit')">
                                    <i class="bi bi-credit-card fs-4 mb-1"></i>
                                    <div class="fw-semibold text-sm">Debit/QRIS</div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="metode_bayar" id="metode_bayar" value="tunai">
                    </div>

                    {{-- Panel Tunai: nominal diterima & kembalian --}}
                    <div id="panelTunai">
                        <label for="nominal_bayar" class="form-label fw-semibold text-sm">Nominal Diterima (Rp) <span class="text-danger">*</span></label>
                        <div class="input-group mb-2">
                            <span class="input-group-text bg-light text-muted text-sm">Rp</span>
                            <input type="number" class="form-control text-sm fw-bold fs-5" id="nominal_bayar" name="nominal_bayar"
                                placeholder="0" step="1000" oninput="calcChange()">
                        </div>
                        {{-- Quick Nominal Buttons --}}
                        <div class="d-flex flex-wrap gap-1 mb-3">
                            <button type="button" class="btn btn-sm btn-outline-secondary text-xs" onclick="setNominal(50000)">50rb</button>
                            <button type="button" class="btn btn-sm btn-outline-secondary text-xs" onclick="setNominal(100000)">100rb</button>
                            <button type="button" class="btn btn-sm btn-outline-secondary text-xs" onclick="setNominal(200000)">200rb</button>
                            <button type="button" class="btn btn-sm btn-outline-secondary text-xs" onclick="setNominal(500000)">500rb</button>
                            <button type="button" class="btn btn-sm btn-outline-secondary text-xs" onclick="setNominalPas()">Uang Pas</button>
                        </div>

                        {{-- Kembalian --}}
                        <div class="p-3 rounded-3 border" style="background: #f0f7f3; border-color: #c3dece !important;">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-sm text-muted fw-semibold">Kembalian</span>
                                <span class="fw-bold fs-5" id="kembalianDisplay" style="color: var(--primary);">Rp 0</span>
                            </div>
                        </div>
                    </div>

                    {{-- Panel Tabungan --}}
                    <div id="panelTabungan" class="d-none">
                        <div class="p-3 rounded-3 border" style="background: #fffbf0; border-color: #f0d070 !important;">
                            <i class="bi bi-info-circle text-warning me-1"></i>
                            <span class="text-xs text-muted">Saldo tabungan anggota akan dipotong otomatis sejumlah total belanja. Pastikan saldo mencukupi.</span>
                        </div>
                    </div>

                    {{-- Panel Debit/QRIS --}}
                    <div id="panelDebit" class="d-none">
                        <label for="no_ref" class="form-label fw-semibold text-sm">No. Referensi / ID Transaksi <span class="text-muted fw-normal text-xs">(Opsional)</span></label>
                        <input type="text" class="form-control text-sm" id="no_ref" name="no_ref" placeholder="Contoh: REF-123456789">
                    </div>
                </div>
            </div>

            {{-- Catatan --}}
            <div class="admin-card border-0 shadow-sm mb-3">
                <div class="admin-card-body p-3 p-md-4">
                    <label for="catatan" class="form-label fw-semibold text-sm">Catatan Transaksi <span class="text-muted fw-normal text-xs">(Opsional)</span></label>
                    <textarea class="form-control text-sm" id="catatan" name="catatan" rows="2" placeholder="Catatan khusus untuk transaksi ini..."></textarea>
                </div>
            </div>
        </form>
    </div>

    {{-- ── Right: Ringkasan Pesanan ── --}}
    <div class="col-12 col-lg-5">
        <div class="admin-card border-0 shadow-sm" style="position: sticky; top: 1rem;">
            <div class="admin-card-header bg-transparent border-bottom p-3 p-md-4">
                <h6 class="fw-bold mb-0"><i class="bi bi-bag-check me-2 text-success"></i>Ringkasan Pesanan</h6>
            </div>
            <div class="admin-card-body p-0">
                {{-- Item List --}}
                <div style="max-height: 280px; overflow-y: auto; padding: 0.75rem 1rem;">
                    {{-- Item demo (normally passed from session/cart) --}}
                    <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                        <div>
                            <div class="text-sm fw-semibold text-dark">🛢️ Minyak Goreng Sawit 1L</div>
                            <div class="text-xs text-muted">Rp 16.500 × 2</div>
                        </div>
                        <span class="fw-bold text-sm">Rp 33.000</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                        <div>
                            <div class="text-sm fw-semibold text-dark">🍬 Gula Pasir Premium 1kg</div>
                            <div class="text-xs text-muted">Rp 17.500 × 1</div>
                        </div>
                        <span class="fw-bold text-sm">Rp 17.500</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center py-2">
                        <div>
                            <div class="text-sm fw-semibold text-dark">🌾 Beras SPHP 5kg</div>
                            <div class="text-xs text-muted">Rp 68.000 × 1</div>
                        </div>
                        <span class="fw-bold text-sm">Rp 68.000</span>
                    </div>
                </div>

                {{-- Summary Total --}}
                <div class="p-3 p-md-4 border-top">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="text-muted text-sm">Subtotal (4 item)</span>
                        <span class="fw-semibold text-sm">Rp 118.500</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="text-muted text-sm">Diskon</span>
                        <span class="fw-semibold text-sm text-danger">- Rp 0</span>
                    </div>
                    <hr class="my-2" style="border-color: #e8f0ea;">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="fw-bold">Total Bayar</span>
                        <span class="fw-bold fs-4" style="color: var(--primary);">Rp 118.500</span>
                    </div>

                    {{-- Selesaikan Transaksi Button --}}
                    <button type="submit" form="checkoutForm" class="btn btn-primary text-white w-100 fw-bold py-3 shadow-sm" style="border-radius: 12px; font-size: 1.05rem;">
                        <i class="bi bi-check-circle-fill me-2"></i>Selesaikan Transaksi
                    </button>
                    <a href="{{ route('admin.belanja-koperasi.pos') }}" class="btn btn-outline-secondary w-100 mt-2 text-sm py-2">
                        <i class="bi bi-arrow-left me-1"></i>Kembali & Edit Keranjang
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.payment-method-card {
    border: 2px solid #e0e8e3;
    border-radius: 10px;
    padding: 0.7rem 0.5rem;
    text-align: center;
    cursor: pointer;
    transition: all 0.18s;
    color: #666;
    background: #fff;
    user-select: none;
}
.payment-method-card:hover { border-color: var(--primary); color: var(--primary); }
.payment-method-card.active {
    border-color: var(--primary);
    background: var(--primary-light, #e6f0eb);
    color: var(--primary);
    font-weight: 600;
}

/* Tom Select overrides */
.ts-wrapper {
    font-size: 0.875rem;
}
.ts-wrapper .ts-control {
    border: 1px solid #dee2e6;
    border-radius: 0.375rem;
    padding: 0.475rem 0.75rem;
    background: #fff;
    box-shadow: none;
    cursor: text;
    min-height: 38px;
    gap: 4px;
}
.ts-wrapper.focus .ts-control {
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(8, 70, 39, 0.1);
}
.ts-wrapper .ts-control input {
    font-size: 0.875rem;
    color: #212529;
}
.ts-dropdown {
    border: 1px solid #dee2e6;
    border-radius: 0.5rem;
    box-shadow: 0 8px 24px rgba(0,0,0,0.1);
    font-size: 0.875rem;
    overflow: hidden;
}
.ts-dropdown .ts-dropdown-content { max-height: 260px; }
.ts-dropdown [data-selectable] {
    padding: 0.5rem 0.85rem;
    border-bottom: 1px solid #f0f4f2;
    cursor: pointer;
    transition: background 0.12s;
}
.ts-dropdown [data-selectable]:hover,
.ts-dropdown [data-selectable].active {
    background: var(--primary-light, #e6f0eb);
    color: var(--primary);
}
.ts-dropdown .no-results {
    padding: 0.75rem;
    color: #888;
    text-align: center;
}
.ts-wrapper .ts-control .item {
    color: #1a2a1e;
    font-weight: 500;
}
</style>

@endsection

@section('scripts')
{{-- Tom Select: lightweight searchable-select library --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.bootstrap5.min.css">
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>
<script>
    const TOTAL = 118500; // Normally from session/cart

    // ── Tom Select: searchable anggota dropdown ──
    const anggotaSelect = new TomSelect('#anggota_id', {
        placeholder: 'Ketik nama atau ID anggota...',
        allowEmptyOption: false,
        items: [],
        maxOptions: null,
        dropdownParent: 'body',
        searchField: ['text'],
        onChange(value) {
            updateSaldoInfo();
        },
        render: {
            option(data, escape) {
                // Parse the label, e.g. "Budi Santoso (AGT-001) · Saldo: Rp 450.000"
                const parts = data.text.match(/^(.+?)\s*\(([^)]+)\)(.*)$/);
                if (parts) {
                    return `<div style="line-height:1.3;">
                        <span style="font-weight:600;color:#1a2a1e;">${escape(parts[1].trim())}</span>
                        <span style="font-size:0.72rem;color:#666;"> &nbsp;${escape(parts[2])}${escape(parts[3])}</span>
                    </div>`;
                }
                return `<div>${escape(data.text)}</div>`;
            },
            item(data, escape) {
                const parts = data.text.match(/^(.+?)\s*\(([^)]+)\)/);
                return parts
                    ? `<div>${escape(parts[1].trim())} <span style="color:#666;font-size:0.8em">(${escape(parts[2])})</span></div>`
                    : `<div>${escape(data.text)}</div>`;
            },
            no_results() {
                return '<div class="no-results"><i class="bi bi-search me-1"></i>Anggota tidak ditemukan</div>';
            }
        }
    });

    function togglePembeli() {
        const isAnggota = document.getElementById('tipeAnggota').checked;
        document.getElementById('sectionAnggota').classList.toggle('d-none', !isAnggota);
        document.getElementById('sectionUmum').classList.toggle('d-none', isAnggota);
        // If not anggota, hide tabungan option
        const pmTabungan = document.getElementById('pm_tabungan');
        if (!isAnggota) {
            pmTabungan.style.opacity = '0.4';
            pmTabungan.style.pointerEvents = 'none';
            if (document.getElementById('metode_bayar').value === 'tabungan') {
                selectPayment('tunai');
            }
        } else {
            pmTabungan.style.opacity = '';
            pmTabungan.style.pointerEvents = '';
        }
    }

    function updateSaldoInfo() {
        const sel = document.getElementById('anggota_id');
        const opt = sel.options[sel.selectedIndex];
        const info = document.getElementById('anggotaInfo');
        if (opt && opt.value) {
            const saldo = parseInt(opt.dataset.saldo || 0);
            document.getElementById('anggotaSaldo').innerText = 'Rp ' + saldo.toLocaleString('id-ID');
            info.classList.remove('d-none');
        } else {
            info.classList.add('d-none');
        }
    }

    function selectPayment(method) {
        ['tunai', 'tabungan', 'debit'].forEach(m => {
            document.getElementById('pm_' + m).classList.remove('active');
            document.getElementById('panel' + m.charAt(0).toUpperCase() + m.slice(1)).classList.add('d-none');
        });
        document.getElementById('pm_' + method).classList.add('active');
        document.getElementById('panel' + method.charAt(0).toUpperCase() + method.slice(1)).classList.remove('d-none');
        document.getElementById('metode_bayar').value = method;
    }

    function calcChange() {
        const bayar = parseFloat(document.getElementById('nominal_bayar').value) || 0;
        const kembalian = bayar - TOTAL;
        const el = document.getElementById('kembalianDisplay');
        if (kembalian < 0) {
            el.innerText = '− Rp ' + Math.abs(kembalian).toLocaleString('id-ID');
            el.style.color = '#dc3545';
        } else {
            el.innerText = 'Rp ' + kembalian.toLocaleString('id-ID');
            el.style.color = 'var(--primary)';
        }
    }

    function setNominal(val) {
        document.getElementById('nominal_bayar').value = val;
        calcChange();
    }

    function setNominalPas() {
        document.getElementById('nominal_bayar').value = TOTAL;
        calcChange();
    }
</script>
@endsection
