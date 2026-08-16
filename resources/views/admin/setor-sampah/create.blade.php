@extends('layouts.admin')

@section('title', 'Input Setor Sampah')
@section('header_title', 'Input Setor Sampah Baru')

@section('content')
<form action="{{ route('admin.setor-sampah.store') }}" method="POST" id="create-setor-form">
    @csrf
    <!-- Top Header Bar with Back & Save Buttons on a single row -->
    <div class="row g-3 mb-3 mb-md-4">
        <div class="col-12 d-flex align-items-center justify-content-between gap-2">
            <a href="{{ route('admin.setor-sampah.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
            <button type="submit" class="btn btn-primary btn-sm text-white px-3 shadow-sm" id="submit-btn" disabled>
                <i class="bi bi-check-lg me-1"></i> Simpan Transaksi
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
        <div class="col-12 col-lg-9 mx-auto">
            <!-- Step 1: Cari Anggota -->
            <div class="admin-card border-0 shadow-sm mb-3">
                <div class="admin-card-header bg-transparent border-bottom p-3 p-md-4">
                    <h5 class="admin-card-title mb-0 fw-bold fs-5">1. Pilih Anggota Penyetor</h5>
                </div>
                <div class="admin-card-body p-3 p-md-4">
                    <label for="search-anggota" class="form-label fw-semibold text-sm">Pencarian Nama / ID Anggota <span class="text-danger">*</span></label>
                    <div class="d-flex flex-column flex-sm-row align-items-stretch align-items-sm-center gap-2">
                        <div class="input-group flex-grow-1">
                            <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-search"></i></span>
                            <input type="text" class="form-control bg-white border-start-0 text-sm" id="search-anggota" placeholder="Ketik nama atau ID anggota...">
                        </div>
                        <a href="{{ route('admin.anggota.create') }}" class="btn btn-outline-success text-nowrap text-sm py-2">
                            <i class="bi bi-person-plus me-1"></i> Tambah Anggota Baru
                        </a>
                    </div>
                    <div id="search-results" class="list-group mt-1 position-absolute w-100 shadow-sm d-none" style="max-height: 200px; overflow-y: auto; z-index: 1000;"></div>
                    
                    <input type="hidden" name="user_id" id="user_id" value="{{ old('user_id') }}" required>

                    <!-- Selected Member Info Card -->
                    <div class="mt-3 p-3 bg-success bg-opacity-10 border border-success border-opacity-25 rounded-3 d-flex justify-content-between align-items-center d-none" id="selected-member-card">
                        <div class="d-flex align-items-center">
                            <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center me-3 flex-shrink-0" style="width: 40px; height: 40px;">
                                <span class="fw-bold" id="selected-member-initial"></span>
                            </div>
                            <div>
                                <h6 class="mb-0 fw-bold text-success text-sm" id="selected-member-name"></h6>
                                <span class="text-success text-xs opacity-75" id="selected-member-detail"></span>
                            </div>
                        </div>
                        <button type="button" class="btn btn-sm btn-light text-danger border" onclick="clearMemberSelection()">
                            Batal
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Step 2: Detail Setoran Sampah -->
            <div class="admin-card border-0 shadow-sm mb-3">
                <div class="admin-card-header bg-transparent border-bottom p-3 p-md-4 d-flex align-items-center justify-content-between">
                    <h5 class="admin-card-title mb-0 fw-bold fs-5">2. Detail Rincian Setoran Sampah</h5>
                </div>
                <div class="admin-card-body p-3 p-md-4">
                    <div class="mb-3">
                        <label for="tanggal" class="form-label fw-semibold text-sm">Tanggal Setor <span class="text-danger">*</span></label>
                        <input type="date" class="form-control text-sm" id="tanggal" name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" style="max-width: 250px;" required>
                    </div>

                    <!-- Single Item Form (Backend currently only handles 1 item) -->
                    <div class="text-xs fw-bold text-uppercase text-muted tracking-wider mb-2">Item Sampah Diterima</div>
                    <div class="item-row p-3 border rounded-3 bg-light position-relative mb-4">
                        <div class="row g-2 align-items-center">
                            <div class="col-12 col-md-6">
                                <label class="form-label text-xs fw-semibold text-muted mb-1">Kategori Sampah</label>
                                <select class="form-select text-sm kategori-select" name="kategori_sampah_id" required onchange="calculateGrandTotal()">
                                    <option value="" selected disabled>Pilih Kategori...</option>
                                    @foreach($kategoriList as $kat)
                                        <option value="{{ $kat->id }}" data-harga="{{ $kat->harga_beli }}" {{ old('kategori_sampah_id') == $kat->id ? 'selected' : '' }}>
                                            {{ $kat->nama }} (Rp {{ number_format($kat->harga_beli, 0, ',', '.') }} / kg)
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12 col-md-3">
                                <label class="form-label text-xs fw-semibold text-muted mb-1">Berat (kg)</label>
                                <div class="input-group">
                                    <input type="number" step="0.1" min="0.1" class="form-control text-sm berat-input" name="berat" value="{{ old('berat') }}" placeholder="0.0" required oninput="calculateGrandTotal()">
                                    <span class="input-group-text bg-white text-muted text-xs">kg</span>
                                </div>
                            </div>
                            <div class="col-12 col-md-3">
                                <label class="form-label text-xs fw-semibold text-muted mb-1">Subtotal (Rp)</label>
                                <div class="fw-bold text-success text-sm py-2 px-2 bg-white rounded border subtotal-text">Rp 0</div>
                            </div>
                        </div>
                    </div>

                    <!-- Grand Total Summary Card -->
                    <div class="p-3 p-md-4 bg-success bg-opacity-10 border border-success border-opacity-25 rounded-3">
                        <div class="row align-items-center g-3">
                            <div class="col-12 col-sm-6 border-end-sm">
                                <span class="text-muted text-xs text-uppercase tracking-wider fw-semibold d-block">Total Berat Keseluruhan</span>
                                <span class="fs-4 fw-bold text-dark" id="total_berat_display">0.0 kg</span>
                            </div>
                            <div class="col-12 col-sm-6">
                                <span class="text-muted text-xs text-uppercase tracking-wider fw-semibold d-block">Grand Total Pendapatan</span>
                                <div class="d-flex align-items-center">
                                    <span class="fs-4 fw-bold text-success me-1">Rp</span>
                                    <span class="fs-2 fw-bold text-success" id="grand_total_display">0</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

