@extends('layouts.app')

@section('content')
<div id="gatewayModal" class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/70 backdrop-blur-sm p-4 sm:p-6 transition-all">
    
    <div class="w-full max-w-4xl bg-white rounded-3xl shadow-[0_20px_60px_-15px_rgba(0,0,0,0.5)] overflow-hidden flex flex-col md:flex-row transform transition-all">
        
        <div class="md:w-1/2 relative bg-gradient-to-br from-purple-900 via-purple-800 to-purple-900 p-8 md:p-10 overflow-hidden text-white">
            <div class="absolute -top-24 -right-24 w-64 h-64 bg-white opacity-5 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-24 -left-24 w-64 h-64 bg-purple-500 opacity-20 rounded-full blur-3xl"></div>

            <div class="relative z-10 flex flex-col h-full">
                <div class="flex items-start justify-between mb-8">
                    <div>
                        <div class="inline-flex items-center gap-1.5 bg-purple-950/50 border border-purple-400/30 text-purple-200 text-[10px] font-bold uppercase tracking-widest px-3 py-1 rounded-full mb-3">
                            <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                            Simulator Mode
                        </div>
                        <h3 class="text-2xl font-bold tracking-tight">Konfirmasi Pembayaran</h3>
                        <p class="text-sm text-purple-200 mt-1 font-light">Metode: <strong class="text-white font-semibold">{{ ucwords(str_replace('_',' ', $method)) }}</strong></p>
                    </div>
                </div>

                <div class="space-y-4 flex-1">
                    <div class="rounded-2xl border border-white/10 bg-white/10 backdrop-blur-md p-5">
                        <div class="text-xs text-purple-300 font-medium uppercase tracking-wider mb-1">Nomor Reservasi</div>
                        <div class="text-lg font-bold text-white tracking-wide">#{{ $reservation->reservation_code ?? $reservation->id }}</div>
                        <div class="text-sm text-purple-200 mt-2 flex justify-between border-t border-white/10 pt-2">
                            <span>Tipe Kamar</span>
                            <span class="font-semibold text-white">{{ $reservation->kamar->name ?? '-' }}</span>
                        </div>
                    </div>

                    <div class="rounded-2xl border border-white/10 bg-white/10 backdrop-blur-md p-5">
                        <div class="flex flex-col">
                            <span class="text-xs text-purple-300 font-medium uppercase tracking-wider mb-1">Total Pembayaran</span>
                            <span class="text-3xl font-black text-white tracking-tight">Rp {{ number_format($reservation->total_price, 0, ',', '.') }}</span>
                            <div class="mt-3 inline-flex items-center gap-1.5 text-xs text-purple-200 bg-purple-950/40 px-3 py-1.5 rounded-lg w-fit border border-purple-500/30">
                                <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Batas waktu: <span class="font-bold text-white">24 Jam</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="md:w-1/2 p-8 md:p-10 bg-white flex flex-col justify-center relative">
            <button id="modal_close" class="absolute top-6 right-6 w-8 h-8 flex items-center justify-center rounded-full bg-gray-100 hover:bg-gray-200 text-gray-500 hover:text-gray-800 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>

            <div class="mb-8 mt-4 md:mt-0">
                <h4 class="text-xl font-bold text-gray-900">Hasil Pembayaran</h4>
                <p class="text-sm text-gray-500 mt-2 font-light leading-relaxed">Pilih salah satu tombol di bawah untuk menyimulasikan *callback* dari pihak bank/e-wallet ke sistem hotel kita.</p>
            </div>

            <form method="POST" action="{{ route('gateway.callback', ['id' => $reservation->id]) }}">
                @csrf
                <input type="hidden" name="method" value="{{ $method }}">
                
                <div class="space-y-4">
                    <button name="status" value="success" class="group w-full flex items-center justify-center gap-3 bg-gradient-to-r from-purple-600 to-purple-800 hover:from-purple-700 hover:to-purple-900 text-white py-4 px-6 rounded-xl font-bold shadow-xl shadow-purple-600/20 transition-all active:scale-[0.98]">
                        <div class="w-6 h-6 rounded-full bg-white/20 flex items-center justify-center group-hover:scale-110 transition-transform">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                        Simulasikan Berhasil
                    </button>

                    <button name="status" value="failure" class="group w-full flex items-center justify-center gap-3 bg-white border-2 border-rose-500 hover:bg-rose-50 text-rose-600 py-3.5 px-6 rounded-xl font-bold transition-all active:scale-[0.98]">
                        <div class="w-6 h-6 rounded-full bg-rose-100 flex items-center justify-center group-hover:scale-110 transition-transform">
                            <svg class="w-4 h-4 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </div>
                        Simulasikan Gagal
                    </button>
                </div>
            </form>

            <div class="mt-8 pt-6 border-t border-gray-100 text-center">
                <a href="{{ route('payment.checkout', ['id' => $reservation->id]) }}" class="inline-flex items-center gap-2 text-sm font-medium text-gray-400 hover:text-purple-600 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Kembali ke Halaman Checkout
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function(){
    const close = document.getElementById('modal_close');
    if(close){ close.addEventListener('click', ()=> window.location = "{{ route('payment.checkout', ['id' => $reservation->id]) }}"); }
    document.addEventListener('keydown', function(e){ if(e.key === 'Escape'){ window.location = "{{ route('payment.checkout', ['id' => $reservation->id]) }}"; } });
    
    // prevent background scroll on modal
    document.body.style.overflow = 'hidden';
    window.addEventListener('beforeunload', ()=> { document.body.style.overflow = ''; });
});
</script>
@endpush