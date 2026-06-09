@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-10 px-4 min-h-[calc(100vh-80px)]">
    
    <div class="flex flex-col sm:flex-row sm:items-end justify-between mb-8 gap-4">
        <div>
            <h2 class="text-3xl font-black text-gray-900 tracking-tight">Riwayat Pemesanan</h2>
            <p class="text-gray-500 text-sm mt-1">Kelola dan pantau semua reservasi Anda di sini.</p>
        </div>
        <a href="/" class="inline-flex items-center gap-1.5 text-sm font-semibold text-gray-500 hover:text-purple-600 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali ke Beranda
        </a>
    </div>

    @if($reservations->count() === 0)
        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-12 text-center flex flex-col items-center justify-center">
            <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
            </div>
            <h3 class="text-lg font-bold text-gray-900 mb-1">Belum Ada Riwayat Pemesanan</h3>
            <p class="text-gray-500 text-sm mb-6">Sepertinya Anda belum melakukan reservasi kamar. Ayo rencanakan liburan Anda sekarang!</p>
            <a href="/" class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-3 px-6 rounded-xl shadow-lg shadow-purple-600/20 transition-all active:scale-95">
                Pesan Kamar Sekarang
            </a>
        </div>
    @else
        <div class="space-y-4">
            @foreach($reservations as $r)
                <div class="bg-white p-5 md:p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-all flex flex-col md:flex-row gap-5 items-start md:items-center justify-between group">
                    
                    <div class="flex-1 w-full">
                        <div class="flex items-center gap-3 mb-3">
                            <span class="px-2.5 py-1 bg-emerald-50 text-emerald-600 rounded-md text-[10px] font-bold uppercase tracking-wider border border-emerald-100">
                                {{ $r->status ?? 'Confirmed' }}
                            </span>
                            <span class="text-xs font-bold text-gray-400 tracking-wider">ID: #{{ $r->reservation_code ?? $r->id }}</span>
                        </div>
                        
                        <h3 class="text-lg font-bold text-gray-900 mb-2">{{ $r->kamar->name ?? 'Kamar Standard' }}</h3>
                        
                        <div class="flex flex-wrap items-center gap-2 md:gap-3 text-sm text-gray-500 bg-gray-50 p-2.5 rounded-lg border border-gray-100 w-fit">
                            <div class="flex items-center gap-1.5 font-medium">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                {{ \Carbon\Carbon::parse($r->check_in)->format('d M Y') }}
                            </div>
                            <svg class="w-3.5 h-3.5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            <div class="flex items-center gap-1.5 font-medium">
                                {{ \Carbon\Carbon::parse($r->check_out)->format('d M Y') }}
                            </div>
                            <span class="text-gray-300 ml-1">|</span>
                            <span class="font-bold text-purple-600 ml-1">{{ $r->nights }} Malam</span>
                        </div>
                    </div>
                    
                    <div class="w-full md:w-auto flex flex-row md:flex-col items-center md:items-end justify-between border-t md:border-t-0 border-gray-100 pt-4 md:pt-0">
                        <div class="text-left md:text-right mb-0 md:mb-4">
                            <div class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-0.5">Total Harga</div>
                            <div class="text-lg md:text-xl font-black text-gray-900 group-hover:text-purple-700 transition-colors">Rp {{ number_format($r->total_price, 0, ',', '.') }}</div>
                        </div>
                        
                        <div class="flex gap-2">
                            <a href="{{ route('reservation.show', ['id' => $r->id]) }}#" class="px-4 py-2 border border-gray-200 text-gray-600 hover:bg-gray-50 hover:border-gray-300 rounded-xl text-xs font-bold transition-all">
                                Detail
                            </a>
                            <a href="{{ route('reservation.show', ['id' => $r->id]) }}" class="px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded-xl text-xs font-bold shadow-md shadow-purple-600/20 transition-all flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path></svg>
                                E-Voucher
                            </a>
                        </div>
                    </div>

                </div>
            @endforeach
        </div>

        <div class="mt-8 flex justify-center">
            {{ $reservations->links() }}
        </div>
    @endif
</div>

<style>
    nav[role="navigation"] {
        @apply flex items-center justify-between bg-white px-4 py-3 sm:px-6 rounded-xl border border-gray-100 shadow-sm;
    }
</style>
@endsection