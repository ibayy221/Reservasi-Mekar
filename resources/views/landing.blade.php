@extends('layouts.app')

@section('content')
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
    <!-- Flatpickr CSS for datepicker -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css"/>

    <div class="relative min-h-[50vh] md:h-[80vh] bg-cover bg-center flex items-center justify-center px-4 py-12" style="background-image: linear-gradient(rgba(17, 24, 39, 0.65), rgba(17, 24, 39, 0.75)), url('{{ asset('Asset/Facilities and facade building/Waiting room.jpg') }}');">
        <div class="text-center text-white max-w-4xl mx-auto w-full">
            <h1 class="text-2xl md:text-5xl font-bold mb-2 md:mb-4 tracking-tight leading-tight">Pilihan Hotel Terbaik untuk Setiap Momen</h1>
            <p class="text-xs md:text-lg text-gray-300 mb-6 md:mb-8 max-w-xl mx-auto font-light">Pesan kamar terbaik dengan harga kompetitif dan proses booking yang cepat, aman, dan mudah.</p>
            
            <div class="bg-white p-4 md:p-6 rounded-xl shadow-xl max-w-4xl mx-auto text-gray-800 grid grid-cols-1 md:grid-cols-4 gap-4 items-center">
                <div>
                    <label class="block text-[10px] font-semibold uppercase tracking-wider text-gray-400 mb-1">Tanggal Check-In</label>
                    <input id="checkin_date" type="text" class="w-full bg-gray-50 border border-gray-200 p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 text-sm font-medium" placeholder="Pilih tanggal">
                </div>
                <div>
                    <label class="block text-[10px] font-semibold uppercase tracking-wider text-gray-400 mb-1">Tanggal Check-Out</label>
                    <input id="checkout_date" type="text" class="w-full bg-gray-50 border border-gray-200 p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 text-sm font-medium relative z-10" placeholder="Pilih tanggal">
                </div>
                <div class="flex items-center justify-center gap-6 md:ml-8">
                    <div class="text-center">
                        <label class="block text-[10px] font-semibold uppercase tracking-wider text-gray-400 mb-1">Dewasa</label>
                        <div class="flex items-center justify-center gap-3">
                            <button type="button" id="adult_decr" class="w-8 h-8 rounded-full border border-gray-200 text-gray-600 flex items-center justify-center text-sm">−</button>
                            <span id="adult_count" class="w-6 text-center text-sm font-medium">2</span>
                            <button type="button" id="adult_incr" class="w-8 h-8 rounded-full border border-gray-200 text-gray-600 flex items-center justify-center text-sm">+</button>
                        </div>
                    </div>
                    <div class="text-center">
                        <label class="block text-[10px] font-semibold uppercase tracking-wider text-gray-400 mb-1">Anak</label>
                        <div class="flex items-center justify-center gap-3">
                            <button type="button" id="child_decr" class="w-8 h-8 rounded-full border border-gray-200 text-gray-600 flex items-center justify-center text-sm">−</button>
                            <span id="child_count" class="w-6 text-center text-sm font-medium">0</span>
                            <button type="button" id="child_incr" class="w-8 h-8 rounded-full border border-gray-200 text-gray-600 flex items-center justify-center text-sm">+</button>
                        </div>
                    </div>
                    <input type="hidden" id="adults_input" name="adults" value="2">
                    <input type="hidden" id="children_input" name="children" value="0">
                </div>
                <div class="flex items-center md:justify-end">
                    <button id="search_rooms_btn" class="w-full md:w-auto bg-purple-500 hover:bg-purple-600 text-white px-6 py-3 rounded-full text-sm font-semibold shadow-md transition duration-200 flex items-center justify-center gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                        </svg>
                        Cari Kamar
                    </button>
                </div>
            </div>
            <!-- Availability Modal -->
            <div id="availability_modal" class="fixed inset-0 hidden z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm px-4 md:px-6">
                <div class="modal-dialog bg-white w-full max-w-4xl md:max-w-5xl mx-4 md:mx-0 rounded-2xl shadow-2xl overflow-hidden transform transition-all duration-300 scale-95 opacity-0">
                    <div class="flex items-center justify-between p-5 border-b bg-white">
                        <h3 class="font-bold text-lg">Hasil Pencarian Kamar</h3>
                        <button id="availability_close" class="text-gray-500 hover:text-gray-800 bg-gray-100 hover:bg-gray-200 px-3 py-1 rounded">Tutup ✕</button>
                    </div>
                    <div id="availability_content" class="p-6 max-h-[70vh] overflow-auto bg-white">
                        <!-- results will be injected here -->
                        <div id="availability_loading" class="text-center py-12 text-gray-500">Memuat...</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

 <!-- Section Foto Kamar - Carousel Premium -->
    <div class="bg-gray-50 py-12 md:py-24 border-t border-gray-100 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 md:px-6 relative">
            
            <!-- Header Elegan -->
            <div class="text-center mb-10 md:mb-16">
                <h2 class="text-2xl md:text-4xl font-bold text-purple-500 mb-4 tracking-tight">Kamar Mewah Mercure Karawang</h2>
                <div class="w-16 h-1 bg-purple-500 mx-auto rounded-full mb-4"></div>
            </div>
            
            <!-- Swiper Carousel -->
            <div class="swiper kamar-carousel relative px-2 md:px-12">
                <div class="swiper-wrapper py-4">
                    
                    <!-- Kamar 1 -->
                    <div class="swiper-slide">
                        <div class="group relative overflow-hidden rounded-2xl shadow-md hover:shadow-2xl transition-all duration-500 h-[320px] md:h-[420px] cursor-pointer">
                            <!-- Image -->
                            <img src="{{ asset('Asset/Room images/Deluxe 1 king bed/Deluxe 1 king bed.jpg') }}" alt="Deluxe Room" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                            <!-- Gradient Overlay Ekstra Lembut -->
                            <div class="absolute inset-0 bg-gradient-to-t from-purple-700/95 via-purple-700/20 to-transparent opacity-80 group-hover:opacity-100 transition-opacity duration-500"></div>
                            <!-- Elegant Text Content -->
                            <div class="absolute bottom-0 left-0 right-0 p-6 md:p-8 transform translate-y-4 group-hover:translate-y-0 transition-transform duration-500">
                                <span class="text-[10px] text-purple-400 font-semibold uppercase tracking-widest mb-2 block opacity-0 group-hover:opacity-100 transition-opacity duration-500 delay-100">Best Seller</span>
                                <h3 class="font-bold text-xl md:text-2xl text-white tracking-wide mb-1">Deluxe Room</h3>
                                <p class="text-xs md:text-sm text-gray-300 font-light">Kamar yang nyaman dan elegan</p>
                            </div>
                        </div>
                    </div>

                    <!-- Kamar 2 -->
                    <div class="swiper-slide">
                        <div class="group relative overflow-hidden rounded-2xl shadow-md hover:shadow-2xl transition-all duration-500 h-[320px] md:h-[420px] cursor-pointer">
                            <img src="{{ asset('Asset/Room images/Suite business 1 king bed and sofa/Suite business 1 king bed and sofa.jpg') }}" alt="Executive Suite" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                            <div class="absolute inset-0 bg-gradient-to-t from-purple-700/95 via-purple-700/20 to-transparent opacity-80 group-hover:opacity-100 transition-opacity duration-500"></div>
                            <div class="absolute bottom-0 left-0 right-0 p-6 md:p-8 transform translate-y-4 group-hover:translate-y-0 transition-transform duration-500">
                                <span class="text-[10px] text-purple-400 font-semibold uppercase tracking-widest mb-2 block opacity-0 group-hover:opacity-100 transition-opacity duration-500 delay-100">Premium</span>
                                <h3 class="font-bold text-xl md:text-2xl text-white tracking-wide mb-1">Executive Suite</h3>
                                <p class="text-xs md:text-sm text-gray-300 font-light">Suite eksklusif dengan pemandangan</p>
                            </div>
                        </div>
                    </div>

                    <!-- Kamar 3 -->
                    <div class="swiper-slide">
                        <div class="group relative overflow-hidden rounded-2xl shadow-md hover:shadow-2xl transition-all duration-500 h-[320px] md:h-[420px] cursor-pointer">
                            <img src="{{ asset('Asset/Room images/Superior 1 king bed/Kamar-supperior 1 king bed.jpg') }}" alt="Superior Room" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                            <div class="absolute inset-0 bg-gradient-to-t from-purple-700/95 via-purple-700/20 to-transparent opacity-80 group-hover:opacity-100 transition-opacity duration-500"></div>
                            <div class="absolute bottom-0 left-0 right-0 p-6 md:p-8 transform translate-y-4 group-hover:translate-y-0 transition-transform duration-500">
                                <span class="text-[10px] text-purple-400 font-semibold uppercase tracking-widest mb-2 block opacity-0 group-hover:opacity-100 transition-opacity duration-500 delay-100">Modern</span>
                                <h3 class="font-bold text-xl md:text-2xl text-white tracking-wide mb-1">Superior Room</h3>
                                <p class="text-xs md:text-sm text-gray-300 font-light">Kamar premium dengan fasilitas lengkap</p>
                            </div>
                        </div>
                    </div>

                    <!-- Kamar 4 -->
                    <div class="swiper-slide">
                        <div class="group relative overflow-hidden rounded-2xl shadow-md hover:shadow-2xl transition-all duration-500 h-[320px] md:h-[420px] cursor-pointer">
                            <img src="{{ asset('Asset/Room images/Suite business 1 king bed and sofa/Suite business 1 king bed and sofa(family place).jpg') }}" alt="Family Room" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                            <div class="absolute inset-0 bg-gradient-to-t from-purple-700/95 via-purple-700/20 to-transparent opacity-80 group-hover:opacity-100 transition-opacity duration-500"></div>
                            <div class="absolute bottom-0 left-0 right-0 p-6 md:p-8 transform translate-y-4 group-hover:translate-y-0 transition-transform duration-500">
                                <span class="text-[10px] text-purple-400 font-semibold uppercase tracking-widest mb-2 block opacity-0 group-hover:opacity-100 transition-opacity duration-500 delay-100">Spacious</span>
                                <h3 class="font-bold text-xl md:text-2xl text-white tracking-wide mb-1">Family Room</h3>
                                <p class="text-xs md:text-sm text-gray-300 font-light">Ruangan luas untuk keluarga</p>
                            </div>
                        </div>
                    </div>

                    <!-- Kamar 5 -->
                    <div class="swiper-slide">
                        <div class="group relative overflow-hidden rounded-2xl shadow-md hover:shadow-2xl transition-all duration-500 h-[320px] md:h-[420px] cursor-pointer">
                            <img src="{{ asset('Asset/Room images/Suite 1 king bed/suite 1 king bed.jpg') }}" alt="Studio Room" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                            <div class="absolute inset-0 bg-gradient-to-t from-purple-700/95 via-purple-700/20 to-transparent opacity-80 group-hover:opacity-100 transition-opacity duration-500"></div>
                            <div class="absolute bottom-0 left-0 right-0 p-6 md:p-8 transform translate-y-4 group-hover:translate-y-0 transition-transform duration-500">
                                <span class="text-[10px] text-purple-400 font-semibold uppercase tracking-widest mb-2 block opacity-0 group-hover:opacity-100 transition-opacity duration-500 delay-100">Cozy</span>
                                <h3 class="font-bold text-xl md:text-2xl text-white tracking-wide mb-1">Studio Room</h3>
                                <p class="text-xs md:text-sm text-gray-300 font-light">Kamar kompak yang efisien</p>
                            </div>
                        </div>
                    </div>

                    <!-- Kamar 6 -->
                    <div class="swiper-slide">
                        <div class="group relative overflow-hidden rounded-2xl shadow-md hover:shadow-2xl transition-all duration-500 h-[320px] md:h-[420px] cursor-pointer">
                            <img src="{{ asset('Asset/Room images/Superior 1 king bed/Wastafel superior 1 kingbed.jpg') }}" alt="Luxury Room" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                            <div class="absolute inset-0 bg-gradient-to-t from-purple-700/95 via-purple-700/20 to-transparent opacity-80 group-hover:opacity-100 transition-opacity duration-500"></div>
                            <div class="absolute bottom-0 left-0 right-0 p-6 md:p-8 transform translate-y-4 group-hover:translate-y-0 transition-transform duration-500">
                                <span class="text-[10px] text-purple-400 font-semibold uppercase tracking-widest mb-2 block opacity-0 group-hover:opacity-100 transition-opacity duration-500 delay-100">Exclusive</span>
                                <h3 class="font-bold text-xl md:text-2xl text-white tracking-wide mb-1">Luxury Room</h3>
                                <p class="text-xs md:text-sm text-gray-300 font-light">Kamar paling mewah kami</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Navigation Buttons (Premium Glass/Minimalist Style) -->
                <button aria-label="Previous" class="swiper-button-prev kamar-prev absolute left-2 top-1/2 -translate-y-1/2 z-10 w-9 h-9 bg-transparent hover:bg-white/10 text-white items-center justify-center rounded-full transition duration-150">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
                <button aria-label="Next" class="swiper-button-next kamar-next absolute right-2 top-1/2 -translate-y-1/2 z-10 w-9 h-9 bg-transparent hover:bg-white/10 text-white items-center justify-center rounded-full transition duration-150">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                    </svg>
                </button>

                <!-- Pagination -->
                <div class="swiper-pagination mt-8 relative bottom-0"></div>
            </div>

            <!-- Tombol Bawah -->
            <div class="text-center mt-14 relative z-10">
                <a id="explore_rooms_link" href="{{ route('kamar') }}" class="inline-flex items-center justify-center gap-3 bg-purple-700 hover:bg-purple-600 text-white text-xs md:text-sm font-semibold px-8 py-3.5 rounded-full transition duration-300 shadow-xl hover:shadow-purple-500/30">
                    Jelajahi Semua Kamar
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                    </svg>
                </a>
            </div>
            
        </div>
    </div>
    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <!-- Flatpickr JS + range plugin -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/plugins/rangePlugin.js"></script>
    <script>
        // expose authentication state to frontend
        window.__isAuthenticated = @json(auth()->check());
    </script>

    <script>
        // forward selected dates and guests to /kamar when clicking "Jelajahi Semua Kamar"
        document.addEventListener('DOMContentLoaded', function(){
            const explore = document.getElementById('explore_rooms_link');
            if (!explore) return;
            explore.addEventListener('click', function(e){
                e.preventDefault();
                const checkin = document.getElementById('checkin_date')?.value || '';
                const checkout = document.getElementById('checkout_date')?.value || '';
                const adults = document.getElementById('adults_input')?.value || 2;
                const children = document.getElementById('children_input')?.value || 0;
                const url = new URL(explore.href, window.location.origin);
                if (checkin) url.searchParams.set('checkin', checkin);
                if (checkout) url.searchParams.set('checkout', checkout);
                if (adults) url.searchParams.set('adults', adults);
                if (children) url.searchParams.set('children', children);
                window.location.href = url.toString();
            });
        });
    </script>

    <script>
        const swiper = new Swiper('.kamar-carousel', {
            slidesPerView: 1,
            spaceBetween: 30,
            loop: true,
            autoplay: {
                delay: 10000,
                disableOnInteraction: false,
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.kamar-next',
                prevEl: '.kamar-prev',
            },
            breakpoints: {
                640: {
                    slidesPerView: 2,
                    spaceBetween: 20,
                },
                1024: {
                    slidesPerView: 3,
                    spaceBetween: 30,
                },
            },
        });
    </script>

    <script>
        // Initialize Flatpickr with range plugin linking checkin->checkout
        document.addEventListener('DOMContentLoaded', function () {
            if (typeof flatpickr !== 'undefined') {
                flatpickr('#checkin_date', {
                    dateFormat: 'Y-m-d',
                    minDate: 'today',
                    allowInput: true,
                    plugins: [new rangePlugin({ input: '#checkout_date' })]
                });
            }
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const adultCountEl = document.getElementById('adult_count');
            const childCountEl = document.getElementById('child_count');
            const adultsInput = document.getElementById('adults_input');
            const childrenInput = document.getElementById('children_input');

            let adults = 2;
            let children = 0;

            function updateCounts() {
                adultCountEl.textContent = adults;
                childCountEl.textContent = children;
                if (adultsInput) adultsInput.value = adults;
                if (childrenInput) childrenInput.value = children;
            }

            const adultIncr = document.getElementById('adult_incr');
            const adultDecr = document.getElementById('adult_decr');
            const childIncr = document.getElementById('child_incr');
            const childDecr = document.getElementById('child_decr');

            if (adultIncr) adultIncr.addEventListener('click', () => { if (adults < 10) adults++; updateCounts(); });
            if (adultDecr) adultDecr.addEventListener('click', () => { if (adults > 1) adults--; updateCounts(); });
            if (childIncr) childIncr.addEventListener('click', () => { if (children < 10) children++; updateCounts(); });
            if (childDecr) childDecr.addEventListener('click', () => { if (children > 0) children--; updateCounts(); });

            updateCounts();
        });
    </script>

