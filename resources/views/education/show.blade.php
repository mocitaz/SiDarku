@extends('layouts.app')

@section('content')
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
        <!-- Back Button -->
        <div class="mb-3">
            <a href="{{ route('education') }}" class="inline-flex items-center space-x-1.5 text-xs font-semibold text-gray-600 hover:text-sidarku-primary transition-colors">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                <span>Kembali</span>
            </a>
        </div>
        
        <!-- Portal Berita Layout -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 lg:gap-5">
            <!-- Main Article -->
            <div class="lg:col-span-2">
                <article class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                    <!-- Image -->
                    @if($education->image)
                        <div class="w-full aspect-video overflow-hidden">
                            <img src="{{ $education->image_url ?? asset('images/icon.png') }}" alt="{{ $education->title }}" class="w-full h-full object-cover">
                        </div>
                    @endif

                    <!-- Content -->
                    <div class="p-4 sm:p-5">
                        <!-- Category Badge & Meta -->
                        <div class="flex items-center justify-between mb-3">
                            <span class="inline-block px-2 py-0.5 text-[10px] font-bold text-pink-700 bg-pink-100 rounded-full uppercase">
                {{ $education->category }}
                            </span>
                            <div class="flex items-center space-x-1.5 text-xs text-gray-500">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span>{{ \Carbon\Carbon::parse($education->created_at)->locale('id')->isoFormat('D MMM YYYY') }}</span>
                            </div>
                        </div>

                        <!-- Title -->
                        <h1 class="text-lg sm:text-xl md:text-2xl font-bold text-gray-900 mb-3 leading-tight">
                            {{ $education->title }}
                        </h1>

                        <!-- Article Content -->
                        <div class="prose prose-pink prose-sm max-w-none prose-headings:font-bold prose-headings:text-gray-900 prose-headings:text-base prose-p:text-gray-700 prose-p:leading-relaxed prose-p:text-sm prose-p:mb-3 prose-a:text-sidarku-primary prose-a:no-underline hover:prose-a:underline prose-strong:text-gray-900 prose-strong:font-semibold prose-ul:text-gray-700 prose-ol:text-gray-700 prose-li:text-gray-700 prose-li:text-sm prose-li:mb-1 prose-img:rounded-lg prose-img:shadow-sm prose-img:max-w-full prose-img:w-full prose-img:my-3 prose-h2:text-base prose-h2:font-bold prose-h2:mt-4 prose-h2:mb-2 prose-h3:text-sm prose-h3:font-bold prose-h3:mt-3 prose-h3:mb-2">
                            <div class="text-gray-700 leading-relaxed text-sm education-content">
                                {!! $education->content !!}
                            </div>
                        </div>
                        
                        <style>
                            /* Preserve Quill.js alignment - override prose styles */
                            .education-content p[style*="text-align: justify"],
                            .education-content p[style*="text-align:justify"],
                            .education-content .ql-align-justify,
                            .education-content .ql-align-justify p {
                                text-align: justify !important;
                            }
                            
                            .education-content p[style*="text-align: center"],
                            .education-content p[style*="text-align:center"],
                            .education-content .ql-align-center,
                            .education-content .ql-align-center p {
                                text-align: center !important;
                            }
                            
                            .education-content p[style*="text-align: right"],
                            .education-content p[style*="text-align:right"],
                            .education-content .ql-align-right,
                            .education-content .ql-align-right p {
                                text-align: right !important;
                            }
                            
                            .education-content p[style*="text-align: left"],
                            .education-content p[style*="text-align:left"],
                            .education-content .ql-align-left,
                            .education-content .ql-align-left p {
                                text-align: left !important;
                            }
                            
                            /* Preserve alignment for all elements */
                            .education-content *[style*="text-align: justify"],
                            .education-content *[style*="text-align:justify"] {
                                text-align: justify !important;
                            }
                            
                            .education-content *[style*="text-align: center"],
                            .education-content *[style*="text-align:center"] {
                                text-align: center !important;
                            }
                            
                            .education-content *[style*="text-align: right"],
                            .education-content *[style*="text-align:right"] {
                                text-align: right !important;
                            }
                            
                            .education-content *[style*="text-align: left"],
                            .education-content *[style*="text-align:left"] {
                                text-align: left !important;
                            }
                            
                            /* Ensure paragraphs inherit alignment from parent */
                            .education-content p {
                                text-align: inherit;
                            }
                            
                            /* Override prose default alignment */
                            .prose .education-content p {
                                text-align: inherit;
                            }
                        </style>
                    </div>
                </article>
            </div>

            <!-- Sidebar -->
            <aside class="lg:col-span-1 space-y-4">
                <!-- Related Articles -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-3 sm:p-4">
                    <h3 class="text-sm font-bold text-gray-900 mb-3">Artikel Terkait</h3>
                    <div class="space-y-3">
                        @php
                            $relatedEducations = \App\Models\Education::where('category', $education->category)
                                ->where('id', '!=', $education->id)
                                ->latest()
                                ->take(5)
                                ->get();
                        @endphp
                        @forelse($relatedEducations as $related)
                            <a href="{{ route('education.show', $related->slug) }}" class="block group">
                                <div class="flex space-x-2.5">
                                    @if($related->image)
                                        <div class="w-16 h-16 flex-shrink-0 rounded-lg overflow-hidden">
                                            <img src="{{ $related->image_url ?? asset('images/icon.png') }}" alt="{{ $related->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                        </div>
                                    @else
                                        <div class="w-16 h-16 flex-shrink-0 bg-gradient-to-br from-pink-200 to-purple-200 rounded-lg flex items-center justify-center">
                                            <span class="text-xl">
                                                @if($related->category === 'Anemia') 🩸
                                                @elseif($related->category === 'Menstruasi') 📅
                                                @elseif($related->category === 'TTD') 💊
                                                @elseif($related->category === 'Nutrisi') 🥗
                                                @else 🌟
                                                @endif
                                            </span>
                                        </div>
                                    @endif
                                    <div class="flex-1 min-w-0">
                                        <h4 class="text-xs font-bold text-gray-900 group-hover:text-sidarku-primary transition-colors line-clamp-2 mb-1 leading-snug">
                                            {{ $related->title }}
                                        </h4>
                                        <p class="text-[10px] text-gray-500">
                                            {{ \Carbon\Carbon::parse($related->created_at)->locale('id')->diffForHumans() }}
            </p>
                                    </div>
                                </div>
                            </a>
                        @empty
                            <p class="text-xs text-gray-500 text-center py-3">Tidak ada artikel terkait</p>
                        @endforelse
                    </div>
        </div>

                <!-- Popular Categories -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-3 sm:p-4">
                    <h3 class="text-sm font-bold text-gray-900 mb-3">Kategori Populer</h3>
                    <div class="space-y-1.5">
                        @php
                            $categories = ['Anemia', 'Menstruasi', 'TTD', 'Nutrisi', 'Tips Sehat'];
                        @endphp
                        @foreach($categories as $category)
                            <a href="{{ route('education', ['category' => $category]) }}" class="block px-2.5 py-1.5 rounded-lg text-xs font-semibold text-gray-700 hover:bg-pink-50 hover:text-sidarku-primary transition-colors {{ $education->category === $category ? 'bg-pink-50 text-sidarku-primary' : '' }}">
                                {{ $category }}
                            </a>
                        @endforeach
                    </div>
            </div>
            </aside>
        </div>
    </div>
</div>
@endsection
