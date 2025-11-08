@extends('admin.layout')

@section('title', isset($education) ? 'Edit Artikel' : 'Tambah Artikel')
@section('page-title', isset($education) ? 'Edit Artikel' : 'Tambah Artikel')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <form method="POST" action="{{ isset($education) ? route('admin.education.update', $education->id) : route('admin.education.store') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @if(isset($education))
                @method('PUT')
            @endif

            <!-- Title -->
            <div>
                <label for="title" class="block text-sm font-semibold text-gray-700 mb-2">
                    Judul Artikel <span class="text-red-500">*</span>
                </label>
                <input 
                    type="text" 
                    id="title"
                    name="title"
                    value="{{ old('title', $education->title ?? '') }}"
                    required
                    class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent transition-all"
                    placeholder="Masukkan judul artikel">
                @error('title')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Category -->
            <div>
                <label for="category" class="block text-sm font-semibold text-gray-700 mb-2">
                    Kategori <span class="text-red-500">*</span>
                </label>
                <select 
                    id="category"
                    name="category"
                    required
                    class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent transition-all bg-white">
                    <option value="">Pilih Kategori</option>
                    <option value="Anemia" {{ old('category', $education->category ?? '') === 'Anemia' ? 'selected' : '' }}>Anemia</option>
                    <option value="Menstruasi" {{ old('category', $education->category ?? '') === 'Menstruasi' ? 'selected' : '' }}>Menstruasi</option>
                    <option value="TTD" {{ old('category', $education->category ?? '') === 'TTD' ? 'selected' : '' }}>TTD</option>
                    <option value="Nutrisi" {{ old('category', $education->category ?? '') === 'Nutrisi' ? 'selected' : '' }}>Nutrisi</option>
                    <option value="Tips Sehat" {{ old('category', $education->category ?? '') === 'Tips Sehat' ? 'selected' : '' }}>Tips Sehat</option>
                </select>
                @error('category')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Image -->
            <div>
                <label for="image" class="block text-sm font-semibold text-gray-700 mb-2">
                    Gambar Artikel
                </label>
                @if(isset($education) && $education->image)
                    <div class="mb-3">
                        <div class="w-full max-w-md aspect-video rounded-lg overflow-hidden border border-gray-200 mb-2">
                            <img src="{{ $education->image_url ?? asset('images/icon.png') }}" alt="{{ $education->title }}" class="w-full h-full object-cover">
                        </div>
                        <p class="text-xs text-gray-500">Gambar saat ini (16:9)</p>
                    </div>
                @endif
                <input 
                    type="file" 
                    id="image"
                    name="image"
                    accept="image/*"
                    class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent transition-all">
                <div class="mt-2 p-3 bg-blue-50 border border-blue-200 rounded-lg">
                    <p class="text-xs font-semibold text-blue-800 mb-1">📐 Ukuran Gambar yang Disarankan:</p>
                    <ul class="text-xs text-blue-700 space-y-1 list-disc list-inside">
                        <li>Rasio aspek: <strong>16:9</strong> (landscape)</li>
                        <li>Ukuran ideal: <strong>1920x1080px</strong> atau <strong>1280x720px</strong></li>
                        <li>Format: JPG, PNG, GIF, WebP</li>
                        <li>Maksimal ukuran file: <strong>2MB</strong></li>
                    </ul>
                </div>
                @error('image')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Content -->
            <div>
                <label for="content" class="block text-sm font-semibold text-gray-700 mb-2">
                    Isi Artikel <span class="text-red-500">*</span>
                </label>
                <div class="border border-gray-200 rounded-lg overflow-hidden">
                    <div id="content" style="min-height: 400px;"></div>
                </div>
                <textarea 
                    id="content-hidden"
                    name="content"
                    style="display: none;">{{ old('content', $education->content ?? '') }}</textarea>
                <p class="mt-2 text-xs text-gray-500">Gunakan toolbar di atas untuk memformat teks (bold, italic, numbering, dll)</p>
                @error('content')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Actions -->
            <div class="flex items-center space-x-3 pt-4 border-t border-gray-200">
                <button 
                    type="submit"
                    class="px-6 py-2.5 text-sm font-semibold text-white rounded-lg transition-all"
                    style="background: linear-gradient(135deg, #ff79b8 0%, #feb4c8 100%);">
                    {{ isset($education) ? 'Perbarui Artikel' : 'Simpan Artikel' }}
                </button>
                <a href="{{ route('admin.educations') }}" class="px-6 py-2.5 text-sm font-semibold text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Quill Rich Text Editor -->
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize Quill editor
        var quill = new Quill('#content', {
            theme: 'snow',
            modules: {
                toolbar: [
                    [{ 'header': [1, 2, 3, false] }],
                    ['bold', 'italic', 'underline', 'strike'],
                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                    [{ 'color': [] }, { 'background': [] }],
                    [{ 'align': [] }],
                    ['link'],
                    ['clean']
                ]
            },
            placeholder: 'Masukkan isi artikel...',
        });

        // Set initial content if editing
        var initialContent = '';
        @if(isset($education) && $education->content)
            initialContent = {!! json_encode($education->content) !!};
        @elseif(old('content'))
            initialContent = {!! json_encode(old('content')) !!};
        @else
            initialContent = document.getElementById('content-hidden').value;
        @endif
        
        if (initialContent) {
            quill.root.innerHTML = initialContent;
        }

        // Update hidden textarea continuously as user types
        quill.on('text-change', function() {
            var contentTextarea = document.getElementById('content-hidden');
            var htmlContent = quill.root.innerHTML;
            // Only update if content is not just empty paragraph
            if (htmlContent.trim() !== '<p><br></p>' && htmlContent.trim() !== '<p></p>') {
                contentTextarea.value = htmlContent;
            } else {
                contentTextarea.value = '';
            }
        });

        // Update hidden textarea before form submit (as backup)
        var form = document.querySelector('form');
        form.addEventListener('submit', function(e) {
            var contentTextarea = document.getElementById('content-hidden');
            var htmlContent = quill.root.innerHTML;
            
            // Validate content is not empty
            var textContent = quill.getText().trim();
            if (!textContent) {
                e.preventDefault();
                alert('Isi artikel tidak boleh kosong!');
                return false;
            }
            
            // Update textarea with HTML content
            contentTextarea.value = htmlContent;
            
            // Ensure textarea has value
            if (!contentTextarea.value || contentTextarea.value.trim() === '' || contentTextarea.value.trim() === '<p><br></p>' || contentTextarea.value.trim() === '<p></p>') {
                e.preventDefault();
                alert('Isi artikel tidak boleh kosong!');
                return false;
            }
        });
    });
</script>
<style>
    .ql-editor {
        min-height: 400px;
        font-family: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif;
        font-size: 14px;
    }
    .ql-container {
        border-bottom-left-radius: 0.5rem;
        border-bottom-right-radius: 0.5rem;
    }
    .ql-toolbar {
        border-top-left-radius: 0.5rem;
        border-top-right-radius: 0.5rem;
        border-color: #e5e7eb;
    }
    .ql-container {
        border-color: #e5e7eb;
    }
</style>
@endsection

