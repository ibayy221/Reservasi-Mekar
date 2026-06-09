@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto py-10 px-4 sm:px-6 min-h-[calc(100vh-80px)] flex flex-col justify-center bg-gray-50/50">
    
    <div class="text-center mb-10">
        <h2 class="text-3xl md:text-4xl font-black text-gray-900 tracking-tight">Selesaikan Pembayaran</h2>
        <div class="flex items-center justify-center gap-2 mt-3 text-sm text-purple-600 font-semibold bg-purple-50 inline-flex px-4 py-1.5 rounded-full border border-purple-100 shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
            Koneksi 256-bit Enkripsi Aman
        </div>
    </div>

    @if($errors->has('midtrans') || $errors->any())
    <div class="max-w-5xl mx-auto mb-6 px-4">
        <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-r-xl shadow-sm">
            <div class="flex items-center gap-3 mb-1">
                <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <h3 class="text-sm font-bold text-red-800">Terjadi Kesalahan</h3>
            </div>
            @if($errors->has('midtrans'))
                <p class="text-sm text-red-700 ml-8">{{ $errors->first('midtrans') }}</p>
            @else
                <ul class="text-sm text-red-700 list-disc ml-12 mt-1">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        
        <div class="lg:col-span-5 bg-white rounded-2xl shadow-lg shadow-gray-200/50 border border-gray-100 overflow-hidden sticky top-24">
            <div class="h-2.5 w-full bg-gradient-to-r from-purple-600 to-purple-400"></div>
            
            <div class="p-6 md:p-8">
                <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                    <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Ringkasan Tagihan
                </h3>
                
                <div class="space-y-5">
                    @if(auth()->check() && auth()->user()->role === 'admin')
                    <div class="bg-purple-50/50 p-4 rounded-xl border border-purple-100">
                        <div class="text-xs font-semibold text-purple-600 uppercase tracking-wider mb-1">Mode Admin</div>
                        <div class="text-sm text-gray-600">ID: <span class="font-bold text-gray-900">#{{ $reservation->reservation_code ?? $reservation->id }}</span></div>
                        @if(! empty($reservation->payment_id))
                            <div class="text-sm text-gray-600 mt-1">Kode Bayar: <span class="font-mono font-bold text-purple-700">{{ $reservation->payment_id }}</span></div>
                        @endif
                    </div>
                    @endif
                     
                    <div class="flex justify-between items-center pb-4 border-b border-gray-100">
                        <span class="text-sm font-medium text-gray-500">Tipe Kamar</span>
                        <span class="text-sm font-bold text-gray-900 text-right">{{ $reservation->kamar->name ?? '-' }}</span>
                    </div>

                    <div class="grid grid-cols-2 gap-3 pb-4 border-b border-gray-100">
                        <div class="bg-gray-50 p-3 rounded-xl border border-gray-100">
                            <span class="block text-[10px] text-gray-400 uppercase font-bold tracking-wider mb-1">Check-in</span>
                            <span class="block font-bold text-sm text-gray-900">{{ $reservation->check_in }}</span>
                        </div>
                        <div class="bg-gray-50 p-3 rounded-xl border border-gray-100">
                            <span class="block text-[10px] text-gray-400 uppercase font-bold tracking-wider mb-1">Check-out</span>
                            <span class="block font-bold text-sm text-gray-900">{{ $reservation->check_out }}</span>
                        </div>
                    </div>

                    <div class="flex justify-between items-center pt-1">
                        <span class="text-sm font-medium text-gray-500">Durasi Menginap</span>
                        <span class="text-sm font-bold text-gray-900 bg-gray-100 px-3 py-1 rounded-full">{{ $reservation->nights }} Malam</span>
                    </div>
                </div>
            </div>

            <div class="bg-gray-900 p-6 md:p-8 text-white relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-purple-600 rounded-full blur-3xl opacity-30 -mr-10 -mt-10"></div>
                <div class="flex justify-between items-end relative z-10">
                    <span class="text-sm text-gray-300 font-medium">Total Pembayaran</span>
                    <span class="text-3xl font-black tracking-tight text-white">Rp {{ number_format($reservation->total_price, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <div class="lg:col-span-7 bg-white p-6 md:p-8 rounded-2xl shadow-lg shadow-gray-200/50 border border-gray-100">
            
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-xl font-bold text-gray-900">Metode Pembayaran</h3>
                    <p class="text-sm text-gray-500 mt-1 font-light">Didukung oleh ekosistem pembayaran terpercaya.</p>
                </div>
                <div class="hidden sm:flex items-center gap-1.5 bg-blue-50 text-blue-700 border border-blue-200 px-3 py-1.5 rounded-lg text-xs font-bold">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4L15 6m2 5h-2m-6 0H7"></path></svg>
                    Midtrans Snap
                </div>
            </div>

            <div class="bg-gray-50 rounded-xl border border-gray-200 p-5 mb-8">
                <h4 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-3">Opsi Tersedia di Halaman Berikutnya:</h4>
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                    <div class="bg-white border border-gray-100 py-2 px-3 rounded-lg text-center shadow-sm">
                        <span class="text-xs font-bold text-gray-700">Virtual Account</span>
                        <div class="text-[9px] text-gray-400 mt-0.5">BCA, BNI, Mandiri</div>
                    </div>
                    <div class="bg-white border border-gray-100 py-2 px-3 rounded-lg text-center shadow-sm">
                        <span class="text-xs font-bold text-gray-700">E-Wallet</span>
                        <div class="text-[9px] text-gray-400 mt-0.5">GoPay, ShopeePay</div>
                    </div>
                    <div class="bg-white border border-gray-100 py-2 px-3 rounded-lg text-center shadow-sm">
                        <span class="text-xs font-bold text-gray-700">QRIS</span>
                        <div class="text-[9px] text-gray-400 mt-0.5">Scan Cepat</div>
                    </div>
                    <div class="bg-white border border-gray-100 py-2 px-3 rounded-lg text-center shadow-sm">
                        <span class="text-xs font-bold text-gray-700">Retail</span>
                        <div class="text-[9px] text-gray-400 mt-0.5">Indomaret, Alfamart</div>
                    </div>
                </div>
            </div>

            <form id="payment_form" method="POST" action="{{ route('payment.pay', ['id' => $reservation->id]) }}">
                @csrf
                <input type="hidden" name="payment_method" value="snap">
                
                <div class="bg-purple-50 border border-purple-100 rounded-xl p-5 mb-8 flex items-start gap-4">
                    <div class="bg-purple-200 text-purple-700 p-2 rounded-full shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-gray-900">Langkah Terakhir</h4>
                        <p class="text-sm text-gray-600 mt-1">Klik tombol di bawah ini untuk membuka antarmuka pembayaran yang aman. Sistem akan mengarahkan Anda otomatis setelah selesai.</p>
                    </div>
                </div>

                <button id="pay_button" type="submit" class="w-full relative group overflow-hidden bg-purple-600 hover:bg-purple-700 text-white py-4 rounded-xl font-bold text-lg shadow-xl shadow-purple-600/30 transition-all active:scale-[0.98]">
                    <div class="absolute inset-0 w-full h-full bg-gradient-to-r from-transparent via-white/20 to-transparent -translate-x-full group-hover:animate-[shimmer_1.5s_infinite]"></div>
                    <div class="relative flex justify-center items-center gap-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        <span id="pay_button_label">Lanjutkan ke Pembayaran</span>
                    </div>
                </button>
            </form>

            <div class="mt-8 text-center pt-6 border-t border-gray-100">
                <a href="{{ route('reservation.show', ['id' => $reservation->id]) }}" class="inline-flex items-center gap-1.5 text-sm font-medium text-gray-400 hover:text-purple-600 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Lewati & lihat detail pesanan
                </a>
            </div>

        </div>
    </div>
</div>

<div id="payment_result" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-gray-900/60 backdrop-blur-sm p-4 transition-opacity">
    <div class="bg-white rounded-3xl max-w-md w-full shadow-2xl overflow-hidden transform transition-all" id="payment_result_inner">
        <div class="bg-gray-50 border-b border-gray-100 px-6 py-4 flex justify-between items-center">
            <h3 class="text-sm font-bold text-gray-500 uppercase tracking-wider">Status Transaksi</h3>
            <button id="payment_result_close_icon" class="text-gray-400 hover:text-gray-700 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        
        <div class="p-6 md:p-8" id="payment_result_content">
            </div>
        
        <div class="px-6 py-5 bg-gray-50 border-t border-gray-100 text-center">
            <button id="payment_result_close" class="w-full px-4 py-3 bg-gray-900 hover:bg-gray-800 text-white font-bold rounded-xl shadow-md transition-colors active:scale-95">
                Tutup Jendela Ini
            </button>
        </div>
    </div>
</div>
@endsection

<style>
    @keyframes shimmer {
        100% { transform: translateX(100%); }
    }
</style>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function(){
    const form = document.getElementById('payment_form');
    if (!form) return;
    const payButton = document.getElementById('pay_button');
    const payLabel = document.getElementById('pay_button_label');
    const resultModal = document.getElementById('payment_result');
    const resultContent = document.getElementById('payment_result_content');
    const resultClose = document.getElementById('payment_result_close');
    const resultCloseIcon = document.getElementById('payment_result_close_icon');
    let vaHandled = false;

    async function loadSnap(clientKey){
        if (window.snap) return;
        return new Promise((resolve, reject) => {
            const s = document.createElement('script');
            s.src = 'https://app.sandbox.midtrans.com/snap/snap.js';
            if (clientKey) s.setAttribute('data-client-key', clientKey);
            s.onload = () => resolve();
            s.onerror = () => reject(new Error('Gagal memuat jendela pembayaran')); 
            document.head.appendChild(s);
        });
    }

    form.addEventListener('submit', async function(e){
        e.preventDefault();
        payButton.disabled = true;
        payLabel.textContent = 'Memproses...';
        payButton.classList.add('opacity-75','cursor-wait');
        
        const formData = new FormData(form);
        const action = form.action;
        const token = formData.get('_token');
        
        try{
            const resp = await fetch(action, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': token
                },
                body: formData
            });

            if (!resp.ok) {
                const text = await resp.text();
                resultContent.innerHTML = `<div class="text-center"><div class="w-12 h-12 bg-red-100 text-red-500 rounded-full flex items-center justify-center mx-auto mb-3"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></div><h3 class="text-xl font-bold text-gray-900">Gagal Memproses</h3><p class="text-sm text-gray-500 mt-1">Status: ${resp.status}</p></div><div class="mt-4 bg-gray-50 p-3 rounded-lg border border-gray-200 overflow-x-auto"><pre class="text-xs text-gray-600">${text}</pre></div>`;
                resultModal.classList.remove('hidden');
                return;
            }

            let json = null;
            try {
                json = await resp.json();
            } catch (e) {
                const txt = await resp.text();
                try { json = JSON.parse(txt); } catch (e2) { json = txt; }
            }

            function findVA(obj) {
                if (!obj || typeof obj !== 'object') return null;
                if (obj.va_numbers || obj.permata_va_number) return obj;
                for (const k of Object.keys(obj)) {
                    try {
                        const v = obj[k];
                        if (v && typeof v === 'object') {
                            const found = findVA(v);
                            if (found) return found;
                        }
                    } catch (e) { continue; }
                }
                return null;
            }

            function findStatus(obj) {
                if (!obj || typeof obj !== 'object') return null;
                if (obj.transaction_status) return obj.transaction_status;
                if (obj.status_code) return obj.status_code;
                for (const k of Object.keys(obj)) {
                    try {
                        const v = obj[k];
                        if (v && typeof v === 'object') {
                            const s = findStatus(v);
                            if (s) return s;
                        }
                    } catch (e) { continue; }
                }
                return null;
            }

            const vaRoot = (typeof json === 'object') ? findVA(json) : null;
            const statusFound = (typeof json === 'object') ? findStatus(json) : null;
            
            // Reusable HTML builder for VA injection
            const buildVaHtml = (vaObj) => {
                let html = `<div class="text-center mb-5">
                                <div class="w-14 h-14 bg-purple-100 text-purple-600 rounded-full flex items-center justify-center mx-auto mb-3 shadow-inner">
                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                                </div>
                                <h3 class="text-xl font-bold text-gray-900">Virtual Account Dibuat</h3>
                                <p class="text-sm text-gray-500 mt-1">Gunakan nomor di bawah untuk membayar</p>
                            </div>`;
                if (vaObj.permata_va_number) {
                    html += `<div class="bg-gray-50 border-2 border-dashed border-gray-300 rounded-xl p-4 text-center mb-3">
                                <div class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Permata Bank</div>
                                <div class="font-mono text-2xl font-black text-purple-700 tracking-wider">${vaObj.permata_va_number}</div>
                             </div>`;
                }
                if (vaObj.va_numbers && Array.isArray(vaObj.va_numbers)) {
                    vaObj.va_numbers.forEach(v => {
                        html += `<div class="bg-gray-50 border-2 border-dashed border-gray-300 rounded-xl p-4 text-center mb-3">
                                    <div class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">${v.bank}</div>
                                    <div class="font-mono text-2xl font-black text-purple-700 tracking-wider">${v.va_number}</div>
                                 </div>`;
                    });
                }
                html += `<div class="mt-5 p-3 bg-blue-50 text-blue-700 text-xs rounded-lg flex gap-2">
                            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span>Simpan nomor ini. Status reservasi akan terupdate otomatis setelah dana masuk.</span>
                         </div>`;
                return html;
            };

            if (vaRoot && (statusFound === 'pending' || statusFound === '201')) {
                if (vaHandled) return;
                vaHandled = true;
                resultContent.innerHTML = buildVaHtml(vaRoot);
                resultModal.classList.remove('hidden');
                return;
            }

            if (json && json.snapToken) {
                await loadSnap(json.clientKey);
                window.snap.pay(json.snapToken, {
                    onSuccess: function(result){
                        window.location.href = '{{ route('reservation.show', ['id' => $reservation->id]) }}';
                    },
                    onPending: function(result){
                        if (vaHandled) return;
                        const vaFromPending = (typeof result === 'object') ? findVA(result) : null;
                        if (vaFromPending) {
                            vaHandled = true;
                            resultContent.innerHTML = buildVaHtml(vaFromPending);
                        } else {
                            resultContent.innerHTML = `<div class="text-center"><h3 class="text-xl font-bold text-gray-900">Status Menunggu</h3><p class="text-sm text-gray-500">Selesaikan instruksi pembayaran pada aplikasi Anda.</p></div><div class="mt-4 bg-gray-50 p-3 rounded-lg overflow-x-auto"><pre class="text-[10px] text-gray-600">${JSON.stringify(result, null, 2)}</pre></div>`;
                        }
                        resultModal.classList.remove('hidden');
                    },
                    onError: function(err){
                        resultContent.innerHTML = `<div class="text-center"><div class="w-12 h-12 bg-red-100 text-red-500 rounded-full flex items-center justify-center mx-auto mb-3"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></div><h3 class="text-xl font-bold text-gray-900">Transaksi Gagal</h3></div><div class="mt-4 bg-gray-50 p-3 rounded-lg overflow-x-auto"><pre class="text-[10px] text-gray-600">${JSON.stringify(err, null, 2)}</pre></div>`;
                        resultModal.classList.remove('hidden');
                    }
                });
            } else if (json.va) {
                resultContent.innerHTML = buildVaHtml(json.va);
                resultModal.classList.remove('hidden');
            } else {
                resultContent.innerHTML = `<div class="bg-gray-50 p-4 rounded-lg border border-gray-200 overflow-x-auto"><pre class="text-xs text-gray-700">${JSON.stringify(json, null, 2)}</pre></div>`;
                resultModal.classList.remove('hidden');
            }
        } catch(err){
            resultContent.innerHTML = `<div class="text-center"><div class="w-12 h-12 bg-red-100 text-red-500 rounded-full flex items-center justify-center mx-auto mb-3"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></div><h3 class="text-xl font-bold text-gray-900">Terjadi Kesalahan Sistem</h3><p class="text-sm text-red-600 mt-2">${err.message}</p></div>`;
            resultModal.classList.remove('hidden');
        } finally{
            payButton.disabled = false;
            payLabel.textContent = 'Lanjutkan ke Pembayaran';
            payButton.classList.remove('opacity-75','cursor-wait');
        }
    });

    const closeAction = () => {
        resultModal.classList.add('hidden');
        window.location.href = '{{ route('reservation.show', ['id' => $reservation->id]) }}';
    };

    if (resultClose) resultClose.addEventListener('click', closeAction);
    if (resultCloseIcon) resultCloseIcon.addEventListener('click', closeAction);
});
</script>
@endpush