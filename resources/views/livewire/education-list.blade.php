<div class="min-h-screen flex flex-col bg-gray-50">
    <!-- Header Section -->
    <div class="bg-white border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 py-3 sm:py-4">
            <h2 class="text-xl font-semibold text-gray-900">Edukasi</h2>
            <p class="text-gray-600 text-sm mt-1">Pelajari lebih lanjut tentang kesehatanmu</p>
        </div>
    </div>

    <!-- Main Content -->
    <div class="flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 py-4 sm:py-5 pb-6">

    <!-- Search Bar -->
        <div class="mb-4">
            <div class="relative w-full">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
    <input 
        type="text" 
        wire:model.live="search" 
                    placeholder="Cari artikel tentang anemia, menstruasi, nutrisi..." 
                    class="block w-full pl-10 pr-3 py-2 text-sm border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-pink-500 bg-white shadow-sm"
    >
            </div>
        </div>

    <!-- Category Chips -->
        <div class="flex gap-2 overflow-x-auto pb-3 mb-5 -mx-4 px-4 scrollbar-hide">
        @foreach($categories as $category)
            <button 
                wire:click="filterByCategory('{{ $category }}')"
                    class="px-3 py-1.5 rounded-full text-xs font-semibold whitespace-nowrap transition-all duration-200 {{ $selectedCategory === $category && $category !== 'Semua' ? 'bg-gradient-to-r from-pink-500 to-pink-600 text-white shadow-lg scale-105' : 'bg-white text-gray-700 hover:bg-gray-50 border border-gray-200 shadow-sm' }}"
            >
                {{ $category }}
            </button>
        @endforeach
    </div>

        @if($educations->count() > 0)
            @if($selectedCategory === 'Semua')
                <!-- Featured Article (Hero) - Only show when "Semua" is selected -->
                @if($featuredArticle)
                    <a href="{{ route('education.show', $featuredArticle->slug) }}" class="block mb-4 group">
                        <div class="bg-white rounded-lg overflow-hidden shadow-md hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                            <div class="relative w-full aspect-video overflow-hidden">
                                @if($featuredArticle->image)
                                    <img src="{{ $featuredArticle->image_url ?? asset('images/icon.png') }}" alt="{{ $featuredArticle->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                @else
                                    <div class="w-full h-full bg-gradient-to-br from-pink-400 via-purple-500 to-indigo-600 flex items-center justify-center">
                                        <span class="text-5xl opacity-50">
                                            @if($featuredArticle->category === 'Anemia') 🩸
                                            @elseif($featuredArticle->category === 'Menstruasi') 📅
                                            @elseif($featuredArticle->category === 'TTD') 💊
                                            @elseif($featuredArticle->category === 'Nutrisi') 🥗
                                            @else 🌟
                                            @endif
                                        </span>
                                    </div>
                                @endif
                                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-transparent"></div>
                                <div class="absolute bottom-0 left-0 right-0 p-3 sm:p-4 text-white">
                                    <div class="inline-block px-2 py-0.5 bg-pink-500 rounded-full text-[10px] font-bold uppercase mb-1.5">
                                        {{ $featuredArticle->category }}
                                    </div>
                                    <h2 class="text-base sm:text-lg md:text-xl font-bold mb-1 line-clamp-2 text-white drop-shadow-lg">
                                        {{ $featuredArticle->title }}
                                    </h2>
                                    <p class="text-[10px] sm:text-xs text-white/90 flex items-center space-x-1 drop-shadow-md">
                                        <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <span>{{ \Carbon\Carbon::parse($featuredArticle->created_at)->locale('id')->isoFormat('D MMM YYYY') }}</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </a>
                @endif

                <!-- Other Articles Grid (2 columns on desktop) - Only show when "Semua" is selected -->
                @if($otherArticles->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-5">
                        @foreach($otherArticles as $education)
                            <a href="{{ route('education.show', $education->slug) }}" class="block bg-white rounded-lg overflow-hidden shadow-md hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1 group">
                                <div class="relative w-full aspect-video overflow-hidden">
                                    @if($education->image)
                                        <img src="{{ $education->image_url ?? asset('images/icon.png') }}" alt="{{ $education->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                    @else
                                        <div class="w-full h-full bg-gradient-to-br from-pink-300 via-purple-400 to-indigo-500 flex items-center justify-center">
                                            <span class="text-5xl opacity-50">
                                                @if($education->category === 'Anemia') 🩸
                                                @elseif($education->category === 'Menstruasi') 📅
                                                @elseif($education->category === 'TTD') 💊
                                                @elseif($education->category === 'Nutrisi') 🥗
                                                @else 🌟
                                                @endif
                                            </span>
                                        </div>
                                    @endif
                                    <div class="absolute top-2 left-2">
                                        <span class="px-2 py-0.5 bg-pink-500 text-white rounded-full text-[10px] font-bold uppercase">
                                            {{ $education->category }}
                                        </span>
                                    </div>
                                </div>
                                <div class="p-3">
                                    <h3 class="text-sm font-bold text-gray-900 mb-1 line-clamp-2 group-hover:text-pink-600 transition-colors">
                                        {{ $education->title }}
                                    </h3>
                                    <p class="text-xs text-gray-500 flex items-center space-x-1">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <span>{{ \Carbon\Carbon::parse($education->created_at)->locale('id')->diffForHumans() }}</span>
                                    </p>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @endif

                <!-- Grid Articles (3 columns on desktop) - Only show when "Semua" is selected -->
                @if($gridArticles->count() > 0)
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($gridArticles as $education)
                            <a href="{{ route('education.show', $education->slug) }}" class="block bg-white rounded-lg overflow-hidden shadow-md hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1 group">
                                <div class="relative w-full aspect-video overflow-hidden">
                                    @if($education->image)
                                        <img src="{{ $education->image_url ?? asset('images/icon.png') }}" alt="{{ $education->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                    @else
                                        <div class="w-full h-full bg-gradient-to-br from-pink-200 via-purple-300 to-indigo-400 flex items-center justify-center">
                                            <span class="text-4xl opacity-50">
                            @if($education->category === 'Anemia') 🩸
                            @elseif($education->category === 'Menstruasi') 📅
                            @elseif($education->category === 'TTD') 💊
                            @elseif($education->category === 'Nutrisi') 🥗
                            @else 🌟
                            @endif
                        </span>
                    </div>
                                    @endif
                                    <div class="absolute top-1.5 left-1.5">
                                        <span class="px-1.5 py-0.5 bg-pink-500 text-white rounded-full text-[9px] font-bold uppercase">
                            {{ $education->category }}
                                        </span>
                                    </div>
                        </div>
                                <div class="p-3">
                                    <h3 class="text-xs font-bold text-gray-900 mb-1 line-clamp-2 group-hover:text-pink-600 transition-colors">
                            {{ $education->title }}
                        </h3>
                                    <p class="text-[10px] text-gray-500 flex items-center space-x-1">
                                        <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <span>{{ \Carbon\Carbon::parse($education->created_at)->locale('id')->diffForHumans() }}</span>
                        </p>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @endif
            @else
                <!-- All Articles Grid (3 columns) - Show when category filter is selected -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($educations as $education)
                        <a href="{{ route('education.show', $education->slug) }}" class="block bg-white rounded-lg overflow-hidden shadow-md hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1 group">
                            <div class="relative h-32 overflow-hidden">
                                @if($education->image)
                                    <img src="{{ $education->image_url ?? asset('images/icon.png') }}" alt="{{ $education->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                @else
                                    <div class="w-full h-full bg-gradient-to-br from-pink-200 via-purple-300 to-indigo-400 flex items-center justify-center">
                                        <span class="text-4xl opacity-50">
                                            @if($education->category === 'Anemia') 🩸
                                            @elseif($education->category === 'Menstruasi') 📅
                                            @elseif($education->category === 'TTD') 💊
                                            @elseif($education->category === 'Nutrisi') 🥗
                                            @else 🌟
                                            @endif
                                        </span>
                                    </div>
                                @endif
                                <div class="absolute top-1.5 left-1.5">
                                    <span class="px-1.5 py-0.5 bg-pink-500 text-white rounded-full text-[9px] font-bold uppercase">
                                        {{ $education->category }}
                                    </span>
                                </div>
                            </div>
                            <div class="p-3">
                                <h3 class="text-xs font-bold text-gray-900 mb-1 line-clamp-2 group-hover:text-pink-600 transition-colors">
                                    {{ $education->title }}
                                </h3>
                                <p class="text-[10px] text-gray-500 flex items-center space-x-1">
                                    <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <span>{{ \Carbon\Carbon::parse($education->created_at)->locale('id')->diffForHumans() }}</span>
                                </p>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif

        @else
            <!-- Empty State -->
            <div class="text-center py-12">
                <div class="flex justify-center mb-3">
                    <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                </div>
                <h3 class="text-base font-semibold text-gray-900 mb-1">Tidak ada artikel ditemukan</h3>
                <p class="text-sm text-gray-500">Coba ubah filter atau kata kunci pencarian Anda</p>
            </div>
        @endif
    </div>

    <style>
        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }
    </style>
</div>
