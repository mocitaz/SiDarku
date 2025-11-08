<x-app-layout>
    <div class="px-4 py-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Profil</h2>

        <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm mb-6">
            <div class="flex items-center space-x-4 mb-6">
                <div class="w-20 h-20 rounded-full overflow-hidden border-4 border-pink-200">
                    <img src="{{ asset('images/default-profile.png') }}" alt="Profile" class="w-full h-full object-cover">
                </div>
                <div>
                    <h3 class="text-xl font-bold text-gray-800">{{ auth()->user()->name }}</h3>
                    <p class="text-gray-500 text-sm">{{ auth()->user()->email }}</p>
                </div>
            </div>

            <div class="space-y-4">
                <div>
                    <label class="text-sm font-semibold text-gray-600">Tanggal Lahir</label>
                    <p class="text-gray-800">
                        {{ auth()->user()->date_of_birth ? \Carbon\Carbon::parse(auth()->user()->date_of_birth)->locale('id')->isoFormat('D MMMM YYYY') : 'Belum diisi' }}
                    </p>
                </div>
            </div>
        </div>

        <button onclick="showLogoutModal()" class="w-full bg-red-500 text-white font-bold py-3 px-6 rounded-xl hover:bg-red-600 transition-colors mt-6">
            Keluar
        </button>
    </div>
</x-app-layout>

