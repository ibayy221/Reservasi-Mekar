@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto py-8">
    <h1 class="text-2xl font-bold mb-4">Daftar Reservasi</h1>

    <div class="bg-white rounded-lg shadow p-4">
        <table class="w-full table-auto">
            <thead>
                <tr class="text-left text-sm text-gray-500">
                    <th class="py-2">ID</th>
                    <th class="py-2">Tamu</th>
                    <th class="py-2">Kamar</th>
                    <th class="py-2">Checkin</th>
                    <th class="py-2">Checkout</th>
                    <th class="py-2">Status</th>
                    <th class="py-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reservations as $r)
                <tr class="border-t">
                    <td class="py-3">{{ $r->id }}</td>
                    <td class="py-3">{{ $r->user->name ?? $r->nama_tamu }}</td>
                    <td class="py-3">{{ $r->kamar->name ?? '-' }}</td>
                    <td class="py-3">{{ $r->checkin }}</td>
                    <td class="py-3">{{ $r->checkout }}</td>
                    <td class="py-3">{{ $r->status }}</td>
                    <td class="py-3"><a href="{{ route('admin.reservations.show', $r->id) }}" class="text-emerald-600">Lihat</a></td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4">
            {{ $reservations->links() }}
        </div>
    </div>
</div>
@endsection
