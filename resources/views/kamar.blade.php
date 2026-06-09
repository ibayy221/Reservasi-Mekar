@extends('layouts.app')

@section('content')
<div class="bg-gray-50 min-h-screen py-6 md:py-12">
    <div class="max-w-7xl mx-auto px-4 md:px-6">
        
        <!-- Header Halaman -->
            <div class="mb-8">
            <span class="text-[10px] md:text-xs font-bold tracking-widest text-purple-600 uppercase block mb-1">Pilihan Terbaik</span>
            <h1 class="text-xl md:text-3xl font-bold text-purple-600 tracking-tight">Tipe Kamar & Kamar Mewah</h1>
            <p class="text-xs md:text-sm text-gray-500 mt-1">Pilih akomodasi yang sesuai dengan kenyamanan istirahat Anda.</p>
        </div>

       <!-- Grid Katalog Kamar -->
        <!-- Mobile: 1 kolom (stack), Tablet: 2 kolom, Desktop: 3 kolom -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($kamars as $kamar)
                <div class="bg-white rounded-2xl shadow-md border border-gray-100 overflow-hidden flex flex-col justify-between">
                    <div>
                        <div class="relative">
                            <img class="w-full h-48 md:h-52 object-cover" src="{{ $kamar->image ? asset($kamar->image) : asset('Asset/Room images/Superior 1 king bed/Kamar-supperior 1 king bed.jpg') }}" alt="{{ $kamar->name }}">
                            <span class="absolute top-3 right-3 bg-purple-600 text-white text-[10px] font-semibold px-2.5 py-1 rounded-full uppercase tracking-wider border border-purple-800">Tersedia</span>
                        </div>
                        <div class="p-4 md:p-5">
                            <h3 class="text-base md:text-lg font-bold text-purple-600">{{ $kamar->name }}</h3>
                            <p class="text-[11px] text-gray-400 font-light mt-0.5">{{ \Illuminate\Support\Str::limit($kamar->description, 60) }}</p>
                            <div class="flex flex-wrap gap-1.5 mt-3">
                                <span class="bg-gray-100 text-gray-600 text-[10px] px-2 py-0.5 rounded-md font-medium">{{ $kamar->capacity }} Tamu</span>
                                <span class="bg-gray-100 text-gray-600 text-[10px] px-2 py-0.5 rounded-md font-medium">AC</span>
                            </div>
                        </div>
                    </div>
                    <div class="p-4 md:p-5 pt-0 border-t border-gray-50 flex items-center justify-between mt-4">
                        <div>
                            <span class="text-[10px] text-gray-400 block">Mulai dari</span>
                            <span class="text-sm md:text-base font-bold text-purple-600">{{ $priceMap[$kamar->id] ?? ('Rp ' . number_format($kamar->price ?? 0,0,',','.')) }}<span class="text-[10px] text-gray-400 font-normal">/malam</span></span>
                        </div>
                        <a href="{{ route('booking.create') }}?kamar_id={{ $kamar->id }}&checkin={{ request()->query('checkin') }}&checkout={{ request()->query('checkout') }}&adults={{ request()->query('adults',2) }}&children={{ request()->query('children',0) }}" class="btn-pesan bg-purple-600 hover:bg-purple-700 text-white text-xs font-semibold px-4 py-2 rounded-lg shadow-sm transition">Pesan</a>
                    </div>
                </div>
            @endforeach
        </div>
        <!-- Modal: pilih tanggal jika tamu klik Pesan tanpa tanggal -->
        <div id="dateModal" class="hidden fixed inset-0 bg-black/50 z-50 items-center justify-center">
            <div class="bg-white rounded-xl p-6 w-full max-w-md mx-4">
                <h3 class="text-lg font-bold text-gray-800 mb-3">Pilih Tanggal Menginap</h3>
                <div class="grid grid-cols-1 gap-3">
                    <label class="text-xs text-gray-600">Check-in</label>
                    <input id="modal_checkin" type="date" class="w-full border border-gray-200 px-3 py-2 rounded" />
                    <label class="text-xs text-gray-600">Check-out</label>
                    <input id="modal_checkout" type="date" class="w-full border border-gray-200 px-3 py-2 rounded" />
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="text-xs text-gray-600">Dewasa</label>
                            <input id="modal_adults" type="number" min="1" value="2" class="w-full border border-gray-200 px-3 py-2 rounded" />
                        </div>
                        <div>
                            <label class="text-xs text-gray-600">Anak</label>
                            <input id="modal_children" type="number" min="0" value="0" class="w-full border border-gray-200 px-3 py-2 rounded" />
                        </div>
                    </div>
                </div>
                <div class="mt-4 flex items-center justify-end gap-3">
                    <button id="modal_cancel" class="px-3 py-2 rounded bg-gray-100">Batal</button>
                    <button id="modal_continue" class="px-4 py-2 rounded bg-purple-600 text-white">Lanjutkan</button>
                </div>
            </div>
        </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
