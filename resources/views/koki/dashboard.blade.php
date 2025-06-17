@extends('layouts.app')

@section('title', 'Dashboard Koki')

@section('page-header', 'Dashboard Koki')
@section('page-icon', 'bi-speedometer2')

@push('styles')
<style>
    /* Custom styles specific for this page */
    .scan-result-icon {
        font-size: 3rem;
        margin-bottom: 1rem;
    }
    
    .karyawan-name {
        font-size: 1.25rem;
        font-weight: 600;
        color: #0e5fb4;
    }
    
    .divisi-name {
        font-size: 0.9rem;
        color: #718096;
    }
    
    .stat-card {
        border-left: 4px solid #0e5fb4;
        transition: all 0.3s ease;
    }
    
    .stat-card:hover {
        border-left: 4px solid #d8d262;
    }
    
    .stat-number {
        font-size: 1.5rem;
        font-weight: 700;
        color: #0e5fb4;
    }
</style>
@endpush

@section('content')
<div class="container">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col">
            <h2 class="page-title">
                <i class="bi bi-qr-code-scan"></i> Validasi Makanan Karyawan
            </h2>
            <p class="text-muted">Arahkan kamera pada QR Code karyawan untuk validasi pengambilan makanan</p>
        </div>
        <div class="col-auto">
            <button id="toggle-debug" class="btn btn-outline-warning">
                <i class="bi bi-bug"></i> Debug Mode
            </button>
        </div>
    </div>

    <!-- Debug Panel -->
    <div id="debug-panel" class="debug-panel" style="display: none;">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <strong>Debug Information:</strong>
            <button id="clear-debug" class="btn btn-sm btn-outline-danger">
                <i class="bi bi-trash"></i> Clear
            </button>
        </div>
        <div id="debug-content" class="font-monospace small">Menunggu scan...</div>
    </div>

    <div class="row g-4">
        <!-- Scanner Column -->
        <div class="col-lg-7">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <!-- Camera Status -->
                    <div id="camera-status" class="alert alert-info d-flex align-items-center">
                        <i class="bi bi-camera-video"></i>
                        <span class="ms-2">Memuat kamera...</span>
                    </div>

                    <!-- Scanner Area -->
                    <div id="qr-reader" class="mx-auto mb-3"></div>
                    
                    <!-- Manual Input for Testing -->
                    <div id="manual-input" class="mt-4 p-3 rounded-3" style="display: none;">
                        <h5 class="mb-3"><i class="bi bi-keyboard"></i> Manual Input</h5>
                        <div class="input-group">
                            <input type="text" id="manual-token" class="form-control" placeholder="Masukkan QR Token...">
                            <button class="btn btn-warning" id="btn-manual-test">
                                <i class="bi bi-send-check"></i> Test
                            </button>
                        </div>
                    </div>

                    <!-- Scan Result -->
                    <div class="mt-4">
                        <h5 class="d-flex align-items-center">
                            <i class="bi bi-clock-history me-2"></i> Hasil Scan Terakhir
                        </h5>
                        <div id="scan-result" class="alert alert-secondary mt-2" role="alert">
                            <div id="result-content" class="text-center py-3">
                                <div class="scan-result-icon">
                                    <i class="bi bi-hourglass-split text-muted"></i>
                                </div>
                                <p class="mb-0">Menunggu scan QR Code...</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Info Column -->
        <div class="col-lg-5">
            <!-- Shift Info -->
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="bi bi-calendar-event"></i> Shift Aktif</h5>
                </div>
                <div class="card-body text-center">
                    @if($shiftAktif)
                        <h3 class="text-primary">{{ $shiftAktif->nama_shift }}</h3>
                        <p class="text-muted mb-0">
                            <i class="bi bi-clock"></i> {{ $shiftAktif->jam_mulai }} - {{ $shiftAktif->jam_selesai }}
                        </p>
                    @else
                        <div class="alert alert-warning mb-0">
                            <i class="bi bi-exclamation-triangle"></i> Tidak ada shift aktif
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- Statistik Card -->
            <div class="card shadow-sm border-0 mt-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="bi bi-clipboard-data"></i> Statistik Porsi</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span><i class="bi bi-cart-check text-primary"></i> Total Dipesan</span>
                            <span id="total-dipesan" class="badge bg-primary rounded-pill fs-6">{{ $totalDipesan }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span><i class="bi bi-check-circle text-success"></i> Sudah Diambil</span>
                            <span id="total-diambil" class="badge bg-success rounded-pill fs-6">{{ $totalDiambil }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center fw-bold">
                            <span><i class="bi bi-hourglass-split text-dark"></i> Sisa Porsi</span>
                            <span id="sisa-porsi" class="badge bg-dark rounded-pill fs-6">{{ $totalDipesan - $totalDiambil }}</span>
                        </li>
                    </ul>
                </div>
            </div>
            
            <!-- Karyawan Belum Ambil -->
            <div class="card shadow-sm border-0 mt-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="bi bi-people"></i> Belum Mengambil</h5>
                </div>
                <div id="sisa-karyawan-list" class="list-group list-group-flush" style="max-height: 300px; overflow-y: auto;">
                    @forelse ($sisaKaryawan as $karyawan)
                        <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center" data-karyawan-id="{{ $karyawan->id }}">
                            <div>
                                <span class="d-block fw-medium">{{ $karyawan->nama_lengkap }}</span>
                                <small class="text-muted">{{ $karyawan->divisi->nama_divisi ?? 'N/A' }}</small>
                            </div>
                            <i class="bi bi-chevron-right text-muted"></i>
                        </a>
                    @empty
                        <div id="sisa-karyawan-empty" class="list-group-item text-center py-4">
                            <i class="bi bi-check-circle-fill text-success" style="font-size: 2rem;"></i>
                            <p class="mt-2 mb-0">Semua karyawan telah mengambil makanan</p>
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