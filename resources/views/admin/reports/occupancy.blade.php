@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-6 lg:px-6">
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between mb-6">
        <div>
            <h1 class="text-2xl font-extrabold text-gray-900">Occupancy Rate</h1>
            <p class="text-sm text-gray-500 mt-1">Status okupansi kamar saat ini.</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-purple-600 text-white text-sm font-semibold hover:bg-purple-700 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            Kembali ke Dashboard
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-gradient-to-br from-purple-600 to-violet-500 rounded-2xl p-5 text-white shadow-sm">
            <p class="text-sm font-semibold uppercase tracking-wide text-purple-100">Occupancy Hari Ini</p>
            <h2 class="text-3xl font-black mt-2">{{ $occupancyRate }}%</h2>
        </div>
        <div class="bg-white rounded-2xl border border-gray-200 p-5 shadow-sm">
            <p class="text-sm font-semibold uppercase tracking-wide text-gray-500">Unit Terisi</p>
            <h2 class="text-3xl font-black text-gray-900 mt-2">{{ $occupiedRooms }}</h2>
        </div>
        <div class="bg-white rounded-2xl border border-gray-200 p-5 shadow-sm">
            <p class="text-sm font-semibold uppercase tracking-wide text-gray-500">Unit Tersedia</p>
            <h2 class="text-3xl font-black text-gray-900 mt-2">{{ $availableRooms }}</h2>
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
