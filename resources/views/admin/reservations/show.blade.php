@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto py-8">
    <h1 class="text-2xl font-bold mb-4">Reservasi #{{ $reservation->reservation_code ?? $reservation->id }}</h1>

    <div class="bg-white p-4 rounded shadow">
        <p><strong>Tamu:</strong> {{ $reservation->user->name ?? $reservation->nama_tamu }}</p>
        <p><strong>Kamar:</strong> {{ $reservation->kamar->name ?? '-' }}</p>
        <p><strong>Checkin:</strong> {{ $reservation->checkin }}</p>
        <p><strong>Checkout:</strong> {{ $reservation->checkout }}</p>
        <p><strong>Status:</strong> {{ $reservation->status }}</p>
        <p><strong>Preferensi:</strong> {{ $reservation->preferences ?? '-' }}</p>

        <form method="POST" action="{{ route('admin.reservations.updateStatus', $reservation->id) }}">
            @csrf
            <div class="mt-4">
                <label class="block mb-2">Ubah Status</label>
                <select name="status" class="border px-3 py-2 rounded">
                    <option value="booked" {{ $reservation->status=='booked'?'selected':'' }}>booked</option>
                    <option value="paid" {{ $reservation->status=='paid'?'selected':'' }}>paid</option>
                    <option value="cancelled" {{ $reservation->status=='cancelled'?'selected':'' }}>cancelled</option>
                </select>
                <button class="ml-2 bg-purple-600 text-white px-3 py-2 rounded">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection
