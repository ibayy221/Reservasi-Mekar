@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto py-6 px-4 min-h-[calc(100vh-80px)] flex flex-col justify-center">
    
    <!-- Header Pembayaran -->
    <div class="text-center mb-8">
        <h2 class="text-3xl font-extrabold text-gray-800 tracking-tight">Selesaikan Pembayaran</h2>
        <div class="flex items-center justify-center gap-1.5 mt-2 text-sm text-emerald-600 font-medium">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
            Koneksi 256-bit Enkripsi Aman
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        
        <!-- KOLOM KIRI: Rincian Tagihan (Col-span 5) -->
        <div class="lg:col-span-5 bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden relative">
            <!-- Pita dekoratif atas -->
            <div class="h-2 w-full bg-emerald-500"></div>
            
            <div class="p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4 border-b border-gray-100 pb-3">Ringkasan Tagihan</h3>
                
                <div class="space-y-4">
                    @if(auth()->check() && auth()->user()->role === 'admin')
                    <div class="flex justify-start items-center gap-4">
                        <div>
                            <div class="text-sm text-gray-500">Nomor Reservasi</div>
                            <div class="text-sm font-bold text-gray-800 bg-gray-100 px-2 py-0.5 rounded">#{{ $reservation->reservation_code ?? $reservation->id }}</div>
                            @if(! empty($reservation->payment_id))
                                <div class="text-xs text-gray-500 mt-1">Kode Pembayaran: <span class="font-mono text-gray-800">{{ $reservation->payment_id }}</span></div>
                            @endif
                        </div>
                    </div>
                    @endif
                    
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-500">Tipe Kamar</span>
                        <span class="text-sm font-bold text-gray-800 text-right">{{ $reservation->kamar->name ?? '-' }}</span>
                    </div>

                    <div class="bg-gray-50 p-3 rounded-lg border border-gray-100 mt-2">
                        <div class="flex justify-between text-xs mb-2">
                            <span class="text-gray-500 uppercase font-semibold">Check-in</span>
                            <span class="font-bold text-gray-800">{{ $reservation->check_in }}</span>
                        </div>
                        <div class="flex justify-between text-xs">
                            <span class="text-gray-500 uppercase font-semibold">Check-out</span>
                            <span class="font-bold text-gray-800">{{ $reservation->check_out }}</span>
                        </div>
                    </div>

                    <div class="flex justify-between items-center pt-2">
                        <span class="text-sm text-gray-500">Durasi Menginap</span>
                        <span class="text-sm font-bold text-gray-800">{{ $reservation->nights }} Malam</span>
                    </div>
                </div>
            </div>

            <!-- Total Harga (Sticky/Prominent di bawah card) -->
            <div class="bg-gray-50 p-6 border-t border-gray-200">
                <div class="flex justify-between items-end">
                    <span class="text-sm text-gray-500 font-medium">Total Pembayaran</span>
                    <span class="text-2xl font-black text-emerald-600">Rp {{ number_format($reservation->total_price, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <!-- KOLOM KANAN: Metode Pembayaran (Col-span 7) -->
        <div class="lg:col-span-7 bg-white p-6 rounded-2xl shadow-sm border border-gray-200">
            <h3 class="text-lg font-bold text-gray-800 mb-1">Pilih Metode Pembayaran</h3>
            <p class="text-sm text-gray-500 mb-6">Pilih salah satu opsi pembayaran di bawah ini (Mode Demo).</p>

            <form method="POST" action="{{ route('payment.pay', ['id' => $reservation->id]) }}">
                @csrf
                
                <!-- Opsi Pembayaran (Radio Cards Dummy) -->
                <div class="space-y-3 mb-8">
                    <!-- Opsi 1: Transfer Bank -->
                    <label class="relative block cursor-pointer">
                        <input type="radio" name="payment_method" value="bank_transfer" class="peer sr-only" checked>
                        <div class="flex items-center justify-between px-4 py-3 border-2 border-gray-100 rounded-xl peer-checked:border-emerald-500 peer-checked:bg-emerald-50 hover:bg-gray-50 transition-all">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-white rounded-lg border border-gray-200 flex items-center justify-center text-emerald-600">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                                </div>
                                <div>
                                    <h4 class="text-sm font-bold text-gray-800">Transfer Bank (Virtual Account)</h4>
                                    <p class="text-xs text-gray-500">BCA, Mandiri, BNI, BRI</p>
                                </div>
                            </div>
                            <!-- Check icon when selected -->
                            <div class="w-5 h-5 rounded-full border-2 border-gray-300 peer-checked:border-emerald-500 peer-checked:bg-emerald-500 flex items-center justify-center transition-colors">
                                <svg class="w-3 h-3 text-white opacity-0 peer-checked:opacity-100" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                        </div>
                    </label>

                    <!-- Opsi 2: E-Wallet -->
                    <label class="relative block cursor-pointer">
                        <input type="radio" name="payment_method" value="ewallet" class="peer sr-only">
                        <div class="flex items-center justify-between px-4 py-3 border-2 border-gray-100 rounded-xl peer-checked:border-emerald-500 peer-checked:bg-emerald-50 hover:bg-gray-50 transition-all">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-white rounded-lg border border-gray-200 flex items-center justify-center text-emerald-600">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                </div>
                                <div>
                                    <h4 class="text-sm font-bold text-gray-800">E-Wallet / QRIS</h4>
                                    <p class="text-xs text-gray-500">GoPay, OVO, Dana, ShopeePay</p>
                                </div>
                            </div>
                            <div class="w-5 h-5 rounded-full border-2 border-gray-300 peer-checked:border-emerald-500 peer-checked:bg-emerald-500 flex items-center justify-center transition-colors">
                                <svg class="w-3 h-3 text-white opacity-0 peer-checked:opacity-100" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                        </div>
                    </label>
                </div>

                <!-- Detail Metode Pembayaran (dinamis) -->
                <div class="mb-6">
                    <div id="details_bank_transfer" class="payment-details bg-emerald-50 border border-emerald-100 p-4 rounded-lg mb-3">
                        <h4 class="text-sm font-bold text-gray-800">Instruksi Transfer Bank</h4>
                        <p class="text-xs text-gray-600">Silakan transfer ke Virtual Account berikut:</p>
                        <div class="mt-2 flex items-center justify-between">
                            <div class="font-mono font-bold text-lg text-gray-800">VA{{ str_pad($reservation->id, 6, '0', STR_PAD_LEFT) }}</div>
                            <button type="button" data-copy-target="#va_number" class="text-sm text-emerald-600 hover:underline">Salin</button>
                        </div>
                        <input type="hidden" id="va_number" value="VA{{ str_pad($reservation->id, 6, '0', STR_PAD_LEFT) }}">
                        <p class="text-xs text-gray-500 mt-2">Status pembayaran akan terupdate setelah kami menerima konfirmasi bank (demo: klik Bayar untuk menandai sudah dibayar).</p>
                    </div>

                    <div id="details_ewallet" class="payment-details hidden bg-emerald-50 border border-emerald-100 p-4 rounded-lg">
                        <h4 class="text-sm font-bold text-gray-800">Scan QR untuk Bayar (E-Wallet)</h4>
                        <div class="mt-3 flex items-center justify-center">
                            <div class="w-44 h-44 bg-white border border-gray-200 flex items-center justify-center text-sm text-gray-400">QR CODE</div>
                        </div>
                        <p class="text-xs text-gray-500 mt-3">Buka aplikasi e-wallet Anda dan scan QR di atas, lalu klik Bayar.</p>
                    </div>
                </div>

                <!-- Tombol Action -->
                <button id="pay_button" type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white py-3.5 rounded-xl font-bold text-base shadow-lg shadow-emerald-200 transition-all transform active:scale-[0.99] flex justify-center items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span id="pay_button_label">Bayar Rp {{ number_format($reservation->total_price, 0, ',', '.') }} Sekarang</span>
                </button>
            </form>

            <!-- Link Skip -->
            <div class="mt-6 text-center">
                <a href="{{ route('reservation.show', ['id' => $reservation->id]) }}" class="inline-flex items-center gap-1 text-sm text-gray-400 hover:text-gray-600 transition-colors">
                    Lewati pembayaran & lihat detail pesanan
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </a>
            </div>

        </div>
    </div>
</div>
@endsection

        @push('scripts')
        <script>
        document.addEventListener('DOMContentLoaded', function(){
            const radios = document.querySelectorAll('input[name="payment_method"]');
            const detailsBank = document.getElementById('details_bank_transfer');
            const detailsEwallet = document.getElementById('details_ewallet');
            const payLabel = document.getElementById('pay_button_label');
            const vaInput = document.getElementById('va_number');

            function updateDetails(){
                const selected = document.querySelector('input[name="payment_method"]:checked').value;
                if(selected === 'bank_transfer'){
                    detailsBank.classList.remove('hidden');
                    detailsEwallet.classList.add('hidden');
                    payLabel.textContent = 'Bayar Rp {{ number_format($reservation->total_price, 0, ',', '.') }} Sekarang (Transfer)';
                } else if(selected === 'ewallet'){
                    detailsBank.classList.add('hidden');
                    detailsEwallet.classList.remove('hidden');
                    payLabel.textContent = 'Bayar Rp {{ number_format($reservation->total_price, 0, ',', '.') }} Sekarang (E-Wallet)';
                }
            }

            radios.forEach(r => r.addEventListener('change', updateDetails));
            updateDetails();

            // copy VA
            document.querySelectorAll('[data-copy-target]').forEach(btn => {
                btn.addEventListener('click', function(){
                    const target = document.querySelector(this.getAttribute('data-copy-target'));
                    if(target){
                        navigator.clipboard.writeText(target.value).then(() => {
                            btn.textContent = 'Tersalin!';
                            setTimeout(()=> btn.textContent = 'Salin', 2000);
                        });
                    }
                });
            });
        });
        </script>
        @endpush