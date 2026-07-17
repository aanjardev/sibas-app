@extends('layouts.mobile')

@section('title', 'Setor Sampah')
@section('header_title', 'Setor Sampah')
@section('header_actions')
<a href="{{ route('anggota.dashboard') }}" class="text-dark me-2">
    <i class="bi bi-arrow-left fs-4"></i>
</a>
@endsection

@section('content')
<div class="glass-card p-4 mb-4">
    <div class="text-center mb-4">
        <img src="https://cdn-icons-png.flaticon.com/512/3299/3299935.png" alt="Recycle" width="80" class="mb-3 opacity-75">
        <h5 class="fw-bold">Tukar Sampah Jadi Saldo</h5>
        <p class="text-muted text-sm">Pilih jenis sampah dan masukkan estimasi berat yang Anda bawa.</p>
    </div>

    <form action="#" method="POST">
        <div class="mb-3">
            <label class="form-label text-sm fw-semibold">Jenis Sampah</label>
            <select class="form-select-custom w-100" id="jenis_sampah">
                <option value="" selected disabled>Pilih Kategori...</option>
                <option value="3000">Botol Plastik (Rp 3.000/kg)</option>
                <option value="2500">Kardus (Rp 2.500/kg)</option>
                <option value="4000">Besi/Logam (Rp 4.000/kg)</option>
                <option value="1500">Kertas Campur (Rp 1.500/kg)</option>
            </select>
        </div>

        <div class="mb-4">
            <label class="form-label text-sm fw-semibold">Estimasi Berat (kg)</label>
            <div class="input-group">
                <input type="number" class="form-control-custom w-100 rounded" id="berat" placeholder="Contoh: 5" step="0.1" min="0.1">
            </div>
        </div>
        
        <div class="p-3 bg-light rounded-3 mb-4 border">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="text-muted text-sm">Harga Satuan</span>
                <span class="fw-medium" id="lbl_harga">Rp 0</span>
            </div>
            <hr class="my-2 border-secondary border-opacity-25">
            <div class="d-flex justify-content-between align-items-center">
                <span class="fw-bold">Estimasi Total</span>
                <h4 class="text-success fw-bold mb-0" id="lbl_total">Rp 0</h4>
            </div>
        </div>

        <button type="button" class="btn btn-primary-custom w-100 py-3 d-flex justify-content-center align-items-center" id="btnTukar">
            <i class="bi bi-qr-code-scan me-2"></i> Tampilkan QR Setor
        </button>
    </form>
</div>

<!-- Modal QR Code Simulation -->
<div class="modal fade" id="qrModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 rounded-4">
      <div class="modal-header border-0 pb-0">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center pb-5 pt-0">
        <h5 class="fw-bold mb-3">Tunjukkan ke Petugas</h5>
        <p class="text-muted text-sm mb-4">Petugas akan memverifikasi berat asli dan menyelesaikan transaksi ini.</p>
        <img src="https://upload.wikimedia.org/wikipedia/commons/d/d0/QR_code_for_mobile_English_Wikipedia.svg" alt="QR" width="200" class="mb-3">
        <div class="mt-3">
            <span class="badge bg-light text-dark border px-3 py-2 fs-6">ID: TRXS-99281</span>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const jenisSelect = document.getElementById('jenis_sampah');
        const beratInput = document.getElementById('berat');
        const lblHarga = document.getElementById('lbl_harga');
        const lblTotal = document.getElementById('lbl_total');
        const btnTukar = document.getElementById('btnTukar');
        const qrModal = new bootstrap.Modal(document.getElementById('qrModal'));

        function calculate() {
            const harga = parseInt(jenisSelect.value) || 0;
            const berat = parseFloat(beratInput.value) || 0;
            const total = harga * berat;

            lblHarga.textContent = 'Rp ' + harga.toLocaleString('id-ID');
            lblTotal.textContent = 'Rp ' + total.toLocaleString('id-ID');
        }

        jenisSelect.addEventListener('change', calculate);
        beratInput.addEventListener('input', calculate);

        btnTukar.addEventListener('click', function() {
            if(!jenisSelect.value || !beratInput.value) {
                alert('Pilih jenis sampah dan masukkan berat terlebih dahulu!');
                return;
            }
            qrModal.show();
        });
    });
</script>
@endpush
