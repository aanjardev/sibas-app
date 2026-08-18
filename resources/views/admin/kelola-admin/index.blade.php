@extends('layouts.admin')

@section('title', 'Kelola Admin')
@section('header_title', 'Kelola Admin')

@section('content')
{{-- Header Bar & Actions --}}
<div class="row g-3 mb-3 mb-md-4 align-items-center">
    <div class="col-12 col-md-auto">
        <a href="{{ route('admin.kelola-admin.create') }}" class="btn btn-primary btn-sm text-white shadow-sm d-flex align-items-center justify-content-center py-2 px-3" style="min-width: 180px;">
            <i class="bi bi-person-plus me-2"></i> Undang Admin
        </a>
    </div>
    
    {{-- Search & Filter Bar --}}
    <div class="col-12 col-md">
        <form action="{{ route('admin.kelola-admin.index') }}" method="GET" class="d-flex gap-2">
            <div class="input-group">
                <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-search"></i></span>
                <input type="text" name="search" value="{{ request('search') }}" class="form-control bg-white border-start-0 text-sm" placeholder="Cari nama, email...">
                <button class="btn btn-primary" type="submit">Cari</button>
            </div>
            <select name="status" class="form-select bg-white text-sm" style="min-width: 160px; max-width: 200px;" onchange="this.form.submit()">
                <option value="">Semua Status</option>
                <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Sudah Aktif</option>
                <option value="belum_aktif" {{ request('status') == 'belum_aktif' ? 'selected' : '' }}>Belum Aktif</option>
            </select>
        </form>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

