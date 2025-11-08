<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - SiDarku</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background-color: #f3f4f6;
            line-height: 1.5;
        }
        .email-wrapper {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
        }
        .header {
            background: linear-gradient(135deg, #ff79b8 0%, #feb4c8 100%);
            padding: 16px 20px;
            text-align: center;
        }
        .header-logo {
            color: #ffffff;
            font-size: 20px;
            font-weight: bold;
            margin: 0;
            letter-spacing: 0.5px;
        }
        .content {
            padding: 24px 20px;
        }
        .greeting {
            font-size: 16px;
            font-weight: 600;
            color: #111827;
            margin-bottom: 12px;
        }
        .message {
            font-size: 14px;
            color: #374151;
            margin-bottom: 20px;
            line-height: 1.6;
        }
        .cta-button {
            display: inline-block;
            background: linear-gradient(135deg, #ff79b8 0%, #feb4c8 100%);
            color: #ffffff !important;
            text-decoration: none;
            padding: 12px 28px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 14px;
            margin: 20px 0;
            text-align: center;
        }
        .info-box {
            background-color: #fef3f7;
            border-left: 3px solid #ff79b8;
            padding: 12px 14px;
            margin: 20px 0;
            border-radius: 6px;
        }
        .info-box-title {
            font-size: 13px;
            font-weight: 600;
            color: #111827;
            margin-bottom: 6px;
        }
        .info-box-text {
            font-size: 12px;
            color: #6b7280;
            margin: 0;
            line-height: 1.6;
        }
        .footer {
            background-color: #f9fafb;
            padding: 16px 20px;
            text-align: center;
            border-top: 1px solid #e5e7eb;
        }
        .footer-text {
            font-size: 11px;
            color: #6b7280;
            margin: 4px 0;
        }
        .footer-link {
            color: #ff79b8;
            text-decoration: none;
        }
        .footer-copyright {
            font-size: 10px;
            color: #9ca3af;
            margin-top: 12px;
        }
        .reset-link {
            word-break: break-all;
            font-size: 12px;
            color: #6b7280;
            background-color: #f9fafb;
            padding: 10px;
            border-radius: 6px;
            margin: 15px 0;
        }
    </style>
</head>
<body>
    <div class="email-wrapper">
        <!-- Header -->
        <div class="header">
            <h1 class="header-logo">SiDarku</h1>
        </div>

        <!-- Content -->
        <div class="content">
            <div class="greeting">
                Hai, {{ $user->name }}! 👋
            </div>

            <div class="message">
                Kami menerima permintaan untuk mereset password akun SiDarku Anda. Klik tombol di bawah ini untuk membuat password baru.
            </div>

            <div style="text-align: center;">
                <a href="{{ $resetUrl }}" class="cta-button" style="color: #ffffff !important;">
                    Reset Password
                </a>
            </div>

            <div class="info-box">
                <div class="info-box-title">💡 Informasi Penting:</div>
                <p class="info-box-text">
                    • Link reset password akan kedaluwarsa dalam 60 menit<br>
                    • Jika tombol tidak berfungsi, salin dan tempel link di bawah ini ke browser Anda<br>
                    • Jika Anda tidak meminta reset password, abaikan email ini dan password Anda tidak akan berubah
                </p>
            </div>

            <div class="reset-link">
                {{ $resetUrl }}
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p class="footer-text">
                <strong>SiDarku</strong> - Selalu Ingat Darah Ku
            </p>
            <p class="footer-text">
                Aplikasi kesehatan untuk perempuan Indonesia
            </p>
            <p class="footer-text">
                <a href="{{ config('app.url') }}" class="footer-link">Kunjungi Website</a>
            </p>
            <p class="footer-copyright">
                © {{ date('Y') }} SiDarku. All rights reserved.
            </p>
        </div>
    </div>
</body>
</html>

