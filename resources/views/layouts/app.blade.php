<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
    @livewireStyles
</head>
<body class="bg-gray-50 min-h-screen flex flex-col">
    <!-- Top Navigation (Desktop/Tablet) -->
    <nav class="hidden md:block bg-white border-b border-gray-200 sticky top-0 z-50 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            <div class="flex items-center justify-between h-14">
                <!-- Logo -->
                <a href="{{ route('home') }}" class="flex items-center space-x-2">
                    <img src="{{ asset('images/icon.png') }}" alt="SiDarku Logo" class="w-7 h-7 object-contain">
                    <h1 class="text-lg font-semibold text-gradient-sidarku">SiDarku</h1>
                </a>

                <!-- Navigation Links -->
                <div class="flex items-center space-x-1">
                    <a href="{{ route('home') }}" class="px-3 py-1.5 rounded-lg font-medium transition-colors text-sm {{ request()->routeIs('home') ? 'bg-pink-50 text-sidarku-primary' : 'text-gray-600 hover:bg-gray-50' }}">
                        <div class="flex items-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                            <span>Home</span>
                        </div>
                    </a>
                    <a href="{{ route('progress') }}" class="px-3 py-1.5 rounded-lg font-medium transition-colors text-sm {{ request()->routeIs('progress') ? 'bg-pink-50 text-sidarku-primary' : 'text-gray-600 hover:bg-gray-50' }}">
                        <div class="flex items-center space-x-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                            <span>Progress</span>
                        </div>
                    </a>
                    <a href="{{ route('cycle') }}" class="px-3 py-1.5 rounded-lg font-medium transition-colors text-sm {{ request()->routeIs('cycle') ? 'bg-pink-50 text-sidarku-primary' : 'text-gray-600 hover:bg-gray-50' }}">
                        <div class="flex items-center space-x-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span>Siklus</span>
                        </div>
                    </a>
                    <a href="{{ route('education') }}" class="px-3 py-1.5 rounded-lg font-medium transition-colors text-sm {{ request()->routeIs('education') ? 'bg-pink-50 text-sidarku-primary' : 'text-gray-600 hover:bg-gray-50' }}">
                        <div class="flex items-center space-x-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                            <span>Edukasi</span>
                        </div>
                    </a>
                </div>

                <!-- Right Section: Profile Dropdown -->
                <div class="flex items-center relative" x-data="{ open: false }" @click.away="open = false">
                    <button @click="open = !open" class="flex items-center space-x-2 px-2 py-1.5 rounded-lg hover:bg-gray-50 transition-colors">
                        <img src="{{ asset('images/default-profile.png') }}" alt="Profile" class="w-6 h-6 sm:w-7 sm:h-7 rounded-full object-cover border-2 border-pink-200">
                        <span class="text-xs sm:text-sm font-medium text-gray-700 hidden lg:block">{{ auth()->user()->name }}</span>
                        <svg class="w-3 h-3 sm:w-4 sm:h-4 text-gray-500 transition-transform" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    
                    <!-- Dropdown Menu -->
                    <div x-show="open" 
                         x-transition:enter="transition ease-out duration-100"
                         x-transition:enter-start="transform opacity-0 scale-95"
                         x-transition:enter-end="transform opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="transform opacity-100 scale-100"
                         x-transition:leave-end="transform opacity-0 scale-95"
                         class="absolute right-0 top-full mt-2 w-44 sm:w-48 bg-white rounded-lg shadow-lg border border-gray-200 py-1 z-50"
                         style="display: none;">
                        <div class="px-3 sm:px-4 py-1.5 sm:py-2 border-b border-gray-100">
                            <p class="text-xs sm:text-sm font-medium text-gray-900 truncate">{{ auth()->user()->name }}</p>
                            <p class="text-[10px] sm:text-xs text-gray-500 truncate">{{ auth()->user()->email }}</p>
                        </div>
                        <a href="{{ route('profile') }}" class="flex items-center space-x-2 px-3 sm:px-4 py-2 text-xs sm:text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                            <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            <span>Profil Saya</span>
                        </a>
                        <hr class="my-1 border-gray-100">
                        <button onclick="showLogoutModal()" class="w-full flex items-center space-x-2 px-3 sm:px-4 py-2 text-xs sm:text-sm text-red-600 hover:bg-red-50 transition-colors">
                            <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            <span>Keluar</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Mobile Header -->
    <header class="md:hidden bg-white border-b border-gray-100 px-3 py-2.5 sticky top-0 z-50 shadow-sm">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-2">
                <img src="{{ asset('images/icon.png') }}" alt="SiDarku Logo" class="w-6 h-6 object-contain">
                <h1 class="text-base font-semibold text-gradient-sidarku">SiDarku</h1>
            </div>
            
            <!-- Mobile Profile Dropdown -->
            <div x-data="{ open: false }" @click.away="open = false" class="relative">
                <button @click="open = !open" class="w-7 h-7 rounded-full overflow-hidden border-2 border-pink-200">
                    <img src="{{ asset('images/default-profile.png') }}" alt="Profile" class="w-full h-full object-cover">
                </button>
                
                <!-- Mobile Dropdown Menu -->
                <div x-show="open" 
                     x-transition:enter="transition ease-out duration-100"
                     x-transition:enter-start="transform opacity-0 scale-95"
                     x-transition:enter-end="transform opacity-100 scale-100"
                     x-transition:leave="transition ease-in duration-75"
                     x-transition:leave-start="transform opacity-100 scale-100"
                     x-transition:leave-end="transform opacity-0 scale-95"
                     class="absolute right-0 mt-2 w-44 bg-white rounded-lg shadow-lg border border-gray-200 py-1 z-50"
                     style="display: none;">
                        <div class="px-3 py-1.5 border-b border-gray-100">
                        <p class="text-xs font-medium text-gray-900 truncate">{{ auth()->user()->name }}</p>
                        <p class="text-[10px] text-gray-500 truncate">{{ auth()->user()->email }}</p>
                    </div>
                    <a href="{{ route('profile') }}" class="flex items-center space-x-2 px-3 py-2 text-xs text-gray-700 hover:bg-gray-50 transition-colors">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        <span>Profil Saya</span>
                    </a>
                    <hr class="my-1 border-gray-100">
                    <button onclick="showLogoutModal()" class="w-full flex items-center space-x-2 px-3 py-2 text-xs text-red-600 hover:bg-red-50 transition-colors">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        <span>Keluar</span>
                    </button>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content (Full Width) -->
    <main class="flex-1 pb-20 md:pb-6">
        @if (session('message'))
            <div class="max-w-7xl mx-auto px-6 pt-6">
                <div class="p-4 bg-green-50 border border-green-200 rounded-xl text-green-700 flex items-center space-x-3">
                    <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    <span>{{ session('message') }}</span>
                </div>
            </div>
        @endif

        @if ($errors->any())
            <div class="max-w-7xl mx-auto px-6 pt-6">
                <div class="p-4 bg-red-50 border border-red-200 rounded-xl text-red-700">
                    <div class="flex items-start space-x-3">
                        <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        @yield('content')
        @if(isset($slot))
        {{ $slot }}
        @endif
    </main>

        <!-- Footer -->
    <footer class="hidden md:block bg-white border-t border-gray-200 w-full">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 py-4">
                <div class="flex flex-col md:flex-row justify-between items-center space-y-3 md:space-y-0">
                    <!-- Brand -->
                    <div class="flex items-center space-x-2">
                        <img src="{{ asset('images/icon.png') }}" alt="SiDarku Logo" class="w-6 h-6 object-contain">
                        <h3 class="text-sm font-semibold text-gradient-sidarku">SiDarku</h3>
                    </div>

                    <!-- Links -->
                    <div class="flex flex-wrap items-center justify-center gap-x-4 gap-y-1 text-xs">
                        <a href="#" class="text-gray-600 hover:text-sidarku-primary transition-colors font-medium">Tentang Kami</a>
                        <a href="#" class="text-gray-600 hover:text-sidarku-primary transition-colors font-medium">FAQ</a>
                        <a href="#" class="text-gray-600 hover:text-sidarku-primary transition-colors font-medium">Syarat & Ketentuan</a>
                        <a href="#" class="text-gray-600 hover:text-sidarku-primary transition-colors font-medium">Kebijakan Privasi</a>
                    </div>

                    <!-- Copyright -->
                    <div class="flex flex-col items-center md:items-end">
                        <p class="text-[10px] text-gray-500">© {{ date('Y') }} SiDarku. All rights reserved</p>
                    </div>
                </div>
            </div>
        </footer>
    </main>

    <!-- Bottom Navigation (Mobile Only) -->
    <nav class="md:hidden fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 shadow-lg z-50">
        <div class="flex justify-around items-center h-14 px-1">
            <a href="{{ route('home') }}" class="flex flex-col items-center justify-center flex-1 h-full {{ request()->routeIs('home') ? 'text-sidarku-primary' : 'text-gray-400' }}">
                <svg class="w-5 h-5 mb-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                <span class="text-xs font-medium">Home</span>
            </a>
            <a href="{{ route('progress') }}" class="flex flex-col items-center justify-center flex-1 h-full {{ request()->routeIs('progress') ? 'text-sidarku-primary' : 'text-gray-400' }}">
                <svg class="w-5 h-5 mb-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                </svg>
                <span class="text-xs font-medium">Progress</span>
            </a>
            <a href="{{ route('cycle') }}" class="flex flex-col items-center justify-center flex-1 h-full {{ request()->routeIs('cycle') ? 'text-sidarku-primary' : 'text-gray-400' }}">
                <svg class="w-5 h-5 mb-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <span class="text-xs font-medium">Siklus</span>
            </a>
            <a href="{{ route('education') }}" class="flex flex-col items-center justify-center flex-1 h-full {{ request()->routeIs('education') ? 'text-sidarku-primary' : 'text-gray-400' }}">
                <svg class="w-5 h-5 mb-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
                <span class="text-xs font-medium">Edukasi</span>
            </a>
            <a href="{{ route('profile') }}" class="flex flex-col items-center justify-center flex-1 h-full {{ request()->routeIs('profile') ? 'text-sidarku-primary' : 'text-gray-400' }}">
                <svg class="w-5 h-5 mb-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                <span class="text-xs font-medium">Profil</span>
            </a>
        </div>
    </nav>

    <!-- Logout Confirmation Modal -->
    <div id="logoutModal" class="fixed inset-0 backdrop-blur-sm bg-white/30 z-50 hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-xl max-w-xs w-full p-5 shadow-xl border border-gray-200 transform transition-all" onclick="event.stopPropagation()">
            <div class="flex items-center space-x-3 mb-4">
                <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-red-100">
                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                </div>
                <div class="flex-1">
                    <h3 class="text-base font-semibold text-gray-900">Keluar dari Akun?</h3>
                    <p class="text-gray-600 text-xs mt-0.5">Yakin ingin keluar?</p>
                </div>
            </div>
            
            <div class="flex space-x-2">
                <button onclick="hideLogoutModal()" class="flex-1 px-3 py-2 border border-gray-300 text-gray-700 text-sm font-semibold rounded-lg hover:bg-gray-50 transition-colors">
                    Batal
                </button>
                <form method="POST" action="{{ route('logout') }}" class="flex-1">
                    @csrf
                    <button type="submit" class="w-full px-3 py-2 bg-red-600 text-white text-sm font-semibold rounded-lg hover:bg-red-700 transition-colors">
                        Ya, Keluar
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function showLogoutModal() {
            document.getElementById('logoutModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }
        
        function hideLogoutModal() {
            document.getElementById('logoutModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }
        
        // Close modal when clicking outside
        document.getElementById('logoutModal')?.addEventListener('click', function(e) {
            if (e.target === this) {
                hideLogoutModal();
            }
        });
        
        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                hideLogoutModal();
            }
        });
    </script>

    @livewireScripts
</body>
</html>
