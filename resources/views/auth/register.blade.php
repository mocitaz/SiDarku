<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - SiDarku</title>
    
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
        <div class="hidden lg:flex lg:w-1/2 relative overflow-hidden" style="background: linear-gradient(135deg, #feb4c8 0%, #ff79b8 100%);">
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
                            <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd" />
                        </svg>
                        <p class="text-white text-sm font-semibold">Bergabunglah dengan Kami</p>
                    </div>
                    <h2 class="text-3xl font-bold text-white mb-4 leading-tight">
                        Mulai Perjalanan Kesehatanmu Hari Ini
                    </h2>
                    <p class="text-white/90 leading-relaxed mb-8">
                        Gratis selamanya. Tidak perlu kartu kredit. Mulai jaga kesehatanmu sekarang!
                    </p>

                    <!-- Benefits -->
                    <div class="space-y-3">
                        <div class="flex items-center space-x-3">
                            <div class="flex-shrink-0 w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <p class="text-white font-medium">100% Gratis Selamanya</p>
                        </div>
                        <div class="flex items-center space-x-3">
                            <div class="flex-shrink-0 w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <p class="text-white font-medium">Data Pribadi Terlindungi</p>
                        </div>
                        <div class="flex items-center space-x-3">
                            <div class="flex-shrink-0 w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <p class="text-white font-medium">Akses Semua Fitur</p>
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <p class="text-white/70 text-xs">© 2025 SiDarku. Semua hak dilindungi.</p>
            </div>
        </div>

        <!-- Right Side - Register Form -->
        <div class="flex-1 flex items-center justify-center p-4 sm:p-6 lg:p-12">
            <div class="w-full max-w-md">
                <!-- Mobile Logo -->
                <div class="lg:hidden text-center mb-6 sm:mb-8">
                    <div class="flex items-center justify-center space-x-2 mb-2">
                        <img src="{{ asset('images/icon.png') }}" alt="SiDarku Logo" class="w-8 h-8 sm:w-10 sm:h-10 object-contain">
                        <h1 class="text-2xl sm:text-3xl font-extrabold text-gradient-sidarku">SiDarku</h1>
                    </div>
                    <p class="text-gray-600 text-xs sm:text-sm">Buat akun baru</p>
                    <p class="text-xs text-gray-500 mt-1">
                        <span class="text-red-500">*</span> Field wajib diisi
                    </p>
                </div>

                <!-- Title -->
                <div class="mb-6 sm:mb-8 hidden lg:block">
                    <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-2">Daftar Akun Baru</h2>
                    <p class="text-sm sm:text-base text-gray-600">Mulai perjalanan kesehatanmu hari ini</p>
                    <p class="text-xs text-gray-500 mt-2">
                        <span class="text-red-500">*</span> Menandakan field wajib diisi
                    </p>
                </div>

                <!-- Error Messages -->
                @if ($errors->any())
                    <div class="mb-6 bg-red-50 border border-red-200 rounded-xl p-4" id="error-notification">
                        <div class="flex items-start space-x-3">
                            <svg class="w-5 h-5 text-red-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                            </svg>
                            <div class="flex-1">
                                <p class="text-sm font-semibold text-red-800 mb-2">Mohon perbaiki kesalahan berikut:</p>
                                <ul class="list-disc list-inside space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li class="text-sm text-red-700">{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Register Form -->
                <form method="POST" action="{{ route('register') }}" class="space-y-4">
                    @csrf

                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                            Nama Lengkap <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <input 
                                type="text" 
                                id="name"
                                name="name" 
                                value="{{ old('name') }}"
                                required 
                                autofocus
                                onblur="validateField('name')"
                                class="w-full pl-10 pr-4 py-3 border rounded-xl focus:ring-2 focus:ring-sidarku-primary focus:border-sidarku-primary transition-all {{ $errors->has('name') ? 'border-red-300 bg-red-50' : 'border-gray-300' }}"
                                placeholder="Nama lengkap"
                            >
                        </div>
                        @error('name')
                            <p class="mt-2 text-sm text-red-600 flex items-center space-x-1">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                                <span>{{ $message }}</span>
                            </p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                            Email <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                                </svg>
                            </div>
                            <input 
                                type="email" 
                                id="email"
                                name="email" 
                                value="{{ old('email') }}"
                                required 
                                onblur="validateField('email')"
                                class="w-full pl-10 pr-4 py-3 border rounded-xl focus:ring-2 focus:ring-sidarku-primary focus:border-sidarku-primary transition-all {{ $errors->has('email') ? 'border-red-300 bg-red-50' : 'border-gray-300' }}"
                                placeholder="nama@email.com"
                            >
                        </div>
                        @error('email')
                            <p class="mt-2 text-sm text-red-600 flex items-center space-x-1">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                                <span>{{ $message }}</span>
                            </p>
                        @enderror
                    </div>

                    <!-- Date of Birth -->
                    <div>
                        <label for="date_of_birth" class="block text-sm font-semibold text-gray-700 mb-2">
                            Tanggal Lahir <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <input 
                                type="date" 
                                id="date_of_birth"
                                name="date_of_birth" 
                                value="{{ old('date_of_birth') }}"
                                required 
                                onchange="validateField('date_of_birth')"
                                class="w-full pl-10 pr-4 py-3 border rounded-xl focus:ring-2 focus:ring-sidarku-primary focus:border-sidarku-primary transition-all {{ $errors->has('date_of_birth') ? 'border-red-300 bg-red-50' : 'border-gray-300' }}"
                            >
                        </div>
                        @error('date_of_birth')
                            <p class="mt-2 text-sm text-red-600 flex items-center space-x-1">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                                <span>{{ $message }}</span>
                            </p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                            Password <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                            <input 
                                type="password" 
                                id="password"
                                name="password" 
                                required 
                                minlength="8"
                                class="w-full pl-10 pr-12 py-3 border rounded-xl focus:ring-2 focus:ring-sidarku-primary focus:border-sidarku-primary transition-all {{ $errors->has('password') ? 'border-red-300 bg-red-50' : 'border-gray-300' }}"
                                placeholder="Minimal 8 karakter"
                                onkeyup="validatePassword()"
                            >
                            <button 
                                type="button"
                                onclick="togglePassword('password')"
                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600">
                                <svg id="eye-icon-password" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <svg id="eye-off-icon-password" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                </svg>
                            </button>
                        </div>
                        @error('password')
                            <p class="mt-2 text-sm text-red-600 flex items-center space-x-1">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                                <span>{{ $message }}</span>
                            </p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500" id="password-hint">
                            Password harus minimal 8 karakter
                        </p>
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">
                            Konfirmasi Password <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                            <input 
                                type="password" 
                                id="password_confirmation"
                                name="password_confirmation" 
                                required 
                                minlength="8"
                                onkeyup="validatePasswordConfirmation()"
                                class="w-full pl-10 pr-12 py-3 border rounded-xl focus:ring-2 focus:ring-sidarku-primary focus:border-sidarku-primary transition-all {{ $errors->has('password_confirmation') ? 'border-red-300 bg-red-50' : 'border-gray-300' }}"
                                placeholder="Ulangi password"
                            >
                            <button 
                                type="button"
                                onclick="togglePassword('password_confirmation')"
                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600">
                                <svg id="eye-icon-password_confirmation" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <svg id="eye-off-icon-password_confirmation" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                </svg>
                            </button>
                        </div>
                        @error('password_confirmation')
                            <p class="mt-2 text-sm text-red-600 flex items-center space-x-1">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                                <span>{{ $message }}</span>
                            </p>
                        @enderror
                    </div>

                    <!-- Terms -->
                    <div class="flex items-start">
                        <input 
                            type="checkbox" 
                            name="terms" 
                            id="terms" 
                            required 
                            onchange="validateTerms()"
                            class="w-4 h-4 mt-1 text-sidarku-primary border-gray-300 rounded focus:ring-sidarku-primary {{ $errors->has('terms') ? 'border-red-300' : '' }}"
                        >
                        <label for="terms" class="ml-2 text-sm text-gray-600">
                            Saya menyetujui <button type="button" onclick="openTermsModal()" class="text-sidarku-primary hover:text-sidarku-primary-dark font-semibold underline">Syarat & Ketentuan</button> <span class="text-red-500">*</span>
                        </label>
                    </div>
                    @error('terms')
                        <p class="mt-2 text-sm text-red-600 flex items-center space-x-1">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                            <span>{{ $message }}</span>
                        </p>
                    @enderror

                    <!-- Submit Button -->
                    <button 
                        type="submit" 
                        class="w-full bg-sidarku-primary hover:bg-sidarku-primary-dark text-white font-bold py-3 px-6 rounded-xl shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-0.5 flex items-center justify-center space-x-2"
                    >
                        <span>Daftar</span>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </button>
                </form>

                <!-- Login Link -->
                <p class="text-center text-gray-600 text-sm mt-6">
                    Sudah punya akun? 
                    <a href="{{ route('login') }}" class="font-semibold text-sidarku-primary hover:text-sidarku-primary-dark transition-colors">
                        Masuk
                    </a>
                </p>
            </div>
        </div>
    </div>

    <!-- Terms & Conditions Modal -->
    <div id="termsModal" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-hidden">
            <!-- Modal Header -->
            <div class="sticky top-0 bg-white border-b border-gray-200 px-6 py-4 flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center" style="background: linear-gradient(135deg, #ff79b8 0%, #feb4c8 100%);">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900">Syarat & Ketentuan</h3>
                </div>
                <button onclick="closeTermsModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Modal Content -->
            <div class="px-6 py-6 overflow-y-auto max-h-[calc(90vh-140px)]">
                <div class="prose prose-sm max-w-none">
                    <h4 class="text-lg font-bold text-gray-900 mb-4">Selamat Datang di SiDarku</h4>
                    <p class="text-gray-600 mb-4">
                        Dengan menggunakan aplikasi SiDarku, Anda menyetujui syarat dan ketentuan berikut:
                    </p>

                    <div class="space-y-4">
                        <div>
                            <h5 class="font-bold text-gray-900 mb-2">1. Penggunaan Aplikasi</h5>
                            <ul class="list-disc list-inside text-gray-600 space-y-1 ml-2">
                                <li>SiDarku adalah platform kesehatan untuk membantu remaja putri mengelola kesehatan mereka.</li>
                                <li>Aplikasi ini gratis dan dapat digunakan oleh remaja putri berusia minimal 10 tahun.</li>
                                <li>Pengguna bertanggung jawab untuk menjaga kerahasiaan akun mereka.</li>
                            </ul>
                        </div>

                        <div>
                            <h5 class="font-bold text-gray-900 mb-2">2. Data Pribadi & Privasi</h5>
                            <ul class="list-disc list-inside text-gray-600 space-y-1 ml-2">
                                <li>Kami menghormati privasi Anda dan melindungi data pribadi Anda.</li>
                                <li>Data yang dikumpulkan: nama, email, tanggal lahir, dan data kesehatan (TTD, siklus menstruasi).</li>
                                <li>Data Anda tidak akan dibagikan kepada pihak ketiga tanpa izin Anda.</li>
                                <li>Anda dapat menghapus akun dan data Anda kapan saja.</li>
                            </ul>
                        </div>

                        <div>
                            <h5 class="font-bold text-gray-900 mb-2">3. Informasi Kesehatan</h5>
                            <ul class="list-disc list-inside text-gray-600 space-y-1 ml-2">
                                <li>Informasi yang disediakan bersifat edukatif dan bukan pengganti konsultasi medis profesional.</li>
                                <li>Untuk masalah kesehatan serius, selalu konsultasikan dengan dokter atau tenaga medis.</li>
                                <li>Kami tidak bertanggung jawab atas keputusan kesehatan yang diambil berdasarkan informasi dari aplikasi.</li>
                            </ul>
                        </div>

                        <div>
                            <h5 class="font-bold text-gray-900 mb-2">4. Konten Pengguna</h5>
                            <ul class="list-disc list-inside text-gray-600 space-y-1 ml-2">
                                <li>Pengguna bertanggung jawab atas konten yang mereka masukkan (catatan, data kesehatan).</li>
                                <li>Kami berhak menghapus konten yang melanggar aturan atau tidak pantas.</li>
                            </ul>
                        </div>

                        <div>
                            <h5 class="font-bold text-gray-900 mb-2">5. Perubahan Layanan</h5>
                            <ul class="list-disc list-inside text-gray-600 space-y-1 ml-2">
                                <li>Kami berhak mengubah, menangguhkan, atau menghentikan layanan kapan saja.</li>
                                <li>Perubahan pada syarat & ketentuan akan diberitahukan kepada pengguna.</li>
                            </ul>
                        </div>

                        <div>
                            <h5 class="font-bold text-gray-900 mb-2">6. Batasan Tanggung Jawab</h5>
                            <ul class="list-disc list-inside text-gray-600 space-y-1 ml-2">
                                <li>Kami berusaha memberikan layanan terbaik, tetapi tidak menjamin aplikasi bebas dari error.</li>
                                <li>Kami tidak bertanggung jawab atas kerugian yang timbul dari penggunaan aplikasi.</li>
                            </ul>
                        </div>

                        <div class="bg-pink-50 border border-pink-200 rounded-xl p-4 mt-6">
                            <div class="flex items-start space-x-3">
                                <svg class="w-5 h-5 text-sidarku-primary flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                </svg>
                                <div>
                                    <p class="text-sm font-semibold text-gray-900 mb-1">Kontak Kami</p>
                                    <p class="text-sm text-gray-600">
                                        Jika ada pertanyaan tentang Syarat & Ketentuan ini, silakan hubungi kami di: 
                                        <a href="mailto:support@sidarku.id" class="text-sidarku-primary font-semibold">support@sidarku.id</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <p class="text-xs text-gray-500 mt-6 italic">
                        Terakhir diperbarui: {{ date('d F Y') }}
                    </p>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="sticky bottom-0 bg-white border-t border-gray-200 px-6 py-4 flex items-center justify-between">
                <button onclick="acceptTerms()" class="flex-1 bg-sidarku-primary hover:bg-sidarku-primary-dark text-white font-bold py-3 px-6 rounded-xl transition-all flex items-center justify-center space-x-2 mr-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <span>Saya Setuju</span>
                </button>
                <button onclick="closeTermsModal()" class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold py-3 px-6 rounded-xl transition-all">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    <script>
        function togglePassword(fieldId) {
            const passwordInput = document.getElementById(fieldId);
            const eyeIcon = document.getElementById(`eye-icon-${fieldId}`);
            const eyeOffIcon = document.getElementById(`eye-off-icon-${fieldId}`);
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.add('hidden');
                eyeOffIcon.classList.remove('hidden');
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.remove('hidden');
                eyeOffIcon.classList.add('hidden');
            }
        }

        function openTermsModal() {
            document.getElementById('termsModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeTermsModal() {
            document.getElementById('termsModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        function acceptTerms() {
            document.getElementById('terms').checked = true;
            closeTermsModal();
        }

        // Close modal when clicking outside
        document.getElementById('termsModal')?.addEventListener('click', function(e) {
            if (e.target === this) {
                closeTermsModal();
            }
        });

        // Close modal with ESC key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeTermsModal();
            }
        });

        // Password validation
        function validatePassword() {
            const passwordInput = document.getElementById('password');
            const passwordHint = document.getElementById('password-hint');
            const password = passwordInput.value;
            
            if (password.length > 0 && password.length < 8) {
                passwordInput.classList.add('border-red-300', 'bg-red-50');
                passwordInput.classList.remove('border-gray-300');
                passwordHint.classList.remove('text-gray-500');
                passwordHint.classList.add('text-red-600', 'font-medium');
                passwordHint.innerHTML = '<svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" /></svg>Password harus minimal 8 karakter. Saat ini: ' + password.length + ' karakter';
            } else if (password.length >= 8) {
                passwordInput.classList.remove('border-red-300', 'bg-red-50');
                passwordInput.classList.add('border-green-300', 'bg-green-50');
                passwordHint.classList.remove('text-red-600');
                passwordHint.classList.add('text-green-600', 'font-medium');
                passwordHint.innerHTML = '<svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg>Password valid (' + password.length + ' karakter)';
            } else {
                passwordInput.classList.remove('border-red-300', 'bg-red-50', 'border-green-300', 'bg-green-50');
                passwordInput.classList.add('border-gray-300');
                passwordHint.classList.remove('text-red-600', 'text-green-600', 'font-medium');
                passwordHint.classList.add('text-gray-500');
                passwordHint.textContent = 'Password harus minimal 8 karakter';
            }
        }

        // Validate individual field
        function validateField(fieldName) {
            const field = document.getElementById(fieldName);
            const value = field.value.trim();
            
            if (fieldName === 'email') {
                // Validate email format
                const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!value) {
                    field.classList.add('border-red-300', 'bg-red-50');
                    field.classList.remove('border-gray-300', 'border-green-300', 'bg-green-50');
                } else if (!emailPattern.test(value)) {
                    field.classList.add('border-red-300', 'bg-red-50');
                    field.classList.remove('border-gray-300', 'border-green-300', 'bg-green-50');
                } else {
                    field.classList.remove('border-red-300', 'bg-red-50');
                    field.classList.add('border-green-300', 'bg-green-50');
                }
            } else {
                if (!value) {
                    field.classList.add('border-red-300', 'bg-red-50');
                    field.classList.remove('border-gray-300', 'border-green-300', 'bg-green-50');
                } else {
                    field.classList.remove('border-red-300', 'bg-red-50');
                    field.classList.add('border-green-300', 'bg-green-50');
                }
            }
        }

        // Validate password confirmation
        function validatePasswordConfirmation() {
            const password = document.getElementById('password').value;
            const passwordConfirmation = document.getElementById('password_confirmation');
            const confirmValue = passwordConfirmation.value;
            
            if (confirmValue.length > 0) {
                if (confirmValue !== password) {
                    passwordConfirmation.classList.add('border-red-300', 'bg-red-50');
                    passwordConfirmation.classList.remove('border-gray-300');
                } else {
                    passwordConfirmation.classList.remove('border-red-300', 'bg-red-50');
                    passwordConfirmation.classList.add('border-green-300', 'bg-green-50');
                }
            } else {
                passwordConfirmation.classList.remove('border-red-300', 'bg-red-50', 'border-green-300', 'bg-green-50');
                passwordConfirmation.classList.add('border-gray-300');
            }
        }

        // Validate terms checkbox
        function validateTerms() {
            const termsCheckbox = document.getElementById('terms');
            if (!termsCheckbox.checked) {
                termsCheckbox.classList.add('border-red-300');
            } else {
                termsCheckbox.classList.remove('border-red-300');
            }
        }

        // Validate all fields on form submit
        document.querySelector('form').addEventListener('submit', function(e) {
            let hasError = false;
            
            // Validate name
            const nameInput = document.getElementById('name');
            if (!nameInput.value.trim()) {
                nameInput.classList.add('border-red-300', 'bg-red-50');
                nameInput.focus();
                hasError = true;
            }
            
            // Validate email
            const emailInput = document.getElementById('email');
            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailInput.value.trim()) {
                emailInput.classList.add('border-red-300', 'bg-red-50');
                if (!hasError) {
                    emailInput.focus();
                    hasError = true;
                }
            } else if (!emailPattern.test(emailInput.value.trim())) {
                emailInput.classList.add('border-red-300', 'bg-red-50');
                if (!hasError) {
                    emailInput.focus();
                    hasError = true;
                }
            }
            
            // Validate date of birth
            const dobInput = document.getElementById('date_of_birth');
            if (!dobInput.value) {
                dobInput.classList.add('border-red-300', 'bg-red-50');
                if (!hasError) {
                    dobInput.focus();
                    hasError = true;
                }
            }
            
            // Validate password
            const passwordInput = document.getElementById('password');
            if (!passwordInput.value || passwordInput.value.length < 8) {
                passwordInput.classList.add('border-red-300', 'bg-red-50');
                validatePassword();
                if (!hasError) {
                    passwordInput.focus();
                    hasError = true;
                }
            }
            
            // Validate password confirmation
            const passwordConfirmation = document.getElementById('password_confirmation');
            if (!passwordConfirmation.value || passwordConfirmation.value !== passwordInput.value) {
                passwordConfirmation.classList.add('border-red-300', 'bg-red-50');
                if (!hasError) {
                    passwordConfirmation.focus();
                    hasError = true;
                }
            }
            
            // Validate terms
            const termsCheckbox = document.getElementById('terms');
            if (!termsCheckbox.checked) {
                termsCheckbox.classList.add('border-red-300');
                if (!hasError) {
                    termsCheckbox.focus();
                    hasError = true;
                }
            }
            
            if (hasError) {
                e.preventDefault();
                
                // Create or show error notification
                let errorNotification = document.getElementById('client-error-notification');
                if (!errorNotification) {
                    errorNotification = document.createElement('div');
                    errorNotification.id = 'client-error-notification';
                    errorNotification.className = 'mb-6 bg-red-50 border border-red-200 rounded-xl p-4';
                    errorNotification.innerHTML = `
                        <div class="flex items-start space-x-3">
                            <svg class="w-5 h-5 text-red-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                            </svg>
                            <div class="flex-1">
                                <p class="text-sm font-semibold text-red-800 mb-2">Mohon lengkapi semua field yang wajib diisi!</p>
                                <ul class="list-disc list-inside space-y-1 text-sm text-red-700" id="client-error-list"></ul>
                            </div>
                        </div>
                    `;
                    const form = document.querySelector('form');
                    form.parentNode.insertBefore(errorNotification, form);
                }
                
                // Build error list
                const errorList = document.getElementById('client-error-list');
                errorList.innerHTML = '';
                
                if (!nameInput.value.trim()) {
                    errorList.innerHTML += '<li>Nama lengkap wajib diisi</li>';
                }
                
                const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailInput.value.trim()) {
                    errorList.innerHTML += '<li>Email wajib diisi</li>';
                } else if (!emailPattern.test(emailInput.value.trim())) {
                    errorList.innerHTML += '<li>Format email tidak valid</li>';
                }
                
                if (!dobInput.value) {
                    errorList.innerHTML += '<li>Tanggal lahir wajib diisi</li>';
                }
                
                if (!passwordInput.value || passwordInput.value.length < 8) {
                    errorList.innerHTML += '<li>Password harus minimal 8 karakter</li>';
                }
                
                if (!passwordConfirmation.value || passwordConfirmation.value !== passwordInput.value) {
                    errorList.innerHTML += '<li>Konfirmasi password tidak sesuai atau kosong</li>';
                }
                
                if (!termsCheckbox.checked) {
                    errorList.innerHTML += '<li>Anda harus menyetujui Syarat & Ketentuan</li>';
                }
                
                // Scroll to error notification
                errorNotification.scrollIntoView({ behavior: 'smooth', block: 'center' });
                
                // Show notification with animation
                errorNotification.style.opacity = '0';
                errorNotification.style.transform = 'translateY(-10px)';
                setTimeout(() => {
                    errorNotification.style.transition = 'all 0.3s ease';
                    errorNotification.style.opacity = '1';
                    errorNotification.style.transform = 'translateY(0)';
                }, 10);
                
                return false;
            }
        });
    </script>
</body>
</html>