document.addEventListener('DOMContentLoaded', function(){
    const modal = document.getElementById('dateModal');
    const modalCheckin = document.getElementById('modal_checkin');
    const modalCheckout = document.getElementById('modal_checkout');
    const btnCancel = document.getElementById('modal_cancel');
    const btnContinue = document.getElementById('modal_continue');
    const modalAdults = document.getElementById('modal_adults');
    const modalChildren = document.getElementById('modal_children');
    let pendingHref = null;

    function showModal(){
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }
    function hideModal(){
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    document.querySelectorAll('a.btn-pesan').forEach(function(a){
        a.addEventListener('click', function(e){
            try{
                const url = new URL(a.href, window.location.origin);
                const checkin = url.searchParams.get('checkin');
                const checkout = url.searchParams.get('checkout');
                if(!checkin || !checkout){
                    e.preventDefault();
                    pendingHref = a.href;
                    // prefill modal with query params from page if any
                    const pageParams = new URLSearchParams(window.location.search);
                    if(pageParams.get('checkin')) modalCheckin.value = pageParams.get('checkin');
                    if(pageParams.get('checkout')) modalCheckout.value = pageParams.get('checkout');
                    if(pageParams.get('adults')) modalAdults.value = pageParams.get('adults');
                    if(pageParams.get('children')) modalChildren.value = pageParams.get('children');
                    showModal();
                }
            }catch(err){ /* ignore */ }
        });
    });

    btnCancel.addEventListener('click', function(){ hideModal(); });
    modal.addEventListener('click', function(e){ if(e.target === modal) hideModal(); });

    // Initialize Flatpickr on modal inputs for better UX
    let fpCheckout = null;
    const fpCheckin = flatpickr(modalCheckin, {
        minDate: 'today',
        dateFormat: 'Y-m-d',
        allowInput: false,
        onChange: function(selectedDates){
            if(selectedDates[0] && fpCheckout){ fpCheckout.set('minDate', selectedDates[0]); }
        }
    });
    fpCheckout = flatpickr(modalCheckout, {
        minDate: 'today',
        dateFormat: 'Y-m-d',
        allowInput: false,
    });

    btnContinue.addEventListener('click', function(){
        const cIn = modalCheckin.value;
        const cOut = modalCheckout.value;
        const adults = parseInt(modalAdults.value) || 1;
        const children = parseInt(modalChildren.value) || 0;
        if(!cIn || !cOut){ alert('Pilih tanggal check-in dan check-out.'); return; }
        if(new Date(cIn) > new Date(cOut)){ alert('Tanggal check-out harus setelah check-in.'); return; }
        if(!pendingHref){ hideModal(); return; }
        const url = new URL(pendingHref, window.location.origin);
        url.searchParams.set('checkin', cIn);
        url.searchParams.set('checkout', cOut);
        // set adults/children from modal (fallback to page params preserved below)
        url.searchParams.set('adults', adults);
        url.searchParams.set('children', children);
        // preserve other page params if set
        const pageParams = new URLSearchParams(window.location.search);
        // (we intentionally overwrite adults/children with modal values)
        window.location.href = url.toString();
    });
});
</script>
@endpush