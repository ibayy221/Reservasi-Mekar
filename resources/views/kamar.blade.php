@extends('layouts.app')

@section('content')
<div class="bg-gray-50 min-h-screen py-6 md:py-12">
    <div class="max-w-7xl mx-auto px-4 md:px-6">
        
        <!-- Header Halaman -->
        <div class="mb-8">
            <span class="text-[10px] md:text-xs font-bold tracking-widest text-emerald-500 uppercase block mb-1">Pilihan Terbaik</span>
            <h1 class="text-xl md:text-3xl font-bold text-dark tracking-tight">Tipe Kamar & Kamar Mewah</h1>
            <p class="text-xs md:text-sm text-gray-500 mt-1">Pilih akomodasi yang sesuai dengan kenyamanan istirahat Anda.</p>
        </div>

       <!-- Grid Katalog Kamar -->
        <!-- Mobile: 1 kolom (stack), Tablet: 2 kolom, Desktop: 3 kolom -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            
            <!-- CARD 1: SUPERIOR 1 KING BED -->
            <div class="bg-white rounded-2xl shadow-md border border-gray-100 overflow-hidden flex flex-col justify-between">
                <div>
                    <div class="relative">
                        <img class="w-full h-48 md:h-52 object-cover" src="https://images.unsplash.com/photo-1566665797739-1674de7a421a?q=80&w=1000" alt="Superior King">
                        <span class="absolute top-3 right-3 bg-emerald-700 text-white text-[10px] font-semibold px-2.5 py-1 rounded-full uppercase tracking-wider border border-emerald-900">Modern</span>
                    </div>
                    <div class="p-4 md:p-5">
                        <h3 class="text-base md:text-lg font-bold text-dark">Superior dengan 1 Kasur King</h3>
                        <p class="text-[11px] text-gray-400 font-light mt-0.5">Superior Room with 1 King-size Bed</p>
                        <div class="flex flex-wrap gap-1.5 mt-3">
                            <span class="bg-gray-100 text-gray-600 text-[10px] px-2 py-0.5 rounded-md font-medium">1 King Bed</span>
                            <span class="bg-gray-100 text-gray-600 text-[10px] px-2 py-0.5 rounded-md font-medium">Free WiFi</span>
                            <span class="bg-gray-100 text-gray-600 text-[10px] px-2 py-0.5 rounded-md font-medium">AC</span>
                            <span class="bg-gray-100 text-gray-600 text-[10px] px-2 py-0.5 rounded-md font-medium">Shower</span>
                        </div>
                    </div>
                </div>
                <div class="p-4 md:p-5 pt-0 border-t border-gray-50 flex items-center justify-between mt-4">
                    <div>
                        <span class="text-[10px] text-gray-400 block">Mulai dari</span>
                        <span class="text-sm md:text-base font-bold text-emerald-500">Rp 650.000<span class="text-[10px] text-gray-400 font-normal">/malam</span></span>
                    </div>
                    <a href="#" class="bg-emerald-500 hover:bg-emerald-600 text-white text-xs font-semibold px-4 py-2 rounded-lg shadow-sm transition">Pesan</a>
                </div>
            </div>

            <!-- CARD 2: DELUXE 1 KING BED -->
            <div class="bg-white rounded-2xl shadow-md border border-gray-100 overflow-hidden flex flex-col justify-between">
                <div>
                    <div class="relative">
                        <img class="w-full h-48 md:h-52 object-cover" src="https://images.unsplash.com/photo-1590490360182-c33d57733427?q=80&w=1000" alt="Deluxe King">
                        <span class="absolute top-3 right-3 bg-emerald-500 text-white text-[10px] font-semibold px-2.5 py-1 rounded-full uppercase tracking-wider">Best Seller</span>
                    </div>
                    <div class="p-4 md:p-5">
                        <h3 class="text-base md:text-lg font-bold text-dark">Deluxe dengan 1 Kasur King</h3>
                        <p class="text-[11px] text-gray-400 font-light mt-0.5">Deluxe Room with 1 King-Size Bed</p>
                        <div class="flex flex-wrap gap-1.5 mt-3">
                            <span class="bg-gray-100 text-gray-600 text-[10px] px-2 py-0.5 rounded-md font-medium">1 King Bed</span>
                            <span class="bg-gray-100 text-gray-600 text-[10px] px-2 py-0.5 rounded-md font-medium">Free WiFi</span>
                            <span class="bg-gray-100 text-gray-600 text-[10px] px-2 py-0.5 rounded-md font-medium">City View</span>
                            <span class="bg-gray-100 text-gray-600 text-[10px] px-2 py-0.5 rounded-md font-medium">Coffee Maker</span>
                        </div>
                    </div>
                </div>
                <div class="p-4 md:p-5 pt-0 border-t border-gray-50 flex items-center justify-between mt-4">
                    <div>
                        <span class="text-[10px] text-gray-400 block">Mulai dari</span>
                        <span class="text-sm md:text-base font-bold text-emerald-500">Rp 800.000<span class="text-[10px] text-gray-400 font-normal">/malam</span></span>
                    </div>
                    <a href="#" class="bg-emerald-500 hover:bg-emerald-600 text-white text-xs font-semibold px-4 py-2 rounded-lg shadow-sm transition">Pesan</a>
                </div>
            </div>

            <!-- CARD 3: BUSINESS SUITE -->
            <div class="bg-white rounded-2xl shadow-md border border-gray-100 overflow-hidden flex flex-col justify-between">
                <div>
                    <div class="relative">
                        <img class="w-full h-48 md:h-52 object-cover" src="https://images.unsplash.com/photo-1618773928121-c32242e63f39?q=80&w=1000" alt="Business Suite">
                        <span class="absolute top-3 right-3 bg-emerald-700 text-white text-[10px] font-semibold px-2.5 py-1 rounded-full uppercase tracking-wider border border-emerald-900">Work & Stay</span>
                    </div>
                    <div class="p-4 md:p-5">
                        <h3 class="text-base md:text-lg font-bold text-dark">Suite Business</h3>
                        <p class="text-[11px] text-gray-400 font-light mt-0.5">Business Suite</p>
                        <div class="flex flex-wrap gap-1.5 mt-3">
                            <span class="bg-gray-100 text-gray-600 text-[10px] px-2 py-0.5 rounded-md font-medium">Working Desk</span>
                            <span class="bg-gray-100 text-gray-600 text-[10px] px-2 py-0.5 rounded-md font-medium">Living Area</span>
                            <span class="bg-gray-100 text-gray-600 text-[10px] px-2 py-0.5 rounded-md font-medium">Minibar</span>
                            <span class="bg-gray-100 text-gray-600 text-[10px] px-2 py-0.5 rounded-md font-medium">Bathtub</span>
                        </div>
                    </div>
                </div>
                <div class="p-4 md:p-5 pt-0 border-t border-gray-50 flex items-center justify-between mt-4">
                    <div>
                        <span class="text-[10px] text-gray-400 block">Mulai dari</span>
                        <span class="text-sm md:text-base font-bold text-emerald-500">Rp 1.350.000<span class="text-[10px] text-gray-400 font-normal">/malam</span></span>
                    </div>
                    <a href="#" class="bg-emerald-500 hover:bg-emerald-600 text-white text-xs font-semibold px-4 py-2 rounded-lg shadow-sm transition">Pesan</a>
                </div>
            </div>

            <!-- CARD 4: KING SUITE -->
            <div class="bg-white rounded-2xl shadow-md border border-gray-100 overflow-hidden flex flex-col justify-between">
                <div>
                    <div class="relative">
                        <img class="w-full h-48 md:h-52 object-cover" src="https://images.unsplash.com/photo-1578683010236-d716f9a3f461?q=80&w=1000" alt="King Suite">
                        <span class="absolute top-3 right-3 bg-emerald-500 text-white text-[10px] font-semibold px-2.5 py-1 rounded-full uppercase tracking-wider">Premium Suite</span>
                    </div>
                    <div class="p-4 md:p-5">
                        <h3 class="text-base md:text-lg font-bold text-dark">Suite King</h3>
                        <p class="text-[11px] text-gray-400 font-light mt-0.5">King Suite</p>
                        <div class="flex flex-wrap gap-1.5 mt-3">
                            <span class="bg-gray-100 text-gray-600 text-[10px] px-2 py-0.5 rounded-md font-medium">Extra Large King Bed</span>
                            <span class="bg-gray-100 text-gray-600 text-[10px] px-2 py-0.5 rounded-md font-medium">VIP Lounge Access</span>
                            <span class="bg-gray-100 text-gray-600 text-[10px] px-2 py-0.5 rounded-md font-medium">Smart TV 55"</span>
                        </div>
                    </div>
                </div>
                <div class="p-4 md:p-5 pt-0 border-t border-gray-50 flex items-center justify-between mt-4">
                    <div>
                        <span class="text-[10px] text-gray-400 block">Mulai dari</span>
                        <span class="text-sm md:text-base font-bold text-emerald-500">Rp 1.850.000<span class="text-[10px] text-gray-400 font-normal">/malam</span></span>
                    </div>
                    <a href="#" class="bg-emerald-500 hover:bg-emerald-600 text-white text-xs font-semibold px-4 py-2 rounded-lg shadow-sm transition">Pesan</a>
                </div>
            </div>

            <!-- CARD 5: SUPERIOR 2 SINGLE BEDS -->
            <div class="bg-white rounded-2xl shadow-md border border-gray-100 overflow-hidden flex flex-col justify-between">
                <div>
                    <div class="relative">
                        <img class="w-full h-48 md:h-52 object-cover" src="https://images.unsplash.com/photo-1544161515-4ab6ce6db874?q=80&w=1000" alt="Superior Twin">
                    </div>
                    <div class="p-4 md:p-5">
                        <h3 class="text-base md:text-lg font-bold text-dark">Superior - Ranjang 2 Single</h3>
                        <p class="text-[11px] text-gray-400 font-light mt-0.5">Superior Room - 2 Single Beds</p>
                        <div class="flex flex-wrap gap-1.5 mt-3">
                            <span class="bg-gray-100 text-gray-600 text-[10px] px-2 py-0.5 rounded-md font-medium">2 Twin Beds</span>
                            <span class="bg-gray-100 text-gray-600 text-[10px] px-2 py-0.5 rounded-md font-medium">Free WiFi</span>
                            <span class="bg-gray-100 text-gray-600 text-[10px] px-2 py-0.5 rounded-md font-medium">AC</span>
                            <span class="bg-gray-100 text-gray-600 text-[10px] px-2 py-0.5 rounded-md font-medium">Hot Shower</span>
                        </div>
                    </div>
                </div>
                <div class="p-4 md:p-5 pt-0 border-t border-gray-50 flex items-center justify-between mt-4">
                    <div>
                        <span class="text-[10px] text-gray-400 block">Mulai dari</span>
                        <span class="text-sm md:text-base font-bold text-emerald-500">Rp 650.000<span class="text-[10px] text-gray-400 font-normal">/malam</span></span>
                    </div>
                    <a href="#" class="bg-emerald-500 hover:bg-emerald-600 text-white text-xs font-semibold px-4 py-2 rounded-lg shadow-sm transition">Pesan</a>
                </div>
            </div>

        </div>
@endsection