@extends('layouts.admin')

@section('title', 'Kelola Jenis & Harga Sampah')
@section('header_title', 'Jenis & Harga Sampah')

@section('content')
<!-- Header Bar & Action -->
<div class="row g-3 mb-3 mb-md-4 align-items-center">
    <div class="col-12 col-md-6 d-flex align-items-center justify-content-between justify-content-md-start">
        <a href="{{ route('admin.kategori-sampah.create') }}" class="btn btn-primary text-white shadow-sm w-100 w-md-auto d-flex align-items-center justify-content-center py-2 px-3">
            <i class="bi bi-plus-circle me-2 fs-6"></i> Tambah Jenis Sampah Baru
        </a>
    </div>
    
    <!-- Search Bar -->
    <div class="col-12 col-md-6">
        <form action="{{ route('admin.kategori-sampah.index') }}" method="GET">
            <div class="input-group">
                <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-search"></i></span>
                <input type="text" name="search" value="{{ request('search') }}" class="form-control bg-white border-start-0 text-sm" placeholder="Cari nama jenis sampah...">
                <button class="btn btn-primary" type="submit">Cari</button>
            </div>
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

<div class="row g-3">
    <div class="col-12">
        <div class="admin-card border-0 shadow-sm">
            <div class="admin-card-body p-0">
                <!-- Desktop Table View (>= 768px) -->
                <div class="table-responsive d-none d-md-block">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light border-bottom">
                            <tr>
                                <th class="ps-4 py-3 text-xs text-uppercase text-muted">Kode</th>
                                <th class="py-3 text-xs text-uppercase text-muted">Jenis / Kategori Sampah</th>
                                <th class="py-3 text-xs text-uppercase text-muted">Satuan</th>
                                <th class="py-3 text-end text-xs text-uppercase text-muted">Harga per Kg</th>
                                <th class="py-3 text-center text-xs text-uppercase text-muted">Status</th>
                                <th class="pe-4 py-3 text-end text-xs text-uppercase text-muted">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($kategoriList as $kategori)
                            <tr>
                                <td class="ps-4 py-3"><span class="badge bg-light text-dark border fw-medium">SMP-{{ str_pad($kategori->id, 3, '0', STR_PAD_LEFT) }}</span></td>
                                <td class="py-3">
                                    <div class="fw-bold text-dark text-sm">{{ $kategori->nama }}</div>
                                    <div class="text-xs text-muted">{{ $kategori->deskripsi ?? '-' }}</div>
                                </td>
                                <td class="py-3 text-muted text-sm">Kilogram (kg)</td>
                                <td class="py-3 text-end fw-bold text-success text-sm">Rp {{ number_format($kategori->harga_beli, 0, ',', '.') }} / kg</td>
                                <td class="py-3 text-center">
                                    @if($kategori->is_active)
                                        <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-1">Aktif</span>
                                    @else
                                        <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-3 py-1">Nonaktif</span>
                                    @endif
                                </td>
                                <td class="pe-4 py-3 text-end">
                                    <div class="btn-group">
                                        <a href="{{ route('admin.kategori-sampah.edit', $kategori->id) }}" class="btn btn-sm btn-outline-primary" title="Edit Data">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-outline-danger" title="Hapus Jenis Sampah" onclick="confirmDelete({{ $kategori->id }})">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">Data jenis sampah tidak ditemukan.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Mobile Card List View (< 768px) -->
                <div class="d-block d-md-none p-3">
                    @forelse($kategoriList as $kategori)
                    <div class="p-3 mb-2 rounded-3 border bg-white shadow-xs">
                        <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-2">
                            <span class="badge bg-light text-dark border">SMP-{{ str_pad($kategori->id, 3, '0', STR_PAD_LEFT) }}</span>
                            @if($kategori->is_active)
                                <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-2 py-1 text-xs">Aktif</span>
                            @else
                                <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-2 py-1 text-xs">Nonaktif</span>
                            @endif
                        </div>
                        <div class="mb-2">
                            <h6 class="mb-0 fw-bold text-dark text-sm">{{ $kategori->nama }}</h6>
                            <p class="text-xs text-muted mb-0">{{ Str::limit($kategori->deskripsi, 50) }}</p>
                        </div>
                        <div class="d-flex justify-content-between align-items-center pt-2 border-top mb-3">
                            <span class="text-muted text-xs">Harga per Kg</span>
                            <span class="fw-bold text-success text-base">Rp {{ number_format($kategori->harga_beli, 0, ',', '.') }} / kg</span>
                        </div>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.kategori-sampah.edit', $kategori->id) }}" class="btn btn-sm btn-outline-primary flex-fill text-xs py-1.5"><i class="bi bi-pencil me-1"></i> Edit</a>
                            <button type="button" class="btn btn-sm btn-outline-danger flex-fill text-xs py-1.5" onclick="confirmDelete({{ $kategori->id }})"><i class="bi bi-trash me-1"></i> Hapus</button>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-4 text-muted border rounded-3 bg-light">Data jenis sampah tidak ditemukan.</div>
                    @endforelse
                </div>
            </div>

            <!-- Footer Pagination -->
            <div class="admin-card-footer p-3 p-md-4 border-top">
                {{ $kategoriList->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>

<!-- Modal Konfirmasi Hapus Jenis Sampah -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="margin: 1rem auto; width: calc(100% - 2rem); max-width: 360px;">
        <div class="modal-content shadow border-0" style="border-radius: 16px;">
            <div class="modal-body text-center p-4">
                <div class="bg-danger bg-opacity-10 text-danger rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 56px; height: 56px;">
                    <i class="bi bi-trash fs-3"></i>
                </div>
                <h5 class="fw-bold mb-2 text-dark">Hapus Jenis Sampah?</h5>
                <p class="text-muted text-xs mb-4">Master data jenis dan harga sampah ini akan terhapus dari sistem.</p>
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

<style>
.pagination .page-link {
    color: var(--primary);
}
.pagination .page-item.active .page-link {
    background-color: var(--primary);
    border-color: var(--primary);
    color: white;
}
.pagination .page-link:hover {
    color: var(--primary-dark);
    background-color: #e9ecef;
}
</style>

@section('scripts')
<script>
    function confirmDelete(id) {
        var form = document.getElementById('deleteForm');
        form.action = '/admin/kategori-sampah/' + id;
        var modal = new bootstrap.Modal(document.getElementById('deleteModal'));
        modal.show();
    }
</script>
@endsection
@endsection