<script>
    // Availability search AJAX + modal
    document.addEventListener('DOMContentLoaded', function(){
        const btn = document.getElementById('search_rooms_btn');
        const modal = document.getElementById('availability_modal');
        const closeBtn = document.getElementById('availability_close');
        const content = document.getElementById('availability_content');
        const loading = document.getElementById('availability_loading');
        const dialog = document.querySelector('#availability_modal .modal-dialog');

        function formatCurrency(num){
            return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(num);
        }

        btn.addEventListener('click', function(e){
            e.preventDefault();
            const checkin = document.getElementById('checkin_date').value;
            const checkout = document.getElementById('checkout_date').value;
            const adults = document.getElementById('adults_input').value || 1;
            const children = document.getElementById('children_input').value || 0;

            if(!checkin || !checkout){
                alert('Silakan pilih tanggal check-in dan check-out.');
                return;
            }

            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden'; // lock background scroll
            
            // Animasi masuk modal
            setTimeout(()=>{
                if(dialog){ 
                    dialog.classList.remove('scale-95','opacity-0'); 
                    dialog.classList.add('scale-100','opacity-100', 'transition-all', 'duration-300', 'ease-out'); 
                }
            }, 10);
            
            loading.style.display = 'block';
            content.querySelectorAll('.result-row')?.forEach(n=>n.remove());

            const params = new URLSearchParams({ checkin, checkout, adults, children });
            fetch('/api/availability?' + params.toString())
                .then(r => r.json())
                .then(data => {
                    loading.style.display = 'none';
                    
                    // State: Jika tidak ada kamar
                    if(!data.rooms || data.rooms.length === 0){
                        content.insertAdjacentHTML('beforeend', `
                            <div class="result-row flex flex-col items-center justify-center p-8 text-center bg-gray-50 rounded-2xl border border-gray-100">
                                <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <p class="text-gray-500 font-medium">Yah, tidak ada kamar tersedia.</p>
                                <p class="text-sm text-gray-400 mt-1">Coba ubah tanggal atau jumlah tamu yang dipilih.</p>
                            </div>
                        `);
                        return;
                    }

                    // State: Kamar tersedia (Desain Modern Minimalis)
                    data.rooms.forEach(room => {
                        const html = `
                            <div class="result-row group p-4 mb-4 bg-white border border-gray-100 rounded-2xl shadow-sm hover:shadow-md hover:border-purple-100 transition-all duration-300 flex flex-col sm:flex-row gap-5 items-start sm:items-center relative overflow-hidden">
                                
                                <div class="relative w-full sm:w-36 h-40 sm:h-28 flex-shrink-0 overflow-hidden rounded-xl">
                                    <img src="/${room.image}" alt="${room.name}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 ease-in-out">
                                    <div class="sr-only absolute top-2 left-2 bg-white/90 backdrop-blur-sm px-2.5 py-1 rounded-md text-[10px] font-extrabold text-purple-600 uppercase tracking-widest shadow-sm">
                                        Sisa ${room.available}
                                    </div>
                                </div>

                                <div class="flex-1 w-full">
                                    <h4 class="text-lg font-bold text-gray-900 mb-1 leading-tight">${room.name}</h4>
                                    <div class="flex items-center text-sm text-gray-500 mb-2">
                                        <svg class="w-4 h-4 mr-1.5 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                        Maks. ${room.capacity} Tamu
                                    </div>
                                </div>

                                <div class="w-full sm:w-auto flex flex-row sm:flex-col items-center sm:items-end justify-between sm:justify-center border-t sm:border-t-0 border-gray-100 pt-4 sm:pt-0">
                                    <div class="text-left sm:text-right mb-0 sm:mb-3">
                                        <div class="text-[11px] text-gray-400 uppercase tracking-wider font-semibold mb-0.5">Total ${room.nights} Malam</div>
                                        <div class="font-black text-xl text-purple-500">${formatCurrency(room.total_price)}</div>
                                        <div class="text-xs text-gray-400 mt-0.5">${formatCurrency(room.price)} / malam</div>
                                    </div>
                                    
                                    <button type="button" onclick="window.__openRoomDetail && window.__openRoomDetail(this)"
                                        class="open-room-detail inline-flex justify-center items-center px-6 py-2.5 bg-gray-900 hover:bg-purple-500 text-white text-sm font-semibold rounded-xl transition-colors duration-300 shadow-sm w-full sm:w-auto focus:ring-4 focus:ring-purple-500/20"
                                        data-id="${room.id}"
                                        data-name="${room.name}"
                                        data-price="${room.price}"
                                        data-total="${room.total_price}"
                                        data-image="${room.image}"
                                        data-description="${room.description || ''}"
                                        data-images='${JSON.stringify(room.images || [])}'
                                        data-capacity="${room.capacity}"
                                        data-nights="${room.nights}"
                                        data-checkin="${encodeURIComponent(data.checkin)}"
                                        data-checkout="${encodeURIComponent(data.checkout)}"
                                        data-adults="${adults}"
                                        data-children="${children}"
                                    >
                                        Pilih Kamar
                                    </button>
                                </div>
                                
                            </div>
                        `;
                        content.insertAdjacentHTML('beforeend', html);
                    });
                })
                .catch(err => {
                    loading.style.display = 'none';
                    content.insertAdjacentHTML('beforeend', `
                        <div class="result-row p-6 text-center bg-red-50 rounded-2xl border border-red-100">
                            <p class="text-red-600 font-medium">Terjadi kesalahan saat memuat data.</p>
                            <p class="text-sm text-red-400 mt-1">Silakan periksa koneksi internetmu dan coba lagi.</p>
                        </div>
                    `);
                    console.error(err);
                });
        });

        function closeModal() {
            if(dialog){ 
                dialog.classList.remove('scale-100','opacity-100'); 
                dialog.classList.add('scale-95','opacity-0'); 
            }
            setTimeout(()=>{ 
                modal.classList.add('hidden'); 
                document.body.style.overflow = ''; 
            }, 300);
        }

        closeBtn.addEventListener('click', closeModal);

        // Close when click outside dialog
        modal.addEventListener('click', function(e){ 
            if(e.target === modal){ 
                closeModal();
            }
        });

        // Room detail modal logic
        const roomModal = document.getElementById('room_detail_modal');
        const roomDialog = document.querySelector('#room_detail_modal .room-modal-dialog');
        const roomCloseBtn = document.getElementById('room_detail_close');
        const roomTitle = document.getElementById('room_detail_title');
        const roomName = document.getElementById('room_detail_name');
        const roomImage = document.getElementById('room_detail_image');
        const roomCapacity = document.getElementById('room_detail_capacity');
        const roomPrice = document.getElementById('room_detail_price');
        const roomPriceSmall = document.getElementById('room_detail_price_small');
        const roomBookLink = document.getElementById('room_detail_book_link');

        // Move room detail modal to document.body to avoid stacking-context issues
        try {
            if (roomModal) {
                roomModal.style.zIndex = '99999';
                if (roomModal.parentNode !== document.body) {
                    document.body.appendChild(roomModal);
                }
            }
        } catch (e) {
            console.warn('Could not move room modal to body', e);
        }

        // Global fallback in case event delegation fails
        window.__openRoomDetail = function(btn){
            try{
                const id = btn.getAttribute('data-id');
                const name = btn.getAttribute('data-name');
                const price = btn.getAttribute('data-price');
                const total = btn.getAttribute('data-total');
                const image = btn.getAttribute('data-image');
                const capacity = btn.getAttribute('data-capacity');
                const nights = btn.getAttribute('data-nights');
                const checkin = btn.getAttribute('data-checkin');
                const checkout = btn.getAttribute('data-checkout');
                const adults = btn.getAttribute('data-adults');
                const children = btn.getAttribute('data-children');

                roomName.textContent = name;
                roomImage.src = '/' + image;
                roomCapacity.textContent = `Maks. ${capacity} tamu • ${nights} malam`;
                roomPrice.textContent = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(price);
                roomPriceSmall.textContent = `Total ${nights} malam: ` + new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(total);
                const link = `/booking?checkin=${checkin}&checkout=${checkout}&kamar_id=${id}&adults=${adults}&children=${children}`;
                roomBookLink.href = link;

                roomModal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
                setTimeout(()=>{ if(roomDialog){ roomDialog.classList.remove('scale-95','opacity-0'); roomDialog.classList.add('scale-100','opacity-100'); } }, 10);
            }catch(err){ console.error('openRoomDetail fallback error', err); }
        }

        // Delegate clicks from availability content to open detail modal
        console.log('Availability content listener attached', content);
        content.addEventListener('click', function(e){
            console.log('availability content clicked', e.target);
            const btn = e.target.closest('.open-room-detail');
            if(!btn) return; console.log('open-room-detail button found', btn);
            const id = btn.getAttribute('data-id');
            const name = btn.getAttribute('data-name');
            const price = btn.getAttribute('data-price');
            const total = btn.getAttribute('data-total');
            const image = btn.getAttribute('data-image');
            const capacity = btn.getAttribute('data-capacity');
            const nights = btn.getAttribute('data-nights');
            const checkin = btn.getAttribute('data-checkin');
            const checkout = btn.getAttribute('data-checkout');
            const adults = btn.getAttribute('data-adults');
            const children = btn.getAttribute('data-children');

            // populate
            roomName.textContent = name;
            roomImage.src = '/' + image;
            roomCapacity.textContent = `Maks. ${capacity} tamu • ${nights} malam`;
            roomPrice.textContent = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(price);
            roomPriceSmall.textContent = `Total ${nights} malam: ` + new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(total);

            // description & images
            const desc = btn.getAttribute('data-description') || '';
            const imagesJson = btn.getAttribute('data-images') || '[]';
            let images = [];
            try{ images = JSON.parse(imagesJson); }catch(e){ images = []; }
            const descEl = document.getElementById('room_detail_desc');
            if(descEl) descEl.textContent = desc || 'Tidak ada deskripsi tersedia untuk kamar ini.';

            // if images available, show first image
            if(images.length > 0 && roomImage){ roomImage.src = '/' + images[0]; }

            // set booking link
            const link = `/booking?checkin=${checkin}&checkout=${checkout}&kamar_id=${id}&adults=${adults}&children=${children}`;
            // If guest, immediately navigate to booking (auth middleware will redirect to login)
            if(!window.__isAuthenticated){
                window.location.href = link;
                return;
            }
            roomBookLink.href = link;

            // show modal
            roomModal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
            setTimeout(()=>{ if(roomDialog){ roomDialog.classList.remove('scale-95','opacity-0'); roomDialog.classList.add('scale-100','opacity-100'); } }, 10);
        });

        function closeRoomModal(){
            if(roomDialog){ roomDialog.classList.remove('scale-100','opacity-100'); roomDialog.classList.add('scale-95','opacity-0'); }
            setTimeout(()=>{ roomModal.classList.add('hidden'); document.body.style.overflow = ''; }, 200);
        }

        roomCloseBtn.addEventListener('click', closeRoomModal);
        roomModal.addEventListener('click', function(e){ if(e.target === roomModal) closeRoomModal(); });
    });
