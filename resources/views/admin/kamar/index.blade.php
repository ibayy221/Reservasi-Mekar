@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Kelola Kamar</h1>
            <p class="text-sm text-gray-500 mt-1">Manajemen inventaris, harga, dan ketersediaan kamar.</p>
        </div>
        
        <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto">
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <input type="text" placeholder="Cari kamar..." class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-purple-500 focus:border-purple-500 sm:text-sm transition duration-150 ease-in-out">
            </div>

            <a href="{{ route('admin.kamar.create') }}" class="inline-flex justify-center items-center px-4 py-2 bg-purple-600 border border-transparent rounded-lg font-semibold text-sm text-white hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 transition-all shadow-sm">
                <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Tambah Kamar
            </a>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 text-left text-sm whitespace-nowrap">
                <thead class="bg-gray-50/75">
                    <tr>
                        <th scope="col" class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Nama Kamar</th>
                        <th scope="col" class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Spesifikasi</th>
                        <th scope="col" class="px-6 py-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Ketersediaan</th>
                        <th scope="col" class="px-6 py-4 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 bg-white text-gray-700">
                    
                    @forelse($kamars as $k)
                    <tr class="hover:bg-gray-50/50 transition-colors duration-200 group">
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="h-12 w-16 flex-shrink-0 rounded-md bg-gray-100 border border-gray-200 overflow-hidden">
                                    @if(!empty($k->image) && file_exists(public_path($k->image)))
                                        <img src="{{ asset($k->image) }}" alt="{{ $k->name }}" class="h-full w-full object-cover">
                                    @else
                                        <svg class="h-full w-full text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    @endif
                                </div>
                                <div class="ml-4">
                                    <div class="font-semibold text-gray-900 group-hover:text-purple-700 transition-colors">{{ $k->name }}</div>
                                    <div class="text-xs text-gray-500 mt-0.5">ID: #{{ str_pad($k->id, 5, '0', STR_PAD_LEFT) }}</div>
                                </div>
                            </div>
                        </td>

                        <td class="px-6 py-4">
                            <div class="flex flex-col gap-1.5">
                                <div class="flex items-center text-gray-600">
                                    <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                    </svg>
                                    <span class="text-sm">{{ $k->capacity }} Tamu</span>
                                </div>
                                <div class="flex items-center font-medium text-gray-900">
                                    <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                    </svg>
                                    <span>Rp {{ number_format($k->price, 0, ',', '.') }}<span class="text-xs text-gray-500 font-normal"> / malam</span></span>
                                </div>
                            </div>
                        </td>

                        <td class="px-6 py-4 text-center">
                            @if($k->stock > 5)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-50 text-green-700 ring-1 ring-inset ring-green-600/20">
                                    <span class="w-1.5 h-1.5 rounded-full bg-green-600 mr-2"></span>
                                    {{ $k->stock }} Tersedia
                                </span>
                            @elseif($k->stock > 0)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-yellow-50 text-yellow-700 ring-1 ring-inset ring-yellow-600/20">
                                    <span class="w-1.5 h-1.5 rounded-full bg-yellow-600 mr-2"></span>
                                    Sisa {{ $k->stock }}
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-red-50 text-red-700 ring-1 ring-inset ring-red-600/10">
                                    <span class="w-1.5 h-1.5 rounded-full bg-red-600 mr-2"></span>
                                    Penuh / Habis
                                </span>
                            @endif
                        </td>

                        <td class="px-6 py-4 text-right">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('admin.kamar.edit', $k->id) }}" class="p-2 text-gray-400 hover:text-purple-600 hover:bg-purple-50 rounded-lg transition-all" title="Edit Kamar">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </a>
                                <form action="{{ route('admin.kamar.destroy', $k->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus kamar ini?');" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all" title="Hapus Kamar">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <div class="bg-gray-50 rounded-full p-4 mb-4">
                                    <svg class="h-10 w-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                    </svg>
                                </div>
                                <h3 class="text-base font-medium text-gray-900">Belum ada data kamar</h3>
                                <p class="mt-1 text-sm text-gray-500 max-w-sm">Inventaris kamar masih kosong. Silakan tambahkan data tipe kamar baru untuk memulai manajemen hotel.</p>
                                <a href="{{ route('admin.kamar.create') }}" class="mt-4 inline-flex items-center px-4 py-2 border border-purple-600 rounded-lg shadow-sm text-sm font-medium text-purple-600 hover:bg-purple-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition-colors">
                                    Tambah Kamar Sekarang
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endempty
                    
                </tbody>
            </table>
        </div>
        
        @if(count($kamars) > 0)
        <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
            <div class="flex items-center justify-between text-sm text-gray-500">
                <span>Menampilkan 1 hingga {{ count($kamars) }} data</span>
                </div>
        </div>
        @endif
    </div>
</div>
@endsection