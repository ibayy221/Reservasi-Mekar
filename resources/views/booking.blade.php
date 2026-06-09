@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto py-6 px-4 min-h-[calc(100vh-80px)] flex flex-col justify-center">
    
    <div class="mb-6">
        <h2 class="text-3xl font-extrabold text-gray-800 tracking-tight">Selesaikan Pemesanan Anda</h2>
        <p class="text-gray-500 text-sm mt-1">Hanya butuh 1 menit untuk mengamankan kamar Anda.</p>
    </div>

    <form method="POST" action="{{ route('reservation.store') }}" class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
        @csrf
        <input type="hidden" name="kamar_id" value="{{ $kamar->id ?? '' }}">
        <input type="hidden" id="checkin_hidden" name="checkin" value="{{ $checkin ?? old('checkin') }}">
        <input type="hidden" id="checkout_hidden" name="checkout" value="{{ $checkout ?? old('checkout') }}">
        <input type="hidden" name="adults" value="{{ $adults ?? 2 }}">
        <input type="hidden" name="children" value="{{ $children ?? 0 }}">

        <div class="lg:col-span-4 bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden sticky top-6">
            <div class="bg-purple-600 p-5 text-white">
                <h3 class="text-lg font-bold">{{ $kamar->name ?? 'Tipe Kamar' }}</h3>
                <div class="mt-2 text-purple-100 text-sm flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    {{ ($adults ?? 2) }} Dewasa, {{ ($children ?? 0) }} Anak
                </div>
            </div>

            <div class="p-5">
                <div class="flex justify-between items-center bg-gray-50 p-3 rounded-xl mb-4 border border-gray-100">
                    <div class="text-center w-full">
                        <span class="block text-xs text-gray-500 font-medium uppercase">Check-In</span>
                        <input type="text" name="checkin" value="{{ $checkin ?? old('checkin') }}" class="w-full text-center bg-transparent text-sm font-bold text-gray-800 focus:outline-none" readonly>
                    </div>
                    <div class="w-px h-8 bg-gray-300 mx-2"></div>
                    <div class="text-center w-full">
                        <span class="block text-xs text-gray-500 font-medium uppercase">Check-Out</span>
                        <input type="text" name="checkout" value="{{ $checkout ?? old('checkout') }}" class="w-full text-center bg-transparent text-sm font-bold text-gray-800 focus:outline-none" readonly>
                    </div>
                </div>

                <div class="mb-4">
                    <h4 class="text-xs font-bold text-gray-400 uppercase mb-2">Fasilitas Termasuk</h4>
                    <div class="flex flex-wrap gap-2">
                        <span class="px-2.5 py-1 bg-purple-50 text-purple-700 text-xs font-medium rounded-md border border-purple-100">WiFi Gratis</span>
                        <span class="px-2.5 py-1 bg-purple-50 text-purple-700 text-xs font-medium rounded-md border border-purple-100">AC</span>
                        <span class="px-2.5 py-1 bg-purple-50 text-purple-700 text-xs font-medium rounded-md border border-purple-100">TV</span>
                        <span class="px-2.5 py-1 bg-purple-50 text-purple-700 text-xs font-medium rounded-md border border-purple-100">Sarapan</span>
                        <span class="px-2.5 py-1 bg-purple-50 text-purple-700 text-xs font-medium rounded-md border border-purple-100">Kolam Renang</span>
                    </div>
                    @if(!empty($kamar->description))
                        <p class="text-xs text-gray-500 mt-3 line-clamp-2">{{ $kamar->description }}</p>
                    @endif
                </div>

                <hr class="border-gray-100 my-4">

                <div class="flex justify-between items-end">
                    <span class="text-sm text-gray-500 font-medium">Harga per malam</span>
                    <span class="text-xl font-black text-gray-800">Rp {{ number_format($kamar->price ?? 0, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <div class="lg:col-span-8 flex flex-col gap-5">
            @if ($errors->any())
                <div class="bg-red-50 border border-red-100 text-red-700 p-4 rounded">
                    <ul class="list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if(session('status'))
                <div class="bg-purple-50 border border-purple-100 text-purple-700 p-4 rounded">{{ session('status') }}</div>
            @endif
            
            <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100">
                <h4 class="text-base font-bold text-gray-800 mb-4 flex items-center gap-2">
                    <span class="w-6 h-6 rounded-full bg-purple-100 text-purple-600 flex items-center justify-center text-sm">1</span> 
                    Informasi Tamu
                </h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="md:col-span-2">
                        <label class="block text-xs font-semibold text-gray-600 mb-1">NIK / Nomor KTP</label>
                            <input type="text" name="nik_ktp" value="{{ old('nik_ktp', auth()->user()->nik_ktp ?? '') }}" class="w-full border border-gray-200 px-4 py-2.5 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all text-sm" placeholder="Nomor KTP" required>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Nama Lengkap Sesuai KTP</label>
                            <input type="text" name="name" value="{{ old('name', auth()->user()->name ?? '') }}" class="w-full border border-gray-200 px-4 py-2.5 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all text-sm" placeholder="Masukkan nama lengkap" required>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Alamat Email</label>
                            <input type="email" name="email" value="{{ old('email', auth()->user()->email ?? '') }}" class="w-full border border-gray-200 px-4 py-2.5 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all text-sm" placeholder="email@contoh.com" required>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Nomor Telepon / WhatsApp</label>
                            <input type="tel" name="phone" value="{{ old('phone', auth()->user()->no_hp ?? '') }}" class="w-full border border-gray-200 px-4 py-2.5 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all text-sm" placeholder="0812xxxxxx">
                    </div>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100">
                <h4 class="text-base font-bold text-gray-800 mb-4 flex items-center gap-2">
                    <span class="w-6 h-6 rounded-full bg-purple-100 text-purple-600 flex items-center justify-center text-sm">2</span> 
                        Preferensi Menginap
                </h4>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-2">Tipe Ruangan</label>
                        <div class="grid grid-cols-2 gap-3">
                            <label class="cursor-pointer">
                                <input type="radio" name="smoking_preference" value="non-smoking" class="peer sr-only" checked>
                                <div class="text-center px-3 py-2 text-sm border border-gray-200 rounded-lg peer-checked:bg-purple-50 peer-checked:border-purple-500 peer-checked:text-purple-700 hover:bg-gray-50 transition-all font-medium">
                                    Non-Smoking
                                </div>
                            </label>
                            <label class="cursor-pointer">
                                <input type="radio" name="smoking_preference" value="smoking" class="peer sr-only">
                                <div class="text-center px-3 py-2 text-sm border border-gray-200 rounded-lg peer-checked:bg-purple-50 peer-checked:border-purple-500 peer-checked:text-purple-700 hover:bg-gray-50 transition-all font-medium">
                                    Smoking
                                </div>
                            </label>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-2">Pengaturan Tempat Tidur</label>
                        <div class="grid grid-cols-2 gap-3">
                            <label class="cursor-pointer">
                                <input type="radio" name="bed_setup" value="large" class="peer sr-only" checked>
                                <div class="text-center px-3 py-2 text-sm border border-gray-200 rounded-lg peer-checked:bg-purple-50 peer-checked:border-purple-500 peer-checked:text-purple-700 hover:bg-gray-50 transition-all font-medium">
                                    1 Kasur Besar
                                </div>
                            </label>
                            <label class="cursor-pointer">
                                <input type="radio" name="bed_setup" value="twin" class="peer sr-only">
                                <div class="text-center px-3 py-2 text-sm border border-gray-200 rounded-lg peer-checked:bg-purple-50 peer-checked:border-purple-500 peer-checked:text-purple-700 hover:bg-gray-50 transition-all font-medium">
                                    2 Kasur (Twin)
                                </div>
                            </label>
                        </div>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Catatan Tambahan (Opsional)</label>
                        <textarea name="special_requests" rows="2" class="w-full border border-gray-200 px-4 py-2 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all text-sm resize-none" placeholder="Contoh: Lantai atas, dekat lift, minta tambahan handuk..."></textarea>
                    </div>
                </div>
            </div>

            <button type="submit" class="w-full bg-purple-600 hover:bg-purple-700 text-white font-bold py-3.5 px-6 rounded-xl shadow-lg shadow-purple-200 transition-all transform active:scale-[0.99] flex justify-center items-center gap-2">
                Konfirmasi Pesanan Sekarang
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
            </button>
            <p class="text-center text-xs text-gray-400 mt-1">Anda belum akan dikenakan biaya pada tahap ini.</p>

        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function(){
    // sync visible readonly inputs with hidden fields before submit
    const form = document.querySelector('form[action="{{ route('reservation.store') }}"]');
    const visibleCheckin = form.querySelector('input[name="checkin"]');
    const visibleCheckout = form.querySelector('input[name="checkout"]');
    const hiddenCheckin = document.getElementById('checkin_hidden');
    const hiddenCheckout = document.getElementById('checkout_hidden');

    // if URL has params, fill visible inputs when empty
    const params = new URLSearchParams(window.location.search);
    if(!visibleCheckin.value && params.get('checkin')) visibleCheckin.value = params.get('checkin');
    if(!visibleCheckout.value && params.get('checkout')) visibleCheckout.value = params.get('checkout');

    function sync() {
        hiddenCheckin.value = visibleCheckin.value || '';
        hiddenCheckout.value = visibleCheckout.value || '';
    }

    sync();

    form.addEventListener('submit', function(e){
        sync();
        if(!hiddenCheckin.value || !hiddenCheckout.value || !form.querySelector('input[name="kamar_id"]').value){
            e.preventDefault();
            // show errors area
            const errorsDiv = document.querySelector('.bg-red-50');
            if(errorsDiv){
                errorsDiv.innerHTML = '<ul class="list-disc list-inside text-sm"><li>Check-in dan Check-out wajib diisi.</li><li>Pilih kamar terlebih dahulu.</li></ul>';
                errorsDiv.style.display = 'block';
            } else {
                alert('Check-in, Check-out, dan Kamar wajib diisi.');
            }
        }
    });
});
</script>
@endpush