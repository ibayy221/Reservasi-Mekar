@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-6 lg:px-6">
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between mb-6">
        <div>
            <h1 class="text-2xl font-extrabold text-gray-900">Laporan Lengkap Admin</h1>
            <p class="text-sm text-gray-500 mt-1">Ringkasan semua laporan reservasi, pendapatan, occupancy, dan tamu dalam satu halaman.</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-purple-600 text-white text-sm font-semibold hover:bg-purple-700 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            Kembali ke Dashboard
        </a>
    </div>

    <div class="mb-4 flex justify-end">
        <a href="{{ route('admin.reports.all.print') }}" target="_blank" class="inline-flex items-center gap-2 rounded-lg border border-purple-200 bg-purple-50 px-4 py-2 text-sm font-semibold text-purple-700 hover:bg-purple-100 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 9V3h12v6M6 18h12v3H6z"></path></svg>
            Cetak Semua Laporan
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-gradient-to-br from-purple-600 to-violet-500 rounded-2xl p-5 text-white shadow-sm">
            <p class="text-sm font-semibold uppercase tracking-wide text-purple-100">Total Reservasi</p>
            <h2 class="text-3xl font-black mt-2">{{ $totalReservations }}</h2>
        </div>
        <div class="bg-white rounded-2xl border border-gray-200 p-5 shadow-sm">
            <p class="text-sm font-semibold uppercase tracking-wide text-gray-500">Pendapatan</p>
            <h2 class="text-3xl font-black text-gray-900 mt-2">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h2>
        </div>
        <div class="bg-white rounded-2xl border border-gray-200 p-5 shadow-sm">
            <p class="text-sm font-semibold uppercase tracking-wide text-gray-500">Occupancy</p>
            <h2 class="text-3xl font-black text-gray-900 mt-2">{{ $occupancyRate }}%</h2>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-100">
                <h3 class="text-base font-bold text-gray-800">Reservasi Terbaru</h3>
            </div>
            <div class="p-5 space-y-3">
                @foreach($recentReservations as $reservation)
                    <div class="rounded-xl border border-gray-100 bg-gray-50 p-3">
                        <div class="flex items-center justify-between">
                            <span class="font-semibold text-gray-800">{{ $reservation->user->name ?? '-' }}</span>
                            <span class="text-xs font-semibold text-purple-600">{{ $reservation->status }}</span>
                        </div>
                        <div class="text-sm text-gray-500 mt-1">{{ $reservation->kamar->name ?? '-' }} · {{ $reservation->check_in }} s/d {{ $reservation->check_out }}</div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-100">
                <h3 class="text-base font-bold text-gray-800">Tamu</h3>
            </div>
            <div class="p-5 space-y-3">
                @foreach($guestSummaries as $guest)
                    <div class="rounded-xl border border-gray-100 bg-gray-50 p-3">
                        <div class="flex items-center justify-between">
                            <span class="font-semibold text-gray-800">{{ $guest['name'] }}</span>
                            <span class="text-xs font-semibold {{ $guest['category'] === 'checked-in' ? 'text-emerald-600' : 'text-gray-600' }}">{{ $guest['label'] }}</span>
                        </div>
                        <div class="text-sm text-gray-500 mt-1">{{ $guest['room'] }} · {{ $guest['check_in'] }} s/d {{ $guest['check_out'] }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-100">
            <h3 class="text-base font-bold text-gray-800">Status Kamar</h3>
        </div>
        <div class="p-5 grid grid-cols-1 md:grid-cols-2 gap-3">
            @foreach($roomStats as $room)
                <div class="rounded-xl border border-gray-100 bg-gray-50 px-4 py-3">
                    <div class="flex items-center justify-between">
                        <span class="font-semibold text-gray-700">{{ $room['name'] }}</span>
                        <span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-semibold {{ $room['status'] === 'Penuh' ? 'bg-rose-100 text-rose-700' : ($room['status'] === 'Sebagian' ? 'bg-amber-100 text-amber-700' : 'bg-emerald-100 text-emerald-700') }}">
                            {{ $room['status'] }}
                        </span>
                    </div>
                    <div class="mt-2 text-sm text-gray-500">
                        Stok: {{ $room['stock'] }} unit · Terpakai: {{ $room['used'] }} · Tersedia: {{ $room['available'] }}
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
