<div class="w-full bg-gray-50">
    <style>
        input:focus, select:focus {
            --tw-ring-color: rgba(255, 121, 184, 0.5) !important;
            box-shadow: 0 0 0 2px rgba(255, 121, 184, 0.5) !important;
        }
    </style>

    <!-- Header Section -->
    <div class="bg-white border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 py-3 sm:py-4">
            <h2 class="text-lg sm:text-xl font-semibold text-gray-900">Profil Saya</h2>
            <p class="text-gray-600 text-xs sm:text-sm mt-1">Kelola informasi pribadi dan pengaturan akun</p>
        </div>
    </div>

    <div class="max-w-7xl w-full mx-auto px-4 sm:px-6 py-3 sm:py-5 pb-20 sm:pb-8">
        <!-- Compact Header with Stats -->
        <div class="rounded-xl sm:rounded-2xl p-3 sm:p-6 mb-3 sm:mb-4 shadow-xl relative overflow-hidden" style="background: linear-gradient(135deg, #ff79b8 0%, #feb4c8 100%);">
            <!-- Decorative circles -->
            <div class="absolute top-0 right-0 w-32 h-32 bg-white opacity-10 rounded-full -mr-16 -mt-16"></div>
            <div class="absolute bottom-0 left-0 w-24 h-24 bg-white opacity-10 rounded-full -ml-12 -mb-12"></div>
            
            <div class="relative z-10">
                <!-- Profile Info -->
                <div class="flex items-center space-x-3 mb-3 sm:mb-4">
                    <div class="w-14 h-14 sm:w-20 sm:h-20 bg-white rounded-xl sm:rounded-2xl overflow-hidden flex items-center justify-center shadow-lg border-2 border-white flex-shrink-0">
                        <img src="{{ asset('images/default-profile.png') }}" alt="Profile" class="w-full h-full object-cover">
                    </div>
                    <div class="flex-1 min-w-0">
                        <h1 class="text-base sm:text-lg md:text-xl font-semibold text-white mb-0.5 sm:mb-1 truncate">{{ auth()->user()->name }}</h1>
                        <p class="text-white text-opacity-90 text-xs sm:text-sm flex items-center truncate">
                            <svg class="w-3 h-3 sm:w-4 sm:h-4 mr-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            <span class="truncate">{{ auth()->user()->email }}</span>
                        </p>
                    </div>
                </div>

                <!-- Quick Stats -->
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-1.5 sm:gap-3">
                    <div class="bg-white/20 backdrop-blur-sm rounded-lg sm:rounded-xl p-2 sm:p-3 text-center">
                        <p class="text-base sm:text-xl md:text-2xl font-semibold text-white">{{ $totalCheckins }}</p>
                        <p class="text-xs text-white text-opacity-90 mt-0.5 sm:mt-1">Check-in</p>
                    </div>
                    <div class="bg-white/20 backdrop-blur-sm rounded-lg sm:rounded-xl p-2 sm:p-3 text-center">
                        <p class="text-base sm:text-xl md:text-2xl font-semibold text-white">{{ $currentStreak }}</p>
                        <p class="text-xs text-white text-opacity-90 mt-0.5 sm:mt-1">Streak</p>
                    </div>
                    <div class="bg-white/20 backdrop-blur-sm rounded-lg sm:rounded-xl p-2 sm:p-3 text-center">
                        <p class="text-base sm:text-xl md:text-2xl font-semibold text-white">{{ $totalCycles }}</p>
                        <p class="text-xs text-white text-opacity-90 mt-0.5 sm:mt-1">Siklus</p>
                    </div>
                    <div class="bg-white/20 backdrop-blur-sm rounded-lg sm:rounded-xl p-2 sm:p-3 text-center">
                        <p class="text-xs sm:text-sm font-semibold text-white truncate">
                            @if($lastCheckin)
                                {{ \Carbon\Carbon::parse($lastCheckin)->diffForHumans(null, true) }}
                            @else
                                -
                            @endif
                        </p>
                        <p class="text-xs text-white text-opacity-90 mt-0.5 sm:mt-1">Terakhir</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-3 sm:gap-4">
            <!-- Left Sidebar - Info Card -->
            <div class="md:col-span-1 space-y-3 sm:space-y-4 order-2 md:order-1">
                <!-- Personal Info -->
                <div class="bg-white rounded-lg sm:rounded-xl p-3 sm:p-4 shadow-sm border border-gray-100">
                    <h3 class="text-sm font-semibold text-gray-800 mb-3 flex items-center">
                        <svg class="w-4 h-4 mr-2" style="color: #ff79b8;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        Informasi Pribadi
                    </h3>
                    <div class="space-y-3 text-sm">
                        <div class="flex items-start">
                            <svg class="w-4 h-4 text-gray-400 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <div class="flex-1">
                                <p class="text-xs text-gray-500">Tanggal Lahir</p>
                                <p class="text-gray-800 font-medium">
                                    {{ auth()->user()->date_of_birth ? \Carbon\Carbon::parse(auth()->user()->date_of_birth)->locale('id')->isoFormat('D MMM YYYY') : '-' }}
                                </p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <svg class="w-4 h-4 text-gray-400 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                            <div class="flex-1">
                                <p class="text-xs text-gray-500">Telepon</p>
                                <p class="text-gray-800 font-medium break-all">{{ auth()->user()->phone ?? '-' }}</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <svg class="w-4 h-4 text-gray-400 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            <div class="flex-1">
                                <p class="text-xs text-gray-500">Pekerjaan</p>
                                <p class="text-gray-800 font-medium">{{ auth()->user()->occupation ?? '-' }}</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <svg class="w-4 h-4 text-gray-400 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                            <div class="flex-1">
                                <p class="text-xs text-gray-500">Status</p>
                                <p class="text-gray-800 font-medium">
                                    @if(auth()->user()->marital_status === 'single') Belum Menikah
                                    @elseif(auth()->user()->marital_status === 'married') Menikah
                                    @elseif(auth()->user()->marital_status === 'divorced') Cerai
                                    @elseif(auth()->user()->marital_status === 'widowed') Janda
                                    @else -
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Logout Button - Desktop Only -->
                <div class="hidden md:block">
                    <button onclick="showLogoutModal()" type="button" class="w-full bg-red-50 hover:bg-red-100 text-red-600 text-sm font-semibold py-2.5 px-4 rounded-lg transition-colors flex items-center justify-center space-x-2 border border-red-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        <span>Keluar</span>
                    </button>
                </div>
            </div>

            <!-- Right Content - Forms -->
            <div class="md:col-span-2 order-1 md:order-2">
                <div class="bg-white rounded-lg sm:rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <!-- Tabs -->
                    <div class="border-b border-gray-200">
                        <div class="flex">
                            <button 
                                wire:click="$set('activeTab', 'profile')"
                                class="flex-1 px-3 py-2.5 text-xs sm:text-sm font-medium transition-colors relative {{ $activeTab === 'profile' ? 'hover:bg-gray-50' : 'text-gray-500 hover:text-gray-700 hover:bg-gray-50' }}"
                                style="{{ $activeTab === 'profile' ? 'color: #ff79b8; background-color: rgba(255, 121, 184, 0.1);' : '' }}">
                                <span class="flex items-center justify-center space-x-1.5 sm:space-x-2">
                                    <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                    <span>Edit Profil</span>
                                </span>
                                @if($activeTab === 'profile')
                                    <div class="absolute bottom-0 left-0 right-0 h-0.5" style="background-color: #ff79b8;"></div>
                                @endif
                            </button>
                            <button 
                                wire:click="$set('activeTab', 'password')"
                                class="flex-1 px-3 py-2.5 text-xs sm:text-sm font-medium transition-colors relative {{ $activeTab === 'password' ? 'hover:bg-gray-50' : 'text-gray-500 hover:text-gray-700 hover:bg-gray-50' }}"
                                style="{{ $activeTab === 'password' ? 'color: #ff79b8; background-color: rgba(255, 121, 184, 0.1);' : '' }}">
                                <span class="flex items-center justify-center space-x-1.5 sm:space-x-2">
                                    <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                    <span>Keamanan</span>
                                </span>
                                @if($activeTab === 'password')
                                    <div class="absolute bottom-0 left-0 right-0 h-0.5" style="background-color: #ff79b8;"></div>
                                @endif
                            </button>
                        </div>
                    </div>

                    <!-- Tab Content -->
                    <div class="p-3 sm:p-5">
                        @if($activeTab === 'profile')
                            <!-- Edit Profile Form -->
                            <form wire:submit.prevent="updateProfile" class="space-y-3 sm:space-y-4">
                                <div class="grid md:grid-cols-2 gap-3 sm:gap-4">
                                    <div>
                                        <label for="name" class="block text-xs sm:text-sm font-semibold text-gray-700 mb-1 sm:mb-1.5">
                                            Nama Lengkap
                                        </label>
                                        <input 
                                            type="text" 
                                            id="name"
                                            wire:model="name"
                                            class="w-full px-3 py-2 sm:py-2.5 text-xs sm:text-sm border border-gray-200 rounded-lg focus:ring-2 focus:border-transparent transition-all"
                                            placeholder="Nama lengkap">
                                        @error('name') 
                                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="email" class="block text-xs sm:text-sm font-semibold text-gray-700 mb-1 sm:mb-1.5">
                                            Email
                                        </label>
                                        <input 
                                            type="email" 
                                            id="email"
                                            wire:model="email"
                                            class="w-full px-3 py-2 sm:py-2.5 text-xs sm:text-sm border border-gray-200 rounded-lg focus:ring-2 focus:border-transparent transition-all"
                                            placeholder="email@example.com">
                                        @error('email') 
                                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="date_of_birth" class="block text-xs sm:text-sm font-semibold text-gray-700 mb-1 sm:mb-1.5">
                                            Tanggal Lahir
                                        </label>
                                        <input 
                                            type="date" 
                                            id="date_of_birth"
                                            wire:model="date_of_birth"
                                            class="w-full px-3 py-2 sm:py-2.5 text-xs sm:text-sm border border-gray-200 rounded-lg focus:ring-2 focus:border-transparent transition-all"
                                            max="{{ now()->subYears(10)->format('Y-m-d') }}">
                                        @error('date_of_birth') 
                                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="phone" class="block text-xs sm:text-sm font-semibold text-gray-700 mb-1 sm:mb-1.5">
                                            Nomor Telepon
                                        </label>
                                        <div class="flex space-x-2">
                                            <select 
                                                wire:model="phone_country_code"
                                                class="w-20 sm:w-24 px-1.5 sm:px-2 py-2 sm:py-2.5 text-xs sm:text-sm border border-gray-200 rounded-lg focus:ring-2 focus:border-transparent transition-all bg-white">
                                                <option value="+62">🇮🇩 +62</option>
                                                <option value="+1">🇺🇸 +1</option>
                                                <option value="+44">🇬🇧 +44</option>
                                                <option value="+65">🇸🇬 +65</option>
                                                <option value="+60">🇲🇾 +60</option>
                                                <option value="+86">🇨🇳 +86</option>
                                                <option value="+81">🇯🇵 +81</option>
                                                <option value="+82">🇰🇷 +82</option>
                                                <option value="+61">🇦🇺 +61</option>
                                            </select>
                                            <input 
                                                type="tel" 
                                                id="phone"
                                                wire:model="phone"
                                                class="flex-1 px-3 py-2 sm:py-2.5 text-xs sm:text-sm border border-gray-200 rounded-lg focus:ring-2 focus:border-transparent transition-all"
                                                placeholder="8123456789">
                                        </div>
                                        @error('phone') 
                                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="occupation" class="block text-xs sm:text-sm font-semibold text-gray-700 mb-1 sm:mb-1.5">
                                            Pekerjaan
                                        </label>
                                        <select 
                                            id="occupation"
                                            wire:model.live="occupation"
                                            class="w-full px-3 py-2 sm:py-2.5 text-xs sm:text-sm border border-gray-200 rounded-lg focus:ring-2 focus:border-transparent transition-all bg-white">
                                            <option value="">Pilih Pekerjaan</option>
                                            <option value="Pelajar">Pelajar</option>
                                            <option value="Mahasiswa">Mahasiswa</option>
                                            <option value="Guru">Guru</option>
                                            <option value="Dosen">Dosen</option>
                                            <option value="Dokter">Dokter</option>
                                            <option value="Perawat">Perawat</option>
                                            <option value="Bidan">Bidan</option>
                                            <option value="PNS">PNS</option>
                                            <option value="Karyawan Swasta">Karyawan Swasta</option>
                                            <option value="Wiraswasta">Wiraswasta</option>
                                            <option value="Ibu Rumah Tangga">Ibu Rumah Tangga</option>
                                            <option value="Freelancer">Freelancer</option>
                                            <option value="Petani">Petani</option>
                                            <option value="Pedagang">Pedagang</option>
                                            <option value="Buruh">Buruh</option>
                                            <option value="Profesional">Profesional</option>
                                            <option value="Pengusaha">Pengusaha</option>
                                            <option value="Belum Bekerja">Belum Bekerja</option>
                                            <option value="Other">Lainnya...</option>
                                        </select>
                                        @error('occupation') 
                                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                        @enderror
                                        
                                        @if($occupation === 'Other')
                                            <input 
                                                type="text" 
                                                wire:model="occupation_other"
                                                class="w-full px-3 py-2 sm:py-2.5 text-xs sm:text-sm border border-gray-200 rounded-lg focus:ring-2 focus:border-transparent transition-all mt-2"
                                                placeholder="Tuliskan pekerjaan Anda">
                                            @error('occupation_other') 
                                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                            @enderror
                                        @endif
                                    </div>

                                    <div>
                                        <label for="marital_status" class="block text-xs sm:text-sm font-semibold text-gray-700 mb-1 sm:mb-1.5">
                                            Status Pernikahan
                                        </label>
                                        <select 
                                            id="marital_status"
                                            wire:model="marital_status"
                                            class="w-full px-3 py-2 sm:py-2.5 text-xs sm:text-sm border border-gray-200 rounded-lg focus:ring-2 focus:border-transparent transition-all bg-white">
                                            <option value="">Pilih Status</option>
                                            <option value="single">Belum Menikah</option>
                                            <option value="married">Menikah</option>
                                            <option value="divorced">Cerai</option>
                                            <option value="widowed">Janda</option>
                                        </select>
                                        @error('marital_status') 
                                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <button 
                                    type="submit"
                                    class="w-full text-white text-sm font-semibold py-2.5 px-4 rounded-lg hover:shadow-lg transform hover:scale-[1.02] transition-all duration-200"
                                    style="background: linear-gradient(135deg, #ff79b8 0%, #feb4c8 100%);">
                                    Simpan Perubahan
                                </button>
                            </form>
                        @endif

                        @if($activeTab === 'password')
                            <!-- Change Password Form -->
                            <form wire:submit.prevent="updatePassword" class="space-y-3 sm:space-y-4">
                                <div class="bg-blue-50 border border-blue-200 rounded-lg p-2.5 sm:p-3 mb-3 sm:mb-4">
                                    <div class="flex items-start space-x-2">
                                        <svg class="w-4 h-4 sm:w-5 sm:h-5 text-blue-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <p class="text-xs text-blue-700">Gunakan password minimal 8 karakter dengan kombinasi huruf dan angka.</p>
                                    </div>
                                </div>

                                <div>
                                    <label for="current_password" class="block text-xs sm:text-sm font-semibold text-gray-700 mb-1 sm:mb-1.5">
                                        Password Saat Ini
                                    </label>
                                    <input 
                                        type="password" 
                                        id="current_password"
                                        wire:model="current_password"
                                        class="w-full px-3 py-2 sm:py-2.5 text-xs sm:text-sm border border-gray-200 rounded-lg focus:ring-2 focus:border-transparent transition-all"
                                        placeholder="••••••••">
                                    @error('current_password') 
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="new_password" class="block text-xs sm:text-sm font-semibold text-gray-700 mb-1 sm:mb-1.5">
                                        Password Baru
                                    </label>
                                    <input 
                                        type="password" 
                                        id="new_password"
                                        wire:model="new_password"
                                        class="w-full px-3 py-2 sm:py-2.5 text-xs sm:text-sm border border-gray-200 rounded-lg focus:ring-2 focus:border-transparent transition-all"
                                        placeholder="••••••••">
                                    @error('new_password') 
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="new_password_confirmation" class="block text-xs sm:text-sm font-semibold text-gray-700 mb-1 sm:mb-1.5">
                                        Konfirmasi Password Baru
                                    </label>
                                    <input 
                                        type="password" 
                                        id="new_password_confirmation"
                                        wire:model="new_password_confirmation"
                                        class="w-full px-3 py-2 sm:py-2.5 text-xs sm:text-sm border border-gray-200 rounded-lg focus:ring-2 focus:border-transparent transition-all"
                                        placeholder="••••••••">
                                </div>

                                <button 
                                    type="submit"
                                    class="w-full text-white text-sm font-semibold py-2.5 px-4 rounded-lg hover:shadow-lg transform hover:scale-[1.02] transition-all duration-200"
                                    style="background: linear-gradient(135deg, #ff79b8 0%, #feb4c8 100%);">
                                    Ubah Password
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Logout Button - Mobile Only (Bottom) -->
        <div class="md:hidden mt-3 mb-20">
            <button onclick="showLogoutModal()" type="button" class="w-full bg-red-50 hover:bg-red-100 text-red-600 text-sm font-semibold py-2.5 px-4 rounded-lg transition-colors flex items-center justify-center space-x-2 border border-red-200">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                <span>Keluar</span>
            </button>
        </div>
    </div>
</div>
