@extends('layouts.admin')

@section('title', 'Undang Admin Baru')
@section('header_title', 'Undang Admin Baru')

@section('content')
<form action="{{ route('admin.kelola-admin.store') }}" method="POST" id="create-admin-form">
    @csrf
    {{-- Top Header Bar --}}
    <div class="row g-3 mb-3 mb-md-4">
        <div class="col-12 d-flex align-items-center justify-content-between gap-2">
            <a href="{{ route('admin.kelola-admin.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
            <button type="submit" class="btn btn-primary btn-sm text-white px-3 shadow-sm">
                <i class="bi bi-send me-1"></i> Buat Undangan
            </button>
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
            <div class="admin-card border-0 shadow-sm">
                <div class="admin-card-header bg-transparent border-bottom p-3 p-md-4">
                    <h5 class="admin-card-title mb-0 fw-bold fs-5">Form Undangan Admin Baru</h5>
                </div>
                <div class="admin-card-body p-3 p-md-4">
                    {{-- Info --}}
                    <div class="p-3 bg-light rounded-3 border mb-4">
                        <div class="d-flex align-items-start gap-2">
                            <i class="bi bi-lightbulb text-warning fs-5 flex-shrink-0"></i>
                            <p class="text-sm text-muted mb-0">Cukup masukkan email calon admin. Setelah undangan dibuat, admin baru dapat membuka halaman <strong>/admin/register</strong>, memasukkan email yang telah didaftarkan, lalu mengisi nama, password, dan data diri untuk mengaktifkan akunnya.</p>
                        </div>
                    </div>

                    <div class="mb-0">
                        <label for="email" class="form-label fw-semibold text-sm">Email Admin Baru <span class="text-danger">*</span></label>
                        <input type="email" class="form-control text-sm @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" placeholder="Contoh: admin@sibas.com" required>
                        <div class="form-text text-xs">Email ini akan digunakan oleh admin baru untuk login dan registrasi.</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
