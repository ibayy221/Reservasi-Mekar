@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto py-12">
    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
        <h2 class="text-2xl font-bold mb-4">Simulasi Gateway Pembayaran</h2>
        <p class="text-sm text-gray-500 mb-6">Metode: <strong class="text-gray-800">{{ ucwords(str_replace('_',' ', $method)) }}</strong></p>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-gray-50 p-4 rounded border border-gray-100">
                <h4 class="text-sm font-semibold mb-2">Rincian Pembayaran</h4>
                <p class="text-xs text-gray-600">Nomor Reservasi: <strong>#{{ $reservation->reservation_code ?? $reservation->id }}</strong></p>
                <p class="text-xs text-gray-600">Total: <strong>Rp {{ number_format($reservation->total_price,0,',','.') }}</strong></p>
                <p class="text-xs text-gray-600">Kamar: <strong>{{ $reservation->kamar->name ?? '-' }}</strong></p>
            </div>

            <div class="p-4">
                <form method="POST" action="{{ route('gateway.callback', ['id' => $reservation->id]) }}">
                    @csrf
                    <input type="hidden" name="method" value="{{ $method }}">
                    <div class="space-y-3">
                        <button name="status" value="success" class="w-full bg-emerald-600 text-white py-2 rounded font-bold">Simulasikan Pembayaran Berhasil</button>
                        <button name="status" value="failure" class="w-full bg-red-600 text-white py-2 rounded font-bold">Simulasikan Pembayaran Gagal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
