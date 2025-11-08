<div class="min-h-screen flex flex-col bg-gray-50">
    <!-- Header Section -->
    <div class="bg-white border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 py-3 sm:py-4">
            <h2 class="text-xl font-semibold text-gray-900">Progress Kepatuhan TTD</h2>
            <p class="text-gray-600 text-sm mt-1">Pantau konsistensi konsumsi TTD kamu</p>
        </div>
    </div>

    <!-- Main Content -->
    <div class="flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 py-3 sm:py-4 pb-8">

    <!-- Stats Grid -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 mb-4 sm:mb-5">
        <div class="bg-white rounded-xl p-3 sm:p-4 border border-gray-200 shadow-sm">
            <div class="flex items-center space-x-2 mb-2">
                <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background: linear-gradient(135deg, #ff79b8 0%, #feb4c8 100%);">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
                <h3 class="text-xs sm:text-sm font-semibold text-gray-700">Streak</h3>
            </div>
            <div class="text-lg sm:text-xl font-semibold text-gray-900">
                @if($currentStreak > 0)
                    {{ $currentStreak }} Hari
                @else
                    0 Hari
                @endif
            </div>
        </div>
        
        <div class="bg-white rounded-xl p-3 sm:p-4 border border-gray-200 shadow-sm">
            <div class="flex items-center space-x-2 mb-2">
                <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                </div>
                <h3 class="text-xs sm:text-sm font-semibold text-gray-700">Kepatuhan</h3>
            </div>
            <div class="text-lg sm:text-xl font-semibold text-gray-900 mb-2">{{ $complianceRate }}%</div>
            <div class="w-full h-2 bg-gray-200 rounded-full overflow-hidden">
                <div class="h-full rounded-full" style="width: {{ $complianceRate }}%; background: linear-gradient(90deg, #ff79b8 0%, #feb4c8 100%);"></div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl p-3 sm:p-4 border border-gray-200 shadow-sm">
            <div class="flex items-center space-x-2 mb-2">
                <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                    <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h3 class="text-xs sm:text-sm font-semibold text-gray-700">Bulan Ini</h3>
            </div>
            <div class="text-lg sm:text-xl font-semibold text-gray-900">
                {{ count($calendarData) }} Hari
            </div>
        </div>
        
        <div class="bg-white rounded-xl p-3 sm:p-4 border border-gray-200 shadow-sm">
            <div class="flex items-center space-x-2 mb-2">
                <div class="w-8 h-8 bg-yellow-100 rounded-lg flex items-center justify-center">
                    <svg class="w-4 h-4 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                    </svg>
                </div>
                <h3 class="text-xs sm:text-sm font-semibold text-gray-700">Rekor</h3>
            </div>
            <div class="text-lg sm:text-xl font-semibold text-gray-900">
                @if($longestStreak > 0)
                    {{ $longestStreak }} Hari
                @else
                    0 Hari
                @endif
            </div>
        </div>
    </div>

    <!-- Main Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-5">
        <!-- Calendar -->
        <div class="bg-white rounded-xl p-4 border border-gray-200 shadow-sm">
            <div class="flex justify-between items-center mb-3">
                <h3 class="text-sm sm:text-base font-semibold text-gray-900">
                    {{ \Carbon\Carbon::parse($currentMonth)->locale('id')->isoFormat('MMMM YYYY') }}
                </h3>
                <div class="flex space-x-1">
                    <button wire:click="changeMonth('prev')" class="w-7 h-7 flex items-center justify-center rounded-lg text-gray-600 hover:bg-gray-100 hover:text-sidarku-primary transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </button>
                    <button wire:click="changeMonth('next')" class="w-7 h-7 flex items-center justify-center rounded-lg text-gray-600 hover:bg-gray-100 hover:text-sidarku-primary transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                </div>
            </div>
            
            <div class="grid grid-cols-7 gap-1 text-center">
                <!-- Day names -->
                <div class="text-xs font-semibold text-gray-500 py-1.5">M</div>
                <div class="text-xs font-semibold text-gray-500 py-1.5">S</div>
                <div class="text-xs font-semibold text-gray-500 py-1.5">S</div>
                <div class="text-xs font-semibold text-gray-500 py-1.5">R</div>
                <div class="text-xs font-semibold text-gray-500 py-1.5">K</div>
                <div class="text-xs font-semibold text-gray-500 py-1.5">J</div>
                <div class="text-xs font-semibold text-gray-500 py-1.5">S</div>
                
                <!-- Calendar days -->
                @php
                    $startOfMonth = \Carbon\Carbon::parse($currentMonth)->startOfMonth();
                    $endOfMonth = \Carbon\Carbon::parse($currentMonth)->endOfMonth();
                    $startOfWeek = $startOfMonth->copy()->startOfWeek(\Carbon\Carbon::MONDAY);
                    $endOfWeek = $endOfMonth->copy()->endOfWeek(\Carbon\Carbon::MONDAY);
                    $currentDate = $startOfWeek->copy();
                @endphp
                
                @while($currentDate <= $endOfWeek)
                    @php
                        $dateStr = $currentDate->format('Y-m-d');
                        $isChecked = in_array($dateStr, $calendarData);
                        $isCurrentMonth = $currentDate->month == $startOfMonth->month;
                        $isToday = $currentDate->isToday();
                    @endphp
                    <div class="aspect-square flex items-center justify-center text-sm {{ !$isCurrentMonth ? 'text-gray-300' : 'text-gray-700' }} {{ $isChecked ? 'text-white font-semibold rounded-lg' : '' }} {{ $isToday && !$isChecked ? 'ring-2 ring-sidarku-primary rounded-lg' : '' }}" 
                         @if($isChecked) style="background: linear-gradient(135deg, #ff79b8 0%, #feb4c8 100%);" @endif>
                        {{ $currentDate->day }}
                    </div>
                    @php $currentDate->addDay(); @endphp
                @endwhile
            </div>
            
            <!-- Legend -->
            <div class="flex items-center justify-center space-x-4 mt-3 pt-3 border-t border-gray-100">
                <div class="flex items-center space-x-1.5">
                    <div class="w-3 h-3 rounded" style="background: linear-gradient(135deg, #ff79b8 0%, #feb4c8 100%);"></div>
                    <span class="text-xs text-gray-600">Sudah</span>
                </div>
                <div class="flex items-center space-x-1.5">
                    <div class="w-3 h-3 bg-gray-200 rounded"></div>
                    <span class="text-xs text-gray-600">Belum</span>
                </div>
            </div>
        </div>

        <!-- Chart -->
        <div class="bg-white rounded-xl p-4 border border-gray-200 shadow-sm flex flex-col">
            <div class="flex items-center justify-between mb-3">
                <h3 class="text-sm sm:text-base font-semibold text-gray-900">Grafik Mingguan</h3>
                <div class="flex items-center space-x-1 text-xs text-gray-500">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>Bulan ini</span>
                </div>
            </div>
            
            <div class="flex-1 flex items-end">
                <canvas id="progressChart" class="w-full" style="height: 280px;"></canvas>
            </div>
        </div>
    </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('progressChart');
        if (!ctx || typeof Chart === 'undefined') return;

        const chartData = @json($monthlyData);
        if (!chartData || chartData.length === 0) return;
        
        // Find max value for dynamic Y axis
        const maxCount = Math.max(...chartData.map(item => item.count), 2);
        
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: chartData.map(item => item.week),
                datasets: [{
                    label: 'Check-in TTD',
                    data: chartData.map(item => item.count),
                    backgroundColor: 'rgba(255, 121, 184, 0.7)',
                    borderColor: 'rgba(255, 121, 184, 1)',
                    borderWidth: 1,
                    borderRadius: 8,
                    barThickness: 40,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        padding: 12,
                        titleColor: '#fff',
                        bodyColor: '#fff',
                        displayColors: false,
                        callbacks: {
                            label: function(context) {
                                return context.parsed.y + ' kali check-in';
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        max: Math.max(maxCount + 1, 3),
                        ticks: {
                            stepSize: 1,
                            font: {
                                size: 11
                            },
                            callback: function(value) {
                                return value;
                            }
                        },
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)'
                        }
                    },
                    x: {
                        ticks: {
                            font: {
                                size: 11
                            }
                        },
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    });
</script>
