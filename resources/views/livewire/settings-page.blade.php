<div class="max-w-4xl mx-auto px-4 py-6 md:py-8">
    <div class="mb-6">
        <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Pengaturan</h1>
        <p class="text-sm md:text-base text-gray-600 mt-1">Kelola preferensi dan pengaturan akun Anda</p>
    </div>

    @if (session('message'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl text-green-700 text-sm">
            {{ session('message') }}
        </div>
    @endif

    <!-- Email Reminder Settings -->
    <div class="bg-white rounded-lg border border-gray-200 shadow-sm mb-6">
        <div class="p-4">
            <div class="flex items-start justify-between gap-4">
                <div class="flex items-start space-x-3 flex-1 min-w-0">
                    <div class="flex-shrink-0 w-10 h-10 bg-gradient-to-br from-pink-500 to-purple-500 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="text-sm font-semibold text-gray-900 mb-1.5">Notifikasi Email Reminder TTD</h3>
                        <p class="text-xs text-gray-600 leading-relaxed">
                            Pengingat otomatis setiap hari pukul <span class="font-semibold text-pink-600">12:00 WIB</span> jika belum check-in TTD hari ini
                        </p>
                    </div>
                </div>
                <div class="flex-shrink-0">
                    @if($emailReminderEnabled)
                        <button 
                            wire:click="toggleEmailReminder"
                            type="button"
                            class="relative inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold transition-all duration-200 bg-gradient-to-r from-pink-500 to-purple-500 text-white shadow-md hover:shadow-lg hover:from-pink-600 hover:to-purple-600 focus:outline-none focus:ring-2 focus:ring-pink-500 focus:ring-offset-2"
                        >
                            <svg class="w-3.5 h-3.5 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            Aktif
                        </button>
                    @else
                        <button 
                            wire:click="toggleEmailReminder"
                            type="button"
                            class="relative inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold transition-all duration-200 bg-gray-200 text-gray-700 shadow-sm hover:shadow-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-2"
                        >
                            <svg class="w-3.5 h-3.5 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                            </svg>
                            Nonaktif
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Account -->
    <div class="bg-white rounded-xl p-5 md:p-6 border border-red-200 shadow-sm">
        <div class="mb-4">
            <h2 class="text-lg font-semibold text-red-900 mb-2">Hapus Akun</h2>
            <p class="text-sm text-gray-600">
                Menghapus akun Anda akan menghapus semua data yang terkait dengan akun ini, termasuk riwayat siklus, check-in TTD, dan data lainnya. Tindakan ini tidak dapat dibatalkan.
            </p>
        </div>

        <div x-data="{ showDeleteModal: false }">
            <button 
                @click="showDeleteModal = true"
                class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg text-sm transition-colors"
            >
                Hapus Akun
            </button>

            <!-- Delete Confirmation Modal -->
            <div 
                x-show="showDeleteModal"
                @click.away="showDeleteModal = false"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4"
                style="display: none;"
            >
                <div 
                    @click.stop
                    class="bg-white rounded-xl p-6 max-w-md w-full shadow-xl"
                >
                    <h3 class="text-xl font-bold text-red-900 mb-4">Konfirmasi Hapus Akun</h3>
                    
                    <p class="text-sm text-gray-700 mb-4">
                        Apakah Anda yakin ingin menghapus akun Anda? Tindakan ini tidak dapat dibatalkan.
                    </p>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Password <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="password" 
                                wire:model="deletePassword"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent"
                                placeholder="Masukkan password Anda"
                            >
                            @error('deletePassword')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Ketik <strong class="text-red-600">HAPUS AKUN SAYA</strong> untuk konfirmasi
                            </label>
                            <input 
                                type="text" 
                                wire:model="deleteConfirmation"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent"
                                placeholder="HAPUS AKUN SAYA"
                            >
                            @error('deleteConfirmation')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="flex items-center space-x-3 mt-6">
                        <button 
                            @click="showDeleteModal = false"
                            class="flex-1 px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold rounded-lg text-sm transition-colors"
                        >
                            Batal
                        </button>
                        <button 
                            wire:click="deleteAccount"
                            class="flex-1 px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg text-sm transition-colors"
                        >
                            Hapus Akun
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
