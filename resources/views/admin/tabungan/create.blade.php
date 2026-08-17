@extends('layouts.admin')

@section('title', 'Transaksi Tabungan Baru')
@section('header_title', 'Transaksi Tabungan Baru')

@section('content')
<form action="{{ route('admin.tabungan.store') }}" method="POST" id="create-tabungan-form">
    @csrf
    <!-- Top Header Bar with Back & Save Buttons on a single row -->
    <div class="row g-3 mb-3 mb-md-4">
        <div class="col-12 d-flex align-items-center justify-content-between gap-2">
            <a href="{{ route('admin.tabungan.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
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
        <div class="col-12 col-lg-6">
            <!-- Step 1: Pilih Jenis Transaksi & Anggota -->
            <div class="admin-card border-0 shadow-sm mb-3 h-100" style="overflow: visible !important;">
                <div class="admin-card-header bg-transparent border-bottom p-3 p-md-4">
                    <h5 class="admin-card-title mb-0 fw-bold fs-5">1. Jenis Transaksi & Anggota</h5>
                </div>
                <div class="admin-card-body p-3 p-md-4" style="overflow: visible !important;">
                    <!-- Radio Choice: Setor vs Tarik -->
                    <div class="mb-4">
                        <label class="form-label fw-semibold text-sm mb-2">Pilih Jenis Transaksi <span class="text-danger">*</span></label>
                        <div class="btn-group w-100 p-1 bg-light rounded-3 border" role="group">
                            <input type="radio" class="btn-check" name="jenis_transaksi" id="jenis_setor" value="setor" checked onchange="calculateEstimasi()">
                            <label class="btn btn-sm rounded-2 fw-bold border-0 py-2.5 shadow-sm bg-success text-white" for="jenis_setor" id="label_setor">
                                <i class="bi bi-arrow-down-left me-1"></i> Setor Tunai (Nabung)
                            </label>

                            <input type="radio" class="btn-check" name="jenis_transaksi" id="jenis_tarik" value="tarik" onchange="calculateEstimasi()">
                            <label class="btn btn-sm rounded-2 fw-bold border-0 py-2.5 text-secondary opacity-75" for="jenis_tarik" id="label_tarik">
                                <i class="bi bi-arrow-up-right me-1"></i> Tarik Tunai (Penarikan)
                            </label>
                        </div>
                    </div>

                    <!-- Search Anggota -->
                    <div class="mb-3 position-relative">
                        <label for="search-anggota" class="form-label fw-semibold text-sm">Pilih Anggota Nasabah <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-search"></i></span>
                            <input type="text" class="form-control bg-white border-start-0 text-sm" id="search-anggota" placeholder="Ketik nama atau ID anggota...">
                        </div>
                        <div id="search-results" class="list-group mt-1 position-absolute w-100 shadow-sm d-none" style="max-height: 200px; overflow-y: auto; z-index: 1000;"></div>
                        
                        <input type="hidden" name="user_id" id="user_id" value="{{ old('user_id') }}" required>

                        <!-- Selected Member Card Display -->
                        <div class="mt-3 p-3 bg-success bg-opacity-10 border border-success border-opacity-25 rounded-3 d-flex justify-content-between align-items-center d-none" id="selected-member-card">
                            <div class="d-flex align-items-center">
                                <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center me-3 flex-shrink-0" style="width: 40px; height: 40px;">
                                    <span class="fw-bold" id="selected-member-initial"></span>
                                </div>
                                <div>
                                    <h6 class="mb-0 fw-bold text-success text-sm" id="selected-member-name"></h6>
                                    <span class="text-muted text-xs">Saldo Saat Ini: <b class="text-dark" id="saldo_awal_text">Rp 0</b></span>
                                </div>
                            </div>
                            <button type="button" class="btn btn-sm btn-light text-danger border" onclick="clearMemberSelection()">
                                Batal
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-6">
            <!-- Step 2: Detail Transaksi -->
            <div class="admin-card border-0 shadow-sm mb-3 h-100 d-flex flex-column">
                <div class="admin-card-header bg-transparent border-bottom p-3 p-md-4">
                    <h5 class="admin-card-title mb-0 fw-bold fs-5">2. Rincian Nominal Transaksi</h5>
                </div>
                <div class="admin-card-body p-3 p-md-4 d-flex flex-column flex-grow-1">
                    <div class="mb-3">
                        <label for="tanggal" class="form-label fw-semibold text-sm">Tanggal Transaksi <span class="text-danger">*</span></label>
                        @php
                            $today = date('Y-m-d');
                            $sevenDaysAgo = date('Y-m-d', strtotime('-7 days'));
                        @endphp
                        <input type="date" class="form-control text-sm" id="tanggal" name="tanggal" value="{{ old('tanggal', $today) }}" min="{{ $sevenDaysAgo }}" max="{{ $today }}" style="max-width: 250px;" required>
                        <small class="text-muted text-xs mt-1 d-block">Maksimal 7 hari ke belakang.</small>
                    </div>

                    <div class="mb-3">
                        <label for="nominal_display" class="form-label fw-semibold text-sm">Nominal Transaksi (Rp) <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-light text-muted text-sm">Rp</span>
                            <input type="text" class="form-control text-sm fw-bold text-dark fs-5" id="nominal_display" placeholder="0" required oninput="formatRupiah(this)">
                            <input type="hidden" id="nominal" name="nominal" value="{{ old('nominal') }}">
                        </div>
                    </div>

                    <div class="mb-4 flex-grow-1">
                        <label for="keterangan" class="form-label fw-semibold text-sm">Catatan / Keterangan (Opsional)</label>
                        <textarea class="form-control text-sm" id="keterangan" name="keterangan" rows="2" placeholder="Contoh: Setor tunai mandiri / Penarikan tunai keperluan mendesak">{{ old('keterangan') }}</textarea>
                    </div>

                    <!-- Projection Summary Card -->
                    <div class="p-3 p-md-4 rounded-3 border bg-light mt-auto" id="projection-card">
                        <div class="row align-items-center g-3">
                            <div class="col-12 col-sm-6 border-end-sm">
                                <span class="text-muted text-xs text-uppercase tracking-wider fw-semibold d-block">Saldo Awal Nasabah</span>
                                <span class="fs-5 fw-bold text-dark" id="saldo_awal_display">Rp 0</span>
                            </div>
                            <div class="col-12 col-sm-6">
                                <span class="text-muted text-xs text-uppercase tracking-wider fw-semibold d-block">Estimasi Saldo Akhir</span>
                                <span class="fs-3 fw-bold text-success" id="saldo_akhir_display">Rp 0</span>
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
    let saldoAwal = 0;

    // Load old nominal if exists
    document.addEventListener('DOMContentLoaded', function() {
        const nominalValue = document.getElementById('nominal').value;
        if (nominalValue) {
            document.getElementById('nominal_display').value = new Intl.NumberFormat('id-ID').format(nominalValue);
        }
    });

    function formatRupiah(element) {
        let value = element.value.replace(/[^0-9]/g, '');
        document.getElementById('nominal').value = value;
        
        if (value) {
            element.value = new Intl.NumberFormat('id-ID').format(value);
        } else {
            element.value = '';
        }
        
        calculateEstimasi();
    }

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
                            btn.innerHTML = `<div class="fw-bold">${user.name}</div><div class="text-muted text-xs">ID: ${user.nomor_anggota} | Saldo: Rp ${new Intl.NumberFormat('id-ID').format(user.saldo_tabungan)}</div>`;
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
        saldoAwal = parseFloat(user.saldo_tabungan) || 0;

        document.getElementById('selected-member-initial').innerText = user.name.charAt(0).toUpperCase();
        document.getElementById('selected-member-name').innerText = user.name;
        document.getElementById('saldo_awal_text').innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(saldoAwal);
        document.getElementById('saldo_awal_display').innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(saldoAwal);
        
        searchInput.value = '';
        searchInput.closest('.input-group').classList.add('d-none');
        searchResults.classList.add('d-none');
        selectedMemberCard.classList.remove('d-none');
        
        calculateEstimasi();
    }

    function clearMemberSelection() {
        userIdInput.value = '';
        saldoAwal = 0;
        document.getElementById('saldo_awal_display').innerText = 'Rp 0';
        
        searchInput.closest('.input-group').classList.remove('d-none');
        selectedMemberCard.classList.add('d-none');
        
        calculateEstimasi();
    }

    function calculateEstimasi() {
        const isSetor = document.getElementById('jenis_setor').checked;
        const nominal = parseFloat(document.getElementById('nominal').value) || 0;
        const labelSetor = document.getElementById('label_setor');
        const labelTarik = document.getElementById('label_tarik');
        let saldoAkhir = 0;

        if (isSetor) {
            labelSetor.className = 'btn btn-sm rounded-2 fw-bold border-0 py-2.5 shadow-sm bg-success text-white';
            labelTarik.className = 'btn btn-sm rounded-2 fw-bold border-0 py-2.5 text-secondary opacity-75';
            saldoAkhir = saldoAwal + nominal;
            document.getElementById('saldo_akhir_display').className = 'fs-3 fw-bold text-success';
        } else {
            labelTarik.className = 'btn btn-sm rounded-2 fw-bold border-0 py-2.5 shadow-sm bg-danger text-white';
            labelSetor.className = 'btn btn-sm rounded-2 fw-bold border-0 py-2.5 text-secondary opacity-75';
            saldoAkhir = saldoAwal - nominal;
            if (saldoAkhir < 0) {
                document.getElementById('saldo_akhir_display').className = 'fs-3 fw-bold text-danger';
            } else {
                document.getElementById('saldo_akhir_display').className = 'fs-3 fw-bold text-primary';
            }
        }

        document.getElementById('saldo_akhir_display').innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(saldoAkhir);
        
        checkFormValidity(isSetor, nominal, saldoAkhir);
    }

    function checkFormValidity(isSetor, nominal, saldoAkhir) {
        const hasUser = userIdInput.value !== '';
        const hasNominal = nominal > 0;
        
        if (!isSetor && saldoAkhir < 0) {
            submitBtn.disabled = true; // Cannot tarik more than balance
        } else {
            submitBtn.disabled = !(hasUser && hasNominal);
        }
    }
</script>
@endsection
@endsection