{{-- Info Card --}}
<div class="admin-card border-0 shadow-sm mb-3 mb-md-4 p-3">
    <div class="d-flex align-items-start gap-2">
        <i class="bi bi-info-circle text-primary fs-5 flex-shrink-0 mt-1"></i>
        <div>
            <p class="text-sm mb-1 text-dark fw-semibold">Cara Kerja Undangan Admin</p>
            <p class="text-xs text-muted mb-0">Buat undangan dengan memasukkan nama dan email admin baru. Setelah dibuat, admin baru tersebut dapat mengakses halaman <strong>/admin/register</strong> untuk mengaktifkan akunnya dengan mengisi password dan data diri lainnya.</p>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-12">
        <div class="admin-card border-0 shadow-sm">
            <div class="admin-card-body p-0">
                {{-- Desktop Table View (>= 768px) --}}
                <div class="table-responsive d-none d-md-block">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light border-bottom">
                            <tr>
                                <th class="ps-4 py-3 text-xs text-uppercase text-muted">Admin</th>
                                <th class="py-3 text-xs text-uppercase text-muted">Email</th>
                                <th class="py-3 text-xs text-uppercase text-muted">No. HP</th>
                                <th class="py-3 text-center text-xs text-uppercase text-muted">Status Akun</th>
                                <th class="pe-4 py-3 text-end text-xs text-uppercase text-muted">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($adminList as $admin)
                            <tr>
                                <td class="ps-4 py-3">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center me-3 flex-shrink-0" style="width: 38px; height: 38px;">
                                            <span class="fw-bold">{{ strtoupper(substr($admin->name, 0, 1)) }}</span>
                                        </div>
                                        <div>
                                            <h6 class="mb-0 fw-bold text-dark text-sm">
                                                {{ $admin->name }}
                                                @if($admin->id === auth()->id())
                                                    <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-2 py-0.5 text-xs ms-1">Anda</span>
                                                @endif
                                            </h6>
                                            <span class="text-muted text-xs">Bergabung {{ $admin->created_at->format('d M Y') }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3 text-sm text-muted">{{ $admin->email }}</td>
                                <td class="py-3 text-sm text-muted">{{ $admin->no_hp ?? '-' }}</td>
                                <td class="py-3 text-center">
                                    @if(!is_null($admin->password))
                                        <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-1 text-xs">Aktif</span>
                                    @else
                                        <span class="badge bg-warning bg-opacity-10 text-warning rounded-pill px-3 py-1 text-xs">Menunggu Aktivasi</span>
                                    @endif
                                </td>
                                <td class="pe-4 py-3 text-end">
                                    @if($admin->id !== auth()->id())
                                    <div class="btn-group">
                                        @if(!is_null($admin->password))
                                        <button type="button" class="btn btn-sm btn-outline-warning" title="Reset Password" onclick="confirmReset({{ $admin->id }}, '{{ addslashes($admin->name) }}')">
                                            <i class="bi bi-arrow-counterclockwise"></i>
                                        </button>
                                        @endif
                                        <button type="button" class="btn btn-sm btn-outline-danger" title="Hapus Admin" onclick="confirmDelete({{ $admin->id }}, '{{ addslashes($admin->name) }}')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                    @else
                                        <span class="text-xs text-muted">—</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">Tidak ada data admin ditemukan.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Mobile Card List View (< 768px) --}}
                <div class="d-block d-md-none p-3">
                    @forelse($adminList as $admin)
                    <div class="p-3 mb-2 rounded-3 border bg-white shadow-xs">
                        <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-2">
                            <div class="d-flex align-items-center">
                                <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center me-2 flex-shrink-0" style="width: 32px; height: 32px;">
                                    <span class="fw-bold text-sm">{{ strtoupper(substr($admin->name, 0, 1)) }}</span>
                                </div>
                                <div>
                                    <h6 class="mb-0 fw-bold text-dark text-sm">
                                        {{ $admin->name }}
                                        @if($admin->id === auth()->id())
                                            <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-2 text-xs">Anda</span>
                                        @endif
                                    </h6>
                                </div>
                            </div>
                            @if(!is_null($admin->password))
                                <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-2 py-1 text-xs">Aktif</span>
                            @else
                                <span class="badge bg-warning bg-opacity-10 text-warning rounded-pill px-2 py-1 text-xs">Menunggu</span>
                            @endif
                        </div>
                        <div class="text-xs text-muted mb-1"><i class="bi bi-envelope me-1"></i>{{ $admin->email }}</div>
                        <div class="text-xs text-muted mb-3"><i class="bi bi-telephone me-1"></i>{{ $admin->no_hp ?? '-' }}</div>
                        @if($admin->id !== auth()->id())
                        <div class="d-flex gap-2 pt-2 border-top">
                            @if(!is_null($admin->password))
                            <button type="button" class="btn btn-sm btn-outline-warning flex-fill text-xs py-1.5" onclick="confirmReset({{ $admin->id }}, '{{ addslashes($admin->name) }}')">
                                <i class="bi bi-arrow-counterclockwise me-1"></i> Reset Password
                            </button>
                            @endif
                            <button type="button" class="btn btn-sm btn-outline-danger flex-fill text-xs py-1.5" onclick="confirmDelete({{ $admin->id }}, '{{ addslashes($admin->name) }}')">
                                <i class="bi bi-trash me-1"></i> Hapus
                            </button>
                        </div>
                        @endif
                    </div>
                    @empty
                    <div class="text-center py-4 text-muted border rounded-3 bg-light">Tidak ada data admin ditemukan.</div>
                    @endforelse
                </div>
            </div>

            {{-- Footer Pagination --}}
            <div class="admin-card-footer p-3 p-md-4 border-top">
                {{ $adminList->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>

{{-- Modal Konfirmasi Hapus --}}
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="margin: 1rem auto; width: calc(100% - 2rem); max-width: 360px;">
        <div class="modal-content shadow border-0" style="border-radius: 16px;">
            <div class="modal-body text-center p-4">
                <div class="bg-danger bg-opacity-10 text-danger rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 56px; height: 56px;">
                    <i class="bi bi-trash fs-3"></i>
                </div>
                <h5 class="fw-bold mb-2 text-dark">Hapus Admin?</h5>
                <p class="text-muted text-sm mb-1">Anda akan menghapus akun admin:</p>
                <p class="fw-bold text-dark mb-4" id="deleteAdminName">-</p>
                <div class="row g-2">
                    <div class="col-6">
                        <button type="button" class="btn btn-light w-100 fw-bold py-2 text-muted border text-sm" data-bs-dismiss="modal" style="border-radius: 8px;">Batal</button>
                    </div>
                    <div class="col-6">
                        <form id="deleteForm" action="" method="POST" style="margin:0;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger w-100 fw-bold py-2 text-sm shadow-sm" style="border-radius: 8px;">Ya, Hapus</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modal Konfirmasi Reset Password --}}
<div class="modal fade" id="resetModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="margin: 1rem auto; width: calc(100% - 2rem); max-width: 380px;">
        <div class="modal-content shadow border-0" style="border-radius: 16px;">
            <div class="modal-body text-center p-4">
                <div class="bg-warning bg-opacity-10 text-warning rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 56px; height: 56px;">
                    <i class="bi bi-arrow-counterclockwise fs-3"></i>
                </div>
                <h5 class="fw-bold mb-2 text-dark">Reset Password?</h5>
                <p class="text-muted text-sm mb-1">Password admin <strong id="resetAdminName">-</strong> akan di-reset.</p>
                <p class="text-xs text-muted mb-4">Admin tersebut perlu melakukan registrasi ulang melalui halaman <strong>/admin/register</strong> untuk mengaktifkan akunnya kembali.</p>
                <div class="row g-2">
                    <div class="col-6">
                        <button type="button" class="btn btn-light w-100 fw-bold py-2 text-muted border text-sm" data-bs-dismiss="modal" style="border-radius: 8px;">Batal</button>
                    </div>
                    <div class="col-6">
                        <form id="resetForm" action="" method="POST" style="margin:0;">
                            @csrf
                            <button type="submit" class="btn btn-warning w-100 fw-bold py-2 text-sm shadow-sm" style="border-radius: 8px;">Ya, Reset</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
    function confirmDelete(id, name) {
        document.getElementById('deleteAdminName').innerText = name;
        document.getElementById('deleteForm').action = '/admin/kelola-admin/' + id;
        var modal = new bootstrap.Modal(document.getElementById('deleteModal'));
        modal.show();
    }

    function confirmReset(id, name) {
        document.getElementById('resetAdminName').innerText = name;
        document.getElementById('resetForm').action = '/admin/kelola-admin/' + id + '/reset-password';
        var modal = new bootstrap.Modal(document.getElementById('resetModal'));
        modal.show();
    }
</script>
@endsection
@endsection
