@extends('admin.layout')

@section('title', 'Analytics')
@section('page-title', 'Analytics')

@section('content')
<div class="space-y-4">
    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-3">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-3">
            <h3 class="text-xs font-medium text-gray-600 mb-1">Total Users</h3>
            <p class="text-xl font-semibold text-gray-900">{{ $totalUsers > 0 ? number_format($totalUsers) : '0' }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-3">
            <h3 class="text-xs font-medium text-gray-600 mb-1">Active Users (30 hari)</h3>
            <p class="text-xl font-semibold text-gray-900">{{ $activeUsers > 0 ? number_format($activeUsers) : '0' }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-3">
            <h3 class="text-xs font-medium text-gray-600 mb-1">Total Check-ins</h3>
            <p class="text-xl font-semibold text-gray-900">{{ $totalCheckins > 0 ? number_format($totalCheckins) : '0' }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-3">
            <h3 class="text-xs font-medium text-gray-600 mb-1">Total Siklus</h3>
            <p class="text-xl font-semibold text-gray-900">{{ $totalCycles > 0 ? number_format($totalCycles) : '0' }}</p>
        </div>
    </div>

    <!-- Charts Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
        <!-- Chart 1: User Registration per Bulan -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
            <h3 class="text-sm font-semibold text-gray-900 mb-3">Registrasi User per Bulan</h3>
            <div class="h-64">
                <canvas id="userRegistrationChart"></canvas>
            </div>
        </div>

        <!-- Chart 2: Check-ins per Bulan -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
            <h3 class="text-sm font-semibold text-gray-900 mb-3">Check-ins per Bulan</h3>
            <div class="h-64">
                <canvas id="checkinsChart"></canvas>
            </div>
        </div>

        <!-- Chart 3: Cycles per Bulan -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
            <h3 class="text-sm font-semibold text-gray-900 mb-3">Siklus per Bulan</h3>
            <div class="h-64">
                <canvas id="cyclesChart"></canvas>
            </div>
        </div>

        <!-- Chart 4: Check-ins per Hari (30 hari terakhir) -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
            <h3 class="text-sm font-semibold text-gray-900 mb-3">Check-ins per Hari (30 hari terakhir)</h3>
            <div class="h-64">
                <canvas id="dailyCheckinsChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Top Users -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
        <h3 class="text-sm font-semibold text-gray-900 mb-3">Top 10 Users (Check-ins)</h3>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-3 py-2 text-left text-xs font-semibold text-gray-700 uppercase">Rank</th>
                        <th class="px-3 py-2 text-left text-xs font-semibold text-gray-700 uppercase">User</th>
                        <th class="px-3 py-2 text-left text-xs font-semibold text-gray-700 uppercase">Total Check-ins</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($topUsers as $index => $user)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-3 py-2 whitespace-nowrap">
                                <span class="text-xs font-semibold text-gray-900">#{{ $index + 1 }}</span>
                            </td>
                            <td class="px-3 py-2 whitespace-nowrap">
                                <div class="flex items-center space-x-2">
                                    <div class="w-7 h-7 bg-pink-100 rounded-lg flex items-center justify-center">
                                        <svg class="w-3.5 h-3.5 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-xs font-semibold text-gray-900">{{ $user->name }}</p>
                                        <p class="text-[10px] text-gray-500">{{ $user->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-3 py-2 whitespace-nowrap">
                                <span class="text-xs font-semibold text-gray-900">{{ $user->ttd_logs_count }}</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-3 py-6 text-center text-xs text-gray-500">
                                Tidak ada data
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Chart 1: User Registration per Bulan
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
                fill: true
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

    // Chart 2: Check-ins per Bulan
    const checkinsCtx = document.getElementById('checkinsChart').getContext('2d');
    new Chart(checkinsCtx, {
        type: 'line',
        data: {
            labels: @json($checkinsLabels),
            datasets: [{
                label: 'Check-ins',
                data: @json($checkinsData),
                borderColor: 'rgb(34, 197, 94)',
                backgroundColor: 'rgba(34, 197, 94, 0.1)',
                tension: 0.4,
                fill: true
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

    // Chart 3: Cycles per Bulan
    const cyclesCtx = document.getElementById('cyclesChart').getContext('2d');
    new Chart(cyclesCtx, {
        type: 'line',
        data: {
            labels: @json($cyclesLabels),
            datasets: [{
                label: 'Siklus',
                data: @json($cyclesData),
                borderColor: 'rgb(168, 85, 247)',
                backgroundColor: 'rgba(168, 85, 247, 0.1)',
                tension: 0.4,
                fill: true
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

    // Chart 4: Check-ins per Hari (30 hari terakhir)
    const dailyCheckinsCtx = document.getElementById('dailyCheckinsChart').getContext('2d');
    new Chart(dailyCheckinsCtx, {
        type: 'bar',
        data: {
            labels: @json($dailyLabels),
            datasets: [{
                label: 'Check-ins',
                data: @json($dailyData),
                backgroundColor: 'rgba(236, 72, 153, 0.6)',
                borderColor: 'rgb(236, 72, 153)',
                borderWidth: 1
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
                },
                x: {
                    ticks: {
                        maxRotation: 45,
                        minRotation: 45
                    }
                }
            }
        }
    });
});
</script>
@endsection

