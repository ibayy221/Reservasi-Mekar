@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-6 lg:px-6">
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between mb-6">
        <div>
            <h1 class="text-2xl font-extrabold text-gray-900">Laporan Pendapatan</h1>
            <p class="text-sm text-gray-500 mt-1">Ringkasan pendapatan reservasi dan tren bulanan.</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-purple-600 text-white text-sm font-semibold hover:bg-purple-700 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            Kembali ke Dashboard
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-gradient-to-br from-purple-600 to-violet-500 rounded-2xl p-5 text-white shadow-sm">
            <p class="text-sm font-semibold uppercase tracking-wide text-purple-100">Total Pendapatan</p>
            <h2 class="text-3xl font-black mt-2">Rp {{ number_format($totalRevenue ?? 0, 0, ',', '.') }}</h2>
        </div>
        <div class="bg-white rounded-2xl border border-gray-200 p-5 shadow-sm">
            <p class="text-sm font-semibold uppercase tracking-wide text-gray-500">Reservasi Berhasil</p>
            <h2 class="text-3xl font-black text-gray-900 mt-2">{{ $paidReservations ?? 0 }}</h2>
        </div>
        <div class="bg-white rounded-2xl border border-gray-200 p-5 shadow-sm">
            <p class="text-sm font-semibold uppercase tracking-wide text-gray-500">Rata-rata per Reservasi</p>
            <h2 class="text-3xl font-black text-gray-900 mt-2">Rp {{ number_format($avgRevenue ?? 0, 0, ',', '.') }}</h2>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
            <div>
                <h3 class="text-base font-bold text-gray-800">Perkembangan Pendapatan</h3>
                <p class="text-sm text-gray-500">Data 7 hari terakhir</p>
            </div>
        </div>
        <div class="p-5">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach($trend as $item)
                    <div class="rounded-xl border border-gray-100 bg-gray-50 p-4">
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-semibold text-gray-700">{{ $item['label'] }}</span>
                            <span class="text-sm font-bold text-purple-600">Rp {{ number_format($item['revenue'], 0, ',', '.') }}</span>
                        </div>
                        <div class="mt-3 h-2 rounded-full bg-gray-200 overflow-hidden">
                            <div class="h-2 rounded-full bg-purple-500" style="width: {{ min(100, max(8, ($item['revenue'] / max($maxRevenue, 1)) * 100)) }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
