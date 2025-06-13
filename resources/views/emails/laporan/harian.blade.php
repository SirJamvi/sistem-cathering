<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Harian</title>
    <style>
        body { font-family: Arial, sans-serif; color: #333; }
        .container { max-width: 680px; margin: 20px auto; padding: 20px; border: 1px solid #ddd; border-radius: 5px; }
        .header { font-size: 24px; font-weight: bold; text-align: center; }
        .content { margin-top: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .footer { margin-top: 20px; font-size: 12px; text-align: center; color: #777; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            Laporan Konsumsi Harian
        </div>
        <div class="content">
            <p>Berikut adalah ringkasan laporan konsumsi makanan untuk:</p>
            <ul>
                <li><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($laporan->tanggal)->format('d F Y') }}</li>
                <li><strong>Shift:</strong> {{ $laporan->shift->nama_shift ?? 'N/A' }}</li>
            </ul>
            
            <table>
                <thead>
                    <tr>
                        <th>Deskripsi</th>
                        <th>Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Total Porsi Dipesan</td>
                        <td>{{ $laporan->total_porsi_dipesan }}</td>
                    </tr>
                    <tr>
                        <td>Total Porsi Dikonsumsi</td>
                        <td>{{ $laporan->total_porsi_dikonsumsi }}</td>
                    </tr>
                    <tr>
                        <td>Total Porsi Sisa</td>
                        <td>{{ $laporan->total_porsi_sisa }}</td>
                    </tr>
                    <tr>
                        <td><strong>Efektivitas Konsumsi</strong></td>
                        <td><strong>{{ $laporan->persentase_konsumsi }}%</strong></td>
                    </tr>
                </tbody>
            </table>

            <p>Untuk detail lebih lanjut, silakan login ke dashboard sistem.</p>
        </div>
        <div class="footer">
            <p>Email ini digenerate secara otomatis oleh sistem.</p>
        </div>
    </div>
</body>
</html> 