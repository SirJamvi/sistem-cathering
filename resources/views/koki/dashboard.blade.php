@extends('layouts.app')

@section('title', 'Dashboard Koki')

@push('styles')
<style>
    #qr-reader {
        width: 100%;
        max-width: 500px;
        border: 2px solid #dee2e6;
        border-radius: 8px;
        overflow: hidden;
    }
    
    .debug-panel {
        background: #f8f9fa;
        border: 1px solid #dee2e6;
        border-radius: 5px;
        padding: 10px;
        margin-bottom: 15px;
        font-family: monospace;
        font-size: 0.85em;
    }
    
    .debug-panel.error {
        background: #fff5f5;
        border-color: #fed7d7;
        color: #c53030;
    }
    
    .debug-panel.success {
        background: #f0fff4;
        border-color: #9ae6b4;
        color: #2f855a;
    }
</style>
@endpush

@section('content')
<div class="container">
    <div class="row mb-3">
        <div class="col">
            <h1 class="h3 mb-0">Validasi Makanan Karyawan</h1>
            <p class="text-muted">Arahkan kamera pada QR Code karyawan.</p>
        </div>
        <div class="col-auto">
            <button id="toggle-debug" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-bug"></i> Debug Mode
            </button>
        </div>
    </div>

    {{-- Debug Panel --}}
    <div id="debug-panel" class="debug-panel" style="display: none;">
        <strong>Debug Information:</strong>
        <div id="debug-content">Menunggu scan...</div>
    </div>

    <div class="row g-4">
        {{-- KOLOM UTAMA UNTUK SCANNER --}}
        <div class="col-lg-7">
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    {{-- Status Kamera --}}
                    <div id="camera-status" class="alert alert-info mb-3">
                        <i class="bi bi-camera-video"></i> Memuat kamera...
                    </div>

                    {{-- Area Scanner --}}
                    <div id="qr-reader" class="mx-auto mb-3"></div>
                    <div id="qr-reader-results" class="text-center"></div>

                    {{-- Form tersembunyi --}}
                    <form id="scan-form" class="d-none">
                        @csrf
                        <input type="text" class="form-control" id="qr_token" name="qr_token" autocomplete="off">
                        <button type="button" id="manual-scan" class="btn btn-secondary mt-2">Test Manual Scan</button>
                    </form>

                    {{-- Manual Input untuk Testing --}}
                    <div id="manual-input" class="mt-3" style="display: none;">
                        <hr>
                        <h6>Manual Input (untuk testing):</h6>
                        <div class="input-group">
                            <input type="text" id="manual-token" class="form-control" placeholder="Masukkan QR Token...">
                            <button class="btn btn-outline-primary" id="btn-manual-test">Test</button>
                        </div>
                    </div>

                    <hr>

                    <h5 class="mb-3">Hasil Scan Terakhir:</h5>
                    <div id="scan-result" class="alert alert-secondary" role="alert" style="min-height: 120px;">
                        <div id="result-content" class="text-center p-3">Menunggu scan...</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- KOLOM UNTUK INFORMASI & MONITORING --}}
        <div class="col-lg-5">
            <div class="card shadow-sm mb-4">
                <div class="card-header"><h5 class="mb-0">Informasi Shift Aktif</h5></div>
                <div class="card-body">
                    @if($shiftAktif)
                        <h3 class="text-center">{{ $shiftAktif->nama_shift }}</h3>
                        <p class="text-center text-muted mb-0">({{ $shiftAktif->jam_mulai }} - {{ $shiftAktif->jam_selesai }})</p>
                    @else
                        <p class="text-center text-danger mb-0">Tidak ada shift yang aktif saat ini.</p>
                    @endif
                </div>
            </div>
            
            <div class="card shadow-sm">
                <div class="card-header"><h5 class="mb-0">Statistik Porsi</h5></div>
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
                <div class="card-header"><h5 class="mb-0">Karyawan Belum Mengambil</h5></div>
                <div id="sisa-karyawan-list" class="list-group list-group-flush" style="max-height: 300px; overflow-y: auto;">
                    @forelse ($sisaKaryawan as $karyawan)
                        <a href="#" class="list-group-item list-group-item-action" data-karyawan-id="{{ $karyawan->id }}">
                            {{ $karyawan->nama_lengkap }} ({{ $karyawan->divisi->nama_divisi ?? 'N/A' }})
                        </a>
                    @empty
                        <div id="sisa-karyawan-empty" class="list-group-item text-center text-muted">
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
<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // DOM Elements
    const qrInput = document.getElementById('qr_token');
    const scanResultDiv = document.getElementById('scan-result');
    const resultContent = document.getElementById('result-content');
    const totalDiambilEl = document.getElementById('total-diambil');
    const sisaPorsiEl = document.getElementById('sisa-porsi');
    const sisaKaryawanList = document.getElementById('sisa-karyawan-list');
    const debugPanel = document.getElementById('debug-panel');
    const debugContent = document.getElementById('debug-content');
    const cameraStatus = document.getElementById('camera-status');
    const toggleDebugBtn = document.getElementById('toggle-debug');
    const manualInput = document.getElementById('manual-input');
    const manualToken = document.getElementById('manual-token');
    const btnManualTest = document.getElementById('btn-manual-test');

    // Debug variables
    let debugMode = false;
    let lastScannedToken = null;
    let lastScanTime = 0;
    let html5QrcodeScanner = null;

    // Debug functions
    function debugLog(message, data = null) {
        const timestamp = new Date().toLocaleTimeString();
        console.log(`[${timestamp}] DEBUG:`, message, data);
        
        if (debugMode) {
            const logEntry = `[${timestamp}] ${message}`;
            debugContent.innerHTML += logEntry + (data ? `<br>Data: ${JSON.stringify(data, null, 2)}` : '') + '<br>';
            debugContent.scrollTop = debugContent.scrollHeight;
        }
    }

    function showDebugError(message, error = null) {
        debugLog(`ERROR: ${message}`, error);
        if (debugMode) {
            debugPanel.className = 'debug-panel error';
        }
    }

    function showDebugSuccess(message, data = null) {
        debugLog(`SUCCESS: ${message}`, data);
        if (debugMode) {
            debugPanel.className = 'debug-panel success';
        }
    }

    // Toggle debug mode
    toggleDebugBtn.addEventListener('click', function() {
        debugMode = !debugMode;
        debugPanel.style.display = debugMode ? 'block' : 'none';
        manualInput.style.display = debugMode ? 'block' : 'none';
        
        if (debugMode) {
            debugContent.innerHTML = 'Debug mode aktif...<br>';
            debugLog('Debug mode diaktifkan');
        }
    });

    // Manual test button
    btnManualTest.addEventListener('click', function() {
        const token = manualToken.value.trim();
        if (token) {
            debugLog('Manual test dimulai', { token: token });
            sendToken(token);
        } else {
            showDebugError('Token kosong untuk manual test');
        }
    });

    // Fungsi untuk mengirim token ke backend
    function sendToken(qrToken) {
        debugLog('sendToken dipanggil', { qrToken: qrToken });
        
        // Mencegah scan ganda dalam 3 detik
        const now = Date.now();
        if (qrToken === lastScannedToken && (now - lastScanTime) < 3000) {
            debugLog('Scan diabaikan - terlalu cepat', { 
                lastToken: lastScannedToken, 
                timeDiff: now - lastScanTime 
            });
            return;
        }
        
        lastScannedToken = qrToken;
        lastScanTime = now;

        debugLog('Memulai request ke server', { 
            url: "{{ route('koki.scan') }}",
            token: qrToken 
        });

        // Update UI - loading state
        resultContent.innerHTML = `
            <div class="d-flex justify-content-center align-items-center">
                <div class="spinner-border spinner-border-sm me-2" role="status"></div>
                <span>Memvalidasi...</span>
            </div>`;
        scanResultDiv.className = 'alert alert-info';

        // Prepare request data
        const requestData = { qr_token: qrToken };
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        
        if (!csrfToken) {
            showDebugError('CSRF token tidak ditemukan');
            showError('Error: CSRF token tidak ditemukan.');
            return;
        }

        debugLog('Request headers dan data siap', {
            csrfToken: csrfToken,
            requestData: requestData
        });

        fetch("{{ route('koki.scan') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify(requestData)
        })
        .then(response => {
            debugLog('Response diterima', { 
                status: response.status, 
                statusText: response.statusText,
                headers: Object.fromEntries(response.headers.entries())
            });
            
            return response.json().then(data => ({
                status: response.status,
                data: data
            }));
        })
        .then(({status, data}) => {
            debugLog('Response JSON parsed', { status: status, data: data });
            
            if (data.success) {
                showDebugSuccess('Scan berhasil', data);
                scanResultDiv.className = 'alert alert-success';
                resultContent.innerHTML = `
                    <div class="text-center">
                        <i class="bi bi-check-circle-fill fs-1 text-success"></i>
                        <h4 class="mt-2">VALID</h4>
                        <p class="fs-5 mb-0">${data.karyawan.nama}</p>
                        <p class="text-muted">${data.karyawan.divisi}</p>
                    </div>`;
                updateStatistik(data.karyawan.id);
            } else {
                showDebugError('Scan tidak berhasil', data);
                showError(data.message || 'Terjadi kesalahan tidak diketahui.');
            }
        })
        .catch(error => {
            showDebugError('Network atau parsing error', {
                error: error.message,
                stack: error.stack
            });
            showError('Tidak dapat terhubung ke server. Periksa koneksi internet.');
        });
    }

    // Fungsi untuk menampilkan error
    function showError(message) {
        debugLog('Menampilkan error', { message: message });
        scanResultDiv.className = 'alert alert-danger';
        resultContent.innerHTML = `
            <div class="text-center">
                <i class="bi bi-x-octagon-fill fs-1 text-danger"></i>
                <h4 class="mt-2">TIDAK VALID</h4>
                <p class="fs-5 mb-0">${message}</p>
            </div>`;
    }

    // Fungsi untuk update statistik
    function updateStatistik(karyawanId) {
        debugLog('Update statistik', { karyawanId: karyawanId });
        
        const currentDiambil = parseInt(totalDiambilEl.textContent);
        const currentSisa = parseInt(sisaPorsiEl.textContent);
        
        totalDiambilEl.textContent = currentDiambil + 1;
        sisaPorsiEl.textContent = currentSisa - 1;
        
        // Remove karyawan dari list
        const karyawanItem = sisaKaryawanList.querySelector(`[data-karyawan-id="${karyawanId}"]`);
        if (karyawanItem) {
            debugLog('Menghapus karyawan dari list', { karyawanId: karyawanId });
            karyawanItem.remove();
        }
        
        // Check if list is empty
        if (sisaKaryawanList.children.length === 0 && !document.getElementById('sisa-karyawan-empty')) {
            debugLog('List karyawan kosong, menampilkan pesan empty');
            sisaKaryawanList.innerHTML = '<div id="sisa-karyawan-empty" class="list-group-item text-center text-muted">Semua karyawan telah mengambil makanan.</div>';
        }
    }

    // Scanner camera functions
    function onScanSuccess(decodedText, decodedResult) {
        debugLog('QR Code berhasil di-scan', { 
            decodedText: decodedText, 
            decodedResult: decodedResult 
        });
        
        qrInput.value = decodedText;
        sendToken(decodedText);
    }

    function onScanFailure(error) {
        // Jangan log error scan failure karena terlalu banyak
        // debugLog('Scan failure (normal)', { error: error });
    }

    // Initialize camera scanner
    function initializeScanner() {
        debugLog('Inisialisasi scanner');
        
        try {
            html5QrcodeScanner = new Html5QrcodeScanner(
                "qr-reader",
                { 
                    fps: 10, 
                    qrbox: {width: 250, height: 250},
                    aspectRatio: 1.0,
                    disableFlip: false
                },
                false // verbose
            );
            
            debugLog('Scanner object dibuat');
            
            html5QrcodeScanner.render(onScanSuccess, onScanFailure)
                .then(() => {
                    debugLog('Scanner berhasil dirender');
                    cameraStatus.innerHTML = '<i class="bi bi-camera-video-fill text-success"></i> Kamera aktif - Arahkan ke QR Code';
                    cameraStatus.className = 'alert alert-success mb-3';
                })
                .catch(err => {
                    showDebugError('Error saat render scanner', err);
                    cameraStatus.innerHTML = '<i class="bi bi-camera-video-off text-danger"></i> Gagal mengaktifkan kamera: ' + err;
                    cameraStatus.className = 'alert alert-danger mb-3';
                });
                
        } catch (error) {
            showDebugError('Error saat inisialisasi scanner', error);
            cameraStatus.innerHTML = '<i class="bi bi-exclamation-triangle text-warning"></i> Error: ' + error.message;
            cameraStatus.className = 'alert alert-warning mb-3';
        }
    }

    // Check camera permissions
    function checkCameraPermissions() {
        debugLog('Memeriksa permission kamera');
        
        if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
            navigator.mediaDevices.getUserMedia({ video: true })
                .then(function(stream) {
                    debugLog('Permission kamera diberikan');
                    // Stop the stream immediately, we just wanted to check permission
                    stream.getTracks().forEach(track => track.stop());
                    initializeScanner();
                })
                .catch(function(error) {
                    showDebugError('Permission kamera ditolak', error);
                    cameraStatus.innerHTML = '<i class="bi bi-camera-video-off text-danger"></i> Akses kamera ditolak. Silakan izinkan akses kamera.';
                    cameraStatus.className = 'alert alert-danger mb-3';
                });
        } else {
            showDebugError('getUserMedia tidak didukung browser');
            cameraStatus.innerHTML = '<i class="bi bi-exclamation-triangle text-warning"></i> Browser tidak mendukung akses kamera.';
            cameraStatus.className = 'alert alert-warning mb-3';
        }
    }

    // Test network connectivity
    function testNetworkConnection() {
        debugLog('Testing network connection');
        
        fetch("{{ route('koki.dashboard') }}", {
            method: 'HEAD',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
            }
        })
        .then(response => {
            if (response.ok) {
                debugLog('Network connection OK');
            } else {
                showDebugError('Network response not OK', { status: response.status });
            }
        })
        .catch(error => {
            showDebugError('Network test failed', error);
        });
    }

    // Initialize everything
    debugLog('Memulai inisialisasi aplikasi');
    
    // Test network first
    testNetworkConnection();
    
    // Initialize camera scanner
    checkCameraPermissions();
    
    debugLog('Inisialisasi selesai');
});
</script>
@endpush