@extends('admin.layout')

@section('title', 'Detail User')
@section('page-title', 'Detail User')

@section('content')
<div class="space-y-4">
    <!-- Back Button -->
    <div>
        <a href="{{ route('admin.users') }}" class="inline-flex items-center space-x-2 text-xs text-gray-600 hover:text-sidarku-primary transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            <span>Kembali ke Daftar User</span>
        </a>
    </div>

    <!-- User Info -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
        <div class="flex items-center space-x-3 mb-4">
            <div class="w-12 h-12 bg-pink-100 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
            </div>
            <div>
                <h2 class="text-base font-semibold text-gray-900">{{ $user->name }}</h2>
                <p class="text-xs text-gray-600">{{ $user->email }}</p>
            </div>
        </div>

        <!-- Stats -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-4">
            <div class="bg-gray-50 rounded-lg p-3">
                <p class="text-[10px] text-gray-600 mb-1">Total Check-ins</p>
                <p class="text-lg font-semibold text-gray-900">{{ $stats['total_checkins'] }}</p>
            </div>
            <div class="bg-gray-50 rounded-lg p-3">
                <p class="text-[10px] text-gray-600 mb-1">Total Siklus</p>
                <p class="text-lg font-semibold text-gray-900">{{ $stats['total_cycles'] }}</p>
            </div>
            <div class="bg-gray-50 rounded-lg p-3">
                <p class="text-[10px] text-gray-600 mb-1">Current Streak</p>
                <p class="text-lg font-semibold text-gray-900">{{ $stats['current_streak'] }} hari</p>
            </div>
            <div class="bg-gray-50 rounded-lg p-3">
                <p class="text-[10px] text-gray-600 mb-1">Compliance Rate</p>
                <p class="text-lg font-semibold text-gray-900">{{ $stats['compliance_rate'] }}%</p>
            </div>
        </div>

        <!-- User Details -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
            <div>
                <p class="text-[10px] text-gray-600 mb-1">Tanggal Lahir</p>
                <p class="text-xs font-semibold text-gray-900">
                    {{ $user->date_of_birth ? \Carbon\Carbon::parse($user->date_of_birth)->format('d M Y') : '-' }}
                </p>
            </div>
            <div>
                <p class="text-[10px] text-gray-600 mb-1">Telepon</p>
                <p class="text-xs font-semibold text-gray-900">{{ $user->phone ?? '-' }}</p>
            </div>
            <div>
                <p class="text-[10px] text-gray-600 mb-1">Pekerjaan</p>
                <p class="text-xs font-semibold text-gray-900">{{ $user->occupation ?? '-' }}</p>
            </div>
            <div>
                <p class="text-[10px] text-gray-600 mb-1">Terdaftar</p>
                <p class="text-xs font-semibold text-gray-900">{{ $user->created_at->format('d M Y H:i') }}</p>
            </div>
        </div>
    </div>

    <!-- Recent Check-ins -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
        <h3 class="text-sm font-semibold text-gray-900 mb-3">Check-in Terbaru</h3>
        <div class="space-y-2">
            @forelse($checkins as $checkin)
                <div class="flex items-center justify-between p-2 rounded-lg hover:bg-gray-50 transition-colors">
                    <div class="flex items-center space-x-2">
                        <div class="w-8 h-8 {{ $checkin->is_consumed ? 'bg-green-100' : 'bg-gray-100' }} rounded-lg flex items-center justify-center">
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
                        <div>
                            <p class="text-xs font-semibold text-gray-900">
                                {{ \Carbon\Carbon::parse($checkin->log_date)->format('d M Y') }}
                            </p>
                            <p class="text-[10px] text-gray-500">
                                {{ $checkin->is_consumed ? 'Sudah minum TTD' : 'Belum minum TTD' }}
                            </p>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-xs text-gray-500 text-center py-3">Belum ada check-in</p>
            @endforelse
        </div>
    </div>

    <!-- Recent Cycles -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
        <h3 class="text-sm font-semibold text-gray-900 mb-3">Siklus Terbaru</h3>
        <div class="space-y-2">
            @forelse($cycles as $cycle)
                <div class="flex items-center justify-between p-2 rounded-lg hover:bg-gray-50 transition-colors">
                    <div class="flex items-center space-x-2">
                        <div class="w-8 h-8 bg-pink-100 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-gray-900">
                                {{ \Carbon\Carbon::parse($cycle->start_date)->format('d M Y') }}
                                @if($cycle->end_date)
                                    - {{ \Carbon\Carbon::parse($cycle->end_date)->format('d M Y') }}
                                @else
                                    (Sedang berlangsung)
                                @endif
                            </p>
                            <p class="text-[10px] text-gray-500">
                                @if($cycle->end_date)
                                    {{ \Carbon\Carbon::parse($cycle->start_date)->diffInDays(\Carbon\Carbon::parse($cycle->end_date)) }} hari
                                @else
                                    {{ \Carbon\Carbon::parse($cycle->start_date)->diffInDays(now()) }} hari
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-xs text-gray-500 text-center py-3">Belum ada siklus</p>
            @endforelse
        </div>
    </div>
</div>
@endsection

