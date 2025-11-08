<div class="min-h-screen bg-gray-50 pb-20">
    <style>
        input[type="date"]::-webkit-calendar-picker-indicator {
            cursor: pointer;
            filter: opacity(0.6);
        }
        input[type="date"]:hover::-webkit-calendar-picker-indicator {
            filter: opacity(1);
        }
    </style>
    
    <!-- Header Section -->
    <div class="bg-white border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 py-3 sm:py-4">
            <h2 class="text-xl font-semibold text-gray-900">Pelacakan Siklus Menstruasi</h2>
            <p class="text-gray-600 text-sm mt-1">Catat siklus menstruasimu untuk prediksi akurat</p>
        </div>
    </div>

    <!-- Main Content -->
    <div class="flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 py-3 sm:py-4 pb-8">
        @if (session()->has('message'))
            <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-xl text-green-700 flex items-center space-x-3">
                <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
                <span class="text-sm">{{ session('message') }}</span>
            </div>
        @endif

        <!-- Info Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-4">
            <!-- Current Cycle -->
            <div class="rounded-xl p-4 shadow-sm" style="background: linear-gradient(135deg, #ff79b8 0%, #feb4c8 100%);">
                <div class="flex items-center space-x-2 mb-3">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <h3 class="text-sm font-semibold text-white">Siklus Saat Ini</h3>
                </div>
                <div class="bg-white/10 rounded-lg p-3">
                    @if($currentCycle)
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs text-white/80">Mulai</p>
                                <p class="text-sm font-semibold text-white">
                                    {{ \Carbon\Carbon::parse($currentCycle['start_date'])->locale('id')->isoFormat('D MMM YYYY') }}
                                </p>
                            </div>
                            @if($cycleDay)
                                <div class="bg-white/20 rounded-lg px-3 py-1">
                                    <p class="text-sm font-semibold text-white">Hari {{ $cycleDay }}</p>
                                </div>
                            @endif
                        </div>
                    @else
                        <p class="text-sm text-white text-center py-2">Belum ada siklus aktif</p>
                    @endif
                </div>
            </div>

            <!-- Next Prediction -->
            <div class="bg-white rounded-xl p-4 border border-gray-200 shadow-sm">
                <div class="flex items-center space-x-2 mb-3">
                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                    <h3 class="text-sm font-semibold text-gray-900">Prediksi Berikutnya</h3>
                </div>
                <div class="bg-purple-50 rounded-lg p-3">
                    @if($nextPeriodPrediction)
                        <p class="text-sm font-semibold text-gray-900">
                            {{ \Carbon\Carbon::parse($nextPeriodPrediction)->locale('id')->isoFormat('D MMM YYYY') }}
                        </p>
                        <p class="text-xs text-gray-600 mt-0.5">
                            {{ \Carbon\Carbon::parse($nextPeriodPrediction)->diffForHumans() }}
                        </p>
                    @else
                        <p class="text-sm text-gray-600 text-center py-2">Belum ada prediksi</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Forms -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <!-- Start Cycle Form -->
            <div class="bg-white rounded-xl p-5 border border-gray-200 shadow-sm">
                <div class="flex items-center space-x-2 mb-4">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background: linear-gradient(135deg, #ff79b8 0%, #feb4c8 100%);">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                    </div>
                    <h3 class="text-sm font-semibold text-gray-900">Mulai Siklus Baru</h3>
                </div>
                <form wire:submit="startCycle" class="space-y-3">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Mulai Haid</label>
                        <input type="date" wire:model="startDate" class="w-full px-4 py-2.5 text-sm border-2 border-gray-300 rounded-lg focus:ring-2 focus:border-transparent transition-all" style="color-scheme: light; --tw-ring-color: rgba(255, 121, 184, 0.5);">
                        @error('startDate') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    <button type="submit" class="w-full text-white font-semibold py-2.5 px-4 rounded-lg text-sm transition-all shadow-sm hover:shadow" style="background: linear-gradient(90deg, #ff79b8 0%, #feb4c8 100%);">
                        Mulai Siklus
                    </button>
                </form>
            </div>

            <!-- End Cycle Form (Always visible but disabled if no active cycle) -->
            <div class="bg-white rounded-xl p-5 border border-gray-200 shadow-sm {{ (!$currentCycle || $currentCycle['end_date']) ? 'opacity-60' : '' }}">
                <div class="flex items-center space-x-2 mb-4">
                    <div class="w-8 h-8 rounded-lg bg-purple-100 flex items-center justify-center">
                        <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <h3 class="text-sm font-semibold text-gray-900">Akhiri Siklus</h3>
                    @if(!$currentCycle || $currentCycle['end_date'])
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    @endif
                </div>
                @if($currentCycle && !$currentCycle['end_date'])
                    <form wire:submit="endCycle" class="space-y-3">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Selesai Haid</label>
                            <div class="mb-2 p-2 bg-blue-50 border border-blue-200 rounded-lg">
                                <p class="text-xs text-blue-700">
                                    <strong>Tanggal Mulai:</strong> {{ \Carbon\Carbon::parse($currentCycle['start_date'])->locale('id')->isoFormat('D MMMM YYYY') }}
                                </p>
                                <p class="text-xs text-blue-600 mt-1">Pastikan tanggal selesai setelah atau sama dengan tanggal mulai</p>
                            </div>
                            <input 
                                type="date" 
                                wire:model="endDate" 
                                min="{{ $currentCycle['start_date'] }}"
                                max="{{ \Carbon\Carbon::today()->addDay()->format('Y-m-d') }}"
                                class="w-full px-4 py-2.5 text-sm border-2 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all {{ $errors->has('endDate') ? 'border-red-300 bg-red-50' : 'border-gray-300' }}" 
                                style="color-scheme: light;">
                            @error('endDate') 
                                <div class="mt-2 p-3 bg-red-50 border border-red-200 rounded-lg">
                                    <div class="flex items-start space-x-2">
                                        <svg class="w-4 h-4 text-red-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                        </svg>
                                        <span class="text-red-700 text-xs leading-relaxed">{{ $message }}</span>
                                    </div>
                                </div>
                            @enderror
                        </div>
                        <button type="submit" class="w-full bg-purple-500 hover:bg-purple-600 text-white font-semibold py-2.5 px-4 rounded-lg text-sm transition-all shadow-sm hover:shadow">
                            Akhiri Siklus
                        </button>
                    </form>
                @else
                    <div class="space-y-3">
                        <div>
                            <label class="block text-sm font-semibold text-gray-400 mb-2">Tanggal Selesai Haid</label>
                            <input type="date" disabled class="w-full px-4 py-2.5 text-sm border-2 border-gray-200 rounded-lg bg-gray-50 text-gray-400 cursor-not-allowed" style="color-scheme: light;">
                        </div>
                        <button disabled class="w-full bg-gray-300 text-gray-500 font-semibold py-2.5 px-4 rounded-lg text-sm cursor-not-allowed">
                            <span class="flex items-center justify-center space-x-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                                <span>Mulai siklus terlebih dahulu</span>
                            </span>
                        </button>
                    </div>
                @endif
            </div>
        </div>

        <!-- History -->
        <div>
            <div class="flex items-center justify-between mb-3">
                <h3 class="text-sm font-semibold text-gray-900">Riwayat Siklus ({{ count($cycles) }})</h3>
                @if(count($cycles) > 0)
                    <button 
                        wire:click="resetCycles" 
                        wire:confirm="Apakah Anda yakin ingin menghapus semua riwayat siklus? Tindakan ini tidak dapat dibatalkan."
                        class="flex items-center space-x-2 px-3 py-1.5 text-xs font-semibold text-red-600 bg-red-50 hover:bg-red-100 rounded-lg transition-colors border border-red-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        <span>Reset Siklus</span>
                    </button>
                @endif
            </div>
            @if(count($cycles) > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    @foreach($cycles as $cycle)
                        <div class="bg-white rounded-lg p-4 border border-gray-200 shadow-sm hover:shadow-md transition-shadow">
                            <div class="flex items-center justify-between mb-3">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 rounded-lg flex items-center justify-center" style="background: linear-gradient(135deg, #ff79b8 0%, #feb4c8 100%);">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-gray-900">
                                            {{ \Carbon\Carbon::parse($cycle['start_date'])->locale('id')->isoFormat('D MMM YY') }}
                                            @if($cycle['end_date'])
                                                - {{ \Carbon\Carbon::parse($cycle['end_date'])->locale('id')->isoFormat('D MMM YY') }}
                                            @endif
                                        </p>
                                        <p class="text-xs text-gray-500">
                                            @if($cycle['end_date'])
                                                {{ \Carbon\Carbon::parse($cycle['start_date'])->diffInDays(\Carbon\Carbon::parse($cycle['end_date'])) }} hari
                                            @else
                                                Sedang berlangsung
                                            @endif
                                        </p>
                                    </div>
                                </div>
                                @if(!$cycle['end_date'])
                                    <span class="px-2.5 py-1 bg-gradient-to-r from-pink-100 to-pink-200 text-pink-700 text-xs font-semibold rounded-lg">
                                        Aktif
                                    </span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-gray-50 rounded-lg p-8 border border-gray-200 text-center">
                    <svg class="w-16 h-16 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <p class="text-sm font-semibold text-gray-700">Belum ada riwayat</p>
                    <p class="text-xs text-gray-500 mt-1">Mulai tracking siklus menstruasimu sekarang</p>
                </div>
            @endif
        </div>
    </div>
</div>