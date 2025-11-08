<div class="min-h-screen bg-gray-50 flex flex-col">
    <!-- Header Section -->
    <div class="bg-white border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 py-3 sm:py-4">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-xl font-semibold text-gray-900">
                        Hai, {{ auth()->user()->name }}! 👋
                    </h1>
                    <p class="text-sm text-gray-600 mt-1">{{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM YYYY') }}</p>
                </div>
                <a href="{{ route('checkin') }}" class="hidden sm:flex items-center space-x-2 text-white px-4 py-2.5 rounded-lg font-semibold transition-all shadow-sm hover:shadow text-sm" style="background: linear-gradient(90deg, #ff79b8 0%, #feb4c8 100%);">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    <span>Check-in TTD</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Main Content - Balanced -->
    <div class="flex-1 max-w-7xl mx-auto w-full px-4 sm:px-6 py-3 sm:py-4 pb-8">
        <!-- Stats Cards Grid - Balanced Size -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 mb-4 sm:mb-5">
            <!-- TTD Status Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-3 sm:p-4 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between mb-2 sm:mb-3">
                    <div class="w-9 h-9 sm:w-10 sm:h-10 bg-pink-100 rounded-lg flex items-center justify-center">
                        @if($todayConsumed)
                            <svg class="w-4 h-4 sm:w-5 sm:h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        @else
                            <svg class="w-4 h-4 sm:w-5 sm:h-5 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        @endif
                    </div>
                    @if($todayConsumed)
                        <span class="bg-green-100 text-green-800 text-xs font-semibold px-2 py-1 rounded-full">Selesai</span>
                    @else
                        <span class="bg-yellow-100 text-yellow-800 text-xs font-semibold px-2 py-1 rounded-full">Pending</span>
                    @endif
                </div>
                <h3 class="text-gray-600 text-xs sm:text-sm font-medium mb-1">TTD Hari Ini</h3>
                <p class="text-base sm:text-lg font-semibold text-gray-900">
                    @if($todayConsumed) Sudah ✓ @else Belum @endif
                </p>
            </div>

            <!-- Cycle Status Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-3 sm:p-4 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between mb-2 sm:mb-3">
                    <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-lg flex items-center justify-center
                        {{ $cycleStatus === 'haid' ? 'bg-red-100' : ($cycleStatus === 'prahaid' ? 'bg-orange-100' : 'bg-blue-100') }}">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 
                            {{ $cycleStatus === 'haid' ? 'text-red-600' : ($cycleStatus === 'prahaid' ? 'text-orange-600' : 'text-blue-600') }}" 
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <span class="
                        {{ $cycleStatus === 'haid' ? 'bg-red-100 text-red-800' : ($cycleStatus === 'prahaid' ? 'bg-orange-100 text-orange-800' : 'bg-blue-100 text-blue-800') }}
                        text-xs font-semibold px-2 py-1 rounded-full capitalize">
                        {{ $cycleStatus === 'haid' ? 'Haid' : ($cycleStatus === 'prahaid' ? 'PMS' : 'Normal') }}
                    </span>
                </div>
                <h3 class="text-gray-600 text-xs sm:text-sm font-medium mb-1">Status Siklus</h3>
                <p class="text-base sm:text-lg font-semibold text-gray-900">
                    @if($currentCycleDay) Hari {{ $currentCycleDay }} @else - @endif
                </p>
            </div>

            <!-- Next Period Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-3 sm:p-4 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between mb-2 sm:mb-3">
                    <div class="w-9 h-9 sm:w-10 sm:h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                    </div>
                </div>
                <h3 class="text-gray-600 text-xs sm:text-sm font-medium mb-1">Prediksi Haid</h3>
                <p class="text-sm sm:text-base font-semibold text-gray-900 truncate">
                    @if($nextPeriodPrediction) {{ \Carbon\Carbon::parse($nextPeriodPrediction)->diffForHumans(null, true) }}
                    @else Belum ada @endif
                </p>
            </div>

            <!-- Streak Card -->
            <div class="rounded-xl shadow-sm p-3 sm:p-4 text-white hover:shadow-md transition-shadow" style="background: linear-gradient(135deg, #ff79b8 0%, #feb4c8 100%);">
                <div class="flex items-center justify-between mb-2 sm:mb-3">
                    <div class="w-9 h-9 sm:w-10 sm:h-10 bg-white/20 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                </div>
                <h3 class="text-white/90 text-xs sm:text-sm font-medium mb-1">Streak</h3>
                <p class="text-lg sm:text-xl font-semibold">
                    @if($currentStreak > 0)
                        {{ $currentStreak }} hari
                    @else
                        0 hari
                    @endif
                </p>
            </div>
        </div>

        <!-- Main Grid: Responsive Layout -->
        <div class="space-y-4">
            <!-- Tips & Progress Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-5">
                <!-- Tips Card -->
                <div class="rounded-xl shadow-lg p-5 text-white" style="background: linear-gradient(135deg, #ff79b8 0%, #feb4c8 100%);">
                    <!-- Header - Paling Atas -->
                    <div class="flex items-center space-x-2 mb-4">
                        <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="font-semibold text-base">Tips Hari Ini</h3>
                    </div>
                    
                    <!-- Content - Tengah -->
                    <p class="text-white text-base sm:text-lg leading-relaxed mb-4">
                        {{ $dailyTip }}
                    </p>
                    
                    <!-- Footer - Paling Bawah -->
                    <div>
                        <a href="{{ route('education') }}" class="inline-flex items-center text-sm sm:text-base font-semibold text-white hover:text-white/90 transition-colors">
                            Pelajari Lebih
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Weekly Progress - Right Column -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
                    <h3 class="text-sm font-semibold text-gray-900 mb-3">Progress Minggu Ini</h3>
                    <div class="space-y-2">
                        <div class="grid grid-cols-7 gap-1.5">
                            @foreach($weeklyProgress as $day)
                                <div class="flex flex-col items-center">
                                    <span class="text-xs text-gray-600 mb-1">{{ $day['day'] }}</span>
                                    <div class="w-8 h-8 rounded-lg flex items-center justify-center {{ $day['consumed'] ? 'bg-green-100 text-green-600' : 'bg-gray-100 text-gray-400' }}">
                                        @if($day['consumed'])
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                        @else
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="mt-3 pt-3 border-t border-gray-200">
                        <div class="flex items-center justify-between mb-1.5">
                            <span class="text-xs text-gray-600">Compliance Rate</span>
                            <span class="text-sm font-semibold text-gray-900">{{ $weeklyCompliance }}%</span>
                        </div>
                        <div class="h-2 bg-gray-200 rounded-full overflow-hidden">
                            <div class="h-full rounded-full transition-all" style="width: {{ $weeklyCompliance }}%; background: linear-gradient(90deg, #ff79b8 0%, #feb4c8 100%);"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Visualisasi Siklus & Statistik - Side by Side -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-5">
                <!-- Cycle Visualization -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-sm font-semibold text-gray-900">Visualisasi Siklus</h3>
                        <a href="{{ route('cycle') }}" class="text-xs font-semibold text-sidarku-primary hover:text-sidarku-primary-dark">
                            Detail →
                        </a>
                    </div>
                    
                    <!-- Cycle Progress Bar -->
                    <div class="space-y-3">
                        <div class="flex items-center space-x-2">
                            <div class="flex-1">
                                <div class="flex items-center justify-between mb-1.5">
                                    <span class="text-sm font-medium text-gray-700">Fase Haid</span>
                                    <span class="text-xs text-gray-500">Hari 1-7</span>
                                </div>
                                <div class="h-2 bg-gray-200 rounded-full overflow-hidden">
                                    <div class="h-full rounded-full transition-all {{ $cycleStatus === 'haid' ? 'bg-red-500' : 'bg-gray-300' }}" 
                                         style="width: {{ $cycleStatus === 'haid' ? '100' : '0' }}%"></div>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center space-x-2">
                            <div class="flex-1">
                                <div class="flex items-center justify-between mb-1.5">
                                    <span class="text-sm font-medium text-gray-700">Fase PMS</span>
                                    <span class="text-xs text-gray-500">Hari 21-28</span>
                                </div>
                                <div class="h-2 bg-gray-200 rounded-full overflow-hidden">
                                    <div class="h-full rounded-full transition-all {{ $cycleStatus === 'prahaid' ? 'bg-orange-500' : 'bg-gray-300' }}" 
                                         style="width: {{ $cycleStatus === 'prahaid' ? '100' : '0' }}%"></div>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center space-x-2">
                            <div class="flex-1">
                                <div class="flex items-center justify-between mb-1.5">
                                    <span class="text-sm font-medium text-gray-700">Fase Normal</span>
                                    <span class="text-xs text-gray-500">Hari 8-20</span>
                                </div>
                                <div class="h-2 bg-gray-200 rounded-full overflow-hidden">
                                    <div class="h-full rounded-full transition-all {{ $cycleStatus === 'nonhaid' ? 'bg-blue-500' : 'bg-gray-300' }}" 
                                         style="width: {{ $cycleStatus === 'nonhaid' ? '100' : '0' }}%"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($nextPeriodPrediction)
                        <div class="mt-4 pt-4 border-t border-gray-200">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-2">
                                    <div class="w-9 h-9 bg-pink-100 rounded-lg flex items-center justify-center">
                                        <svg class="w-4 h-4 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                        </svg>
                                    </div>
<div>
                                        <p class="text-sm font-medium text-gray-900">Prediksi Haid Berikutnya</p>
                                        <p class="text-xs text-gray-600">{{ \Carbon\Carbon::parse($nextPeriodPrediction)->format('d M Y') }}</p>
                                    </div>
                                </div>
                                <span class="bg-pink-100 text-pink-800 text-sm font-semibold px-3 py-1.5 rounded-lg">
                                    {{ \Carbon\Carbon::parse($nextPeriodPrediction)->diffForHumans(null, true) }}
                                </span>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Quick Stats - Sejajar dengan Cycle Visualization -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 sm:p-5">
                    <h3 class="text-base font-semibold text-gray-900 mb-4">Statistik Bulan Ini</h3>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between p-3 rounded-lg hover:bg-gray-50 transition-colors">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" />
                                        <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <span class="text-sm font-medium text-gray-700">Check-in</span>
                            </div>
                            <span class="text-lg font-semibold text-gray-900">{{ $monthlyCheckIns }}</span>
                        </div>

                        <div class="border-t border-gray-100"></div>

                        <div class="flex items-center justify-between p-3 rounded-lg hover:bg-gray-50 transition-colors">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-pink-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <svg class="w-5 h-5 text-pink-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <span class="text-sm font-medium text-gray-700">Streak Max</span>
                            </div>
                            <span class="text-lg font-semibold text-gray-900">
                                @if($maxStreak > 0)
                                    {{ $maxStreak }} hari
                                @else
                                    0 hari
                                @endif
                            </span>
                        </div>

                        <div class="border-t border-gray-100"></div>

                        <div class="flex items-center justify-between p-3 rounded-lg hover:bg-gray-50 transition-colors">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <svg class="w-5 h-5 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z" />
                                    </svg>
                                </div>
                                <span class="text-sm font-medium text-gray-700">Siklus</span>
                            </div>
                            <span class="text-lg font-semibold text-gray-900">{{ \App\Models\Cycle::where('user_id', auth()->id())->count() }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mobile FAB -->
        <div class="md:hidden fixed bottom-16 right-4 z-40">
            <a href="{{ route('checkin') }}" class="w-12 h-12 bg-sidarku-primary rounded-full shadow-lg flex items-center justify-center text-white hover:bg-sidarku-primary-dark transition-all transform hover:scale-110">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
            </a>
        </div>
    </div>
</div>
