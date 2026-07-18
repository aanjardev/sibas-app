@extends('layouts.admin')

@section('title', 'Input Setor Sampah')
@section('header_title', 'Input Setor Sampah Baru')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <a href="{{ route('admin.setor-sampah.index') }}" class="btn btn-outline-secondary btn-sm mb-3">
            <i class="bi bi-arrow-left me-1"></i> Kembali ke Riwayat
        </a>
    </div>
</div>

<div class="row">
    <div class="col-12 col-lg-8 mx-auto">
        <div class="admin-card shadow-sm border mb-4">
            <div class="admin-card-header bg-transparent border-bottom p-4">
                <h5 class="mb-0 fw-bold">1. Cari Anggota</h5>
                <p class="text-muted text-sm mb-0">Temukan nasabah yang menyetor sampah atau tambahkan anggota baru.</p>
            </div>
            <div class="admin-card-body p-4">
                <label for="search-anggota" class="form-label fw-semibold">Pencarian Nama / ID Anggota</label>
                <div class="d-flex align-items-center gap-3">
                    <div class="input-group input-group-lg flex-grow-1">
                        <span class="input-group-text bg-light border-0"><i class="bi bi-search"></i></span>
                        <input type="text" class="form-control bg-light border-0" id="search-anggota" placeholder="Ketik nama anggota...">
                    </div>
                    <span class="text-muted fw-semibold">ATAU</span>
                    <a href="{{ route('admin.anggota.create') }}" class="btn btn-outline-success btn-lg text-nowrap">
                        <i class="bi bi-person-plus me-1"></i> Tambah Baru
                    </a>
                </div>
                
                <!-- Dummy selected member display for prototyping -->
                <div class="mt-3 p-3 bg-success bg-opacity-10 border border-success rounded-3 d-flex justify-content-between align-items-center d-none" id="selected-member-card">
                    <div class="d-flex align-items-center">
                        <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                            <span class="fw-bold">B</span>
                        </div>
                        <div>
                            <h6 class="mb-0 fw-bold text-success">Budi Santoso</h6>
                            <span class="text-success text-sm opacity-75">ID: AGT-001</span>
                        </div>
                    </div>
                    <button type="button" class="btn btn-sm btn-light text-danger" onclick="document.getElementById('selected-member-card').classList.add('d-none'); document.getElementById('search-anggota').value='';">
                        Batal
                    </button>
                </div>
            </div>
        </div>
        
        <div class="admin-card shadow-sm border">
            <div class="admin-card-header bg-transparent border-bottom p-4">
                <h5 class="mb-0 fw-bold">2. Detail Setoran Sampah</h5>
            </div>
            <div class="admin-card-body p-4">
                <form action="#" method="POST">
                    
                    <div class="mb-4">
                        <label for="tanggal" class="form-label fw-semibold">Tanggal Setor <span class="text-danger">*</span></label>
                        <input type="date" class="form-control form-control-lg bg-light border-0" id="tanggal" value="{{ date('Y-m-d') }}" required>
                    </div>
                    
                    <div class="row mb-4">
                        <div class="col-md-6 mb-4 mb-md-0">
                            <label for="kategori" class="form-label fw-semibold">Kategori Sampah <span class="text-danger">*</span></label>
                            <select class="form-select form-select-lg bg-light border-0" id="kategori" required>
                                <option value="" selected disabled>Pilih Kategori...</option>
                                <option value="Plastik PET">Plastik PET (Rp 3.000/kg)</option>
                                <option value="Kardus">Kardus Bekas (Rp 1.000/kg)</option>
                                <option value="Besi">Besi/Logam (Rp 5.000/kg)</option>
                                <option value="Kaca">Kaca/Beling (Rp 500/kg)</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="berat" class="form-label fw-semibold">Berat Aktual (Kg) <span class="text-danger">*</span></label>
                            <div class="input-group input-group-lg">
                                <input type="number" step="0.1" min="0.1" class="form-control bg-light border-0" id="berat" placeholder="0.0" required>
                                <span class="input-group-text bg-light border-0 text-muted">kg</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-4 p-4 bg-light rounded-3 border-start border-4 border-success">
                        <label for="total" class="form-label fw-semibold text-muted mb-1">Total Pendapatan (Estimasi)</label>
                        <div class="input-group input-group-lg">
                            <span class="input-group-text bg-transparent border-0 fs-3 fw-bold text-success ps-0">Rp</span>
                            <input type="text" class="form-control bg-transparent border-0 fs-3 fw-bold text-success" id="total" value="0" readonly>
                        </div>
                        <p class="text-muted text-xs mb-0 mt-1"><i class="bi bi-info-circle me-1"></i> Total akan dihitung otomatis atau bisa diisi manual jika harga fluktuatif.</p>
                    </div>
                    
                    <div class="d-flex justify-content-end pt-3 mt-4 border-top">
                        <button type="reset" class="btn btn-light px-4 me-2">Batal</button>
                        <!-- Add a quick JS snippet just for interactivity demo -->
                        <button type="button" class="btn btn-primary px-4 shadow-sm" onclick="alert('Simulasi: Transaksi Berhasil Disimpan!')">Simpan Transaksi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Dummy interactions for prototype
    document.getElementById('search-anggota').addEventListener('input', function(e) {
        if(e.target.value.toLowerCase().includes('budi')) {
            setTimeout(() => {
                document.getElementById('selected-member-card').classList.remove('d-none');
            }, 300);
        }
    });
</script>
@endsection
