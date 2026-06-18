@extends('layouts.app')

@section('content')
    <div class="max-w-6xl mx-auto p-4 sm:p-6 lg:p-8">
        
        <!-- Breadcrumb (Opsional untuk navigasi yang lebih baik) -->
        <nav class="flex mb-6 text-sm text-gray-500">
            <a href="{{ route('kamar') }}" class="hover:text-purple-600 transition-colors">Daftar Kamar</a>
            <span class="mx-2">/</span>
            <span class="text-gray-900 font-medium">{{ $kamar->name }}</span>
        </nav>

        <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100">
            <div class="lg:flex">
                
                <!-- Sisi Kiri: Gambar -->
                <div class="lg:w-1/2 relative h-80 lg:h-auto bg-gray-100 group">
                    @if(!empty($kamar->image))
                        <img src="{{ asset($kamar->image) }}" alt="{{ $kamar->name }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                    @else
                        <div class="w-full h-full flex flex-col items-center justify-center text-gray-400">
                            <svg class="w-16 h-16 mb-2 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            <span>Gambar tidak tersedia</span>
                        </div>
                    @endif
                    
                    <!-- Badge Status Stok -->
                    <div class="absolute top-4 left-4">
                        @if(($kamar->stock ?? 0) > 0)
                            <span class="bg-green-500/90 backdrop-blur-sm text-white text-xs font-bold px-3 py-1.5 rounded-full shadow-sm">
                                Tersedia (Sisa {{ $kamar->stock }})
                            </span>
                        @else
                            <span class="bg-red-500/90 backdrop-blur-sm text-white text-xs font-bold px-3 py-1.5 rounded-full shadow-sm">
                                Penuh
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Sisi Kanan: Informasi Kamar -->
                <div class="p-8 lg:p-10 lg:w-1/2 flex flex-col justify-between">
                    <div>
                        <!-- Judul & Harga -->
                        <div class="flex flex-col md:flex-row md:justify-between md:items-start gap-4 mb-6">
                            <div>
                                <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">{{ $kamar->name }}</h1>
                                <p class="text-sm text-gray-500 mt-1">Sempurna untuk kenyamanan Anda</p>
                            </div>
                            <div class="text-left md:text-right">
                                <div class="text-2xl font-black text-purple-600">Rp {{ number_format($kamar->price, 0, ',', '.') }}</div>
                                <div class="text-sm text-gray-500 font-medium">/ malam</div>
                            </div>
                        </div>

                        <!-- Info Cepat (Kapasitas, Kasur, Ukuran) -->
                        <div class="grid grid-cols-2 gap-4 mb-8">
                            <div class="flex items-center gap-3 p-3 rounded-2xl bg-gray-50">
                                <div class="bg-white p-2 rounded-xl shadow-sm text-purple-600">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                </div>
                                <div>
                                    <div class="text-xs text-gray-500">Kapasitas</div>
                                    <div class="text-sm font-bold text-gray-900">{{ $kamar->capacity }} Orang</div>
                                </div>
                            </div>
                            <div class="flex items-center gap-3 p-3 rounded-2xl bg-gray-50">
                                <div class="bg-white p-2 rounded-xl shadow-sm text-purple-600">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path></svg>
                                </div>
                                <div>
                                    <div class="text-xs text-gray-500">Tipe Kasur</div>
                                    <div class="text-sm font-bold text-gray-900">{{ $kamar->bed_type ?? 'King Size' }}</div>
                                </div>
                            </div>
                        </div>

                        <!-- Deskripsi -->
                        <h3 class="text-lg font-bold text-gray-900 mb-3">Tentang Kamar Ini</h3>
                        <div class="text-gray-600 leading-relaxed text-sm mb-8">
                            {!! nl2br(e($kamar->description ?? 'Deskripsi tidak tersedia. Kamar ini menawarkan kenyamanan maksimal dengan desain interior modern.')) !!}
                        </div>

                        <!-- Fasilitas Utama -->
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Fasilitas Utama</h3>
                        <div class="grid grid-cols-2 gap-y-3 gap-x-4 mb-8">
                            <div class="flex items-center text-sm text-gray-700">
                                <svg class="w-5 h-5 mr-3 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                Wi-Fi Gratis
                            </div>
                            <div class="flex items-center text-sm text-gray-700">
                                <svg class="w-5 h-5 mr-3 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                AC & TV Kabel
                            </div>
                            <div class="flex items-center text-sm text-gray-700">
                                <svg class="w-5 h-5 mr-3 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                Sarapan Pagi
                            </div>
                            <div class="flex items-center text-sm text-gray-700">
                                <svg class="w-5 h-5 mr-3 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                Kamar Mandi Dalam
                            </div>
                        </div>
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="flex flex-col sm:flex-row items-center gap-4 pt-6 border-t border-gray-100">
                        @if(($kamar->stock ?? 0) > 0)
                            <button id="open_booking_modal" data-kamar-id="{{ $kamar->id }}" data-booking-url="{{ route('booking.create') }}" class="w-full sm:w-auto flex-1 bg-purple-600 hover:bg-purple-700 text-white text-center font-bold px-8 py-4 rounded-xl shadow-lg shadow-purple-600/30 transition-all hover:-translate-y-0.5">
                                Pesan Kamar Sekarang
                            </button>
                        @else
                            <button disabled class="w-full sm:w-auto flex-1 bg-gray-300 text-gray-500 cursor-not-allowed font-bold px-8 py-4 rounded-xl">
                                Stok Habis
                            </button>
                        @endif
                        <a href="{{ route('kamar') }}" class="w-full sm:w-auto px-8 py-4 text-center font-semibold text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors">
                            Kembali
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>

