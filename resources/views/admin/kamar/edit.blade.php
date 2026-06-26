@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    
    <div class="mb-8 flex items-center justify-between">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.kamar.index') }}" class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-full transition-colors" title="Kembali">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Kelola: <span class="text-purple-600">{{ $kamar->name }}</span></h1>
                <p class="text-sm text-gray-500 mt-1">Perbarui informasi, harga, dan ketersediaan kamar ini.</p>
            </div>
        </div>
    </div>

    @if(session('status'))
        <div class="mb-6 flex items-center p-4 bg-green-50 border-l-4 border-green-500 rounded-r-lg shadow-sm">
            <svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span class="text-sm font-medium text-green-800">{{ session('status') }}</span>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.kamar.update', $kamar->id) }}" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white p-6 sm:p-8 rounded-xl shadow-sm border border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6 border-b pb-3">Informasi Dasar</h3>
                    
                    <div class="space-y-5">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Kamar <span class="text-red-500">*</span></label>
                            <input type="text" name="name" value="{{ old('name', $kamar->name) }}" class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-purple-500 focus:border-purple-500 sm:text-sm transition-colors" required>
                        </div>
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Harga per malam <span class="text-red-500">*</span></label>
                                <div class="relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm">Rp</span>
                                    </div>
                                    <input type="number" name="price" value="{{ old('price', $kamar->price) }}" class="block w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 sm:text-sm transition-colors" min="0" required>
                                </div>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Kapasitas (Orang) <span class="text-red-500">*</span></label>
                                <div class="relative rounded-md shadow-sm">
                                    <input type="number" name="capacity" value="{{ old('capacity', $kamar->capacity) }}" class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 sm:text-sm transition-colors" min="1" required>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Lengkap</label>
                            <textarea name="description" rows="4" class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-purple-500 focus:border-purple-500 sm:text-sm transition-colors" placeholder="Fasilitas, pemandangan, ukuran kasur...">{{ old('description', $kamar->description) }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-6 sm:p-8 rounded-xl shadow-sm border border-gray-200">
                    <div class="flex justify-between items-center mb-4 border-b pb-3">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Manajemen Ketersediaan Spesifik</h3>
                            <p class="text-sm text-gray-500">Atur stok ketersediaan kamar untuk tanggal tertentu.</p>
                        </div>
                    </div>

                    @if($overrides->count() > 0)
                    <div class="mb-6 bg-gray-50 rounded-lg p-4 border border-gray-100">
                        <h4 class="text-sm font-medium text-gray-700 mb-3">Data Tersimpan (Centang untuk menghapus)</h4>
                        <div id="overrides_list" class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            @foreach($overrides as $ov)
                            <label class="flex items-center p-3 bg-white border border-gray-200 rounded-lg cursor-pointer hover:bg-red-50 hover:border-red-200 transition-colors group">
                                <input type="checkbox" name="delete_override[]" value="{{ $ov->id }}" class="w-4 h-4 text-red-600 border-gray-300 rounded focus:ring-red-500">
                                <div class="ml-3 flex flex-col">
                                    <span class="text-sm font-medium text-gray-900 group-hover:text-red-700">{{ \Carbon\Carbon::parse($ov->date)->format('d M Y') }}</span>
                                    <span class="text-xs text-gray-500 group-hover:text-red-500">Tersedia: <strong class="text-gray-900 group-hover:text-red-700">{{ $ov->available }}</strong> kamar</span>
                                </div>
                            </label>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <div>
                        <h4 class="text-sm font-medium text-gray-700 mb-3">Tambah Pengaturan Baru</h4>
                        <div id="new_overrides" class="space-y-3">
                            <div class="flex flex-col sm:flex-row gap-3 items-start sm:items-center">
                                <input type="date" name="override_date[]" class="w-full sm:w-auto px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 sm:text-sm">
                                <input type="number" name="override_available[]" class="w-full sm:w-32 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 sm:text-sm" placeholder="Jml Stok">
                            </div>
                        </div>
                        <button type="button" id="add_override" class="mt-4 inline-flex items-center text-sm font-medium text-purple-600 hover:text-purple-800 transition-colors">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                            Tambah Tanggal Lain
                        </button>
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 border-b pb-3">Ketersediaan</h3>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Stok Default <span class="text-red-500">*</span></label>
                        <p class="text-xs text-gray-500 mb-3">Jumlah kamar fisik yang tersedia setiap harinya.</p>
                        <input type="number" name="stock" value="{{ old('stock', $kamar->stock) }}" class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-purple-500 focus:border-purple-500 sm:text-sm transition-colors" min="0" required>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 border-b pb-3">Foto Kamar</h3>
                    
                    @if($kamar->image)
                        <div class="mb-4">
                            <label class="block text-xs font-medium text-gray-500 mb-2 uppercase tracking-wider">Foto Saat Ini</label>
                            <img src="{{ asset($kamar->image) }}" alt="{{ $kamar->name }}" class="w-full h-48 object-cover rounded-lg border border-gray-200 shadow-sm">
                        </div>
                    @endif

                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-2 uppercase tracking-wider">Unggah Baru</label>
                        <div id="dropzone-edit" class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-purple-500 hover:bg-purple-50 transition-colors cursor-pointer">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-gray-600 justify-center">
                                    <label for="edit-file-upload" class="relative cursor-pointer bg-transparent rounded-md font-medium text-purple-600 hover:text-purple-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-purple-500">
                                        <span id="edit-file-label">Pilih file</span>
                                        <input id="edit-file-upload" name="image" type="file" accept="image/*" class="sr-only">
                                    </label>
                                    <p class="pl-1">atau drag and drop</p>
                                </div>
                                <p id="edit-file-hint" class="text-xs text-gray-500">PNG, JPG, WEBP maks 2MB</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="flex items-center justify-end gap-3 pt-6 border-t border-gray-200">
            <a href="{{ route('admin.kamar.index') }}" class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition-colors">Batal</a>
            <button type="submit" class="px-5 py-2.5 text-sm font-medium text-white bg-purple-600 border border-transparent rounded-lg hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 shadow-sm transition-colors">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const addOverrideButton = document.getElementById('add_override');
        if (addOverrideButton) {
            addOverrideButton.addEventListener('click', function () {
                const container = document.getElementById('new_overrides');
                const div = document.createElement('div');
                div.className = 'flex flex-col sm:flex-row gap-3 items-start sm:items-center mt-3 pt-3 border-t border-dashed border-gray-200';
                div.innerHTML = `
                    <input type="date" name="override_date[]" class="w-full sm:w-auto px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 sm:text-sm"> 
                    <input type="number" name="override_available[]" class="w-full sm:w-32 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 sm:text-sm" placeholder="Jml Stok"> 
                    <button type="button" class="text-red-500 hover:text-red-700 hover:bg-red-50 px-3 py-2 rounded-lg text-sm font-medium transition-colors remove">Hapus Baris</button>
                `;
                container.appendChild(div);
                div.querySelector('.remove').addEventListener('click', () => div.remove());
            });
        }

        const input = document.getElementById('edit-file-upload');
        const label = document.getElementById('edit-file-label');
        const hint = document.getElementById('edit-file-hint');
        const dropzone = document.getElementById('dropzone-edit');

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