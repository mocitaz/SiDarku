<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Email - SiDarku</title>
    
    <!-- Favicon & Web Icons -->
    <link rel="icon" type="image/png" href="{{ asset('images/icon.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/icon.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/icon.png') }}">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta name="apple-mobile-web-app-title" content="SiDarku">
    
    @php
        // Load Vite assets manually for production
        $manifestPath = public_path('build/manifest.json');
        $cssFile = 'build/assets/app-CTjIcR7l.css';
        $jsFile = 'build/assets/app-4-iAQeJo.js';
        
        if (file_exists($manifestPath)) {
            try {
                $manifest = json_decode(file_get_contents($manifestPath), true);
                if (isset($manifest['resources/css/app.css']['file'])) {
                    $cssFile = 'build/' . $manifest['resources/css/app.css']['file'];
                }
                if (isset($manifest['resources/js/app.js']['file'])) {
                    $jsFile = 'build/' . $manifest['resources/js/app.js']['file'];
                }
            } catch (\Exception $e) {
                // Use default files if manifest read fails
            }
        }
    @endphp
    <link rel="stylesheet" href="{{ asset($cssFile) }}">
    <script type="module" src="{{ asset($jsFile) }}"></script>
</head>
<body class="min-h-screen bg-gray-50">
    <div class="min-h-screen flex">
        <!-- Left Side - Info Section (Hidden on mobile) -->
        <div class="hidden lg:flex lg:w-1/2 relative overflow-hidden" style="background: linear-gradient(135deg, #ff79b8 0%, #feb4c8 100%);">
            <!-- Decorative Elements -->
            <div class="absolute top-0 right-0 w-96 h-96 bg-white/10 rounded-full -mr-48 -mt-48"></div>
            <div class="absolute bottom-0 left-0 w-80 h-80 bg-white/10 rounded-full -ml-40 -mb-40"></div>
            
            <div class="relative z-10 p-12 flex flex-col justify-between">
                <!-- Logo -->
                <div>
                    <div class="flex items-center space-x-2 mb-2">
                        <img src="{{ asset('images/icon.png') }}" alt="SiDarku Logo" class="w-10 h-10 object-contain">
                        <h1 class="text-4xl font-extrabold text-white">SiDarku</h1>
                    </div>
                    <p class="text-white/90 text-sm">Selalu Ingat Darah Ku</p>
                </div>

                <!-- Main Content -->
                <div class="max-w-md">
                    <div class="inline-flex items-center space-x-2 bg-white/20 backdrop-blur-sm rounded-full px-4 py-2 mb-6">
                        <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                            <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                        </svg>
                        <p class="text-white text-sm font-semibold">Verifikasi Email</p>
                    </div>
                    <h2 class="text-3xl font-bold text-white mb-4 leading-tight">
                        Verifikasi Email Anda
                    </h2>
                    <p class="text-white/90 leading-relaxed mb-8">
                        Kami telah mengirimkan link verifikasi ke email Anda. Silakan cek inbox email Anda dan klik link verifikasi untuk melanjutkan.
                    </p>
                </div>

                <!-- Footer -->
                <p class="text-white/70 text-xs">© 2025 SiDarku. Semua hak dilindungi.</p>
            </div>
        </div>

        <!-- Right Side - Verification Form -->
        <div class="flex-1 flex items-center justify-center p-4 sm:p-6 lg:p-12">
            <div class="w-full max-w-md">
                <!-- Mobile Logo -->
                <div class="lg:hidden text-center mb-6 sm:mb-8">
                    <div class="flex items-center justify-center space-x-2 mb-2">
                        <img src="{{ asset('images/icon.png') }}" alt="SiDarku Logo" class="w-8 h-8 sm:w-10 sm:h-10 object-contain">
                        <h1 class="text-2xl sm:text-3xl font-extrabold text-gradient-sidarku">SiDarku</h1>
                    </div>
                    <p class="text-gray-600 text-xs sm:text-sm">Verifikasi Email</p>
                </div>

                <!-- Title -->
                <div class="mb-6 sm:mb-8 hidden lg:block">
                    <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-2">Verifikasi Email</h2>
                    <p class="text-sm sm:text-base text-gray-600">Silakan verifikasi email Anda untuk melanjutkan</p>
                </div>

                <!-- Success Message -->
                @if (session('message'))
                    <div class="bg-green-50 border border-green-200 rounded-xl p-3 sm:p-4 mb-4 sm:mb-6 flex items-start space-x-2">
                        <svg class="w-5 h-5 text-green-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p class="text-sm text-green-700">{{ session('message') }}</p>
                    </div>
                @endif

                <!-- Error Message -->
                @if (session('error'))
                    <div class="bg-red-50 border border-red-200 rounded-xl p-3 sm:p-4 mb-4 sm:mb-6 flex items-start space-x-2">
                        <svg class="w-5 h-5 text-red-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p class="text-sm text-red-700">{{ session('error') }}</p>
                    </div>
                @endif

                <!-- Verification Info Card -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 sm:p-6 mb-4 sm:mb-6">
                    <div class="text-center mb-4">
                        <div class="inline-flex items-center justify-center w-16 h-16 bg-pink-100 rounded-full mb-3">
                            <svg class="w-8 h-8 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Cek Email Anda</h3>
                        <p class="text-sm text-gray-600 mb-1">
                            Kami telah mengirimkan link verifikasi ke:
                        </p>
                        <p class="text-sm font-semibold text-gray-900">
                            {{ auth()->user()->email }}
                        </p>
                    </div>

                    <div class="bg-pink-50 border-l-3 border-pink-500 rounded-lg p-3 mb-4">
                        <p class="text-xs text-gray-700 leading-relaxed">
                            <strong>💡 Tips:</strong> Jika email tidak muncul di inbox, cek folder spam atau junk mail Anda. Link verifikasi akan kedaluwarsa dalam 60 menit.
                        </p>
                    </div>
                </div>

                <!-- Resend Button -->
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button 
                        type="submit" 
                        class="w-full bg-sidarku-primary hover:bg-sidarku-primary-dark text-white font-bold py-2.5 sm:py-3 px-4 sm:px-6 rounded-xl shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-0.5 flex items-center justify-center space-x-2 text-sm sm:text-base"
                    >
                        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        <span>Kirim Ulang Email Verifikasi</span>
                    </button>
                </form>

                <!-- Back to Home -->
                <div class="mt-4 sm:mt-6 text-center">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-sm text-gray-600 hover:text-gray-900 transition-colors">
                            Kembali ke Login
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

