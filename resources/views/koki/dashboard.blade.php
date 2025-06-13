@extends('layouts.app')

@section('title', 'Dashboard Koki')

@section('content')
<div class="container">
    <div class="row mb-3">
        <div class="col">
            <h1 class="h3 mb-0">Validasi Makanan Karyawan</h1>
            <p class="text-muted">Arahkan QR Code scanner pada kolom di bawah ini.</p>
        </div>
    </div>

    <div class="row g-4">
        {{-- KOLOM UTAMA UNTUK SCANNER --}}
        <div class="col-lg-7">
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <form id="scan-form">
                        @csrf
                        <div class="mb-3">
                            <label for="qr_token" class="form-label fs-5">Scan QR Code Di Sini:</label>
                            <input type="text" class="form-control form-control-lg" id="qr_token" name="qr_token" autofocus autocomplete="off">
                        </div>
                    </form>

                    <hr>

                    {{-- Area untuk menampilkan hasil scan --}}
                    <h5 class="mb-3">Hasil Scan Terakhir:</h5>
                    <div id="scan-result" class="alert alert-secondary" role="alert" style="min-height: 120px;">
                        <div id="result-content" class="text-center p-3">
                             Menunggu scan...
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- KOLOM UNTUK INFORMASI & MONITORING --}}
        <div class="col-lg-5">
            <div class="card shadow-sm mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Informasi Shift Aktif</h5>
                </div>
                <div class="card-body">
                    @if($shiftAktif)
                        <h3 class="text-center">{{ $shiftAktif->nama_shift }}</h3>
                        <p class="text-center text-muted mb-0">
                            ({{ $shiftAktif->jam_mulai }} - {{ $shiftAktif->jam_selesai }})
                        </p>
                    @else
                        <p class="text-center text-danger mb-0">Tidak ada shift yang aktif saat ini.</p>
                    @endif
                </div>
            </div>

            <div class="card shadow-sm">
                 <div class="card-header">
                    <h5 class="mb-0">Statistik Porsi</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Total Porsi Dipesan
                            <span id="total-dipesan" class="badge bg-primary rounded-pill fs-6">{{ $totalDipesan }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Sudah Diambil
                            <span id="total-diambil" class="badge bg-success rounded-pill fs-6">{{ $totalDiambil }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center fw-bold">
                            Sisa Porsi
                            <span id="sisa-porsi" class="badge bg-dark rounded-pill fs-6">{{ $totalDipesan - $totalDiambil }}</span>
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="card shadow-sm mt-4">
                <div class="card-header">
                    <h5 class="mb-0">Karyawan Belum Mengambil</h5>
                </div>
                <div id="sisa-karyawan-list" class="list-group list-group-flush" style="max-height: 300px; overflow-y: auto;">
                    @forelse ($sisaKaryawan as $karyawan)
                        <a href="#" class="list-group-item list-group-item-action" data-karyawan-id="{{ $karyawan->id }}">
                            {{ $karyawan->nama_lengkap }} ({{ $karyawan->divisi->nama_divisi ?? 'N/A' }})
                        </a>
                    @empty
                        <div class="list-group-item text-center text-muted">
                            Semua karyawan telah mengambil makanan.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const scanForm = document.getElementById('scan-form');
    const qrInput = document.getElementById('qr_token');
    const scanResultDiv = document.getElementById('scan-result');
    const resultContent = document.getElementById('result-content');
    
    // Elemen statistik
    const totalDiambilEl = document.getElementById('total-diambil');
    const sisaPorsiEl = document.getElementById('sisa-porsi');
    const sisaKaryawanList = document.getElementById('sisa-karyawan-list');

    scanForm.addEventListener('submit', function (e) {
        e.preventDefault(); // Mencegah form submit dan reload halaman

        const qrToken = qrInput.value;
        if (qrToken.trim() === '') return;

        // Tampilkan status loading
        resultContent.innerHTML = `
            <div class="d-flex justify-content-center align-items-center">
                <div class="spinner-border spinner-border-sm me-2" role="status"></div>
                <span>Memvalidasi...</span>
            </div>
        `;
        scanResultDiv.className = 'alert alert-info';

        fetch("{{ route('koki.scan') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            },
            body: JSON.stringify({ qr_token: qrToken })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Jika validasi berhasil
                scanResultDiv.className = 'alert alert-success';
                resultContent.innerHTML = `
                    <div class="text-center">
                        <i class="bi bi-check-circle-fill fs-1 text-success"></i>
                        <h4 class="mt-2">VALID</h4>
                        <p class="fs-5 mb-0">${data.karyawan.nama}</p>
                        <p class="text-muted">${data.karyawan.divisi}</p>
                    </div>
                `;
                updateStatistik();
            } else {
                // Jika validasi gagal
                showError(data.message || 'Terjadi kesalahan.');
            }
        })
        .catch(error => {
            showError('Tidak dapat terhubung ke server.');
            console.error('Error:', error);
        })
        .finally(() => {
            // Kosongkan dan fokus kembali ke input untuk scan berikutnya
            qrInput.value = '';
            qrInput.focus();
        });
    });

    function showError(message) {
        scanResultDiv.className = 'alert alert-danger';
        resultContent.innerHTML = `
            <div class="text-center">
                <i class="bi bi-x-octagon-fill fs-1 text-danger"></i>
                <h4 class="mt-2">TIDAK VALID</h4>
                <p class="fs-5 mb-0">${message}</p>
            </div>
        `;
    }

    // Fungsi untuk update statistik (contoh sederhana)
    // Untuk aplikasi production, sebaiknya data diambil ulang dari server
    // agar sinkron, namun untuk demo ini kita update di client-side.
    function updateStatistik() {
        let currentDiambil = parseInt(totalDiambilEl.textContent);
        let currentSisa = parseInt(sisaPorsiEl.textContent);
        
        totalDiambilEl.textContent = currentDiambil + 1;
        sisaPorsiEl.textContent = currentSisa - 1;
        
        // Hapus nama karyawan dari daftar sisa (implementasi sederhana)
        // Di aplikasi nyata, Anda perlu ID karyawan untuk menghapus yang benar
    }
});
</script>
@endpush