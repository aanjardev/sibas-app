@extends('layouts.admin')

@section('title', 'Edit Setor Sampah')
@section('header_title', 'Edit Setor Sampah')

@section('content')
<form action="#" method="POST" id="edit-setor-form">
    @csrf
    <!-- Top Header Bar with Back & Save Buttons on a single row -->
    <div class="row g-3 mb-3 mb-md-4">
        <div class="col-12 d-flex align-items-center justify-content-between gap-2">
            <a href="{{ route('admin.setor-sampah.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
            <div class="d-flex align-items-center gap-2">
                <span class="badge bg-light text-dark border d-none d-sm-inline-block">TRX-S045</span>
                <button type="submit" class="btn btn-primary btn-sm text-white px-3 shadow-sm">
                    <i class="bi bi-check-lg me-1"></i> Simpan Perubahan
                </button>
            </div>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-12 col-lg-9 mx-auto">
            <!-- Member Info Card (Read-only) -->
            <div class="admin-card border-0 shadow-sm mb-3">
                <div class="admin-card-header bg-transparent border-bottom p-3 p-md-4 d-flex justify-content-between align-items-center">
                    <h5 class="admin-card-title mb-0 fw-bold fs-6">Anggota Penyetor</h5>
                    <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-1">Terkunci</span>
                </div>
                <div class="admin-card-body p-3 p-md-4">
                    <div class="d-flex align-items-center">
                        <div class="bg-success bg-opacity-10 text-success rounded-circle d-flex align-items-center justify-content-center me-3 flex-shrink-0" style="width: 48px; height: 48px;">
                            <span class="fw-bold fs-5">B</span>
                        </div>
                        <div>
                            <h6 class="mb-0 fw-bold text-dark text-base">Budi Santoso</h6>
                            <span class="text-muted text-xs">ID: AGT-001 | No. HP: 0812-3456-7890</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Edit Form (Multi-Item) -->
            <div class="admin-card border-0 shadow-sm mb-3">
                <div class="admin-card-header bg-transparent border-bottom p-3 p-md-4 d-flex align-items-center justify-content-between">
                    <h5 class="admin-card-title mb-0 fw-bold fs-5">Edit Detail Rincian Setoran Sampah</h5>
                    <button type="button" class="btn btn-outline-primary btn-sm text-sm" onclick="addItemRow()">
                        <i class="bi bi-plus-lg me-1"></i> Tambah Jenis Sampah
                    </button>
                </div>
                <div class="admin-card-body p-3 p-md-4">
                    <div class="mb-3">
                        <label for="tanggal" class="form-label fw-semibold text-sm">Tanggal Setor <span class="text-danger">*</span></label>
                        <input type="date" class="form-control text-sm" id="tanggal" name="tanggal" value="2026-07-15" style="max-width: 250px;" required>
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
                                        <option value="3000" selected>Plastik PET (Rp 3.000 / kg)</option>
                                        <option value="1000">Kardus Bekas (Rp 1.000 / kg)</option>
                                        <option value="5000">Besi / Logam (Rp 5.000 / kg)</option>
                                        <option value="500">Kaca / Beling (Rp 500 / kg)</option>
                                    </select>
                                </div>
                                <div class="col-6 col-md-3">
                                    <label class="form-label text-xs fw-semibold text-muted mb-1">Berat (kg)</label>
                                    <div class="input-group">
                                        <input type="number" step="0.1" min="0.1" class="form-control text-sm berat-input" name="items[0][berat]" value="5.0" required oninput="calculateGrandTotal()">
                                        <span class="input-group-text bg-white text-muted text-xs">kg</span>
                                    </div>
                                </div>
                                <div class="col-6 col-md-3">
                                    <label class="form-label text-xs fw-semibold text-muted mb-1">Subtotal (Rp)</label>
                                    <div class="fw-bold text-success text-sm py-2 px-2 bg-white rounded border subtotal-text">Rp 15.000</div>
                                </div>
                                <div class="col-12 col-md-1 text-end pt-2 pt-md-4">
                                    <button type="button" class="btn btn-outline-danger btn-sm border-0 remove-item-btn" onclick="removeItemRow(this)" title="Hapus Item">
                                        <i class="bi bi-trash fs-6"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Item Row 2 -->
                        <div class="item-row p-3 border rounded-3 bg-light position-relative">
                            <div class="row g-2 align-items-center">
                                <div class="col-12 col-md-5">
                                    <label class="form-label text-xs fw-semibold text-muted mb-1">Kategori Sampah</label>
                                    <select class="form-select text-sm kategori-select" name="items[1][kategori]" required onchange="calculateGrandTotal()">
                                        <option value="3000">Plastik PET (Rp 3.000 / kg)</option>
                                        <option value="1000" selected>Kardus Bekas (Rp 1.000 / kg)</option>
                                        <option value="5000">Besi / Logam (Rp 5.000 / kg)</option>
                                        <option value="500">Kaca / Beling (Rp 500 / kg)</option>
                                    </select>
                                </div>
                                <div class="col-6 col-md-3">
                                    <label class="form-label text-xs fw-semibold text-muted mb-1">Berat (kg)</label>
                                    <div class="input-group">
                                        <input type="number" step="0.1" min="0.1" class="form-control text-sm berat-input" name="items[1][berat]" value="10.0" required oninput="calculateGrandTotal()">
                                        <span class="input-group-text bg-white text-muted text-xs">kg</span>
                                    </div>
                                </div>
                                <div class="col-6 col-md-3">
                                    <label class="form-label text-xs fw-semibold text-muted mb-1">Subtotal (Rp)</label>
                                    <div class="fw-bold text-success text-sm py-2 px-2 bg-white rounded border subtotal-text">Rp 10.000</div>
                                </div>
                                <div class="col-12 col-md-1 text-end pt-2 pt-md-4">
                                    <button type="button" class="btn btn-outline-danger btn-sm border-0 remove-item-btn" onclick="removeItemRow(this)" title="Hapus Item">
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
                                <span class="fs-4 fw-bold text-dark" id="total_berat_display">15.0 kg</span>
                            </div>
                            <div class="col-12 col-sm-6">
                                <span class="text-muted text-xs text-uppercase tracking-wider fw-semibold d-block">Grand Total Pendapatan</span>
                                <div class="d-flex align-items-center">
                                    <span class="fs-4 fw-bold text-success me-1">Rp</span>
                                    <span class="fs-2 fw-bold text-success" id="grand_total_display">25.000</span>
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
    let itemIndex = 2;

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
