@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto py-6 px-4 min-h-[calc(100vh-80px)] flex flex-col justify-center items-center">
    
    <div class="text-center mb-6">
        <div class="w-16 h-16 bg-emerald-100 rounded-full flex items-center justify-center mx-auto mb-4 animate-bounce-short">
            <svg class="w-8 h-8 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
        </div>
        <h2 class="text-3xl font-extrabold text-gray-800 tracking-tight">Reservasi Berhasil!</h2>
        <p class="text-gray-500 text-sm mt-2">Terima kasih, pesanan Anda telah dikonfirmasi dan tercatat di sistem kami.</p>
    </div>

    <div class="w-full bg-white rounded-2xl shadow-md shadow-gray-200/50 border border-gray-100 overflow-hidden relative">
        
        <div class="absolute w-6 h-6 bg-gray-50 rounded-full -left-3 top-[110px] border-r border-gray-100 hidden sm:block"></div>
        <div class="absolute w-6 h-6 bg-gray-50 rounded-full -right-3 top-[110px] border-l border-gray-100 hidden sm:block"></div>

        <div class="p-6">
            <div class="flex justify-between items-start mb-6">
                <div>
                    <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider block mb-1">ID Pesanan</span>
                    <span class="text-sm font-bold text-gray-800">#{{ $reservation->reservation_code ?? $reservation->id }}</span>
                </div>
                <div class="bg-emerald-50 text-emerald-700 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider border border-emerald-100">
                    {{ $reservation->status }}
                </div>
            </div>

            <div>
                <h3 class="text-xl font-bold text-gray-800">{{ $reservation->kamar->name }}</h3>
                <p class="text-sm text-gray-500 mt-1">{{ $reservation->adults }} Dewasa, {{ $reservation->children }} Anak • {{ $reservation->nights }} Malam</p>
            </div>
        </div>

        <div class="border-t-2 border-dashed border-gray-200"></div>

        <div class="p-6 bg-gray-50/50">
            <div class="flex justify-between items-center bg-white p-4 rounded-xl border border-gray-100">
                <div class="w-full">
                    <span class="block text-xs text-gray-400 font-medium uppercase mb-1">Check-In</span>
                    <span class="block text-sm font-bold text-gray-800">{{ $reservation->check_in }}</span>
                </div>
                <div class="flex-shrink-0 px-4 text-gray-300">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </div>
                <div class="w-full text-right">
                    <span class="block text-xs text-gray-400 font-medium uppercase mb-1">Check-Out</span>
                    <span class="block text-sm font-bold text-gray-800">{{ $reservation->check_out }}</span>
                </div>
            </div>

            @if(!empty($reservation->smoking_preference) || !empty($reservation->bed_setup) || !empty($reservation->special_requests))
            <div class="mt-5 p-4 bg-orange-50/50 rounded-xl border border-orange-100/50 text-sm">
                <h4 class="text-xs font-bold text-orange-800 uppercase mb-3 flex items-center gap-1">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path></svg>
                    Permintaan Khusus
                </h4>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-2 gap-x-4">
                    @if($reservation->smoking_preference)
                        <div class="text-gray-600"><span class="font-semibold text-gray-800">Tipe:</span> {{ $reservation->smoking_preference == 'non-smoking' ? 'Non-smoking' : 'Smoking' }}</div>
                    @endif
                    @if($reservation->bed_setup)
                        <div class="text-gray-600"><span class="font-semibold text-gray-800">Kasur:</span> {{ $reservation->bed_setup == 'large' ? '1 Bed Besar' : 'Twin Bed' }}</div>
                    @endif
                    @if($reservation->special_requests)
                        <div class="text-gray-600 sm:col-span-2 mt-1"><span class="font-semibold text-gray-800">Catatan:</span> "{{ $reservation->special_requests }}"</div>
                    @endif
                </div>
            </div>
            @endif
        </div>

        <div class="p-6 bg-emerald-600 text-white flex justify-between items-end rounded-b-2xl">
            <span class="text-emerald-100 text-sm font-medium">Total Pembayaran</span>
            <span class="text-2xl font-black">Rp {{ number_format($reservation->total_price, 0, ',', '.') }}</span>
        </div>
    </div>

    <div class="mt-8 w-full flex justify-center gap-4">
        <a href="/" class="bg-gray-900 hover:bg-gray-800 text-white text-sm font-bold py-3 px-8 rounded-xl shadow-lg shadow-gray-200 transition-all transform active:scale-95">
            Kembali ke Beranda
        </a>
        </div>

</div>

<style>
    .animate-bounce-short {
        animation: bounce-short 1s ease-in-out 1;
    }
    @keyframes bounce-short {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }
</style>
@endsection