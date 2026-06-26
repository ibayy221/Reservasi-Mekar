@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <div class="mb-6">
        <a href="{{ route('admin.kamar.index') }}" class="text-sm text-purple-600 hover:text-purple-700 font-medium">&larr; Kembali ke daftar kamar</a>
        <h1 class="text-2xl font-bold text-gray-900 mt-2">Tambah Kamar Baru</h1>
        <p class="text-sm text-gray-500 mt-1">Isi detail kamar untuk menambah inventaris baru.</p>
    </div>

    <form action="{{ route('admin.kamar.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama Kamar</label>
                    <input type="text" name="name" value="{{ old('name') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-purple-500" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Harga / malam</label>
                    <input type="number" name="price" value="{{ old('price') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-purple-500" min="0" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Kapasitas</label>
                    <input type="number" name="capacity" value="{{ old('capacity', 2) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-purple-500" min="1" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Stok</label>
                    <input type="number" name="stock" value="{{ old('stock', 1) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-purple-500" min="0" required>
                </div>
            </div>

            <div class="mt-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                <textarea name="description" rows="4" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-purple-500">{{ old('description') }}</textarea>
            </div>

            <div class="mt-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Foto Kamar</label>
                <div id="dropzone-create" class="mt-2 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-purple-500 hover:bg-purple-50 transition-colors cursor-pointer">
                    <div class="space-y-1 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <div class="flex text-sm text-gray-600 justify-center">
                            <label for="create-file-upload" class="relative cursor-pointer font-medium text-purple-600 hover:text-purple-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-purple-500">
                                <span id="create-file-label">Pilih file</span>
                                <input id="create-file-upload" name="image" type="file" accept="image/*" class="sr-only">
                            </label>
                            <p class="pl-1">atau drag and drop</p>
                        </div>
                        <p id="create-file-hint" class="text-xs text-gray-500">PNG, JPG, WEBP maks 2MB</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex justify-end gap-3">
            <a href="{{ route('admin.kamar.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50">Batal</a>
            <button type="submit" class="px-4 py-2 bg-purple-600 text-white rounded-lg text-sm font-semibold hover:bg-purple-700">Simpan Kamar</button>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const input = document.getElementById('create-file-upload');
        const label = document.getElementById('create-file-label');
        const hint = document.getElementById('create-file-hint');
        const dropzone = document.getElementById('dropzone-create');

        if (!input || !dropzone || !label || !hint) return;

        const setFileName = (file) => {
            if (!file) {
                label.textContent = 'Pilih file';
                hint.textContent = 'PNG, JPG, WEBP maks 2MB';
                return;
            }

            label.textContent = file.name;
            hint.textContent = `Terpilih: ${file.name}`;
        };

        input.addEventListener('change', function () {
            if (input.files && input.files[0]) {
                setFileName(input.files[0]);
            }
        });

        dropzone.addEventListener('click', function () {
            input.click();
        });

        ['dragenter', 'dragover'].forEach(function (eventName) {
            dropzone.addEventListener(eventName, function (event) {
                event.preventDefault();
                dropzone.classList.add('border-purple-500', 'bg-purple-50');
            });
        });

        ['dragleave', 'dragend', 'drop'].forEach(function (eventName) {
            dropzone.addEventListener(eventName, function (event) {
                event.preventDefault();
                dropzone.classList.remove('border-purple-500', 'bg-purple-50');
            });
        });

        dropzone.addEventListener('drop', function (event) {
            const file = event.dataTransfer && event.dataTransfer.files[0];
            if (!file) return;

            const dataTransfer = new DataTransfer();
            dataTransfer.items.add(file);
            input.files = dataTransfer.files;
            setFileName(file);
        });
    });
</script>
@endsection
