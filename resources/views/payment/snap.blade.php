@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto py-12">
    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
        <h2 class="text-2xl font-bold mb-4">Pembayaran via Midtrans (Sandbox)</h2>
        <p class="text-sm text-gray-600 mb-6">Klik tombol di bawah untuk membuka halaman pembayaran Midtrans (sandbox).</p>

        <div class="mb-4">
            <p class="text-sm text-gray-600">Nomor Reservasi: <strong>#{{ $reservation->reservation_code ?? $reservation->id }}</strong></p>
            <p class="text-sm text-gray-600">Total: <strong>Rp {{ number_format($reservation->total_price,0,',','.') }}</strong></p>
        </div>

        <div class="flex gap-3">
            <button id="midtrans_pay" class="bg-emerald-600 text-white px-4 py-2 rounded font-bold">Bayar Sekarang (Midtrans)</button>
            <a href="{{ route('payment.checkout', ['id' => $reservation->id]) }}" class="text-sm text-gray-500 self-center">Kembali</a>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ $clientKey }}"></script>
<script>
document.getElementById('midtrans_pay').addEventListener('click', function(){
    var token = '{{ $snapToken }}';
    snap.pay(token, {
        onSuccess: function(result){
            console.log('success', result);
            window.location = "{{ route('reservation.show', ['id' => $reservation->id]) }}";
        },
        onPending: function(result){
            console.log('pending', result);
            window.location = "{{ route('reservation.show', ['id' => $reservation->id]) }}";
        },
        onError: function(result){
            console.log('error', result);
            alert('Pembayaran gagal. Cek console untuk detail.');
        }
    });
});
</script>
@endpush
