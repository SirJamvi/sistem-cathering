<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informasi Akun Anda</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 20px auto; padding: 20px; border: 1px solid #ddd; border-radius: 5px; }
        .header { font-size: 24px; font-weight: bold; text-align: center; color: #2d3748; }
        .content { margin-top: 20px; }
        .credentials { background-color: #f7fafc; border: 1px solid #e2e8f0; padding: 15px; border-radius: 5px; }
        .button { display: inline-block; padding: 10px 20px; margin-top: 20px; background-color: #2d3748; color: #ffffff; text-decoration: none; border-radius: 5px; }
        .footer { margin-top: 20px; font-size: 12px; text-align: center; color: #718096; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            Selamat Datang di Sistem Catering
        </div>
        <div class="content">
            <p>Halo, <strong>{{ $nama }}</strong>!</p>
            <p>Sebuah akun telah dibuat untuk Anda pada sistem catering pabrik. Silakan gunakan detail di bawah ini untuk login ke aplikasi mobile atau web:</p>
            
            <div class="credentials">
                <p><strong>Email:</strong> {{ $email }}</p>
                {{-- Password dihapus untuk keamanan --}}
            </div>

            <p>Password Anda adalah yang telah diatur oleh tim HRGA saat pendaftaran. Silakan login menggunakan password tersebut.</p>
            
            <div style="text-align: center;">
                <a href="{{ url('/login') }}" class="button">Login Sekarang</a>
            </div>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} PT Manufaktur Maju Jaya. Semua hak dilindungi.</p>
        </div>
    </div>
</body>
</html>