</script>

    <div class="max-w-7xl mx-auto px-4 md:px-6 py-12 md:py-20 grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-12 items-center">
        <div class="space-y-4">
            <span class="text-[10px] font-bold tracking-widest text-purple-500 uppercase block mb-1">Tentang Kami</span>
            <h2 class="text-2xl md:text-4xl font-extrabold text-gray-900 mb-2 leading-tight">Akomodasi Berkelas di Kawasan Strategis West Karawang</h2>
            <p class="text-sm text-gray-600 mb-4 leading-relaxed">Kami menghadirkan pelayanan internasional dengan kenyamanan modern — pilihan kamar premium, fasilitas pertemuan, dan layanan 24 jam untuk kebutuhan bisnis atau liburan Anda.</p>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
                <div class="p-4 bg-white rounded-xl border border-gray-100 shadow-sm text-center">
                    <div class="text-2xl font-bold text-purple-500">4★</div>
                    <div class="text-xs text-gray-500 uppercase mt-1">Standar</div>
                </div>
                <div class="p-4 bg-white rounded-xl border border-gray-100 shadow-sm text-center">
                    <div class="text-2xl font-bold text-purple-500">150+</div>
                    <div class="text-xs text-gray-500 uppercase mt-1">Kamar Mewah</div>
                </div>
                <div class="p-4 bg-white rounded-xl border border-gray-100 shadow-sm text-center">
                    <div class="text-2xl font-bold text-purple-500">24/7</div>
                    <div class="text-xs text-gray-500 uppercase mt-1">Layanan</div>
                </div>
            </div>

            <div class="flex gap-3">
                <a href="{{ route('kamar') }}" class="inline-block bg-purple-600 hover:bg-purple-700 text-white px-5 py-3 rounded-lg font-semibold">Lihat Semua Kamar</a>
                <a href="/contact" class="inline-block border border-gray-200 px-5 py-3 rounded-lg text-sm text-gray-600">Hubungi Kami</a>
            </div>

            <!-- Room Detail Modal (opened when user clicks 'Pilih Kamar') -->
            <div id="room_detail_modal" class="fixed inset-0 hidden z-60 flex items-center justify-center bg-black/60 backdrop-blur-sm px-4 md:px-6">
                <div class="room-modal-dialog bg-white w-full max-w-4xl mx-4 md:mx-0 rounded-2xl shadow-2xl overflow-hidden transform transition-all duration-300 scale-95 opacity-0">
                    <div class="flex items-center justify-between p-5 border-b bg-white">
                        <h3 id="room_detail_title" class="font-bold text-lg">Detail Kamar</h3>
                        <button id="room_detail_close" class="text-gray-500 hover:text-gray-800 bg-gray-100 hover:bg-gray-200 px-3 py-1 rounded">Tutup ✕</button>
                    </div>
                    <div id="room_detail_content" class="p-6 max-h-[70vh] overflow-auto bg-white">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-start">
                            <div class="space-y-3">
                                <img id="room_detail_image" src="" alt="" class="w-full h-64 object-cover rounded-xl shadow-sm">
                                <div id="room_detail_gallery" class="flex gap-2"></div>
                            </div>
                            <div class="flex-1">
                                <h4 id="room_detail_name" class="text-2xl font-bold mb-2"></h4>
                                <div id="room_detail_capacity" class="text-sm text-gray-600 mb-3"></div>
                                <p id="room_detail_desc" class="text-sm text-gray-500 mb-4">Deskripsi singkat kamar akan tampil di sini.</p>
                                <div class="mt-4 flex items-center justify-between">
                                    <div>
                                        <div class="text-xs text-gray-400 uppercase">Per malam</div>
                                        <div id="room_detail_price" class="font-extrabold text-2xl text-purple-600"></div>
                                        <div id="room_detail_price_small" class="text-xs text-gray-400"></div>
                                    </div>
                                    <div class="text-right">
                                        <a id="room_detail_book_link" href="#" class="inline-block bg-purple-600 hover:bg-purple-700 text-white px-5 py-3 rounded-lg font-semibold">Pesan Sekarang</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="hidden md:grid grid-cols-2 gap-4">
            <img class="rounded-xl shadow-sm w-full h-56 object-cover" src="{{ asset('Asset/Room images/Deluxe 1 king bed/Deluxe 1 king bed.jpg') }}" alt="Kamar">
            <img class="rounded-xl shadow-sm w-full h-56 object-cover" src="{{ asset('Asset/Facilities and facade building/Waiting room.jpg') }}" alt="Lobby">
        </div>
    </div>
    
@endsection