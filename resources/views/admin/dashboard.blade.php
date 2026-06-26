@extends('layouts.app')

@section('content')
<!-- Wrapper utama: Tinggi diatur agar muat 1 layar di desktop (asumsi ada navbar ~80px) -->
<div class="max-w-7xl mx-auto p-4 lg:p-6 lg:h-[calc(100vh-80px)] flex flex-col">
    
    
    <!-- Header Dashboard -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-gray-800">Dashboard Resepsionis</h1>
            <p class="text-sm text-gray-500 mt-1">Ringkasan aktivitas dan operasional hotel hari ini.</p>
        </div>
        <div class="bg-white px-4 py-2 rounded-lg border border-gray-200 shadow-sm flex items-center gap-2 text-sm font-medium text-gray-600">
            <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
        </div>
    </div>

    <!-- Grid Utama: Membagi area kiri (KPI & Aksi) dan Kanan (Tabel) -->
    <div class="flex-1 flex flex-col lg:flex-row gap-6 overflow-hidden">
        
        <!-- KOLOM KIRI: Statistik & Tindakan Cepat (Lebar 1/3 di Desktop) -->
        <div class="w-full lg:w-1/3 flex flex-col gap-6">
            
            <!-- Dua Kartu Statistik -->
            <div class="grid grid-cols-2 gap-4">
                <!-- Total Reservasi (Di-highlight hijau) -->
                <div class="bg-purple-600 p-5 rounded-2xl shadow-sm shadow-purple-200 text-white relative overflow-hidden">
                    <svg class="absolute -right-4 -bottom-4 w-24 h-24 text-purple-500 opacity-50" fill="currentColor" viewBox="0 0 20 20"><path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path><path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"></path></svg>
                    <div class="relative">
                        <p class="text-purple-100 text-xs font-semibold uppercase tracking-wide mb-1">Total Reservasi</p>
                        <h2 class="text-4xl font-black">{{ $totalReservations }}</h2>
                    </div>
                </div>

                <!-- Jumlah Kamar -->
                <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-200 relative overflow-hidden">
                    <svg class="absolute -right-4 -bottom-4 w-24 h-24 text-gray-50 opacity-50" fill="currentColor" viewBox="0 0 20 20"><path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z"></path></svg>
                    <div class="relative">
                        <p class="text-gray-500 text-xs font-semibold uppercase tracking-wide mb-1">Kamar Tersedia Hari Ini</p>
                        <h2 class="text-4xl font-black text-gray-800">{{ $availableUnits }}</h2>
                        <div class="text-sm text-gray-500 mt-1">Total unit: {{ $roomsUnits }} · {{ $roomsCount }} tipe</div>
                    </div>
                </div>
            </div>

            <!-- Panel Tindakan Cepat -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-5 flex-1">
                <h3 class="text-sm font-bold text-gray-800 mb-4 uppercase tracking-wide flex items-center gap-2">
                    <svg class="w-4 h-4 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    Jalan Pintas
                </h3>
                <div class="flex flex-col gap-3 max-h-56 overflow-y-auto pr-1">
                    <div class="group relative">
                        <details class="group">
                            <summary class="list-none cursor-pointer group flex items-center justify-between p-4 rounded-xl border border-gray-100 hover:border-purple-500 hover:bg-purple-50 transition-all bg-gray-50">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-white flex items-center justify-center text-purple-600 shadow-sm group-hover:bg-purple-500 group-hover:text-white transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-6a2 2 0 012-2h2a2 2 0 012 2v6M7 21h10"></path></svg>
                                    </div>
                                    <span class="font-bold text-gray-700 group-hover:text-purple-700">Kelola Laporan</span>
                                </div>
                                <svg class="w-5 h-5 text-gray-400 group-hover:text-purple-600 transition-transform group-open:rotate-90" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            </summary>
                            <div class="absolute left-0 right-0 top-full mt-2 z-20 rounded-xl border border-gray-200 bg-white p-2 shadow-lg hidden group-open:block group-hover:block">
                                <a href="{{ route('admin.reports.reservations') }}" class="flex items-center justify-between px-3 py-2 rounded-lg text-sm font-medium text-gray-700 hover:bg-purple-50 hover:text-purple-700 transition">
                                    <span>Laporan Reservasi</span>
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                </a>
                                <a href="{{ route('admin.reports.revenue') }}" class="flex items-center justify-between px-3 py-2 rounded-lg text-sm font-medium text-gray-700 hover:bg-purple-50 hover:text-purple-700 transition">
                                    <span>Pendapatan</span>
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                </a>
                                <a href="{{ route('admin.reports.occupancy') }}" class="flex items-center justify-between px-3 py-2 rounded-lg text-sm font-medium text-gray-700 hover:bg-purple-50 hover:text-purple-700 transition">
                                    <span>Occupancy Rate</span>
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                </a>
                                <a href="{{ route('admin.reports.guests') }}" class="flex items-center justify-between px-3 py-2 rounded-lg text-sm font-medium text-gray-700 hover:bg-purple-50 hover:text-purple-700 transition">
                                    <span>Laporan Tamu</span>
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                </a>
                                <a href="{{ route('admin.reports.all') }}" class="flex items-center justify-between px-3 py-2 rounded-lg text-sm font-medium text-gray-700 hover:bg-purple-50 hover:text-purple-700 transition">
                                    <span>Cetak Semua Laporan</span>
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                </a>
                            </div>
                        </details>
                    </div>
                    <a href="{{ route('admin.reservations.index') }}" class="group flex items-center justify-between p-4 rounded-xl border border-gray-100 hover:border-purple-500 hover:bg-purple-50 transition-all bg-gray-50">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-white flex items-center justify-center text-purple-600 shadow-sm group-hover:bg-purple-500 group-hover:text-white transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                            </div>
                            <span class="font-bold text-gray-700 group-hover:text-purple-700">Kelola Reservasi</span>
                        </div>
                        <svg class="w-5 h-5 text-gray-400 group-hover:text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </a>

                    <a href="{{ route('admin.kamar.index') }}" class="group flex items-center justify-between p-4 rounded-xl border border-gray-100 hover:border-purple-500 hover:bg-purple-50 transition-all bg-gray-50">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-white flex items-center justify-center text-purple-600 shadow-sm group-hover:bg-purple-500 group-hover:text-white transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                            </div>
                            <div>
                                <span class="font-bold text-gray-700 group-hover:text-purple-700">Manajemen Kamar</span>
                                <div class="text-xs text-gray-500 mt-0.5">{{ $roomsCount }} tipe · {{ $roomsUnits }} unit · {{ $availableUnits }} tersedia</div>
                            </div>
                        </div>
                        <svg class="w-5 h-5 text-gray-400 group-hover:text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </a>
                    
                    <a href="{{ route('admin.events.index') }}" class="group flex items-center justify-between p-4 rounded-xl border border-gray-100 hover:border-purple-500 hover:bg-purple-50 transition-all bg-gray-50">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-white flex items-center justify-center text-purple-600 shadow-sm group-hover:bg-purple-500 group-hover:text-white transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-3.866 0-7 3.134-7 7h14c0-3.866-3.134-7-7-7zM12 2v4M6 6l1.5 1.5M18 6l-1.5 1.5"/></svg>
                            </div>
                            <span class="font-bold text-gray-700 group-hover:text-purple-700">Kelola Event</span>
                        </div>
                        <svg class="w-5 h-5 text-gray-400 group-hover:text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </a>
                </div>
            </div>
            
            <!-- Menu Laporan (Baru) -->
            <div class="hidden lg:block bg-white rounded-2xl shadow-sm border border-gray-200 p-5 mt-4">
                <h3 class="text-sm font-bold text-gray-800 mb-3 uppercase tracking-wide flex items-center gap-2">
                    <svg class="w-4 h-4 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-6a2 2 0 012-2h2a2 2 0 012 2v6M7 21h10"></path></svg>
                    Laporan
                </h3>
                <div class="flex flex-col gap-2 text-sm">
                    <a href="{{ route('admin.reports.reservations') }}" class="flex items-center justify-between p-3 rounded-lg border border-gray-100 hover:bg-purple-50 transition">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-gray-50 flex items-center justify-center text-purple-600">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3M3 21h18"></path></svg>
                            </div>
                            <span class="font-semibold text-gray-700">Laporan Reservasi</span>
                        </div>
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </a>

                    <a href="{{ route('admin.reports.revenue') }}" class="flex items-center justify-between p-3 rounded-lg border border-gray-100 hover:bg-purple-50 transition">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-gray-50 flex items-center justify-center text-purple-600">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-3.866 0-7 3.134-7 7h14c0-3.866-3.134-7-7-7zM12 2v4"></path></svg>
                            </div>
                            <span class="font-semibold text-gray-700">Pendapatan</span>
                        </div>
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </a>

                    <a href="{{ route('admin.reports.occupancy') }}" class="flex items-center justify-between p-3 rounded-lg border border-gray-100 hover:bg-purple-50 transition">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-gray-50 flex items-center justify-center text-purple-600">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18M3 12h18M3 17h18"></path></svg>
                            </div>
                            <span class="font-semibold text-gray-700">Occupancy Rate</span>
                        </div>
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </a>

                    <a href="{{ route('admin.reports.availability') }}" class="flex items-center justify-between p-3 rounded-lg border border-gray-100 hover:bg-purple-50 transition">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-gray-50 flex items-center justify-center text-purple-600">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3M3 21h18"></path></svg>
                            </div>
                            <span class="font-semibold text-gray-700">Ketersediaan Kamar</span>
                        </div>
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </a>

                    <a href="{{ route('admin.reports.guests') }}" class="flex items-center justify-between p-3 rounded-lg border border-gray-100 hover:bg-purple-50 transition">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-gray-50 flex items-center justify-center text-purple-600">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A9 9 0 1118.879 6.196 9 9 0 015.12 17.804z"></path></svg>
                            </div>
                            <span class="font-semibold text-gray-700">Laporan Tamu</span>
                        </div>
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </a>

                    <a href="{{ route('admin.reports.cancellations') }}" class="flex items-center justify-between p-3 rounded-lg border border-gray-100 hover:bg-purple-50 transition">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-gray-50 flex items-center justify-center text-purple-600">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 6L6 18M6 6l12 12"></path></svg>
                            </div>
                            <span class="font-semibold text-gray-700">Pembatalan & No-show</span>
                        </div>
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </a>

                    <a href="{{ route('admin.reports.payments') }}" class="flex items-center justify-between p-3 rounded-lg border border-gray-100 hover:bg-purple-50 transition">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-gray-50 flex items-center justify-center text-purple-600">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3-1.343-3-3S10.343 2 12 2s3 1.343 3 3-1.343 3-3 3zM6 20a6 6 0 0112 0"></path></svg>
                            </div>
                            <span class="font-semibold text-gray-700">Pembayaran & Rekonsiliasi</span>
                        </div>
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </a>

                    <a href="{{ route('admin.reports.events') }}" class="flex items-center justify-between p-3 rounded-lg border border-gray-100 hover:bg-purple-50 transition">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-gray-50 flex items-center justify-center text-purple-600">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A2 2 0 013 15.382V6.618a2 2 0 011.553-1.894L9 2"></path></svg>
                            </div>
                            <span class="font-semibold text-gray-700">Laporan Event</span>
                        </div>
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </a>

                    <a href="{{ route('admin.reports.export') }}" class="flex items-center justify-between p-3 rounded-lg border border-gray-100 hover:bg-purple-50 transition">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-gray-50 flex items-center justify-center text-purple-600">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v12m0 0l-3-3m3 3l3-3M21 21H3"></path></svg>
                            </div>
                            <span class="font-semibold text-gray-700">Export / Cetak</span>
                        </div>
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </a>
                </div>
            </div>
        </div>

        <!-- KOLOM KANAN: Daftar Reservasi Terbaru (Lebar 2/3 di Desktop) -->
        <div class="w-full lg:w-2/3 bg-white rounded-2xl shadow-sm border border-gray-200 flex flex-col overflow-hidden">
            <!-- Header Tabel -->
            <div class="p-5 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                <h3 class="text-base font-bold text-gray-800">Reservasi Terbaru Masuk</h3>
                <a href="{{ route('admin.reservations.index') }}" class="text-xs font-bold text-purple-600 hover:text-purple-700">Lihat Semua &rarr;</a>
            </div>

            <!-- Area Internal Scroll untuk mencegah layar utama ikut ter-scroll -->
            <div class="flex-1 overflow-y-auto p-0">
                @if(count($recentReservations) > 0)
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-gray-50/50 text-xs uppercase text-gray-400 sticky top-0 backdrop-blur-md">
                            <tr>
                                <th class="px-5 py-3 font-semibold border-b border-gray-100">ID</th>
                                <th class="px-5 py-3 font-semibold border-b border-gray-100">Kamar</th>
                                <th class="px-5 py-3 font-semibold border-b border-gray-100">Status</th>
                                <th class="px-5 py-3 font-semibold border-b border-gray-100 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm divide-y divide-gray-50">
                            @foreach($recentReservations as $r)
                                <tr class="hover:bg-purple-50/30 transition-colors">
                                    <td class="px-5 py-4 font-bold text-gray-800">#{{ $r->id }}</td>
                                    <td class="px-5 py-4 text-gray-600">{{ $r->kamar->name ?? '-' }}</td>
                                    <td class="px-5 py-4">
                                        <!-- Badge Status yang dinamis (Menyesuaikan teks status) -->
                                        <span class="px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider rounded-full border 
                                            {{ strtolower($r->status) == 'pending' ? 'bg-orange-50 text-orange-600 border-orange-100' : 
                                               (strtolower($r->status) == 'paid' || strtolower($r->status) == 'berhasil' ? 'bg-purple-50 text-purple-600 border-purple-100' : 
                                               'bg-gray-100 text-gray-600 border-gray-200') }}">
                                            {{ $r->status }}
                                        </span>
                                    </td>
                                    <td class="px-5 py-4 text-right">
                                        <!-- Jika Anda punya route show, bisa pakai ini. Sementara dibuat dummy href="#" -->
                                        <button class="text-gray-400 hover:text-purple-600 transition-colors" title="Detail">
                                            <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <!-- Tampilan kosong jika belum ada reservasi -->
                    <div class="h-full flex flex-col items-center justify-center text-center p-8 text-gray-400">
                        <svg class="w-16 h-16 mb-4 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                        <p class="font-medium">Belum ada reservasi masuk.</p>
                    </div>
                @endif
            </div>
        </div>

    </div>
</div>
@endsection