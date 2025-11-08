@extends('admin.layout')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div class="space-y-4">
    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-3">
        <!-- Total Users -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-3">
            <div class="flex items-center justify-between mb-2">
                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
            </div>
            <h3 class="text-xs font-medium text-gray-600 mb-1">Total Users</h3>
            <p class="text-xl font-semibold text-gray-900">{{ $totalUsers > 0 ? number_format($totalUsers) : '0' }}</p>
        </div>

        <!-- Total Educations -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-3">
            <div class="flex items-center justify-between mb-2">
                <div class="w-10 h-10 bg-pink-100 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                </div>
            </div>
            <h3 class="text-xs font-medium text-gray-600 mb-1">Total Artikel</h3>
            <p class="text-xl font-semibold text-gray-900">{{ $totalEducations > 0 ? number_format($totalEducations) : '0' }}</p>
        </div>

        <!-- Total Check-ins -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-3">
            <div class="flex items-center justify-between mb-2">
                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <h3 class="text-xs font-medium text-gray-600 mb-1">Total Check-ins</h3>
            <p class="text-xl font-semibold text-gray-900">{{ $totalCheckins > 0 ? number_format($totalCheckins) : '0' }}</p>
        </div>

        <!-- Total Cycles -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-3">
            <div class="flex items-center justify-between mb-2">
                <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
            </div>
            <h3 class="text-xs font-medium text-gray-600 mb-1">Total Siklus</h3>
            <p class="text-xl font-semibold text-gray-900">{{ $totalCycles > 0 ? number_format($totalCycles) : '0' }}</p>
        </div>
    </div>

    <!-- Additional Stats -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-3">
        <!-- Active Users -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-3">
            <div class="flex items-center justify-between mb-2">
                <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
            </div>
            <h3 class="text-xs font-medium text-gray-600 mb-1">Active Users (30 hari)</h3>
            <p class="text-xl font-semibold text-gray-900">{{ $activeUsers > 0 ? number_format($activeUsers) : '0' }}</p>
        </div>

        <!-- Today Check-ins -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-3">
            <div class="flex items-center justify-between mb-2">
                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
            </div>
            <h3 class="text-xs font-medium text-gray-600 mb-1">Check-ins Hari Ini</h3>
            <p class="text-xl font-semibold text-gray-900">{{ $todayCheckins > 0 ? number_format($todayCheckins) : '0' }}</p>
        </div>

        <!-- This Month Check-ins -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-3">
            <div class="flex items-center justify-between mb-2">
                <div class="w-10 h-10 bg-indigo-100 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                </div>
            </div>
            <h3 class="text-xs font-medium text-gray-600 mb-1">Check-ins Bulan Ini</h3>
            <p class="text-xl font-semibold text-gray-900">{{ $thisMonthCheckins > 0 ? number_format($thisMonthCheckins) : '0' }}</p>
        </div>

        <!-- This Month Users -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-3">
            <div class="flex items-center justify-between mb-2">
                <div class="w-10 h-10 bg-teal-100 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                    </svg>
                </div>
            </div>
            <h3 class="text-xs font-medium text-gray-600 mb-1">User Baru Bulan Ini</h3>
            <p class="text-xl font-semibold text-gray-900">{{ $thisMonthUsers > 0 ? number_format($thisMonthUsers) : '0' }}</p>
        </div>
    </div>

    <!-- Chart & Quick Stats -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
        <!-- User Registration Chart -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
            <h3 class="text-sm font-semibold text-gray-900 mb-3">Registrasi User (6 Bulan)</h3>
            <div class="h-48">
                <canvas id="userRegistrationChart"></canvas>
            </div>
        </div>

        <!-- Top Categories -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
            <h3 class="text-sm font-semibold text-gray-900 mb-3">Kategori Populer</h3>
            <div class="space-y-2">
                @forelse($topCategories as $category)
                    <div class="flex items-center justify-between p-2 rounded-lg bg-gray-50">
                        <div class="flex items-center space-x-2">
                            <span class="text-xs font-semibold text-gray-900">{{ $category->category }}</span>
                        </div>
                        <span class="text-xs font-semibold text-pink-600">{{ $category->count }} artikel</span>
                    </div>
                @empty
                    <p class="text-xs text-gray-500 text-center py-3">Belum ada kategori</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Recent Users & Check-ins -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
        <!-- Recent Users -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
            <div class="flex items-center justify-between mb-3">
                <h3 class="text-sm font-semibold text-gray-900">User Terbaru</h3>
                <a href="{{ route('admin.users') }}" class="text-xs text-sidarku-primary hover:text-sidarku-primary-dark transition-colors">
                    Lihat Semua →
                </a>
            </div>
            <div class="space-y-2">
                @forelse($recentUsers as $user)
                    <div class="flex items-center space-x-2 p-2 rounded-lg hover:bg-gray-50 transition-colors">
                        <div class="w-8 h-8 bg-pink-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs font-semibold text-gray-900 truncate">{{ $user->name }}</p>
                            <p class="text-[10px] text-gray-500 truncate">{{ $user->email }}</p>
                        </div>
                        <span class="text-[10px] text-gray-500">{{ $user->created_at->diffForHumans() }}</span>
                    </div>
                @empty
                    <p class="text-xs text-gray-500 text-center py-3">Belum ada user</p>
                @endforelse
            </div>
        </div>

        <!-- Recent Check-ins -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
            <div class="flex items-center justify-between mb-3">
                <h3 class="text-sm font-semibold text-gray-900">Check-ins Terbaru</h3>
                <a href="{{ route('admin.analytics') }}" class="text-xs text-sidarku-primary hover:text-sidarku-primary-dark transition-colors">
                    Lihat Semua →
                </a>
            </div>
            <div class="space-y-2">
                @forelse($recentCheckins as $checkin)
                    <div class="flex items-center space-x-2 p-2 rounded-lg hover:bg-gray-50 transition-colors">
                        <div class="w-8 h-8 {{ $checkin->is_consumed ? 'bg-green-100' : 'bg-gray-100' }} rounded-lg flex items-center justify-center flex-shrink-0">
                            @if($checkin->is_consumed)
                                <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                            @else
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs font-semibold text-gray-900 truncate">{{ $checkin->user->name ?? 'Unknown' }}</p>
                            <p class="text-[10px] text-gray-500">{{ \Carbon\Carbon::parse($checkin->log_date)->format('d M Y') }}</p>
                        </div>
                        <span class="text-[10px] {{ $checkin->is_consumed ? 'text-green-600' : 'text-gray-400' }}">
                            {{ $checkin->is_consumed ? '✓' : '✗' }}
                        </span>
                    </div>
                @empty
                    <p class="text-xs text-gray-500 text-center py-3">Belum ada check-in</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // User Registration Chart
    const userRegistrationCtx = document.getElementById('userRegistrationChart').getContext('2d');
    new Chart(userRegistrationCtx, {
        type: 'line',
        data: {
            labels: @json($userRegistrationLabels),
            datasets: [{
                label: 'Registrasi User',
                data: @json($userRegistrationData),
                borderColor: 'rgb(236, 72, 153)',
                backgroundColor: 'rgba(236, 72, 153, 0.1)',
                tension: 0.4,
                fill: true,
                pointRadius: 3,
                pointHoverRadius: 5
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });
});
</script>
@endsection

