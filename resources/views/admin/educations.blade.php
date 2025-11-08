@extends('admin.layout')

@section('title', 'Konten Edukasi')
@section('page-title', 'Konten Edukasi')

@section('content')
<div class="space-y-4">
    <!-- Header Actions -->
    <div class="flex items-center justify-between">
        <h2 class="text-sm font-semibold text-gray-900">Daftar Artikel Edukasi</h2>
        <a href="{{ route('admin.education.create') }}" class="px-3 py-1.5 text-xs font-semibold text-white rounded-lg transition-all" style="background: linear-gradient(135deg, #ff79b8 0%, #feb4c8 100%);">
            + Tambah Artikel
        </a>
    </div>

    <!-- Educations List -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-4 py-2 text-left text-xs font-semibold text-gray-700 uppercase">Gambar</th>
                        <th class="px-4 py-2 text-left text-xs font-semibold text-gray-700 uppercase">Judul</th>
                        <th class="px-4 py-2 text-left text-xs font-semibold text-gray-700 uppercase">Kategori</th>
                        <th class="px-4 py-2 text-left text-xs font-semibold text-gray-700 uppercase">Dibuat</th>
                        <th class="px-4 py-2 text-left text-xs font-semibold text-gray-700 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($educations as $education)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-4 py-3 whitespace-nowrap">
                                @if($education->image)
                                    <div class="w-20 aspect-video rounded-lg overflow-hidden">
                                        <img src="{{ $education->image_url ?? asset('images/icon.png') }}" alt="{{ $education->title }}" class="w-full h-full object-cover">
                                    </div>
                                @else
                                    <div class="w-20 aspect-video bg-gray-100 rounded-lg flex items-center justify-center">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                <p class="text-xs font-semibold text-gray-900">{{ $education->title }}</p>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <span class="px-2 py-0.5 text-[10px] font-semibold bg-pink-100 text-pink-700 rounded-full">
                                    {{ $education->category }}
                                </span>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <p class="text-xs text-gray-600">{{ $education->created_at->format('d M Y') }}</p>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-xs">
                                <div class="flex items-center space-x-2">
                                    <a href="{{ route('admin.education.edit', $education->id) }}" class="text-sidarku-primary hover:text-sidarku-primary-dark transition-colors">
                                        Edit
                                    </a>
                                    <form method="POST" action="{{ route('admin.education.delete', $education->id) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus artikel ini?')" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-700 transition-colors">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-6 text-center text-xs text-gray-500">
                                Belum ada artikel. <a href="{{ route('admin.education.create') }}" class="text-sidarku-primary hover:text-sidarku-primary-dark">Tambah artikel pertama</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($educations->hasPages())
            <div class="px-4 py-3 border-t border-gray-200">
                {{ $educations->links() }}
            </div>
        @endif
    </div>
</div>
@endsection