@section('scripts')
<script>
    // Member search logic via AJAX
    const searchInput = document.getElementById('search-anggota');
    const searchResults = document.getElementById('search-results');
    const selectedMemberCard = document.getElementById('selected-member-card');
    const userIdInput = document.getElementById('user_id');
    const submitBtn = document.getElementById('submit-btn');

    let debounceTimer;

    searchInput.addEventListener('input', function() {
        clearTimeout(debounceTimer);
        const query = this.value;

        if (query.length < 2) {
            searchResults.classList.add('d-none');
            return;
        }

        debounceTimer = setTimeout(() => {
            fetch(`{{ route('admin.api.search-anggota') }}?q=${encodeURIComponent(query)}`)
                .then(response => response.json())
                .then(data => {
                    searchResults.innerHTML = '';
                    if (data.length > 0) {
                        data.forEach(user => {
                            const btn = document.createElement('button');
                            btn.type = 'button';
                            btn.className = 'list-group-item list-group-item-action py-2 text-sm';
                            btn.innerHTML = `<div class="fw-bold">${user.name}</div><div class="text-muted text-xs">ID: ${user.nomor_anggota} | HP: ${user.no_hp}</div>`;
                            btn.onclick = () => selectMember(user);
                            searchResults.appendChild(btn);
                        });
                        searchResults.classList.remove('d-none');
                    } else {
                        searchResults.innerHTML = '<div class="list-group-item text-muted text-sm py-2">Tidak ditemukan anggota.</div>';
                        searchResults.classList.remove('d-none');
                    }
                });
        }, 300);
    });

    document.addEventListener('click', function(e) {
        if (!searchResults.contains(e.target) && e.target !== searchInput) {
            searchResults.classList.add('d-none');
        }
    });

    function selectMember(user) {
        userIdInput.value = user.id;
        document.getElementById('selected-member-initial').innerText = user.name.charAt(0).toUpperCase();
        document.getElementById('selected-member-name').innerText = user.name;
        document.getElementById('selected-member-detail').innerText = `ID: ${user.nomor_anggota} | ${user.no_hp}`;
        
        searchInput.value = '';
        searchInput.closest('.input-group').classList.add('d-none');
        searchResults.classList.add('d-none');
        selectedMemberCard.classList.remove('d-none');
        
        checkFormValidity();
    }

    function clearMemberSelection() {
        userIdInput.value = '';
        searchInput.closest('.input-group').classList.remove('d-none');
        selectedMemberCard.classList.add('d-none');
        checkFormValidity();
    }

    function calculateGrandTotal() {
        const select = document.querySelector('.kategori-select');
        const selectedOption = select.options[select.selectedIndex];
        const harga = parseFloat(selectedOption.getAttribute('data-harga')) || 0;
        const berat = parseFloat(document.querySelector('.berat-input').value) || 0;
        const subtotal = harga * berat;

        document.querySelector('.subtotal-text').innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(subtotal);
        document.getElementById('total_berat_display').innerText = berat.toFixed(1) + ' kg';
        document.getElementById('grand_total_display').innerText = new Intl.NumberFormat('id-ID').format(subtotal);

        checkFormValidity();
    }

    function checkFormValidity() {
        const hasUser = userIdInput.value !== '';
        const hasKategori = document.querySelector('.kategori-select').value !== '';
        const hasBerat = document.querySelector('.berat-input').value > 0;

        submitBtn.disabled = !(hasUser && hasKategori && hasBerat);
    }

    // Call on load if old values exist
    if (document.querySelector('.kategori-select').value !== '') {
        calculateGrandTotal();
    }
</script>
@endsection
@endsection
