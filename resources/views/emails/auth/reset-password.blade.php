<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atur Ulang Password</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 20px auto; padding: 20px; border: 1px solid #ddd; border-radius: 5px; }
        .header { font-size: 24px; font-weight: bold; text-align: center; color: #2d3748; }
        .content { margin-top: 20px; }
        .button { display: inline-block; padding: 10px 20px; margin-top: 20px; background-color: #2d3748; color: #ffffff; text-decoration: none; border-radius: 5px; }
        .footer { margin-top: 20px; font-size: 12px; text-align: center; color: #718096; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            Notifikasi Atur Ulang Password
        </div>
        <div class="content">
            <p>Anda menerima email ini karena kami menerima permintaan untuk mengatur ulang password akun Anda.</p>
            
            <div style="text-align: center;">
                <a href="{{ $url }}" class="button" style="color: #ffffff;">Atur Ulang Password</a>
            </div>

            <p>Link untuk mengatur ulang password ini akan kedaluwarsa dalam 60 menit.</p>
            <p>Jika Anda tidak merasa meminta untuk mengatur ulang password, Anda dapat mengabaikan email ini.</p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} PT Manufaktur Maju Jaya. Semua hak dilindungi.</p>
        </div>
    </div>
</body>
</html>