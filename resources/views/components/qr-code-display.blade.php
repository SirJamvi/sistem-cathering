@props(['token', 'size' => 200])

{{-- 1. Tambahkan data-* attributes untuk menyimpan nilai dari Blade --}}
<div id="qrcode-container" 
     class="d-flex justify-content-center align-items-center p-3 border rounded"
     data-token="{{ $token }}" 
     data-size="{{ $size }}">
    <div id="qrcode-element"></div>
</div>

@push('scripts')
{{-- Library untuk generate QR Code --}}
<script src="https://cdn.jsdelivr.net/npm/qrcodejs@1.0.0/qrcode.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const qrCodeContainer = document.getElementById('qrcode-container');
        const qrCodeElement = document.getElementById('qrcode-element');

        // 2. Ambil nilai dari data-* attributes menggunakan JavaScript murni
        const token = qrCodeContainer.dataset.token;
        const size = parseInt(qrCodeContainer.dataset.size, 10);
        
        // Fungsi untuk membuat QR Code
        function generateQrCode(tokenValue) {
            // Hapus QR code lama jika ada
            qrCodeElement.innerHTML = '';

            // 3. Gunakan variabel JavaScript yang sudah bersih di sini
            new QRCode(qrCodeElement, {
                text: tokenValue,
                width: size,
                height: size,
                colorDark : "#000000",
                colorLight : "#ffffff",
                correctLevel : QRCode.CorrectLevel.H
            });
        }

        // Generate QR code saat halaman dimuat jika token ada
        if (token) {
            generateQrCode(token);
        }

        // Anda bisa menambahkan event listener di sini untuk memperbarui token
        // Contoh: document.body.addEventListener('update-qr', (e) => generateQrCode(e.detail.token));
    });
</script>
@endpush