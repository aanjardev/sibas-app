@extends('layouts.admin')

@section('title', 'Input Setor Sampah')
@section('header_title', 'Input Setor Sampah Baru')

@section('content')
<form action="#" method="POST" id="create-setor-form">
    @csrf
    <!-- Top Header Bar with Back & Save Buttons on a single row -->
    <div class="row g-3 mb-3 mb-md-4">
        <div class="col-12 d-flex align-items-center justify-content-between gap-2">
            <a href="{{ route('admin.setor-sampah.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
            <button type="submit" class="btn btn-primary btn-sm text-white px-3 shadow-sm">
                <i class="bi bi-check-lg me-1"></i> Simpan Transaksi
            </button>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-12 col-lg-9 mx-auto">
            <!-- Step 1: Cari Anggota -->
            <div class="admin-card border-0 shadow-sm mb-3">
                <div class="admin-card-header bg-transparent border-bottom p-3 p-md-4">
                    <h5 class="admin-card-title mb-0 fw-bold fs-5">1. Pilih Anggota Penyetor</h5>
                </div>
                <div class="admin-card-body p-3 p-md-4">
                    <label for="search-anggota" class="form-label fw-semibold text-sm">Pencarian Nama / ID Anggota <span class="text-danger">*</span></label>
                    <div class="d-flex flex-column flex-sm-row align-items-stretch align-items-sm-center gap-2">
                        <div class="input-group flex-grow-1">
                            <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-search"></i></span>
                            <input type="text" class="form-control bg-white border-start-0 text-sm" id="search-anggota" placeholder="Ketik nama anggota (contoh: Budi)..." required>
                        </div>
                        <a href="{{ route('admin.anggota.create') }}" class="btn btn-outline-success text-nowrap text-sm py-2">
                            <i class="bi bi-person-plus me-1"></i> Tambah Anggota Baru
                        </a>
                    </div>
                    
                    <!-- Selected Member Info Card -->
                    <div class="mt-3 p-3 bg-success bg-opacity-10 border border-success border-opacity-25 rounded-3 d-flex justify-content-between align-items-center d-none" id="selected-member-card">
                        <div class="d-flex align-items-center">
                            <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center me-3 flex-shrink-0" style="width: 40px; height: 40px;">
                                <span class="fw-bold">B</span>
                            </div>
                            <div>
                                <h6 class="mb-0 fw-bold text-success text-sm">Budi Santoso</h6>
                                <span class="text-success text-xs opacity-75">ID: AGT-001 | 0812-3456-7890</span>
                            </div>
                        </div>
                        <button type="button" class="btn btn-sm btn-light text-danger border" onclick="document.getElementById('selected-member-card').classList.add('d-none'); document.getElementById('search-anggota').value='';">
                            Batal
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Step 2: Detail Setoran Sampah (Multi-Item) -->
            <div class="admin-card border-0 shadow-sm mb-3">
                <div class="admin-card-header bg-transparent border-bottom p-3 p-md-4 d-flex align-items-center justify-content-between">
                    <h5 class="admin-card-title mb-0 fw-bold fs-5">2. Detail Rincian Setoran Sampah</h5>
                    <button type="button" class="btn btn-outline-primary btn-sm text-sm" onclick="addItemRow()">
                        <i class="bi bi-plus-lg me-1"></i> Tambah Jenis Sampah
                    </button>
                </div>
                <div class="admin-card-body p-3 p-md-4">
                    <div class="mb-3">
                        <label for="tanggal" class="form-label fw-semibold text-sm">Tanggal Setor <span class="text-danger">*</span></label>
                        <input type="date" class="form-control text-sm" id="tanggal" name="tanggal" value="{{ date('Y-m-d') }}" style="max-width: 250px;" required>
                    </div>

                    <!-- Container Items -->
                    <div class="text-xs fw-bold text-uppercase text-muted tracking-wider mb-2">Item Sampah Diterima</div>
                    <div id="items-container" class="d-flex flex-column gap-3 mb-4">
                        <!-- Item Row 1 -->
                        <div class="item-row p-3 border rounded-3 bg-light position-relative">
                            <div class="row g-2 align-items-center">
                                <div class="col-12 col-md-5">
                                    <label class="form-label text-xs fw-semibold text-muted mb-1">Kategori Sampah</label>
                                    <select class="form-select text-sm kategori-select" name="items[0][kategori]" required onchange="calculateGrandTotal()">
                                        <option value="" selected disabled>Pilih Kategori...</option>
                                        <option value="3000">Plastik PET (Rp 3.000 / kg)</option>
                                        <option value="1000">Kardus Bekas (Rp 1.000 / kg)</option>
                                        <option value="5000">Besi / Logam (Rp 5.000 / kg)</option>
                                        <option value="500">Kaca / Beling (Rp 500 / kg)</option>
                                    </select>
                                </div>
                                <div class="col-6 col-md-3">
                                    <label class="form-label text-xs fw-semibold text-muted mb-1">Berat (kg)</label>
                                    <div class="input-group">
                                        <input type="number" step="0.1" min="0.1" class="form-control text-sm berat-input" name="items[0][berat]" placeholder="0.0" required oninput="calculateGrandTotal()">
                                        <span class="input-group-text bg-white text-muted text-xs">kg</span>
                                    </div>
                                </div>
                                <div class="col-6 col-md-3">
                                    <label class="form-label text-xs fw-semibold text-muted mb-1">Subtotal (Rp)</label>
                                    <div class="fw-bold text-success text-sm py-2 px-2 bg-white rounded border subtotal-text">Rp 0</div>
                                </div>
                                <div class="col-12 col-md-1 text-end pt-2 pt-md-4">
                                    <button type="button" class="btn btn-outline-danger btn-sm border-0 remove-item-btn" onclick="removeItemRow(this)" disabled title="Hapus Item">
                                        <i class="bi bi-trash fs-6"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Grand Total Summary Card -->
                    <div class="p-3 p-md-4 bg-success bg-opacity-10 border border-success border-opacity-25 rounded-3">
                        <div class="row align-items-center g-3">
                            <div class="col-12 col-sm-6 border-end-sm">
                                <span class="text-muted text-xs text-uppercase tracking-wider fw-semibold d-block">Total Berat Keseluruhan</span>
                                <span class="fs-4 fw-bold text-dark" id="total_berat_display">0.0 kg</span>
                            </div>
                            <div class="col-12 col-sm-6">
                                <span class="text-muted text-xs text-uppercase tracking-wider fw-semibold d-block">Grand Total Pendapatan</span>
                                <div class="d-flex align-items-center">
                                    <span class="fs-4 fw-bold text-success me-1">Rp</span>
                                    <span class="fs-2 fw-bold text-success" id="grand_total_display">0</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    let itemIndex = 1;

    document.getElementById('search-anggota').addEventListener('input', function(e) {
        if(e.target.value.toLowerCase().includes('budi')) {
            setTimeout(() => {
                document.getElementById('selected-member-card').classList.remove('d-none');
            }, 200);
        }
    });

    function addItemRow() {
        const container = document.getElementById('items-container');
        const newRow = document.createElement('div');
        newRow.className = 'item-row p-3 border rounded-3 bg-light position-relative';
        newRow.innerHTML = `
            <div class="row g-2 align-items-center">
                <div class="col-12 col-md-5">
                    <label class="form-label text-xs fw-semibold text-muted mb-1">Kategori Sampah</label>
                    <select class="form-select text-sm kategori-select" name="items[${itemIndex}][kategori]" required onchange="calculateGrandTotal()">
                        <option value="" selected disabled>Pilih Kategori...</option>
                        <option value="3000">Plastik PET (Rp 3.000 / kg)</option>
                        <option value="1000">Kardus Bekas (Rp 1.000 / kg)</option>
                        <option value="5000">Besi / Logam (Rp 5.000 / kg)</option>
                        <option value="500">Kaca / Beling (Rp 500 / kg)</option>
                    </select>
                </div>
                <div class="col-6 col-md-3">
                    <label class="form-label text-xs fw-semibold text-muted mb-1">Berat (kg)</label>
                    <div class="input-group">
                        <input type="number" step="0.1" min="0.1" class="form-control text-sm berat-input" name="items[${itemIndex}][berat]" placeholder="0.0" required oninput="calculateGrandTotal()">
                        <span class="input-group-text bg-white text-muted text-xs">kg</span>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <label class="form-label text-xs fw-semibold text-muted mb-1">Subtotal (Rp)</label>
                    <div class="fw-bold text-success text-sm py-2 px-2 bg-white rounded border subtotal-text">Rp 0</div>
                </div>
                <div class="col-12 col-md-1 text-end pt-2 pt-md-4">
                    <button type="button" class="btn btn-outline-danger btn-sm border-0 remove-item-btn" onclick="removeItemRow(this)" title="Hapus Item">
                        <i class="bi bi-trash fs-6"></i>
                    </button>
                </div>
            </div>
        `;
        container.appendChild(newRow);
        itemIndex++;
        updateRemoveButtons();
    }

    function removeItemRow(btn) {
        const row = btn.closest('.item-row');
        row.remove();
        updateRemoveButtons();
        calculateGrandTotal();
    }

    function updateRemoveButtons() {
        const rows = document.querySelectorAll('.item-row');
        rows.forEach(row => {
            const btn = row.querySelector('.remove-item-btn');
            if (rows.length === 1) {
                btn.disabled = true;
            } else {
                btn.disabled = false;
            }
        });
    }

    function calculateGrandTotal() {
        const rows = document.querySelectorAll('.item-row');
        let grandTotal = 0;
        let totalBerat = 0;

        rows.forEach(row => {
            const harga = parseFloat(row.querySelector('.kategori-select').value) || 0;
            const berat = parseFloat(row.querySelector('.berat-input').value) || 0;
            const subtotal = harga * berat;

            row.querySelector('.subtotal-text').innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(subtotal);

            grandTotal += subtotal;
            totalBerat += berat;
        });

        document.getElementById('total_berat_display').innerText = totalBerat.toFixed(1) + ' kg';
        document.getElementById('grand_total_display').innerText = new Intl.NumberFormat('id-ID').format(grandTotal);
    }
</script>
@endsection
