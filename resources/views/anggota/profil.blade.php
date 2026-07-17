@extends('layouts.mobile')

@section('title', 'Profil Anggota')
@section('header_title', 'Profil Saya')

@section('content')
<!-- Profile Hero Card -->
<div class="mb-4 mt-3">
    <div class="primary-card p-4 text-center position-relative">
        <!-- Background Icon
        <i class="bi bi-person-badge position-absolute" style="font-size: 8rem; right: -20px; top: -10px; opacity: 0.1;"></i> -->

        <div class="position-relative z-1">
            <div class="bg-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3 shadow-sm" style="width: 80px; height: 80px; color: var(--primary-dark);">
                <i class="bi bi-person-fill" style="font-size: 3.5rem;"></i>
            </div>
            <h4 class="fw-bold mb-1 text-white" style="font-size: 1.6rem;">Budi Santoso</h4>
            <p class="text-white opacity-75 text-sm mb-4">Anggota Aktif • BSA0001</p>
            
            <div class="d-inline-block bg-white bg-opacity-25 text-white px-4 py-2 shadow-sm" style="border-radius: 50rem; border: 1px solid rgba(255,255,255,0.3);">
                <span class="opacity-75 me-1" style="font-size: 0.85rem;">Saldo:</span> 
                <span class="fw-bold" style="font-size: 1.1rem;">Rp 1.250.000</span>
            </div>
        </div>
    </div>
</div>

<h6 class="fw-bold mb-2 text-sm text-uppercase text-muted tracking-wide px-1">Informasi Pribadi</h6>
<div class="surface-card mb-4 p-0">
    <div class="d-flex align-items-center p-3 border-bottom" style="border-color: var(--border-color) !important;">
        <div class="bg-light rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 42px; height: 42px;">
            <i class="bi bi-envelope-fill text-muted fs-5"></i>
        </div>
        <div>
            <p class="mb-0 opacity-75 fw-medium" style="font-size: 0.8rem;">Email</p>
            <h6 class="fw-bold mb-0 text-main" style="font-size: 1rem;">budi@example.com</h6>
        </div>
    </div>
    <div class="d-flex align-items-center p-3 border-bottom" style="border-color: var(--border-color) !important;">
        <div class="bg-light rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 42px; height: 42px;">
            <i class="bi bi-telephone-fill text-muted fs-5"></i>
        </div>
        <div>
            <p class="mb-0 opacity-75 fw-medium" style="font-size: 0.8rem;">Nomor HP</p>
            <h6 class="fw-bold mb-0 text-main" style="font-size: 1rem;">081234567890</h6>
        </div>
    </div>
    <div class="d-flex align-items-center p-3">
        <div class="bg-light rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 42px; height: 42px;">
            <i class="bi bi-geo-alt-fill text-muted fs-5"></i>
        </div>
        <div>
            <p class="mb-0 opacity-75 fw-medium" style="font-size: 0.8rem;">Alamat Lengkap</p>
            <h6 class="fw-bold mb-0 text-main" style="font-size: 1rem;">Jl. Melati No. 45, Sukamaju</h6>
        </div>
    </div>
</div>

<button type="button" class="btn bg-white w-100 py-3 text-danger fw-bold shadow-sm d-flex justify-content-center align-items-center" style="border: 1px solid var(--border-color); border-radius: 8px;" data-bs-toggle="modal" data-bs-target="#logoutModal">
    <i class="bi bi-box-arrow-right me-2 fs-5"></i> Keluar
</button>

<!-- Logout Confirmation Modal -->
<div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="margin: 1rem; max-width: calc(100% - 2rem);">
        <div class="modal-content shadow" style="border-radius: 16px; border: none;">
            <div class="modal-body text-center p-4">
                <div class="bg-danger bg-opacity-10 text-danger rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                    <i class="bi bi-box-arrow-right fs-2"></i>
                </div>
                <h5 class="fw-bold mb-2">Konfirmasi Keluar</h5>
                <p class="text-muted text-sm mb-4">Apakah Anda yakin ingin keluar dari akun Anda?</p>
                <div class="row g-2">
                    <div class="col-6">
                        <button type="button" class="btn btn-light w-100 fw-bold py-2 border" data-bs-dismiss="modal" style="border-radius: 8px;">Batal</button>
                    </div>
                    <div class="col-6">
                        <a href="#" class="btn btn-danger w-100 fw-bold py-2" style="border-radius: 8px;">Ya, Keluar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
