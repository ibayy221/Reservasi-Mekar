@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    <!-- Header Section -->
    <div class="mb-8 flex items-center justify-between">
        <div>
            <div class="flex items-center space-x-3 mb-2">
                <a href="{{ route('admin.events.index') }}" class="p-2 bg-white rounded-full text-gray-500 hover:text-purple-600 hover:bg-purple-50 transition-colors shadow-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                </a>
                <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Edit Event</h1>
            </div>
            <p class="text-gray-500 ml-11">Perbarui informasi, jadwal, dan tampilan event Anda di bawah ini.</p>
        </div>
    </div>

    <!-- Error Alert -->
    @if ($errors->any())
        <div class="mb-8 bg-red-50 border-l-4 border-red-500 p-4 rounded-r-lg shadow-sm">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-red-800">Terdapat {{ $errors->count() }} kesalahan pada isian form:</h3>
                    <div class="mt-2 text-sm text-red-700">
                        <ul class="list-disc pl-5 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <form action="{{ route('admin.events.update', $event->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Card 1: Informasi Dasar -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-800">Informasi Dasar</h2>
                <p class="text-sm text-gray-500">Judul, deskripsi, dan fitur utama dari event.</p>
            </div>
            <div class="p-6 space-y-5">
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Judul Event <span class="text-red-500">*</span></label>
                    <input type="text" id="title" name="title" value="{{ old('title', $event->title) }}" required 
                        class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-lg text-gray-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-200 @error('title') border-red-500 ring-1 ring-red-500 @enderror">
                    @error('title') <span class="text-red-500 text-xs mt-1.5 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Lengkap <span class="text-red-500">*</span></label>
                    <textarea id="description" name="description" rows="4" required 
                        class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-lg text-gray-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-200 @error('description') border-red-500 ring-1 ring-red-500 @enderror">{{ old('description', $event->description) }}</textarea>
                    @error('description') <span class="text-red-500 text-xs mt-1.5 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="features" class="block text-sm font-medium text-gray-700 mb-1">Fitur Unggulan</label>
                    <div class="relative">
                        <textarea id="features" name="features_text" rows="3" placeholder="Contoh:&#10;Kapasitas 1000 orang&#10;Full AC & Sound System&#10;Lahan Parkir Luas" 
                            class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-lg text-gray-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-200 font-mono text-sm leading-relaxed">{{ old('features_text', $event->features ? implode("\n", $event->features ?? []) : '') }}</textarea>
                        <div class="absolute right-3 top-3 text-gray-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path></svg>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500 mt-2 flex items-center">
                        <svg class="w-4 h-4 mr-1 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Pisahkan setiap fitur dengan baris baru (Enter).
                    </p>
                    @error('features') <span class="text-red-500 text-xs mt-1.5 block">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>

        <!-- Card 2: Visual & Tampilan -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-800">Visual & Tampilan</h2>
                <p class="text-sm text-gray-500">Pengaturan gambar cover dan label/badge event.</p>
            </div>
            <div class="p-6 space-y-5">
                <div>
                    <label for="image_path" class="block text-sm font-medium text-gray-700 mb-1">Gambar Header</label>
                    <div class="space-y-2">
                        @if(!empty($event->image_path))
                            <div class="flex items-center space-x-4">
                                <div class="w-28 h-20 bg-gray-100 rounded overflow-hidden border">
                                    <img id="current-image" src="{{ asset('storage/' . $event->image_path) }}" alt="Gambar header" class="object-cover w-full h-full">
                                </div>
                                <div class="text-sm text-gray-600">Gambar saat ini: <span class="font-medium">{{ basename($event->image_path) }}</span></div>
                            </div>
                        @endif

                        <div>
                            <input type="file" id="image_path" name="image_path" accept="image/*"
                                class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-lg text-gray-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-200">
                            <input type="hidden" name="existing_image" value="{{ old('image_path', $event->image_path) }}">
                        </div>

                        <div id="preview-container" class="hidden">
                            <p class="text-sm text-gray-500">Preview file terpilih:</p>
                            <div class="w-36 h-24 bg-gray-100 rounded overflow-hidden border mt-2">
                                <img id="preview-image" src="#" alt="Preview" class="object-cover w-full h-full">
                            </div>
                        </div>
                    </div>
                    @error('image_path') <span class="text-red-500 text-xs mt-1.5 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="badge" class="block text-sm font-medium text-gray-700 mb-1">Teks Badge <span class="text-red-500">*</span></label>
                    <input type="text" id="badge" name="badge" value="{{ old('badge', $event->badge) }}" required placeholder="Misal: Promo, Terlaris, Spesial" 
                        class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-lg text-gray-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-200">
                    @error('badge') <span class="text-red-500 text-xs mt-1.5 block">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>

        <!-- Card 3: Jadwal & Tautan -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-800">Jadwal & Tautan Terkait</h2>
            </div>
            <div class="p-6 space-y-5">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                            <input type="date" id="start_date" name="start_date" value="{{ old('start_date', $event->start_date) }}" 
                                class="w-full pl-10 px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-lg text-gray-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-200">
                        </div>
                        @error('start_date') <span class="text-red-500 text-xs mt-1.5 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Selesai</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                            <input type="date" id="end_date" name="end_date" value="{{ old('end_date', $event->end_date) }}" 
                                class="w-full pl-10 px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-lg text-gray-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-200">
                        </div>
                        @error('end_date') <span class="text-red-500 text-xs mt-1.5 block">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label for="link" class="block text-sm font-medium text-gray-700 mb-1">Tautan Eksternal (URL)</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                            </div>
                            <input type="text" id="link" name="link" value="{{ old('link', $event->link) }}" placeholder="https://... atau /events/wedding" 
                                pattern="^(\/.*|https?:\/\/.*)$" title="Masukkan URL absolut (https://...) atau path relatif yang diawali /" 
                                class="w-full pl-10 px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-lg text-gray-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-200">
                        </div>
                        @error('link') <span class="text-red-500 text-xs mt-1.5 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="order" class="block text-sm font-medium text-gray-700 mb-1">Nomor Urutan Tampil <span class="text-red-500">*</span></label>
                        <input type="number" id="order" name="order" value="{{ old('order', $event->order) }}" required min="0" 
                            class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-lg text-gray-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-200">
                        <p class="text-xs text-gray-500 mt-2">Urutan prioritas saat ditampilkan (angka lebih kecil = lebih awal).</p>
                        @error('order') <span class="text-red-500 text-xs mt-1.5 block">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- Sticky Action Footer -->
        <div class="sticky bottom-4 z-10 flex items-center justify-end space-x-4 bg-white/80 backdrop-blur-md p-4 rounded-xl border border-gray-200 shadow-lg">
            <a href="{{ route('admin.events.index') }}" class="px-6 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition-all duration-200">
                Batal
            </a>
            <button type="submit" class="px-6 py-2.5 text-sm font-medium text-white bg-purple-600 rounded-lg hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 shadow-sm transition-all duration-200 flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle features textarea - convert newlines to array on submit
    const form = document.querySelector('form');
    form.addEventListener('submit', function() {
        const featuresText = document.getElementById('features').value;
        if (featuresText) {
            const features = featuresText.split('\n').filter(f => f.trim());
            // Create hidden input with JSON array
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'features';
            input.value = JSON.stringify(features);
            form.appendChild(input);
        }
    });
});

// Image preview for uploaded header
document.getElementById('image_path')?.addEventListener('change', function(e) {
    const file = e.target.files && e.target.files[0];
    const previewContainer = document.getElementById('preview-container');
    const previewImage = document.getElementById('preview-image');
    if (file) {
        const reader = new FileReader();
        reader.onload = function(ev) {
            previewImage.src = ev.target.result;
            previewContainer.classList.remove('hidden');
        }
        reader.readAsDataURL(file);
    } else {
        if (previewContainer) previewContainer.classList.add('hidden');
    }
});
</script>
@endsection