<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SiDarku - Selalu Ingat Darah Ku</title>
    
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
    <style>
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @keyframes float {
            0%, 100% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-20px);
            }
        }
        
        @keyframes pulse {
            0%, 100% {
                opacity: 1;
            }
            50% {
                opacity: 0.5;
            }
        }
        
        .animate-fade-in-up {
            animation: fadeInUp 0.6s ease-out forwards;
        }
        
        .animate-float {
            animation: float 3s ease-in-out infinite;
        }
        
        .animate-pulse-slow {
            animation: pulse 3s ease-in-out infinite;
        }
        
        .delay-100 { animation-delay: 100ms; }
        .delay-200 { animation-delay: 200ms; }
        .delay-300 { animation-delay: 300ms; }
        .delay-400 { animation-delay: 400ms; }
        
        .gradient-mesh {
            background: linear-gradient(45deg, #ec4899 0%, #8b5cf6 50%, #ec4899 100%);
            background-size: 200% 200%;
            animation: gradientShift 3s ease infinite;
        }
        
        @keyframes gradientShift {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }
    </style>
</head>
<body class="bg-white">
    <!-- Navigation -->
    <nav class="fixed top-0 left-0 right-0 bg-white/80 backdrop-blur-md border-b border-gray-100 z-50 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center space-x-2">
                    <img src="{{ asset('images/icon.png') }}" alt="SiDarku Logo" class="w-8 h-8 object-contain">
                    <h1 class="text-2xl font-extrabold text-gradient-sidarku">
                        SiDarku
                    </h1>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('login') }}" class="text-sm font-semibold text-gray-700 hover:text-sidarku-primary transition-colors">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}" class="bg-sidarku-primary hover:bg-sidarku-primary-dark text-white px-4 py-2 rounded-xl text-sm font-bold hover:shadow-lg transform hover:-translate-y-0.5 transition-all">
                        Daftar
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="pt-32 pb-20 px-4 sm:px-6 lg:px-8 relative overflow-hidden" style="background: linear-gradient(135deg, #fff5fb 0%, #ffe9f5 50%, #fff5fb 100%);">
        <!-- Decorative Elements -->
        <div class="absolute top-20 left-10 w-72 h-72 rounded-full blur-3xl animate-pulse-slow" style="background-color: rgba(255, 121, 184, 0.15);"></div>
        <div class="absolute bottom-20 right-10 w-96 h-96 rounded-full blur-3xl animate-pulse-slow delay-200" style="background-color: rgba(254, 180, 200, 0.15);"></div>
        
        <div class="max-w-7xl mx-auto relative z-10">
            <div class="text-center max-w-4xl mx-auto">
                <div class="inline-block rounded-full px-4 py-2 mb-6 animate-fade-in-up" style="background-color: rgba(255, 121, 184, 0.15);">
                    <p class="text-sm font-semibold flex items-center space-x-2" style="color: #ff79b8;">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                        </svg>
                        <span>Platform Kesehatan Remaja Putri</span>
                    </p>
                </div>
                <h1 class="text-5xl sm:text-6xl lg:text-7xl font-extrabold text-gray-900 mb-6 leading-tight animate-fade-in-up delay-100">
                    Jaga Kesehatanmu dengan
                    <span class="text-gradient-sidarku block mt-2">
                        SiDarku
                    </span>
                </h1>
                <p class="text-xl sm:text-2xl text-gray-600 mb-8 leading-relaxed max-w-2xl mx-auto animate-fade-in-up delay-200">
                    Platform lengkap untuk mengingat konsumsi Tablet Tambah Darah, melacak siklus menstruasi, dan mendapatkan edukasi kesehatan yang tepat.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center items-center animate-fade-in-up delay-300">
                    <a href="{{ route('register') }}" class="bg-sidarku-primary hover:bg-sidarku-primary-dark text-white px-8 py-4 rounded-xl text-lg font-bold shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-1 flex items-center space-x-2">
                        <span>Mulai Gratis</span>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                        </svg>
                    </a>
                    <a href="#fitur" class="bg-white text-gray-700 px-8 py-4 rounded-xl text-lg font-bold border-2 border-gray-200 hover:border-sidarku-secondary hover:text-sidarku-primary transition-all flex items-center space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                        <span>Pelajari Lebih Lanjut</span>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-16 px-4 sm:px-6 lg:px-8 bg-white border-y border-gray-100">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                <div class="group hover:scale-105 transition-transform">
                    <div class="text-4xl font-bold text-sidarku-primary mb-2">100%</div>
                    <div class="text-sm text-gray-600 font-medium">Gratis</div>
                </div>
                <div class="group hover:scale-105 transition-transform">
                    <div class="text-4xl font-bold text-sidarku-secondary mb-2">24/7</div>
                    <div class="text-sm text-gray-600 font-medium">Tersedia</div>
                </div>
                <div class="group hover:scale-105 transition-transform">
                    <div class="text-4xl font-bold text-sidarku-primary mb-2">1000+</div>
                    <div class="text-sm text-gray-600 font-medium">Pengguna</div>
                </div>
                <div class="group hover:scale-105 transition-transform">
                    <div class="text-4xl font-bold text-sidarku-secondary mb-2">100%</div>
                    <div class="text-sm text-gray-600 font-medium">Aman</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="fitur" class="py-20 px-4 sm:px-6 lg:px-8 bg-white">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">Fitur Utama</h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    Semua yang kamu butuhkan untuk menjaga kesehatan dalam satu aplikasi
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="group rounded-2xl p-8 border hover:shadow-xl transition-all hover:-translate-y-2" style="background: linear-gradient(135deg, rgba(255, 121, 184, 0.08) 0%, rgba(254, 180, 200, 0.12) 100%); border-color: rgba(255, 121, 184, 0.2);">
                    <div class="w-16 h-16 bg-sidarku-primary rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">Reminder TTD Otomatis</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Tidak akan lupa lagi minum Tablet Tambah Darah. Sistem akan mengingatkanmu secara otomatis setiap minggu.
                    </p>
                </div>

                <!-- Feature 2 -->
                <div class="group rounded-2xl p-8 border hover:shadow-xl transition-all hover:-translate-y-2" style="background: linear-gradient(135deg, rgba(254, 180, 200, 0.08) 0%, rgba(255, 121, 184, 0.12) 100%); border-color: rgba(254, 180, 200, 0.2);">
                    <div class="w-16 h-16 bg-sidarku-secondary rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">Pelacakan Siklus Menstruasi</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Catat dan lacak siklus menstruasimu dengan mudah. Dapatkan prediksi akurat untuk haid berikutnya.
                    </p>
                </div>

                <!-- Feature 3 -->
                <div class="group rounded-2xl p-8 border hover:shadow-xl transition-all hover:-translate-y-2" style="background: linear-gradient(135deg, rgba(255, 121, 184, 0.08) 0%, rgba(254, 180, 200, 0.12) 100%); border-color: rgba(255, 121, 184, 0.2);">
                    <div class="w-16 h-16 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform" style="background: linear-gradient(135deg, #ff79b8 0%, #feb4c8 100%);">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">Progress Tracking</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Lihat seberapa konsisten kamu minum TTD dengan grafik dan kalender interaktif.
                    </p>
                </div>

                <!-- Feature 4 -->
                <div class="group rounded-2xl p-8 border hover:shadow-xl transition-all hover:-translate-y-2" style="background: linear-gradient(135deg, rgba(255, 121, 184, 0.08) 0%, rgba(254, 180, 200, 0.12) 100%); border-color: rgba(255, 121, 184, 0.2);">
                    <div class="w-16 h-16 bg-sidarku-primary rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">Edukasi Kesehatan</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Akses artikel terpercaya tentang anemia, menstruasi, nutrisi, dan tips kesehatan lainnya.
                    </p>
                </div>

                <!-- Feature 5 -->
                <div class="group rounded-2xl p-8 border hover:shadow-xl transition-all hover:-translate-y-2" style="background: linear-gradient(135deg, rgba(254, 180, 200, 0.08) 0%, rgba(255, 121, 184, 0.12) 100%); border-color: rgba(254, 180, 200, 0.2);">
                    <div class="w-16 h-16 bg-sidarku-secondary rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">Reminder Pintar</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Reminder yang disesuaikan dengan siklus menstruasimu. Lebih intensif saat menstruasi.
                    </p>
                </div>

                <!-- Feature 6 -->
                <div class="group rounded-2xl p-8 border hover:shadow-xl transition-all hover:-translate-y-2" style="background: linear-gradient(135deg, rgba(255, 121, 184, 0.08) 0%, rgba(254, 180, 200, 0.12) 100%); border-color: rgba(255, 121, 184, 0.2);">
                    <div class="w-16 h-16 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform" style="background: linear-gradient(135deg, #ff79b8 0%, #feb4c8 100%);">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">Mobile-First Design</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Aplikasi yang dioptimalkan untuk smartphone. Desain yang cute, feminine, dan mudah digunakan.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section class="py-20 px-4 sm:px-6 lg:px-8" style="background: linear-gradient(135deg, #f9fafb 0%, #fff5fb 100%);">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">Cara Kerja</h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    Mulai dalam 3 langkah mudah
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-12">
                <div class="text-center group">
                    <div class="relative inline-block mb-6">
                        <div class="w-20 h-20 bg-sidarku-primary rounded-full flex items-center justify-center group-hover:scale-110 transition-transform">
                            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <div class="absolute -top-2 -right-2 w-8 h-8 rounded-full flex items-center justify-center" style="background-color: rgba(255, 121, 184, 0.15);">
                            <span class="text-sidarku-primary font-bold">1</span>
                        </div>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Daftar Gratis</h3>
                    <p class="text-gray-600">Buat akun dengan email dan mulai dalam hitungan detik</p>
                </div>

                <div class="text-center group">
                    <div class="relative inline-block mb-6">
                        <div class="w-20 h-20 bg-sidarku-secondary rounded-full flex items-center justify-center group-hover:scale-110 transition-transform">
                            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <div class="absolute -top-2 -right-2 w-8 h-8 rounded-full flex items-center justify-center" style="background-color: rgba(254, 180, 200, 0.15);">
                            <span class="text-sidarku-secondary font-bold">2</span>
                        </div>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Setup Profil</h3>
                    <p class="text-gray-600">Atur preferensi dan jadwal reminder sesuai kebutuhanmu</p>
                </div>

                <div class="text-center group">
                    <div class="relative inline-block mb-6">
                        <div class="w-20 h-20 rounded-full flex items-center justify-center group-hover:scale-110 transition-transform" style="background: linear-gradient(135deg, #ff79b8 0%, #feb4c8 100%);">
                            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <div class="absolute -top-2 -right-2 w-8 h-8 rounded-full flex items-center justify-center" style="background-color: rgba(255, 121, 184, 0.15);">
                            <span class="text-sidarku-primary font-bold">3</span>
                        </div>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Mulai Tracking</h3>
                    <p class="text-gray-600">Check-in TTD, lacak siklus, dan pantau progress kesehatanmu</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Benefits Section -->
    <section class="py-20 px-4 sm:px-6 lg:px-8 bg-white">
        <div class="max-w-7xl mx-auto">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <div>
                    <h2 class="text-4xl font-bold text-gray-900 mb-6">
                        Mengapa Pilih SiDarku?
                    </h2>
                    <div class="space-y-6">
                        <div class="flex items-start space-x-4 group">
                            <div class="flex-shrink-0 w-12 h-12 bg-sidarku-primary rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-900 mb-2">Gratis Selamanya</h3>
                                <p class="text-gray-600">Tidak ada biaya tersembunyi. Semua fitur tersedia untuk semua pengguna.</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-4 group">
                            <div class="flex-shrink-0 w-12 h-12 bg-sidarku-secondary rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-900 mb-2">Data Pribadi Terlindungi</h3>
                                <p class="text-gray-600">Privasi adalah prioritas kami. Data kamu aman dan tidak dibagikan ke pihak ketiga.</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-4 group">
                            <div class="flex-shrink-0 w-12 h-12 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform" style="background: linear-gradient(135deg, #ff79b8 0%, #feb4c8 100%);">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-900 mb-2">Mudah Digunakan</h3>
                                <p class="text-gray-600">Interface yang intuitif dan ramah. Tidak perlu tutorial panjang untuk mulai menggunakan.</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-4 group">
                            <div class="flex-shrink-0 w-12 h-12 bg-sidarku-primary rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-900 mb-3">Dibuat Khusus untuk Remaja Putri</h3>
                                <p class="text-gray-600">Desain yang cute, feminine, dan sesuai dengan kebutuhan remaja putri Indonesia.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="relative">
                    <div class="bg-white rounded-3xl p-8 shadow-2xl border border-gray-100 hover:shadow-3xl transition-shadow">
                        <div class="space-y-6">
                            <div class="text-center">
                                <div class="inline-block rounded-2xl p-6 mb-4" style="background: linear-gradient(135deg, #ff79b8 0%, #feb4c8 100%);">
                                    <svg class="w-16 h-16 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <h3 class="text-2xl font-bold text-gray-900 mb-2">Bergabung dengan Ribuan Pengguna</h3>
                                <p class="text-gray-600">Remaja putri di seluruh Indonesia sudah mempercayai SiDarku untuk menjaga kesehatan mereka.</p>
                            </div>
                            <div class="pt-6 border-t border-gray-200">
                                <div class="grid grid-cols-3 gap-4 text-center">
                                    <div class="hover:scale-110 transition-transform">
                                        <div class="text-3xl font-bold text-sidarku-primary mb-1">100%</div>
                                        <div class="text-sm text-gray-600">Gratis</div>
                                    </div>
                                    <div class="hover:scale-110 transition-transform">
                                        <div class="text-3xl font-bold text-sidarku-secondary mb-1">24/7</div>
                                        <div class="text-sm text-gray-600">Tersedia</div>
                                    </div>
                                    <div class="hover:scale-110 transition-transform">
                                        <div class="text-3xl font-bold text-sidarku-primary mb-1">100%</div>
                                        <div class="text-sm text-gray-600">Aman</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="py-20 px-4 sm:px-6 lg:px-8" style="background: linear-gradient(135deg, rgba(255, 121, 184, 0.05) 0%, rgba(254, 180, 200, 0.08) 100%);">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">Apa Kata Mereka</h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    Pengalaman nyata dari pengguna SiDarku
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <div class="bg-white rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all hover:-translate-y-2">
                    <div class="flex items-center mb-4">
                        <div class="flex text-yellow-400">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                        </div>
                    </div>
                    <p class="text-gray-600 mb-4 leading-relaxed">"SiDarku sangat membantu saya untuk tidak lupa minum TTD. Remindernya tepat waktu dan interface-nya cantik!"</p>
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-sidarku-primary rounded-full flex items-center justify-center text-white font-bold">
                            A
                        </div>
                        <div class="ml-3">
                            <p class="font-semibold text-gray-900">Ayu Lestari</p>
                            <p class="text-sm text-gray-500">Mahasiswi, 19 tahun</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all hover:-translate-y-2">
                    <div class="flex items-center mb-4">
                        <div class="flex text-yellow-400">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                        </div>
                    </div>
                    <p class="text-gray-600 mb-4 leading-relaxed">"Fitur pelacakan siklus menstruasi-nya akurat banget! Jadi bisa persiapan lebih baik sebelum haid."</p>
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-sidarku-secondary rounded-full flex items-center justify-center text-white font-bold">
                            D
                        </div>
                        <div class="ml-3">
                            <p class="font-semibold text-gray-900">Dina Permata</p>
                            <p class="text-sm text-gray-500">Pelajar, 17 tahun</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all hover:-translate-y-2">
                    <div class="flex items-center mb-4">
                        <div class="flex text-yellow-400">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                        </div>
                    </div>
                    <p class="text-gray-600 mb-4 leading-relaxed">"Artikel edukasinya sangat informatif dan mudah dipahami. Recommended untuk semua remaja putri!"</p>
                    <div class="flex items-center">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center text-white font-bold" style="background: linear-gradient(135deg, #ff79b8 0%, #feb4c8 100%);">
                            S
                        </div>
                        <div class="ml-3">
                            <p class="font-semibold text-gray-900">Sari Indah</p>
                            <p class="text-sm text-gray-500">Karyawan, 21 tahun</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 px-4 sm:px-6 lg:px-8 relative overflow-hidden" style="background: linear-gradient(135deg, #ff79b8 0%, #feb4c8 100%);">
        <div class="absolute inset-0 bg-black/10"></div>
        <div class="max-w-4xl mx-auto text-center relative z-10">
            <h2 class="text-4xl sm:text-5xl font-bold text-white mb-6">
                Siap Memulai Perjalanan Sehatmu?
            </h2>
            <p class="text-xl text-white/90 mb-8 max-w-2xl mx-auto">
                Daftar sekarang dan dapatkan akses ke semua fitur SiDarku secara gratis. Tidak perlu kartu kredit.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('register') }}" class="bg-white text-sidarku-primary hover:text-sidarku-primary-dark px-8 py-4 rounded-xl text-lg font-bold shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-1 inline-flex items-center justify-center space-x-2">
                    <span>Daftar Sekarang</span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                    </svg>
                </a>
                <a href="{{ route('login') }}" class="bg-white/10 backdrop-blur-sm text-white border-2 border-white/30 px-8 py-4 rounded-xl text-lg font-bold hover:bg-white/20 transition-all inline-flex items-center justify-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                    </svg>
                    <span>Sudah Punya Akun? Masuk</span>
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-100 py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="flex flex-col md:flex-row justify-between items-center md:items-start gap-6 mb-6">
                <!-- Logo & Description -->
                <div class="text-center md:text-left">
                    <div class="flex items-center justify-center md:justify-start space-x-2 mb-2">
                        <img src="{{ asset('images/icon.png') }}" alt="SiDarku Logo" class="w-7 h-7 object-contain">
                        <h3 class="text-xl font-extrabold text-gradient-sidarku">SiDarku</h3>
                    </div>
                    <p class="text-xs text-gray-600 max-w-xs">
                        Platform kesehatan remaja putri Indonesia
                    </p>
                </div>
                
                <!-- Quick Links -->
                <div class="flex flex-wrap justify-center gap-6 text-sm text-gray-600">
                    <a href="#fitur" class="hover:text-sidarku-primary transition-colors">Fitur</a>
                    <a href="{{ route('login') }}" class="hover:text-sidarku-primary transition-colors">Masuk</a>
                    <a href="{{ route('register') }}" class="hover:text-sidarku-primary transition-colors">Daftar</a>
                    <a href="#" class="hover:text-sidarku-primary transition-colors">Kebijakan Privasi</a>
                    <a href="#" class="hover:text-sidarku-primary transition-colors">Ketentuan</a>
                </div>
            </div>
            
            <!-- Copyright -->
            <div class="border-t border-gray-200 pt-4 text-center">
                <p class="text-xs text-gray-500">© 2025 SiDarku. Semua hak dilindungi.</p>
            </div>
        </div>
    </footer>
</body>
</html>
