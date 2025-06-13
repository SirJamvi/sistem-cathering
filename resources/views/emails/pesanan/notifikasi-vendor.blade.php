<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesanan Makanan Baru</title>
     <style>
        body { font-family: Arial, sans-serif; color: #333; }
        .container { max-width: 680px; margin: 20px auto; padding: 20px; border: 1px solid #ddd; border-radius: 5px; }
        .header { font-size: 24px; font-weight: bold; text-align: center; }
        .content { margin-top: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
        th { background-color: #f2f2f2; width: 30%; }
        .footer { margin-top: 20px; font-size: 12px; text-align: center; color: #777; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            Konfirmasi Pesanan Makanan Baru
        </div>
        <div class="content">
            <p>Yth. Tim <strong>{{ $pesanan->vendor->nama_vendor }}</strong>,</p>
            <p>Kami ingin mengonfirmasi pesanan makanan baru dengan detail sebagai berikut:</p>
            
            <table>
                <tr>
                    <th>Nomor Pesanan</th>
                    <td>#{{ $pesanan->id }}</td>
                </tr>
                <tr>
                    <th>Tanggal Pengiriman</th>
                    <td>{{ \Carbon\Carbon::parse($pesanan->tanggal_pesanan)->format('l, d F Y') }}</td>
                </tr>
                 <tr>
                    <th>Shift</th>
                    <td>{{ $pesanan->shift->nama_shift ?? 'N/A' }} (Estimasi Waktu: {{ $pesanan->waktu_pengiriman_estimasi ? \Carbon\Carbon::parse($pesanan->waktu_pengiriman_estimasi)->format('H:i') : 'N/A' }})</td>
                </tr>
                <tr>
                    <th>Jumlah Porsi</th>
                    <td><strong>{{ $pesanan->jumlah_porsi_dipesan }} Porsi</strong></td>
                </tr>
                <tr>
                    <th>Catatan Pesanan</th>
                    <td>{{ $pesanan->catatan_pesanan ?? 'Tidak ada catatan tambahan.' }}</td>
                </tr>
            </table>

            <p>Mohon untuk mempersiapkan pesanan sesuai dengan detail di atas. Terima kasih atas kerja sama Anda.</p>
            <br>
            <p>Hormat kami,</p>
            <p><strong>Divisi HRGA - PT Manufaktur Maju Jaya</strong></p>
        </div>
        <div class="footer">
            <p>Ini adalah email konfirmasi otomatis. Mohon jangan membalas email ini.</p>
        </div>
    </div>
</body>
</html>