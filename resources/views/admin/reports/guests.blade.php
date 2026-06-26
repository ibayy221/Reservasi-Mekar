@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8 lg:px-8">
    
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between mb-8">
        <div>
            <h1 class="text-2xl font-extrabold text-gray-900 tracking-tight">Laporan Tamu</h1>
            <p class="text-sm text-gray-500 mt-1">Daftar riwayat tamu, status reservasi, dan ketersediaan check-in.</p>
        </div>
        <div class="flex items-center gap-3 w-full sm:w-auto">
            <button type="button" class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-lg bg-white border border-gray-300 text-sm font-semibold text-gray-700 hover:bg-gray-50 transition-all shadow-sm w-full sm:w-auto">
                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                Ekspor CSV
            </button>
            <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-lg bg-purple-600 text-white text-sm font-semibold hover:bg-purple-700 transition-all shadow-sm w-full sm:w-auto">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-8">
        <div class="relative bg-gradient-to-br from-purple-600 to-indigo-600 rounded-2xl p-6 text-white shadow-md overflow-hidden">
            <div class="relative z-10">
                <p class="text-sm font-medium text-purple-100/80 uppercase tracking-wider mb-1">Total Tamu</p>
                <h2 class="text-4xl font-black">{{ $totalGuests ?? 0 }}</h2>
            </div>
            <svg class="absolute -right-4 -bottom-4 w-32 h-32 text-white/10" fill="currentColor" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"></path></svg>
        </div>

        <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-1">Sedang Check-in</p>
                <h2 class="text-4xl font-black text-gray-900">{{ $checkedInGuests ?? 0 }}</h2>
            </div>
            <div class="p-3 bg-emerald-50 rounded-xl">
                <svg class="w-8 h-8 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path></svg>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-1">Selesai (Checkout)</p>
                <h2 class="text-4xl font-black text-gray-900">{{ $completedGuests ?? 0 }}</h2>
            </div>
            <div class="p-3 bg-blue-50 rounded-xl">
                <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden mb-6">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-2 bg-gray-50/50">
            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
            <h3 class="text-base font-bold text-gray-800">Filter Laporan</h3>
        </div>
        <div class="p-6">
            <form method="GET" action="{{ route('admin.reports.guests') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                <div>
                    <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-2">Tanggal Check-in</label>
                    <input type="date" name="date_from" value="{{ request('date_from') }}" class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-2">Tanggal Check-out</label>
                    <input type="date" name="date_to" value="{{ request('date_to') }}" class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-2">Status Reservasi</label>
                    <select name="status" class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors bg-white">
                        <option value="">Semua Status</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Tertunda (Pending)</option>
                        <option value="paid" {{ request('status') === 'paid' ? 'selected' : '' }}>Lunas (Paid)</option>
                        <option value="checked-in" {{ request('status') === 'checked-in' ? 'selected' : '' }}>Sedang Check-in</option>
                        <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Selesai (Completed)</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-2">Tipe Kamar</label>
                    <select name="kamar_id" class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors bg-white">
                        <option value="">Semua Kamar</option>
                        @foreach($kamars as $kamar)
                            <option value="{{ $kamar->id }}" {{ request('kamar_id') == $kamar->id ? 'selected' : '' }}>{{ $kamar->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="sm:col-span-2 lg:col-span-4 flex justify-end gap-3 pt-2 border-t border-gray-100 mt-2">
                    <a href="{{ route('admin.reports.guests') }}" class="px-5 py-2.5 rounded-lg border border-gray-300 text-sm font-semibold text-gray-700 hover:bg-gray-50 hover:text-gray-900 transition-colors">Reset Filter</a>
                    <button type="submit" class="px-5 py-2.5 rounded-lg bg-purple-600 text-white text-sm font-semibold hover:bg-purple-700 shadow-sm transition-colors">Terapkan Filter</button>
                </div>
            </form>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm text-left whitespace-nowrap">
                <thead class="bg-gray-50/75 text-gray-500 uppercase text-xs font-bold tracking-wider border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-4">Tamu & Reservasi</th>
                        <th class="px-6 py-4">Informasi Kontak</th>
                        <th class="px-6 py-4">Detail Kamar</th>
                        <th class="px-6 py-4">Jadwal</th>
                        <th class="px-6 py-4 text-center">Status</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($guestReservations as $guest)
                        <tr class="hover:bg-purple-50/30 transition-colors group">
                            
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    @php
                                        $nameParts = explode(' ', trim($guest['guest_name']));
                                        $initials = isset($nameParts[1]) ? substr($nameParts[0], 0, 1) . substr($nameParts[1], 0, 1) : substr($guest['guest_name'], 0, 2);
                                    @endphp
                                    <div class="hidden sm:flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-purple-100 text-purple-700 font-bold uppercase ring-2 ring-white">
                                        {{ $initials }}
                                    </div>
                                    <div>
                                        <div class="font-bold text-gray-900 group-hover:text-purple-700 transition-colors">{{ $guest['guest_name'] }}</div>
                                        <div class="text-xs text-gray-500 font-mono mt-0.5">#{{ $guest['reservation_code'] }}</div>
                                    </div>
                                </div>
                            </td>

                            <td class="px-6 py-4">
                                <div class="flex flex-col gap-1.5">
                                    <a href="mailto:{{ $guest['guest_email'] }}" class="text-gray-600 hover:text-purple-600 truncate max-w-[200px] block transition-colors" title="{{ $guest['guest_email'] }}">
                                        {{ $guest['guest_email'] }}
                                    </a>
                                    <a href="tel:{{ $guest['guest_phone'] }}" class="text-gray-500 text-xs hover:text-purple-600 transition-colors flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                        {{ $guest['guest_phone'] }}
                                    </a>
                                </div>
                            </td>

                            <td class="px-6 py-4">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-gray-50 border border-gray-200 text-sm font-medium text-gray-700">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                    {{ $guest['room'] }}
                                </span>
                            </td>

                            <td class="px-6 py-4">
                                <div class="flex flex-col gap-1">
                                    <div class="flex items-center gap-2 text-gray-900 font-medium">
                                        <span class="text-xs text-gray-400 w-6">IN</span> 
                                        {{ $guest['check_in'] ? \Carbon\Carbon::parse($guest['check_in'])->translatedFormat('d M Y') : '-' }}
                                    </div>
                                    <div class="flex items-center gap-2 text-gray-500">
                                        <span class="text-xs text-gray-400 w-6">OUT</span>
                                        {{ $guest['check_out'] ? \Carbon\Carbon::parse($guest['check_out'])->translatedFormat('d M Y') : '-' }}
                                    </div>
                                </div>
                            </td>

                            <td class="px-6 py-4 text-center">
                                @php
                                    $status = strtolower($guest['status'] ?? '');
                                    $badgeStyle = 'bg-gray-100 text-gray-700 ring-gray-600/20'; // Default
                                    
                                    if(in_array($status, ['paid', 'success'])) {
                                        $badgeStyle = 'bg-blue-50 text-blue-700 ring-blue-600/20';
                                    } elseif(in_array($status, ['checked-in', 'check in'])) {
                                        $badgeStyle = 'bg-emerald-50 text-emerald-700 ring-emerald-600/20';
                                    } elseif(in_array($status, ['pending', 'unpaid'])) {
                                        $badgeStyle = 'bg-yellow-50 text-yellow-800 ring-yellow-600/20';
                                    } elseif(in_array($status, ['completed', 'selesai'])) {
                                        $badgeStyle = 'bg-purple-50 text-purple-700 ring-purple-600/20';
                                    }
                                @endphp
                                <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-bold uppercase tracking-wider ring-1 ring-inset {{ $badgeStyle }}">
                                    {{ $guest['status'] ?? '-' }}
                                </span>
                            </td>

                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('admin.reports.guests.detail', $guest['reservation_id']) }}" class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-gray-400 hover:text-purple-600 hover:bg-purple-50 transition-all" title="Lihat Detail">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-16 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="p-4 bg-gray-50 rounded-full mb-4">
                                        <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                    </div>
                                    <h3 class="text-sm font-bold text-gray-900">Belum Ada Data Tamu</h3>
                                    <p class="mt-1 text-sm text-gray-500 max-w-sm">Tidak ada tamu yang ditemukan untuk kriteria filter periode ini. Coba sesuaikan tanggal atau status filter.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection