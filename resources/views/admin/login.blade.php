<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - SiDarku</title>
    
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
    <div class="min-h-screen flex items-center justify-center px-4 py-12">
        <div class="max-w-md w-full">
            <!-- Logo & Header -->
            <div class="text-center mb-8">
                <div class="flex items-center justify-center space-x-2 mb-3">
                    <img src="{{ asset('images/icon.png') }}" alt="SiDarku Logo" class="w-10 h-10 object-contain">
                    <h1 class="text-2xl font-semibold text-gradient-sidarku">SiDarku</h1>
                </div>
                <h2 class="text-xl font-semibold text-gray-900 mb-2">Admin Panel</h2>
                <p class="text-sm text-gray-600">Masuk ke panel administrasi</p>
            </div>

            <!-- Login Form -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                @if ($errors->any())
                    <div class="mb-4 p-3 bg-red-50 border border-red-200 rounded-lg">
                        <ul class="text-sm text-red-700 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-4 p-3 bg-red-50 border border-red-200 rounded-lg text-sm text-red-700">
                        {{ session('error') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.login') }}" class="space-y-4">
                    @csrf

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-1.5">
                            Email
                        </label>
                        <input 
                            type="email" 
                            id="email"
                            name="email"
                            value="{{ old('email') }}"
                            required
                            autofocus
                            class="w-full px-3 py-2.5 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent transition-all"
                            placeholder="admin@sidarku.com">
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-semibold text-gray-700 mb-1.5">
                            Password
                        </label>
                        <input 
                            type="password" 
                            id="password"
                            name="password"
                            required
                            class="w-full px-3 py-2.5 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent transition-all"
                            placeholder="••••••••">
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center">
                        <input 
                            type="checkbox" 
                            id="remember"
                            name="remember"
                            class="w-4 h-4 border-gray-300 rounded focus:ring-2 focus:ring-pink-500"
                            style="color: #ff79b8;">
                        <label for="remember" class="ml-2 text-sm text-gray-600">
                            Ingat saya
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <button 
                        type="submit"
                        class="w-full text-white font-semibold py-2.5 px-4 rounded-lg hover:shadow-lg transform hover:scale-[1.02] transition-all duration-200 text-sm"
                        style="background: linear-gradient(135deg, #ff79b8 0%, #feb4c8 100%);">
                        Masuk
                    </button>
                </form>
            </div>

            <!-- Footer -->
            <div class="mt-6 text-center">
                <a href="{{ route('login') }}" class="text-sm text-gray-600 hover:text-sidarku-primary transition-colors">
                    ← Kembali ke Login User
                </a>
            </div>
        </div>
    </div>
</body>
</html>

