@extends('layouts.admin')

@section('title', 'Tambah Anggota Baru')
@section('header_title', 'Tambah Anggota Baru')

@section('content')
<form action="{{ route('admin.anggota.store') }}" method="POST" id="create-anggota-form">
    @csrf
    <!-- Top Header Bar with Back & Save Buttons on a single row -->
    <div class="row g-3 mb-3 mb-md-4">
        <div class="col-12 d-flex align-items-center justify-content-between gap-2">
            <a href="{{ route('admin.anggota.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
            <div class="d-flex align-items-center gap-2">
                <span class="badge bg-light text-dark border d-none d-sm-inline-block">ID: {{ $nomorAnggota ?? 'Otomatis' }}</span>
                <button type="submit" class="btn btn-primary btn-sm text-white px-3 shadow-sm">
                    <i class="bi bi-check-lg me-1"></i> Simpan Data Anggota
                </button>
            </div>
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
                    <h5 class="admin-card-title mb-0 fw-bold fs-5">Form Pendaftaran Anggota Baru</h5>
                </div>
                <div class="admin-card-body p-3 p-md-4">
                    <!-- Data Pribadi -->
                    <div class="text-xs fw-bold text-uppercase text-muted tracking-wider mb-3">Data Pribadi</div>
                    
                    <div class="mb-3">
                        <label for="name" class="form-label fw-semibold text-sm">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" class="form-control text-sm @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" placeholder="Masukkan nama lengkap" required>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-12 col-md-6">
                            <label for="email" class="form-label fw-semibold text-sm">Email</label>
                            <input type="email" class="form-control text-sm @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" placeholder="nama@contoh.com">
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="no_hp" class="form-label fw-semibold text-sm">Nomor HP / WA <span class="text-danger">*</span></label>
                            <input type="tel" class="form-control text-sm @error('no_hp') is-invalid @enderror" id="no_hp" name="no_hp" value="{{ old('no_hp') }}" placeholder="08xxxxxxxxxx" required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="alamat" class="form-label fw-semibold text-sm">Alamat Lengkap <span class="text-danger">*</span></label>
                        <textarea class="form-control text-sm @error('alamat') is-invalid @enderror" id="alamat" name="alamat" rows="3" placeholder="Masukkan alamat lengkap domisili" required>{{ old('alamat') }}</textarea>
                    </div>

                    <!-- Keamanan Akun -->
                    <div class="text-xs fw-bold text-uppercase text-muted tracking-wider mb-3 pt-2 border-top">Keamanan Akun</div>

                    <div class="mb-3">
                        <label for="password" class="form-label fw-semibold text-sm">Password <span class="text-danger">*</span></label>
                        <div class="password-wrapper position-relative">
                            <input type="password" class="form-control text-sm pe-5 @error('password') is-invalid @enderror" id="password" name="password" placeholder="Minimal 8 karakter" required oninput="checkStrength(this.value)">
                            <button type="button" class="btn border-0 position-absolute end-0 top-50 translate-middle-y text-muted px-3" onclick="togglePassword('password', this)">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                        <div class="password-strength d-flex gap-1 mt-2">
                            <div class="strength-bar flex-fill rounded-1 bg-secondary bg-opacity-25" id="bar1" style="height: 4px;"></div>
                            <div class="strength-bar flex-fill rounded-1 bg-secondary bg-opacity-25" id="bar2" style="height: 4px;"></div>
                            <div class="strength-bar flex-fill rounded-1 bg-secondary bg-opacity-25" id="bar3" style="height: 4px;"></div>
                            <div class="strength-bar flex-fill rounded-1 bg-secondary bg-opacity-25" id="bar4" style="height: 4px;"></div>
                        </div>
                        <div class="strength-text text-xs text-muted mt-1" id="strength-text"></div>
                    </div>

                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label fw-semibold text-sm">Konfirmasi Password <span class="text-danger">*</span></label>
                        <div class="password-wrapper position-relative">
                            <input type="password" class="form-control text-sm pe-5" id="password_confirmation" name="password_confirmation" placeholder="Ulangi password" required>
                            <button type="button" class="btn border-0 position-absolute end-0 top-50 translate-middle-y text-muted px-3" onclick="togglePassword('password_confirmation', this)">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

@section('scripts')
<script>
    function togglePassword(fieldId, btn) {
        const field = document.getElementById(fieldId);
        const icon = btn.querySelector('i');
        if (field.type === 'password') {
            field.type = 'text';
            icon.className = 'bi bi-eye-slash';
        } else {
            field.type = 'password';
            icon.className = 'bi bi-eye';
        }
    }

    function checkStrength(value) {
        const bars = [document.getElementById('bar1'), document.getElementById('bar2'), document.getElementById('bar3'), document.getElementById('bar4')];
        const text = document.getElementById('strength-text');
        const hasLetter = /[a-zA-Z]/.test(value);
        const hasUpper  = /[A-Z]/.test(value);
        const hasLower  = /[a-z]/.test(value);
        const hasNumber = /[0-9]/.test(value);
        const hasSymbol = /[^A-Za-z0-9]/.test(value);
        const isLong    = value.length >= 8;

        let score = 0;
        if (value.length > 0) {
            score = 1;
            if (hasLetter && hasNumber) {
                score = 2;
                if (isLong && (hasUpper || hasSymbol)) {
                    score = 3;
                    if (hasUpper && hasLower && hasSymbol) {
                        score = 4;
                    }
                }
            }
        }

        const colors = ['#ef4444', '#f97316', '#eab308', '#22c55e'];
        const labels = ['Lemah', 'Sedang', 'Cukup Kuat', 'Kuat'];

        bars.forEach((bar, i) => {
            bar.style.background = i < score ? colors[score - 1] : '#cbd5e1';
        });

        if (value.length === 0) text.textContent = '';
        else {
            text.textContent = 'Kekuatan: ' + labels[score - 1];
            text.style.color = colors[score - 1];
        }
    }
</script>
@endsection
@endsection
