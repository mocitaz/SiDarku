@extends('admin.layout')

@section('title', 'TTD Reminder Logs')
@section('page-title', 'TTD Reminder Logs')

@section('content')
<div class="space-y-4">
    <!-- Reminder Status Card -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-3 mb-4">
        <div class="flex items-center justify-between mb-2">
            <div class="flex items-center space-x-2.5">
                <div class="w-8 h-8 bg-gradient-to-br from-pink-500 to-purple-500 rounded-lg flex items-center justify-center flex-shrink-0">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-xs font-semibold text-gray-900">Status Reminder Email TTD</h3>
                    <p class="text-[10px] text-gray-500 mt-0.5">Otomatis 2x seminggu (<span class="font-medium">Senin & Kamis</span>) pukul <span class="font-medium text-pink-600">12:00 WIB</span></p>
                </div>
            </div>
            <div class="flex items-center space-x-2">
                <div class="flex items-center space-x-1.5 text-[10px] text-gray-600">
                    <div class="w-1.5 h-1.5 bg-green-500 rounded-full animate-pulse"></div>
                    <span>Aktif</span>
                    <span class="text-gray-400">•</span>
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span><span id="auto-refresh-timer" class="font-medium">30</span>s</span>
                </div>
                <button 
                    type="button"
                    onclick="refreshStatus()"
                    id="refreshStatusBtn"
                    class="px-2.5 py-1 text-[10px] font-medium text-white bg-gradient-to-r from-pink-500 to-purple-500 hover:from-pink-600 hover:to-purple-600 rounded transition-all flex items-center space-x-1">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                    <span>Refresh</span>
                </button>
            </div>
        </div>

        <!-- Status Notification -->
        @if(session('reminder_status'))
            @php
                $status = session('reminder_status');
                $bgColor = 'bg-blue-50';
                $borderColor = 'border-blue-200';
                $textColor = 'text-blue-800';
                $iconColor = 'text-blue-600';
                
                if (isset($status['error'])) {
                    $bgColor = 'bg-red-50';
                    $borderColor = 'border-red-200';
                    $textColor = 'text-red-800';
                    $iconColor = 'text-red-600';
                } elseif (isset($status['triggered'])) {
                    $bgColor = 'bg-green-50';
                    $borderColor = 'border-green-200';
                    $textColor = 'text-green-800';
                    $iconColor = 'text-green-600';
                } elseif ($status['already_sent']) {
                    $bgColor = 'bg-green-50';
                    $borderColor = 'border-green-200';
                    $textColor = 'text-green-800';
                    $iconColor = 'text-green-600';
                } elseif ($status['is_time_to_send']) {
                    $bgColor = 'bg-yellow-50';
                    $borderColor = 'border-yellow-200';
                    $textColor = 'text-yellow-800';
                    $iconColor = 'text-yellow-600';
                }
            @endphp
            <div class="{{ $bgColor }} border {{ $borderColor }} rounded-lg p-2.5">
                <div class="flex items-start justify-between gap-2.5">
                    <div class="flex items-start space-x-2 flex-1">
                        <div class="flex-shrink-0 mt-0.5">
                            @if(isset($status['error']))
                                <svg class="w-3.5 h-3.5 {{ $iconColor }}" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                </svg>
                            @elseif(isset($status['triggered']))
                                <svg class="w-3.5 h-3.5 {{ $iconColor }}" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                            @else
                                <svg class="w-3.5 h-3.5 {{ $iconColor }}" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                </svg>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs font-medium {{ $textColor }} mb-1.5">{{ $status['message'] ?? 'Status reminder' }}</p>
                            
                            <!-- Countdown Timer -->
                            @if(isset($status['countdown']) && $status['countdown'] && isset($status['next_scheduled_datetime']))
                                <div class="mb-2 p-2 bg-white/80 rounded border {{ $borderColor }}">
                                    <p class="text-[10px] font-medium text-gray-600 mb-1.5 text-center">
                                        @if($status['already_sent'] ?? false)
                                            Countdown ke pengiriman berikutnya
                                        @else
                                            Countdown ke pengiriman berikutnya
                                        @endif
                                    </p>
                                    <div id="countdown-timer-session" class="flex items-center justify-center space-x-1 font-mono text-lg font-bold {{ $textColor }}">
                                        <span class="px-1.5 py-0.5 bg-white rounded border border-gray-200 min-w-[40px] text-center text-xs" id="countdown-hours-session">{{ $status['countdown']['hours'] }}</span>
                                        <span class="text-sm">:</span>
                                        <span class="px-1.5 py-0.5 bg-white rounded border border-gray-200 min-w-[40px] text-center text-xs" id="countdown-minutes-session">{{ $status['countdown']['minutes'] }}</span>
                                        <span class="text-sm">:</span>
                                        <span class="px-1.5 py-0.5 bg-white rounded border border-gray-200 min-w-[40px] text-center text-xs animate-pulse" id="countdown-seconds-session">{{ $status['countdown']['seconds'] }}</span>
                                    </div>
                                    <p class="text-[10px] text-gray-500 text-center mt-1">Jam:Menit:Detik</p>
                                    <input type="hidden" id="next-scheduled-datetime-session" value="{{ $status['next_scheduled_datetime'] }}">
                                </div>
                            @endif
                            
                            <!-- Status Info -->
                            <div class="space-y-1.5 text-xs {{ $textColor }}">
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-600">Waktu:</span>
                                    <span class="font-medium" id="current-time-session">{{ $status['current_time'] ?? '-' }} ({{ $status['timezone'] ?? 'WIB' }})</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-600">Jadwal:</span>
                                    <span class="font-medium">{{ $status['scheduled_time'] ?? '12:00' }} WIB</span>
                                </div>
                                @if($status['already_sent'] ?? false)
                                    <div class="flex items-center justify-between pt-1 border-t {{ $borderColor }}">
                                        <span class="text-gray-600">Status:</span>
                                        <span class="px-2 py-0.5 text-[10px] font-medium text-green-700 bg-green-100 rounded-full">Terkirim</span>
                                    </div>
                                    <div class="flex items-center justify-between text-xs">
                                        <span class="text-gray-600">Total:</span>
                                        <span class="font-medium">{{ $status['today_sent'] ?? 0 }} email</span>
                                    </div>
                                    @if($status['last_sent_at'] ?? null)
                                        <div class="flex items-center justify-between text-xs">
                                            <span class="text-gray-600">Terakhir:</span>
                                            <span class="font-medium">{{ $status['last_sent_at'] }}</span>
                                        </div>
                                    @endif
                                @elseif($status['is_time_to_send'] ?? false)
                                    <div class="flex items-center justify-between pt-1 border-t {{ $borderColor }}">
                                        <span class="text-gray-600">Status:</span>
                                        <span class="px-2 py-0.5 text-[10px] font-medium text-yellow-700 bg-yellow-100 rounded-full animate-pulse">Memproses</span>
                                    </div>
                                @else
                                    <div class="flex items-center justify-between pt-1 border-t {{ $borderColor }}">
                                        <span class="text-gray-600">Status:</span>
                                        <span class="px-2 py-0.5 text-[10px] font-medium text-blue-700 bg-blue-100 rounded-full">Menunggu</span>
                                    </div>
                                @endif
                                @if(isset($status['today_sent']) || isset($status['today_skipped']) || isset($status['today_disabled']))
                                    <div class="pt-1.5 border-t {{ $borderColor }}">
                                        <div class="flex items-center flex-wrap gap-2 text-xs">
                                            @if($status['today_sent'] ?? 0)
                                                <div class="flex items-center space-x-1">
                                                    <svg class="w-3 h-3 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                    </svg>
                                                    <span class="text-gray-600">Terkirim:</span>
                                                    <span class="font-semibold text-green-600">{{ $status['today_sent'] }}</span>
                                                </div>
                                            @endif
                                            @if($status['today_skipped'] ?? 0)
                                                <div class="flex items-center space-x-1">
                                                    <svg class="w-3 h-3 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                                    </svg>
                                                    <span class="text-gray-600">Dilewati:</span>
                                                    <span class="font-semibold text-yellow-600">{{ $status['today_skipped'] }}</span>
                                                </div>
                                            @endif
                                            @if($status['today_disabled'] ?? 0)
                                                <div class="flex items-center space-x-1">
                                                    <svg class="w-3 h-3 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                                    </svg>
                                                    <span class="text-gray-600">Dinonaktifkan:</span>
                                                    <span class="font-semibold text-red-600">{{ $status['today_disabled'] }}</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @elseif(isset($reminderStatus))
            @php
                $status = $reminderStatus;
                $bgColor = 'bg-blue-50';
                $borderColor = 'border-blue-200';
                $textColor = 'text-blue-800';
                $iconColor = 'text-blue-600';
                
                if ($status['already_sent']) {
                    $bgColor = 'bg-green-50';
                    $borderColor = 'border-green-200';
                    $textColor = 'text-green-800';
                    $iconColor = 'text-green-600';
                } elseif ($status['is_time_to_send']) {
                    $bgColor = 'bg-yellow-50';
                    $borderColor = 'border-yellow-200';
                    $textColor = 'text-yellow-800';
                    $iconColor = 'text-yellow-600';
                }
            @endphp
            <div class="{{ $bgColor }} border {{ $borderColor }} rounded-lg p-2.5">
                <div class="flex items-start justify-between gap-2.5">
                    <div class="flex items-start space-x-2 flex-1">
                        <div class="flex-shrink-0 mt-0.5">
                            <svg class="w-3.5 h-3.5 {{ $iconColor }}" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs font-medium {{ $textColor }} mb-1.5">{{ $status['message'] ?? 'Status reminder' }}</p>
                            
                            <!-- Countdown Timer -->
                            @if(isset($status['countdown']) && $status['countdown'] && isset($status['next_scheduled_datetime']))
                                <div class="mb-2 p-2 bg-white/80 rounded border {{ $borderColor }}">
                                    <p class="text-[10px] font-medium text-gray-600 mb-1.5 text-center">
                                        @if($status['already_sent'] ?? false)
                                            Countdown ke pengiriman berikutnya
                                        @else
                                            Countdown ke pengiriman berikutnya
                                        @endif
                                    </p>
                                    <div id="countdown-timer-status" class="flex items-center justify-center space-x-1 font-mono text-lg font-bold {{ $textColor }}">
                                        <span class="px-1.5 py-0.5 bg-white rounded border border-gray-200 min-w-[40px] text-center text-xs" id="countdown-hours-status">{{ $status['countdown']['hours'] }}</span>
                                        <span class="text-sm">:</span>
                                        <span class="px-1.5 py-0.5 bg-white rounded border border-gray-200 min-w-[40px] text-center text-xs" id="countdown-minutes-status">{{ $status['countdown']['minutes'] }}</span>
                                        <span class="text-sm">:</span>
                                        <span class="px-1.5 py-0.5 bg-white rounded border border-gray-200 min-w-[40px] text-center text-xs animate-pulse" id="countdown-seconds-status">{{ $status['countdown']['seconds'] }}</span>
                                    </div>
                                    <p class="text-[10px] text-gray-500 text-center mt-1">Jam:Menit:Detik</p>
                                    <input type="hidden" id="next-scheduled-datetime-status" value="{{ $status['next_scheduled_datetime'] }}">
                                </div>
                            @endif
                            
                            <!-- Status Info -->
                            <div class="space-y-1.5 text-xs {{ $textColor }}">
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-600">Waktu:</span>
                                    <span class="font-medium" id="current-time-status">{{ $status['current_time'] ?? '-' }} ({{ $status['timezone'] ?? 'WIB' }})</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-600">Jadwal:</span>
                                    <span class="font-medium">{{ $status['scheduled_time'] ?? '12:00' }} WIB</span>
                                </div>
                                @if($status['already_sent'] ?? false)
                                    <div class="flex items-center justify-between pt-1 border-t {{ $borderColor }}">
                                        <span class="text-gray-600">Status:</span>
                                        <span class="px-2 py-0.5 text-[10px] font-medium text-green-700 bg-green-100 rounded-full">Terkirim</span>
                                    </div>
                                    <div class="flex items-center justify-between text-xs">
                                        <span class="text-gray-600">Total:</span>
                                        <span class="font-medium">{{ $status['today_sent'] ?? 0 }} email</span>
                                    </div>
                                    @if($status['last_sent_at'] ?? null)
                                        <div class="flex items-center justify-between text-xs">
                                            <span class="text-gray-600">Terakhir:</span>
                                            <span class="font-medium">{{ $status['last_sent_at'] }}</span>
                                        </div>
                                    @endif
                                @elseif($status['is_time_to_send'] ?? false)
                                    <div class="flex items-center justify-between pt-1 border-t {{ $borderColor }}">
                                        <span class="text-gray-600">Status:</span>
                                        <span class="px-2 py-0.5 text-[10px] font-medium text-yellow-700 bg-yellow-100 rounded-full animate-pulse">Memproses</span>
                                    </div>
                                @else
                                    <div class="flex items-center justify-between pt-1 border-t {{ $borderColor }}">
                                        <span class="text-gray-600">Status:</span>
                                        <span class="px-2 py-0.5 text-[10px] font-medium text-blue-700 bg-blue-100 rounded-full">Menunggu</span>
                                    </div>
                                @endif
                                @if(isset($status['today_sent']) || isset($status['today_skipped']) || isset($status['today_disabled']))
                                    <div class="pt-1.5 border-t {{ $borderColor }}">
                                        <div class="flex items-center flex-wrap gap-2 text-xs">
                                            @if($status['today_sent'] ?? 0)
                                                <div class="flex items-center space-x-1">
                                                    <svg class="w-3 h-3 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                    </svg>
                                                    <span class="text-gray-600">Terkirim:</span>
                                                    <span class="font-semibold text-green-600">{{ $status['today_sent'] }}</span>
                                                </div>
                                            @endif
                                            @if($status['today_skipped'] ?? 0)
                                                <div class="flex items-center space-x-1">
                                                    <svg class="w-3 h-3 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                                    </svg>
                                                    <span class="text-gray-600">Dilewati:</span>
                                                    <span class="font-semibold text-yellow-600">{{ $status['today_skipped'] }}</span>
                                                </div>
                                            @endif
                                            @if($status['today_disabled'] ?? 0)
                                                <div class="flex items-center space-x-1">
                                                    <svg class="w-3 h-3 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                                    </svg>
                                                    <span class="text-gray-600">Dinonaktifkan:</span>
                                                    <span class="font-semibold text-red-600">{{ $status['today_disabled'] }}</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Statistics -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-3 mb-4">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-3">
            <div class="flex items-center space-x-2 mb-1.5">
                <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0">
                    <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>
                <h3 class="text-xs font-medium text-gray-600">Total Terkirim</h3>
            </div>
            <p class="text-lg font-semibold text-gray-900 ml-10">{{ number_format($stats['total_sent']) }}</p>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-3">
            <div class="flex items-center space-x-2 mb-1.5">
                <div class="w-8 h-8 bg-yellow-100 rounded-lg flex items-center justify-center flex-shrink-0">
                    <svg class="w-4 h-4 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <h3 class="text-xs font-medium text-gray-600">Total Dilewati</h3>
            </div>
            <p class="text-lg font-semibold text-gray-900 ml-10">{{ number_format($stats['total_skipped']) }}</p>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-3">
            <div class="flex items-center space-x-2 mb-1.5">
                <div class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center flex-shrink-0">
                    <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                    </svg>
                </div>
                <h3 class="text-xs font-medium text-gray-600">Total Dinonaktifkan</h3>
            </div>
            <p class="text-lg font-semibold text-gray-900 ml-10">{{ number_format($stats['total_disabled']) }}</p>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-3">
            <div class="flex items-center space-x-2 mb-1.5">
                <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>
                <h3 class="text-xs font-medium text-gray-600">Hari Ini Terkirim</h3>
            </div>
            <p class="text-lg font-semibold text-gray-900 ml-10">{{ number_format($stats['today_sent']) }}</p>
        </div>

    </div>

    <!-- Users with Disabled Reminders -->
    @if($usersWithDisabledReminders->count() > 0)
    <div class="bg-white rounded-lg shadow-sm border border-orange-200 p-3 mb-4">
        <div class="flex items-center space-x-2 mb-3">
            <div class="w-8 h-8 bg-orange-100 rounded-lg flex items-center justify-center">
                <svg class="w-4 h-4 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                </svg>
            </div>
            <div>
                <h3 class="text-xs font-semibold text-gray-900">User yang Menonaktifkan Reminder</h3>
                <p class="text-xs text-gray-600">Total: {{ $usersWithDisabledReminders->count() }} user</p>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-2">
            @foreach($usersWithDisabledReminders as $user)
            <div class="flex items-center justify-between p-2 bg-orange-50 rounded-md border border-orange-100 hover:bg-orange-100 transition-colors">
                <div class="flex-1 min-w-0">
                    <p class="text-xs font-medium text-gray-900 truncate">{{ $user->name }}</p>
                    <p class="text-xs text-gray-600 truncate">{{ $user->email }}</p>
                </div>
                <span class="ml-2 px-2 py-0.5 text-xs font-medium text-orange-700 bg-orange-200 rounded-full flex-shrink-0">Dinonaktifkan</span>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Filters -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-3 mb-4">
        <form method="GET" action="{{ route('admin.ttd-reminder-logs') }}" class="flex flex-wrap items-end gap-3">
            <div class="flex-1 min-w-[200px]">
                <label class="block text-xs font-medium text-gray-700 mb-1">Cari User</label>
                <input 
                    type="text" 
                    name="search" 
                    value="{{ request('search') }}"
                    placeholder="Nama atau email..."
                    class="w-full px-3 py-1.5 text-xs border border-gray-200 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent transition-all">
            </div>
            <div class="min-w-[150px]">
                <label class="block text-xs font-medium text-gray-700 mb-1">Status</label>
                <select 
                    name="status" 
                    class="w-full px-3 py-1.5 text-xs border border-gray-200 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent transition-all">
                    <option value="">Semua Status</option>
                    <option value="sent" {{ request('status') == 'sent' ? 'selected' : '' }}>Terkirim</option>
                    <option value="skipped" {{ request('status') == 'skipped' ? 'selected' : '' }}>Dilewati</option>
                    <option value="disabled" {{ request('status') == 'disabled' ? 'selected' : '' }}>Dinonaktifkan</option>
                </select>
            </div>
            <div class="min-w-[150px]">
                <label class="block text-xs font-medium text-gray-700 mb-1">Tanggal</label>
                <input 
                    type="date" 
                    name="date" 
                    value="{{ request('date') }}"
                    class="w-full px-3 py-1.5 text-xs border border-gray-200 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent transition-all">
            </div>
            <div class="flex space-x-2">
                <button 
                    type="submit"
                    class="px-4 py-1.5 text-xs font-semibold text-white rounded-lg transition-all"
                    style="background: linear-gradient(135deg, #ff79b8 0%, #feb4c8 100%);">
                    Filter
                </button>
                @if(request('search') || request('status') || request('date'))
                <a href="{{ route('admin.ttd-reminder-logs') }}" class="px-4 py-1.5 text-xs font-semibold text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">
                    Reset
                </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Logs Table -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-3 py-2 border-b border-gray-200 bg-gray-50">
            <h3 class="text-xs font-semibold text-gray-900">Log Pengiriman Email Reminder</h3>
            <p class="text-[10px] text-gray-600 mt-0.5">Riwayat pengiriman email reminder TTD</p>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-3 py-2 text-left text-[10px] font-semibold text-gray-700 uppercase tracking-wider">Tanggal & Waktu</th>
                        <th class="px-3 py-2 text-left text-[10px] font-semibold text-gray-700 uppercase tracking-wider">User</th>
                        <th class="px-3 py-2 text-left text-[10px] font-semibold text-gray-700 uppercase tracking-wider">Email</th>
                        <th class="px-3 py-2 text-left text-[10px] font-semibold text-gray-700 uppercase tracking-wider">Status</th>
                        <th class="px-3 py-2 text-left text-[10px] font-semibold text-gray-700 uppercase tracking-wider">Tipe</th>
                        <th class="px-3 py-2 text-left text-[10px] font-semibold text-gray-700 uppercase tracking-wider">Alasan</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($logs as $log)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-3 py-2">
                                <p class="text-[10px] text-gray-900 font-medium">
                                    {{ \Carbon\Carbon::parse($log->reminder_date)->locale('id')->isoFormat('D MMM YYYY') }}
                                </p>
                                <p class="text-[10px] text-gray-500">
                                    {{ \Carbon\Carbon::parse($log->created_at)->setTimezone('Asia/Jakarta')->locale('id')->isoFormat('HH:mm:ss') }} WIB
                                </p>
                            </td>
                            <td class="px-3 py-2">
                                <p class="text-[10px] font-semibold text-gray-900">{{ $log->user_name }}</p>
                            </td>
                            <td class="px-3 py-2">
                                <p class="text-[10px] text-gray-600 break-all">{{ $log->user_email }}</p>
                            </td>
                            <td class="px-3 py-2">
                                @if($log->status == 'sent')
                                    <span class="inline-flex items-center px-2 py-0.5 text-[10px] font-medium text-green-700 bg-green-100 rounded-full">
                                        <svg class="w-2.5 h-2.5 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                        </svg>
                                        Terkirim
                                    </span>
                                @elseif($log->status == 'skipped')
                                    <span class="inline-flex items-center px-2 py-0.5 text-[10px] font-medium text-yellow-700 bg-yellow-100 rounded-full">
                                        <svg class="w-2.5 h-2.5 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                        Dilewati
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 text-[10px] font-medium text-red-700 bg-red-100 rounded-full">
                                        <svg class="w-2.5 h-2.5 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                        </svg>
                                        Dinonaktifkan
                                    </span>
                                @endif
                            </td>
                            <td class="px-3 py-2">
                                @if($log->is_intensive)
                                    <span class="px-2 py-0.5 text-[10px] font-medium text-pink-700 bg-pink-100 rounded-full">Intensive</span>
                                @else
                                    <span class="px-2 py-0.5 text-[10px] font-medium text-gray-700 bg-gray-100 rounded-full">Regular</span>
                                @endif
                            </td>
                            <td class="px-3 py-2">
                                <p class="text-[10px] text-gray-600 max-w-xs">{{ $log->reason ?? '-' }}</p>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-3 py-8 text-center">
                                <svg class="w-10 h-10 mx-auto text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <p class="text-xs font-medium text-gray-500">Tidak ada log ditemukan</p>
                                <p class="text-[10px] text-gray-400 mt-1">Log akan muncul setelah sistem mengirim email reminder</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($logs->hasPages())
        <div class="px-3 py-2 border-t border-gray-200">
            {{ $logs->links() }}
        </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    let autoRefreshTimer = 30; // seconds
    let countdownIntervals = {}; // Store intervals for each countdown
    let timeUpdateInterval = null;
    
    // Function to update current time display
    function updateCurrentTime() {
        // Get current time in WIB (UTC+7)
        const now = new Date();
        // Convert to WIB timezone (UTC+7)
        const wibOffset = 7 * 60; // 7 hours in minutes
        const utc = now.getTime() + (now.getTimezoneOffset() * 60000);
        const wibTime = new Date(utc + (wibOffset * 60000));
        
        const hours = String(wibTime.getHours()).padStart(2, '0');
        const minutes = String(wibTime.getMinutes()).padStart(2, '0');
        const seconds = String(wibTime.getSeconds()).padStart(2, '0');
        const timeString = `${hours}:${minutes}:${seconds} (WIB)`;
        
        // Update all current time elements
        const timeElements = ['current-time-session', 'current-time-status'];
        timeElements.forEach(id => {
            const el = document.getElementById(id);
            if (el) {
                el.textContent = timeString;
            }
        });
    }
    
    // Start updating current time every second
    updateCurrentTime();
    timeUpdateInterval = setInterval(updateCurrentTime, 1000);
    
    // Auto-refresh functionality
    function startAutoRefresh() {
        const timerElement = document.getElementById('auto-refresh-timer');
        
        // Update timer every second
        setInterval(function() {
            autoRefreshTimer--;
            if (timerElement) {
                timerElement.textContent = autoRefreshTimer;
            }
            
            if (autoRefreshTimer <= 0) {
                autoRefreshTimer = 30;
                refreshStatus();
            }
        }, 1000);
    }
    
    // Refresh status function
    window.refreshStatus = function() {
        autoRefreshTimer = 30; // Reset timer
        
        // Show loading state
        const btn = document.getElementById('refreshStatusBtn');
        if (btn) {
            const originalHTML = btn.innerHTML;
            btn.disabled = true;
            btn.innerHTML = '<svg class="animate-spin w-3 h-3" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Loading...';
            
            // Fetch new status
            fetch('{{ route("admin.ttd-reminder-logs.check-status") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                // Reload page to show updated status
                window.location.reload();
            })
            .catch(error => {
                console.error('Error refreshing status:', error);
                btn.disabled = false;
                btn.innerHTML = originalHTML;
            });
        }
    };
    
    // Function to setup countdown timer
    function setupCountdown(timerKey, datetimeId, hoursId, minutesId, secondsId) {
        const nextScheduledDatetime = document.getElementById(datetimeId);
        
        if (!nextScheduledDatetime) {
            return; // Element not found, skip setup
        }
        
        const scheduledTimeStr = nextScheduledDatetime.value;
        if (!scheduledTimeStr) {
            return; // No datetime value, skip setup
        }
        
        // Parse ISO 8601 datetime
        const scheduledTime = new Date(scheduledTimeStr);
        
        if (isNaN(scheduledTime.getTime())) {
            console.error('Invalid scheduled time:', scheduledTimeStr);
            return;
        }
        
        const hoursElement = document.getElementById(hoursId);
        const minutesElement = document.getElementById(minutesId);
        const secondsElement = document.getElementById(secondsId);
        
        if (!hoursElement || !minutesElement || !secondsElement) {
            return; // Countdown elements not found
        }
        
        // Clear existing interval for this timer if any
        if (countdownIntervals[timerKey]) {
            clearInterval(countdownIntervals[timerKey]);
            delete countdownIntervals[timerKey];
        }
        
        function updateCountdown() {
            const now = new Date();
            const diff = scheduledTime.getTime() - now.getTime();
            
            if (diff <= 0) {
                // Time has passed, clear interval and refresh status
                if (countdownIntervals[timerKey]) {
                    clearInterval(countdownIntervals[timerKey]);
                    delete countdownIntervals[timerKey];
                }
                setTimeout(function() {
                    refreshStatus();
                }, 1000);
                return;
            }
            
            const totalSeconds = Math.floor(diff / 1000);
            const hours = Math.floor(totalSeconds / 3600);
            const minutes = Math.floor((totalSeconds % 3600) / 60);
            const seconds = totalSeconds % 60;
            
            // Update elements
            if (hoursElement) hoursElement.textContent = String(hours).padStart(2, '0');
            if (minutesElement) minutesElement.textContent = String(minutes).padStart(2, '0');
            if (secondsElement) secondsElement.textContent = String(seconds).padStart(2, '0');
        }
        
        // Update immediately
        updateCountdown();
        
        // Update every second and store interval
        countdownIntervals[timerKey] = setInterval(updateCountdown, 1000);
    }
    
    // Setup countdown timers after DOM is fully ready
    // Use requestAnimationFrame to ensure DOM is ready
    requestAnimationFrame(function() {
        // Setup countdown for session status (from session flash)
        setupCountdown(
            'session',
            'next-scheduled-datetime-session',
            'countdown-hours-session',
            'countdown-minutes-session',
            'countdown-seconds-session'
        );
        
        // Setup countdown for initial status (from $reminderStatus)
        setupCountdown(
            'status',
            'next-scheduled-datetime-status',
            'countdown-hours-status',
            'countdown-minutes-status',
            'countdown-seconds-status'
        );
    });
    
    // Start auto-refresh timer
    startAutoRefresh();
    
    // Cleanup on page unload
    window.addEventListener('beforeunload', function() {
        // Clear all intervals
        Object.values(countdownIntervals).forEach(interval => {
            if (interval) clearInterval(interval);
        });
        if (timeUpdateInterval) clearInterval(timeUpdateInterval);
    });
});
</script>
@endpush
@endsection

