@extends('layouts.admin')

@section('title', 'Edit Data Anggota')
@section('header_title', 'Edit Data Anggota')

@section('content')
<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <a href="{{ route('admin.anggota.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
        <span class="badge bg-light text-dark border">ID: AGT-001</span>
    </div>
</div>

<div class="row">
    <div class="col-12 col-lg-8 mx-auto">
        <div class="admin-card shadow-sm border">
            <div class="admin-card-header bg-transparent border-bottom p-4">
                <h5 class="mb-0 fw-bold">Form Edit Anggota Koperasi</h5>
                <p class="text-muted text-sm mb-0">Perbarui data diri untuk Budi Santoso.</p>
            </div>
            <div class="admin-card-body p-4">
                <form action="#" method="POST">
                    <div class="mb-4">
                        <label for="nama" class="form-label fw-semibold">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-lg bg-light border-0" id="nama" value="Budi Santoso" required>
                    </div>
                    
                    <div class="row mb-4">
                        <div class="col-md-6 mb-4 mb-md-0">
                            <label for="telepon" class="form-label fw-semibold">No. Telepon <span class="text-danger">*</span></label>
                            <input type="tel" class="form-control form-control-lg bg-light border-0" id="telepon" value="0812-3456-7890" required>
                        </div>
                        <div class="col-md-6">
                            <label for="nik" class="form-label fw-semibold">NIK (Nomor Induk Kependudukan)</label>
                            <input type="text" class="form-control form-control-lg bg-light border-0" id="nik" value="3171234567890001">
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <label for="alamat" class="form-label fw-semibold">Alamat Lengkap <span class="text-danger">*</span></label>
                        <textarea class="form-control form-control-lg bg-light border-0" id="alamat" rows="3" required>Jl. Merdeka No. 10, Jakarta</textarea>
                    </div>
                    
                    <div class="row mb-4">
                        <div class="col-md-6 mb-4 mb-md-0">
                            <label for="rt" class="form-label fw-semibold">RT / RW</label>
                            <div class="d-flex">
                                <input type="text" class="form-control form-control-lg bg-light border-0 me-2" id="rt" value="001">
                                <input type="text" class="form-control form-control-lg bg-light border-0" id="rw" value="005">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="status" class="form-label fw-semibold">Status Keanggotaan</label>
                            <select class="form-select form-select-lg bg-light border-0" id="status">
                                <option value="1" selected>Aktif</option>
                                <option value="0">Nonaktif</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-end pt-3 mt-4 border-top">
                        <button type="reset" class="btn btn-light px-4 me-2">Kembalikan Semula</button>
                        <button type="submit" class="btn btn-primary px-4 shadow-sm">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
