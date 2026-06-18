@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Tambah Event Baru</h1>

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                <h3 class="font-bold">Ada kesalahan:</h3>
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.events.store') }}" method="POST" class="bg-white rounded-lg shadow p-6">
            @csrf

            <div class="mb-4">
                <label for="title" class="block text-gray-700 font-medium mb-2">Judul Event <span class="text-red-500">*</span></label>
                <input type="text" id="title" name="title" value="{{ old('title') }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                @error('title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label for="description" class="block text-gray-700 font-medium mb-2">Deskripsi <span class="text-red-500">*</span></label>
                <textarea id="description" name="description" rows="4" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">{{ old('description') }}</textarea>
                @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label for="image_path" class="block text-gray-700 font-medium mb-2">Path Gambar</label>
                <input type="text" id="image_path" name="image_path" value="{{ old('image_path') }}" placeholder="contoh: /Asset/events/wedding.jpg" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                @error('image_path') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                <p class="text-sm text-gray-500 mt-1">Lokasi gambar di folder public/</p>
            </div>

            <div class="mb-4">
                <label for="badge" class="block text-gray-700 font-medium mb-2">Badge <span class="text-red-500">*</span></label>
                <input type="text" id="badge" name="badge" value="{{ old('badge') }}" required placeholder="contoh: Populer" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                @error('badge') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label for="features" class="block text-gray-700 font-medium mb-2">Fitur (satu per baris)</label>
                <textarea id="features" name="features_text" rows="3" placeholder="Ballroom&#10;Catering&#10;Decoration" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">{{ old('features_text', $event->features ? implode("\n", $event->features ?? []) : '') }}</textarea>
                @error('features') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="start_date" class="block text-gray-700 font-medium mb-2">Tanggal Mulai</label>
                    <input type="date" id="start_date" name="start_date" value="{{ old('start_date') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                    @error('start_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="end_date" class="block text-gray-700 font-medium mb-2">Tanggal Selesai</label>
                    <input type="date" id="end_date" name="end_date" value="{{ old('end_date') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                    @error('end_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="mb-4">
                <label for="link" class="block text-gray-700 font-medium mb-2">Link (URL)</label>
                <input type="url" id="link" name="link" value="{{ old('link') }}" placeholder="https://example.com" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                @error('link') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mb-6">
                <label for="order" class="block text-gray-700 font-medium mb-2">Urutan <span class="text-red-500">*</span></label>
                <input type="number" id="order" name="order" value="{{ old('order', 1) }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                @error('order') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="flex justify-between">
                <a href="{{ route('admin.events.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg">
                    Batal
                </a>
                <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg">
                    Simpan Event
                </button>
            </div>
        </form>
    </div>
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
</script>
@endsection