<!-- Booking modal (check-in/out + guests) -->
@push('scripts')
    <!-- Flatpickr CSS/JS for date inputs -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/plugins/rangePlugin.js"></script>

    <div id="booking_modal" class="fixed inset-0 hidden z-50 items-center justify-center bg-black/50 px-4">
        <div class="bg-white rounded-2xl w-full max-w-xl mx-auto overflow-hidden">
            <div class="flex items-center justify-between p-4 border-b">
                <h3 class="font-bold">Pilih Tanggal & Jumlah Tamu</h3>
                <button id="booking_modal_close" class="text-gray-500 hover:text-gray-800">✕</button>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 mb-1">Tanggal Check-In</label>
                        <input id="modal_checkin" type="text" class="w-full bg-gray-50 border border-gray-200 p-3 rounded-lg text-sm" placeholder="Pilih tanggal">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 mb-1">Tanggal Check-Out</label>
                        <input id="modal_checkout" type="text" class="w-full bg-gray-50 border border-gray-200 p-3 rounded-lg text-sm" placeholder="Pilih tanggal">
                    </div>
                </div>

                <div class="flex items-center gap-6 mb-4">
                    <div class="text-center">
                        <label class="block text-xs font-semibold text-gray-500 mb-1">Dewasa</label>
                        <div class="flex items-center justify-center gap-3">
                            <button id="modal_adult_decr" type="button" class="w-8 h-8 rounded-full border border-gray-200 text-gray-600">−</button>
                            <span id="modal_adult_count" class="w-6 text-center text-sm font-medium">2</span>
                            <button id="modal_adult_incr" type="button" class="w-8 h-8 rounded-full border border-gray-200 text-gray-600">+</button>
                        </div>
                    </div>
                    <div class="text-center">
                        <label class="block text-xs font-semibold text-gray-500 mb-1">Anak</label>
                        <div class="flex items-center justify-center gap-3">
                            <button id="modal_child_decr" type="button" class="w-8 h-8 rounded-full border border-gray-200 text-gray-600">−</button>
                            <span id="modal_child_count" class="w-6 text-center text-sm font-medium">0</span>
                            <button id="modal_child_incr" type="button" class="w-8 h-8 rounded-full border border-gray-200 text-gray-600">+</button>
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <button id="confirm_booking_btn" class="flex-1 bg-purple-600 hover:bg-purple-700 text-white font-bold px-6 py-3 rounded-lg">Lanjutkan ke Pemesanan</button>
                    <button id="booking_modal_cancel" class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold px-6 py-3 rounded-lg">Batal</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function(){
            let currentBookingBtn = null;
            const openBtn = document.getElementById('open_booking_modal');
            const modal = document.getElementById('booking_modal');
            const closeBtn = document.getElementById('booking_modal_close');
            const cancelBtn = document.getElementById('booking_modal_cancel');
            const confirmBtn = document.getElementById('confirm_booking_btn');

            const adultCountEl = document.getElementById('modal_adult_count');
            const childCountEl = document.getElementById('modal_child_count');
            const adultIncr = document.getElementById('modal_adult_incr');
            const adultDecr = document.getElementById('modal_adult_decr');
            const childIncr = document.getElementById('modal_child_incr');
            const childDecr = document.getElementById('modal_child_decr');

            let adults = 2;
            let children = 0;

            function updateCounts(){
                adultCountEl.textContent = adults;
                childCountEl.textContent = children;
            }

            adultIncr.addEventListener('click', ()=> { if(adults < 10) adults++; updateCounts(); });
            adultDecr.addEventListener('click', ()=> { if(adults > 1) adults--; updateCounts(); });
            childIncr.addEventListener('click', ()=> { if(children < 10) children++; updateCounts(); });
            childDecr.addEventListener('click', ()=> { if(children > 0) children--; updateCounts(); });

            // Initialize flatpickr range
            if(typeof flatpickr !== 'undefined'){
                flatpickr('#modal_checkin', {
                    dateFormat: 'Y-m-d',
                    minDate: 'today',
                    allowInput: true,
                    plugins: [new rangePlugin({ input: '#modal_checkout' })]
                });
            }

            function openModal(){
                modal.classList.remove('hidden');
                modal.classList.add('flex');
                document.body.style.overflow = 'hidden';
            }
            function closeModal(){
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                document.body.style.overflow = '';
            }

            // Delegated click handler in case markup changes or multiple buttons exist
            document.addEventListener('click', function(e){
                const btn = e.target.closest('#open_booking_modal');
                if(!btn) return;
                e.preventDefault();
                currentBookingBtn = btn;
                // reset defaults
                adults = 2; children = 0; updateCounts();
                // clear dates
                const ci = document.getElementById('modal_checkin');
                const co = document.getElementById('modal_checkout');
                if(ci) ci.value = '';
                if(co) co.value = '';
                openModal();
            });

            [closeBtn, cancelBtn].forEach(btn=> btn && btn.addEventListener('click', function(e){ e.preventDefault(); closeModal(); }));

            confirmBtn.addEventListener('click', function(e){
                e.preventDefault();
                const checkin = document.getElementById('modal_checkin').value;
                const checkout = document.getElementById('modal_checkout').value;
                if(!checkin || !checkout){
                    alert('Mohon pilih tanggal check-in dan check-out.');
                    return;
                }

                const kamarId = (currentBookingBtn && currentBookingBtn.dataset) ? currentBookingBtn.dataset.kamarId : (openBtn?.dataset?.kamarId ?? null);
                const bookingUrl = (currentBookingBtn && currentBookingBtn.dataset && currentBookingBtn.dataset.bookingUrl) ? currentBookingBtn.dataset.bookingUrl : (openBtn?.dataset?.bookingUrl || '{{ route('booking.create') }}');

                const params = new URLSearchParams({ kamar_id: kamarId, checkin: checkin, checkout: checkout, adults: adults, children: children });
                window.location.href = bookingUrl + '?' + params.toString();
            });

        });
    </script>
@endpush
