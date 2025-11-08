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
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-gray-50 min-h-screen">
    <div class="max-w-md md:max-w-none mx-auto bg-white md:bg-transparent min-h-screen md:min-h-0 shadow-lg md:shadow-none">
        <!-- Header with Typography Logo -->
        <header class="bg-white border-b border-gray-100 px-4 py-4 sticky top-0 z-10 md:hidden">
            <h1 class="text-2xl font-bold bg-gradient-to-r from-pink-400 to-pink-600 bg-clip-text text-transparent">
                SiDarku
            </h1>
        </header>

        <!-- Main Content -->
        <main class="pb-20 md:pb-6">
            @if (session('message'))
                <div class="mx-4 md:mx-0 mt-4 md:mt-0 p-3 bg-pink-50 border border-pink-200 rounded-xl text-pink-700 text-sm">
                    {{ session('message') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mx-4 md:mx-0 mt-4 md:mt-0 p-3 bg-red-50 border border-red-200 rounded-xl text-red-700 text-sm">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{ $slot }}
        </main>

        <!-- Bottom Navigation -->
        <nav class="fixed bottom-0 left-0 right-0 max-w-md md:hidden mx-auto bg-white border-t border-gray-100 shadow-lg">
            <div class="flex justify-around items-center h-16 px-2">
                <a href="{{ route('home') }}" class="flex flex-col items-center {{ request()->routeIs('home') ? 'text-pink-500' : 'text-gray-400' }}">
                    <span class="text-2xl mb-1">🏠</span>
                    <span class="text-xs font-medium">Home</span>
                </a>
                <a href="{{ route('progress') }}" class="flex flex-col items-center {{ request()->routeIs('progress') ? 'text-pink-500' : 'text-gray-400' }}">
                    <span class="text-2xl mb-1">📊</span>
                    <span class="text-xs font-medium">Progress</span>
                </a>
                <a href="{{ route('cycle') }}" class="flex flex-col items-center {{ request()->routeIs('cycle') ? 'text-pink-500' : 'text-gray-400' }}">
                    <span class="text-2xl mb-1">📅</span>
                    <span class="text-xs font-medium">Siklus</span>
                </a>
                <a href="{{ route('education') }}" class="flex flex-col items-center {{ request()->routeIs('education') ? 'text-pink-500' : 'text-gray-400' }}">
                    <span class="text-2xl mb-1">📖</span>
                    <span class="text-xs font-medium">Edukasi</span>
                </a>
                <a href="{{ route('profile') }}" class="flex flex-col items-center {{ request()->routeIs('profile') ? 'text-pink-500' : 'text-gray-400' }}">
                    <span class="text-2xl mb-1">👤</span>
                    <span class="text-xs font-medium">Profil</span>
                </a>
            </div>
        </nav>
</div>

    @livewireScripts
    @stack('scripts')
</body>
</html>
