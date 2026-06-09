@extends('layouts.app')

@section('content')
<!-- Menyembunyikan Navbar bawaan dari layout -->
<style>
    /* Tag umum yang biasanya digunakan untuk navbar/header */
    header, nav, .navbar, #navbar {
        display: none !important;
    }
    
    /* Animasi Bouncing */
    .animate-bounce-short {
        animation: bounce-short 1s ease-in-out 1;
    }
    @keyframes bounce-short {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-8px); }
    }
</style>

<!-- Container utama diset min-h-screen dan justify-center agar persis di tengah layar -->
<div class="max-w-4xl mx-auto p-4 bg-gray-50 flex flex-col justify-center items-center min-h-screen w-full">
    
    <!-- Header Section -->
    <div class="text-center mb-6">
        <div class="w-14 h-14 bg-emerald-100 rounded-full flex items-center justify-center mx-auto mb-3 shadow-inner animate-bounce-short">
            <svg class="w-7 h-7 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
            </svg>
        </div>
        <h2 class="text-2xl md:text-3xl font-black text-gray-900 tracking-tight">Reservasi Berhasil!</h2>
        <p class="text-gray-500 text-sm mt-1 font-light">E-Voucher Anda telah diterbitkan. Tunjukkan kode QR saat check-in.</p>
    </div>

    <!-- Ticket Container (Side-by-Side Layout on Desktop) -->
    <div id="ticket_container" class="w-full bg-white rounded-2xl shadow-xl shadow-purple-900/5 border border-gray-100 overflow-hidden flex flex-col md:flex-row relative">
        
        <!-- Kolom Kiri: Detail Reservasi -->
        <div class="p-6 md:p-8 flex-1">
            <!-- Header Tiket -->
            <div class="flex justify-between items-center mb-6">
                <div>
                    <span class="text-[10px] font-bold text-purple-500 uppercase tracking-widest block mb-0.5">Booking ID</span>
                    <span class="text-xl md:text-2xl font-black text-gray-900 tracking-wider">#{{ $reservation->reservation_code ?? $reservation->id }}</span>
                </div>
                <div class="bg-emerald-50 text-emerald-600 px-3 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider border border-emerald-200 shadow-sm flex items-center gap-1.5">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                    {{ $reservation->status }}
                </div>
            </div>

            <!-- Detail Kamar -->
            <div class="mb-6">
                <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $reservation->kamar->name }}</h3>
                <div class="inline-flex items-center gap-3 text-xs text-gray-600 font-medium bg-gray-50 px-3 py-1.5 rounded-lg border border-gray-100">
                    <svg class="w-4 h-4 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    {{ $reservation->adults }} Dewasa, {{ $reservation->children }} Anak 
                    <span class="text-gray-300">|</span> 
                    {{ $reservation->nights }} Malam
                </div>
            </div>

            <!-- Check-In / Check-Out -->
            <div class="flex items-center justify-between bg-purple-50/50 p-4 rounded-xl border border-purple-100/50">
                <div class="w-full">
                    <span class="block text-[10px] text-purple-400 font-bold uppercase tracking-wider">Check-In</span>
                    <span class="block text-sm md:text-base font-bold text-gray-900">{{ $reservation->check_in }}</span>
                    <span class="block text-[10px] text-gray-500">Mulai 14:00 WIB</span>
                </div>
                <div class="flex-shrink-0 px-2 text-purple-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </div>
                <div class="w-full text-right">
                    <span class="block text-[10px] text-purple-400 font-bold uppercase tracking-wider">Check-Out</span>
                    <span class="block text-sm md:text-base font-bold text-gray-900">{{ $reservation->check_out }}</span>
                    <span class="block text-[10px] text-gray-500">Maks 12:00 WIB</span>
                </div>
            </div>

            <!-- Permintaan Khusus -->
            @if(!empty($reservation->smoking_preference) || !empty($reservation->bed_setup) || !empty($reservation->special_requests))
            <div class="mt-5 p-4 bg-orange-50/50 rounded-xl border border-orange-100 text-sm">
                <h4 class="text-[11px] font-bold text-orange-800 uppercase tracking-wide mb-2 flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path></svg>
                    Permintaan Khusus
                </h4>
                <div class="flex flex-wrap gap-x-6 gap-y-2 text-xs">
                    @if($reservation->smoking_preference)
                        <div class="text-gray-600 flex items-center gap-1.5">
                            <span class="w-1 h-1 rounded-full bg-orange-400"></span>
                            <span class="font-semibold text-gray-800">Ruangan:</span> {{ $reservation->smoking_preference == 'non-smoking' ? 'Non-smoking' : 'Smoking' }}
                        </div>
                    @endif
                    @if($reservation->bed_setup)
                        <div class="text-gray-600 flex items-center gap-1.5">
                            <span class="w-1 h-1 rounded-full bg-orange-400"></span>
                            <span class="font-semibold text-gray-800">Kasur:</span> {{ $reservation->bed_setup == 'large' ? '1 Bed Besar' : 'Twin Bed' }}
                        </div>
                    @endif
                    @if($reservation->special_requests)
                        <div class="w-full text-gray-600 flex items-start gap-1.5 mt-1 bg-white p-2.5 rounded-lg border border-orange-100">
                            <svg class="w-3.5 h-3.5 text-orange-400 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            <span class="italic text-[11px]">"{{ $reservation->special_requests }}"</span>
                        </div>
                    @endif
                </div>
            </div>
            @endif
        </div>

        <!-- Garis Pemisah Tiket -->
        <div class="relative w-full md:w-0 flex items-center justify-center">
            <div class="hidden md:block h-full border-l-2 border-dashed border-gray-200 absolute top-0 bottom-0"></div>
            <div class="md:hidden w-full border-t-2 border-dashed border-gray-200 absolute left-0 right-0"></div>
            <!-- Lingkaran Potongan Tiket -->
            <div class="hidden md:block absolute -top-3 left-1/2 -translate-x-1/2 w-6 h-6 bg-gray-50 rounded-full border border-gray-100 z-10"></div>
            <div class="hidden md:block absolute -bottom-3 left-1/2 -translate-x-1/2 w-6 h-6 bg-gray-50 rounded-full border border-gray-100 z-10"></div>
            <div class="md:hidden absolute -left-3 top-1/2 -translate-y-1/2 w-6 h-6 bg-gray-50 rounded-full border border-gray-100 z-10"></div>
            <div class="md:hidden absolute -right-3 top-1/2 -translate-y-1/2 w-6 h-6 bg-gray-50 rounded-full border border-gray-100 z-10"></div>
        </div>

        <!-- Kolom Kanan: QR Code & Harga -->
        <div class="p-6 md:p-8 bg-gray-50/50 w-full md:w-1/3 flex flex-col justify-center items-center text-center">
            <div class="bg-white p-2.5 rounded-xl border border-gray-200 shadow-sm mb-4">
                <div id="qrcode" class="p-1"></div>
            </div>
            <span class="text-[9px] font-bold text-gray-400 uppercase tracking-widest mb-4">Scan di Resepsionis</span>
            
            <div class="w-full pt-4 border-t border-gray-200">
                <span class="block text-[10px] text-gray-500 font-bold uppercase tracking-wider mb-1">Total Dibayar</span>
                <span class="block text-2xl font-black text-purple-700 tracking-tight">Rp {{ number_format($reservation->total_price, 0, ',', '.') }}</span>
                <span class="block text-[10px] text-gray-400 mt-1">Termasuk pajak & layanan</span>
            </div>
        </div>
    </div>

    <!-- Tombol Aksi -->
    <div class="mt-6 w-full flex flex-col sm:flex-row justify-center gap-3">
        <a href="/" class="flex justify-center items-center gap-2 bg-white hover:bg-gray-100 text-gray-700 border border-gray-200 text-sm font-bold py-3 px-6 rounded-xl shadow-sm transition-all active:scale-95">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Beranda
        </a>
        <button id="print_ticket" class="flex justify-center items-center gap-2 bg-purple-600 hover:bg-purple-700 text-white text-sm font-bold py-3 px-6 rounded-xl shadow-md shadow-purple-600/20 transition-all active:scale-95">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
            Cetak Tiket
        </button>
    </div>

