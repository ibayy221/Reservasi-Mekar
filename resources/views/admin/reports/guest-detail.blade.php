@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-8 lg:px-8">
    
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
        <div>
            <a href="{{ route('admin.reports.guests') }}" class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-purple-600 transition-colors mb-3">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali ke Laporan Tamu
            </a>
            <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Informasi Lengkap Tamu</h1>
            <p class="text-sm text-gray-500 mt-1">Detail reservasi, identitas tamu, dan rincian pembayaran.</p>
        </div>
        
        <div class="flex gap-3">
            <button class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 shadow-sm transition-colors">
                <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                Cetak Dokumen
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 lg:gap-8">
        
        <div class="lg:col-span-2 space-y-6">
            
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-2">
                    <div class="p-1.5 bg-purple-100 rounded-lg text-purple-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    </div>
                    <h3 class="text-base font-bold text-gray-900">Identitas Tamu</h3>
                </div>
                
                <div class="p-6 grid grid-cols-1 sm:grid-cols-2 gap-y-6 gap-x-8">
                    <div>
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Nama Lengkap</p>
                        <p class="text-base font-semibold text-gray-900">{{ $reservation->user->name ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">NIK / KTP</p>
                        <p class="text-base font-semibold text-gray-900 flex items-center gap-2">
                            {{ $reservation->user->nik_ktp ?? '-' }}
                        </p>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Email</p>
                        @if(isset($reservation->user->email))
                            <a href="mailto:{{ $reservation->user->email }}" class="text-base font-medium text-purple-600 hover:text-purple-800 hover:underline inline-flex items-center gap-1.5 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                {{ $reservation->user->email }}
                            </a>
                        @else
                            <p class="text-base font-medium text-gray-900">-</p>
                        @endif
                    </div>
                    <div>
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Nomor Handphone</p>
                        @if(isset($reservation->user->no_hp))
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $reservation->user->no_hp) }}" target="_blank" class="text-base font-medium text-green-600 hover:text-green-800 hover:underline inline-flex items-center gap-1.5 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                {{ $reservation->user->no_hp }}
                            </a>
                        @else
                            <p class="text-base font-medium text-gray-900">-</p>
                        @endif
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                    <div class="flex items-center gap-2">
                        <div class="p-1.5 bg-blue-100 rounded-lg text-blue-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                        <h3 class="text-base font-bold text-gray-900">Spesifikasi Reservasi</h3>
                    </div>
                    
                    @php
                        $status = strtolower($reservation->status ?? '');
                        $badgeClass = 'bg-gray-100 text-gray-800'; // Default
                        if(in_array($status, ['confirmed', 'paid', 'success'])) $badgeClass = 'bg-green-100 text-green-800';
                        if(in_array($status, ['pending', 'unpaid'])) $badgeClass = 'bg-yellow-100 text-yellow-800';
                        if(in_array($status, ['cancelled', 'failed'])) $badgeClass = 'bg-red-100 text-red-800';
                    @endphp
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider {{ $badgeClass }}">
                        {{ $reservation->status ?? 'Unknown' }}
                    </span>
                </div>
                
                <div class="p-6 grid grid-cols-1 sm:grid-cols-2 gap-y-6 gap-x-8">
                    <div>
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Kode Reservasi</p>
                        <p class="text-base font-mono font-bold text-gray-900 bg-gray-50 p-2 rounded border border-gray-200 inline-block">
                            {{ $reservation->reservation_code ?? '-' }}
                        </p>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Tipe Kamar</p>
                        <p class="text-base font-semibold text-gray-900">{{ $reservation->kamar->name ?? '-' }}</p>
                    </div>
                    
                    <div class="sm:col-span-2 border-t border-gray-100 pt-6 mt-2 grid grid-cols-1 sm:grid-cols-3 gap-6">
                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Check-in</p>
                            <p class="text-base font-semibold text-gray-900">{{ $reservation->check_in ? \Carbon\Carbon::parse($reservation->check_in)->translatedFormat('d M Y') : '-' }}</p>
                            <p class="text-sm text-gray-500">14:00 WIB</p>
                        </div>
                        <div class="hidden sm:flex items-center justify-center text-gray-300">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </div>
                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Check-out</p>
                            <p class="text-base font-semibold text-gray-900">{{ $reservation->check_out ? \Carbon\Carbon::parse($reservation->check_out)->translatedFormat('d M Y') : '-' }}</p>
                            <p class="text-sm text-gray-500">12:00 WIB</p>
                        </div>
                    </div>

                    <div>
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Kapasitas Tamu</p>
                        <p class="text-base font-semibold text-gray-900 flex items-center gap-2">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            {{ $reservation->adults ?? 0 }} Dewasa, {{ $reservation->children ?? 0 }} Anak
                        </p>
                    </div>

                    <div class="sm:col-span-2 bg-yellow-50/50 p-4 rounded-lg border border-yellow-100">
                        <p class="text-xs font-medium text-yellow-800 uppercase tracking-wider mb-1 flex items-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path></svg>
                            Catatan Khusus / Request
                        </p>
                        <p class="mt-1 text-sm text-gray-700 font-medium">
                            {{ $reservation->special_requests ?: 'Tidak ada catatan khusus dari tamu.' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="space-y-6 lg:sticky lg:top-8">
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-2">
                    <div class="p-1.5 bg-green-100 rounded-lg text-green-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2zM10 8.5a.5.5 0 11-1 0 .5.5 0 011 0zm5 5a.5.5 0 11-1 0 .5.5 0 011 0z"></path></svg>
                    </div>
                    <h3 class="text-base font-bold text-gray-900">Rincian Biaya</h3>
                </div>
                
                <div class="p-6 space-y-4">
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-gray-500">Harga Kamar</span>
                        <span class="font-medium text-gray-900">Rp {{ number_format(($reservation->total_price ?? 0) / max($reservation->nights ?? 1, 1), 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-gray-500">Durasi Menginap</span>
                        <span class="font-medium text-gray-900">{{ $reservation->nights ?? 0 }} Malam</span>
                    </div>
                    
                    <div class="pt-4 border-t border-dashed border-gray-200">
                        <div class="flex justify-between items-end">
                            <span class="text-sm font-semibold text-gray-900">Total Pembayaran</span>
                            <span class="text-2xl font-extrabold text-purple-700">Rp {{ number_format($reservation->total_price ?? 0, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <div class="mt-6 bg-gray-50 p-4 rounded-lg border border-gray-100">
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Payment ID / Transaksi</p>
                        <p class="text-sm font-mono font-medium text-gray-900 break-all">
                            {{ $reservation->payment_id ?? 'Belum ada ID pembayaran' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</div>
@endsection