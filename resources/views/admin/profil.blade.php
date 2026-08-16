@extends('layouts.admin')

@section('title', 'Profil Admin')
@section('header_title', 'Profil Administrator')

@section('content')
<div class="row">
    <div class="col-12 col-md-8 col-lg-6 mx-auto">
        
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i> Terdapat kesalahan pengisian form.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Profile Header Card -->
        <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px; overflow: hidden;">
            <div class="card-body p-4 text-center text-white" style="background: linear-gradient(135deg, #07351e 0%, #0d522d 100%);">
                <img src="https://ui-avatars.com/api/?name={{ urlencode($admin->name) }}&background=fff&color=084627&size=80&bold=true" alt="Admin Avatar" class="rounded-circle mb-3 shadow-sm" style="width: 80px; height: 80px; border: 3px solid #fff;">
                <h4 class="fw-bold mb-1 text-white">{{ $admin->name }}</h4>
                <p class="text-white opacity-75 mb-0">{{ ucfirst($admin->role) }}</p>
            </div>
        </div>

        <!-- Personal Info Card -->
        <div class="card border-0 shadow-sm" style="border-radius: 12px;">
            <div class="card-header bg-white border-bottom-0 pt-4 pb-0 px-4 d-flex justify-content-between align-items-center">
                <h6 class="fw-bold mb-0 text-uppercase text-muted" style="letter-spacing: 0.5px; font-size: 0.85rem;">Informasi Akun</h6>
                <button type="button" class="btn btn-sm btn-outline-primary fw-bold" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                    <i class="bi bi-pencil-square me-1"></i> Edit
                </button>
            </div>
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-4 pb-3 border-bottom">
                    <div class="bg-light rounded d-flex align-items-center justify-content-center me-3" style="width: 42px; height: 42px;">
                        <i class="bi bi-person text-muted fs-5"></i>
                    </div>
                    <div>
                        <p class="mb-0 text-muted" style="font-size: 0.8rem;">Nama Lengkap</p>
                        <h6 class="fw-bold mb-0 text-dark">{{ $admin->name }}</h6>
                    </div>
                </div>
                
                <div class="d-flex align-items-center mb-4 pb-3 border-bottom">
                    <div class="bg-light rounded d-flex align-items-center justify-content-center me-3" style="width: 42px; height: 42px;">
                        <i class="bi bi-envelope text-muted fs-5"></i>
                    </div>
                    <div>
                        <p class="mb-0 text-muted" style="font-size: 0.8rem;">Email</p>
                        <h6 class="fw-bold mb-0 text-dark">{{ $admin->email }}</h6>
                    </div>
                </div>

                <div class="d-flex align-items-center">
                    <div class="bg-light rounded d-flex align-items-center justify-content-center me-3" style="width: 42px; height: 42px;">
                        <i class="bi bi-shield-check text-muted fs-5"></i>
                    </div>
                    <div>
                        <p class="mb-0 text-muted" style="font-size: 0.8rem;">Status Akses</p>
                        <h6 class="fw-bold mb-0 text-success">
                            <i class="bi bi-check-circle-fill me-1"></i> Hak Akses Penuh
                        </h6>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Profile Modal -->
        <div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content shadow" style="border-radius: 12px; border: none;">
                    <div class="modal-header border-bottom-0 pt-4 px-4 pb-0">
                        <h5 class="modal-title fw-bold" id="editProfileModalLabel">Edit Profil</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4">
                        <form action="{{ route('admin.profil.update') }}" method="POST">
                            @csrf
                            
                            <div class="mb-3">
                                <label for="name" class="form-label fw-semibold" style="font-size: 0.9rem;">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $admin->name) }}" required maxlength="50">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="current_password" class="form-label fw-semibold" style="font-size: 0.9rem;">Password Lama</label>
                                <input type="password" class="form-control @error('current_password') is-invalid @enderror" id="current_password" name="current_password" placeholder="Isi jika ingin mengganti password">
                                @error('current_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label fw-semibold" style="font-size: 0.9rem;">Password Baru</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Minimal 8 karakter">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="password_confirmation" class="form-label fw-semibold" style="font-size: 0.9rem;">Konfirmasi Password Baru</label>
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Ulangi password baru">
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary fw-bold" style="background-color: var(--primary); border-color: var(--primary);">
                                    <i class="bi bi-save me-1"></i> Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        @if ($errors->any())
            var editModal = new bootstrap.Modal(document.getElementById('editProfileModal'));
            editModal.show();
        @endif
    });
</script>
@endsection
