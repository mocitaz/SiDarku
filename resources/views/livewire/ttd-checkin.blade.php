<div class="w-full">
    <style>
        input:focus, textarea:focus {
            --tw-ring-color: rgba(255, 121, 184, 0.5) !important;
            box-shadow: 0 0 0 2px rgba(255, 121, 184, 0.5) !important;
        }
    </style>
    
    <!-- Header Section -->
    <div class="bg-white border-b border-gray-200 mb-4">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 py-3 sm:py-4">
            <div class="flex items-center space-x-3">
                <a href="{{ route('home') }}" class="w-10 h-10 flex items-center justify-center hover:bg-gray-100 rounded-lg transition-colors">
                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </a>
                <div>
                    <h2 class="text-xl font-semibold text-gray-900">Check-in TTD</h2>
                    <p class="text-sm text-gray-600 mt-1">Catat konsumsi TTD harianmu</p>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-2xl mx-auto px-4 sm:px-6 pb-6">

        @if($successMessage)
            <div class="bg-green-50 border border-green-200 rounded-lg p-3 mb-4 flex items-start space-x-2">
                <svg class="w-5 h-5 text-green-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <p class="text-sm text-green-700">{{ $successMessage }}</p>
            </div>
            <script>
                setTimeout(function() { window.location.href = '{{ route("home") }}'; }, 2000);
            </script>
        @endif

        <!-- Main Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <!-- Header Card with Icon -->
            <div class="p-5 text-center" style="background: linear-gradient(135deg, #ff79b8 0%, #feb4c8 100%);">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-white rounded-2xl shadow-lg mb-3">
                    <svg class="w-10 h-10" style="color: #ff79b8;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                    </svg>
                </div>
                <p class="text-white text-sm mb-1">
                    {{ \Carbon\Carbon::parse($logDate)->locale('id')->isoFormat('dddd, D MMMM YYYY') }}
                </p>
                <h3 class="text-base font-semibold text-white">
                    Apakah kamu sudah minum TTD hari ini?
                </h3>
            </div>

            <!-- Form Section -->
            <div class="p-5">
                <form wire:submit="saveCheckin" class="space-y-4">
                    <!-- Date Input -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5 flex items-center space-x-2">
                            <svg class="w-4 h-4" style="color: #ff79b8;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span>Tanggal Check-in</span>
                        </label>
                        <input 
                            type="date" 
                            wire:model="logDate" 
                            class="w-full px-3 py-2.5 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:border-transparent transition-all">
                        @error('logDate') 
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Checkbox -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <label class="flex items-center space-x-3 cursor-pointer">
                            <input 
                                type="checkbox" 
                                wire:model="isConsumed" 
                                class="w-5 h-5 border-gray-300 rounded focus:ring-2"
                                style="color: #ff79b8;">
                            <div class="flex items-center space-x-2 flex-1">
                                <svg class="w-5 h-5" style="color: #ff79b8;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span class="text-gray-700 font-semibold">Sudah minum TTD</span>
                            </div>
                        </label>
                    </div>

                    <!-- Notes -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5 flex items-center space-x-2">
                            <svg class="w-4 h-4" style="color: #ff79b8;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            <span>Catatan</span>
                            <span class="text-xs text-gray-500 font-normal">(opsional)</span>
                        </label>
                        <textarea 
                            wire:model="notes" 
                            rows="3" 
                            class="w-full px-3 py-2.5 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:border-transparent transition-all resize-none" 
                            placeholder="Catatan jika ada efek samping atau kondisi khusus..."></textarea>
                    </div>

                    <!-- Warning if already checked in -->
                    @if($alreadyCheckedIn)
                        <div class="bg-amber-50 border border-amber-200 rounded-lg p-3 flex items-start space-x-2">
                            <svg class="w-5 h-5 text-amber-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                            <p class="text-xs text-amber-700">Anda sudah check-in untuk tanggal ini. Data akan diperbarui.</p>
                        </div>
                    @endif

                    <!-- Buttons -->
                    <div class="flex flex-col sm:flex-row gap-2 pt-2">
                        <button 
                            type="submit" 
                            class="flex-1 text-white font-semibold py-2.5 px-5 rounded-lg hover:shadow-lg transform hover:scale-[1.02] transition-all duration-200 flex items-center justify-center space-x-2 text-sm"
                            style="background: linear-gradient(135deg, #ff79b8 0%, #feb4c8 100%);">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>{{ $alreadyCheckedIn ? 'Perbarui Check-in' : 'Simpan Check-in' }}</span>
                        </button>
                        <a 
                            href="{{ route('home') }}" 
                            class="sm:w-auto bg-white border-2 text-gray-600 font-semibold py-3 px-6 rounded-lg text-center hover:bg-gray-50 transition-colors flex items-center justify-center space-x-2"
                            style="border-color: #ff79b8; color: #ff79b8;">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                            <span>Kembali</span>
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Info Card -->
        <div class="mt-4 bg-blue-50 border border-blue-200 rounded-lg p-4">
            <div class="flex items-start space-x-3">
                <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div class="flex-1">
                    <p class="text-sm font-semibold text-blue-800 mb-1">Tips Konsumsi TTD</p>
                    <ul class="text-xs text-blue-700 space-y-1">
                        <li class="flex items-start">
                            <span class="mr-2">•</span>
                            <span>Minum TTD setelah makan untuk mengurangi efek samping</span>
                        </li>
                        <li class="flex items-start">
                            <span class="mr-2">•</span>
                            <span>Hindari minum bersama teh, kopi, atau susu</span>
                        </li>
                        <li class="flex items-start">
                            <span class="mr-2">•</span>
                            <span>Konsumsi rutin untuk hasil maksimal</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
