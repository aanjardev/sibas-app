@extends('layouts.admin')

@section('title', 'Edit Setor Sampah')
@section('header_title', 'Edit Setor Sampah')

@section('content')
<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <a href="{{ route('admin.setor-sampah.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left me-1"></i> Kembali ke Riwayat
        </a>
        <span class="badge bg-light text-dark border">No. TRX: TRX-S045</span>
    </div>
</div>

<div class="row">
    <div class="col-12 col-lg-8 mx-auto">
        
        <!-- Member Information Readonly -->
        <div class="admin-card shadow-sm border mb-4">
            <div class="admin-card-header bg-transparent border-bottom p-4 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold">1. Anggota Penyetor</h5>
                <span class="badge text-dark rounded-pill" style="background-color: rgba(40, 167, 69, 0.2);">Data Terkunci</span>
            </div>
            <div class="admin-card-body p-4">
                <div class="d-flex align-items-center">
                    <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px; font-size: 1.25rem;">
                        <span class="fw-bold">B</span>
                    </div>
                    <div>
                        <h5 class="mb-1 fw-bold text-success">Budi Santoso</h5>
                        <span class="text-muted text-sm">ID Anggota: AGT-001 | No. Telepon: 0812-3456-7890</span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="admin-card shadow-sm border">
            <div class="admin-card-header bg-transparent border-bottom p-4">
                <h5 class="mb-0 fw-bold">2. Edit Detail Setoran Sampah</h5>
            </div>
            <div class="admin-card-body p-4">
                <form action="#" method="POST">
                    
                    <div class="mb-4">
                        <label for="tanggal" class="form-label fw-semibold">Tanggal Setor <span class="text-danger">*</span></label>
                        <input type="date" class="form-control form-control-lg bg-light border-0" id="tanggal" value="2026-07-17" required>
                    </div>
                    
                    <div class="row mb-4">
                        <div class="col-md-6 mb-4 mb-md-0">
                            <label for="kategori" class="form-label fw-semibold">Kategori Sampah <span class="text-danger">*</span></label>
                            <select class="form-select form-select-lg bg-light border-0" id="kategori" required>
                                <option value="" disabled>Pilih Kategori...</option>
                                <option value="Plastik PET" selected>Plastik PET (Rp 3.000/kg)</option>
                                <option value="Kardus">Kardus Bekas (Rp 1.000/kg)</option>
                                <option value="Besi">Besi/Logam (Rp 5.000/kg)</option>
                                <option value="Kaca">Kaca/Beling (Rp 500/kg)</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="berat" class="form-label fw-semibold">Berat Aktual (Kg) <span class="text-danger">*</span></label>
                            <div class="input-group input-group-lg">
                                <input type="number" step="0.1" min="0.1" class="form-control bg-light border-0" id="berat" value="5.0" required>
                                <span class="input-group-text bg-light border-0 text-muted">kg</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-4 p-4 bg-light rounded-3 border-start border-4 border-success">
                        <label for="total" class="form-label fw-semibold text-muted mb-1">Total Pendapatan</label>
                        <div class="input-group input-group-lg">
                            <span class="input-group-text bg-transparent border-0 fs-3 fw-bold text-success ps-0">Rp</span>
                            <input type="text" class="form-control bg-transparent border-0 fs-3 fw-bold text-success" id="total" value="15.000" readonly>
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-end pt-3 mt-4 border-top">
                        <button type="reset" class="btn btn-light px-4 me-2">Kembalikan Semula</button>
                        <button type="button" class="btn btn-primary px-4 shadow-sm" onclick="alert('Simulasi: Perubahan Disimpan!')">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