</div>

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function(){
    // Generate QR Code
    var qrTarget = document.getElementById('qrcode');
    if(qrTarget){
        var reservationUrl = {!! json_encode(route('reservation.show', ['id' => $reservation->id])) !!};
        var qr = new QRCode(qrTarget, {
            text: reservationUrl,
            width: 110,
            height: 110,
            colorDark : "#1f2937",
            colorLight : "#ffffff",
            correctLevel : QRCode.CorrectLevel.H
        });
    }

    // Fungsi Cetak Tiket Penuh
    var printBtn = document.getElementById('print_ticket');
    if(printBtn){
        printBtn.addEventListener('click', function(){
            var ticketContent = document.getElementById('ticket_container').innerHTML;
            var w = window.open('', '_blank');
            w.document.write(`
                <html>
                <head>
                    <title>E-Voucher Reservasi - Mercure Karawang</title>
                    <script src="https://cdn.tailwindcss.com"><\/script>
                    <style>
                        body { font-family: 'Poppins', sans-serif; background-color: #f9fafb; padding: 40px; }
                        @media print {
                            body { padding: 0; background-color: white; }
                            .print-wrapper { box-shadow: none !important; border: 1px solid #e5e7eb; margin-top: 20px;}
                            .no-print { display: none; }
                            /* Memastikan layout 2 kolom tetap bertahan saat diprint */
                            .md\\:flex-row { flex-direction: row !important; }
                            .md\\:w-1\\/3 { width: 33.333333% !important; }
                            .md\\:block { display: block !important; }
                            .md\\:hidden { display: none !important; }
                        }
                    </style>
                </head>
                <body>
                    <div class="max-w-4xl mx-auto print-wrapper bg-white rounded-2xl shadow-xl overflow-hidden relative border border-gray-100 flex flex-row">
                        ${ticketContent}
                    </div>
                    <script>
                        window.onload = function() { 
                            setTimeout(function() { window.print(); }, 500);
                        }
                    <\/script>
                </body>
                </html>
            `);
            w.document.close();
        });
    }
});
</script>
@endpush