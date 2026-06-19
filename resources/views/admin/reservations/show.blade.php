@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    
    <div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <a href="{{ route('admin.reservations.index') }}" class="text-sm font-medium text-purple-600 hover:text-purple-800 mb-2 inline-flex items-center transition-colors">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali ke Daftar Reservasi
            </a>
            <h1 class="text-2xl font-bold text-gray-900 tracking-tight flex items-center gap-3">
                Detail Reservasi #{{ $reservation->reservation_code ?? str_pad($reservation->id, 5, '0', STR_PAD_LEFT) }}
                
                @php
                    $status = strtolower($reservation->status);
                    $statusClass = match($status) {
                        'booked' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                        'paid' => 'bg-green-100 text-green-800 border-green-200',
                        'cancelled' => 'bg-red-100 text-red-800 border-red-200',
                        default => 'bg-gray-100 text-gray-800 border-gray-200',
                    };
                @endphp
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold border {{ $statusClass }}">
                    {{ ucfirst($reservation->status) }}
                </span>
            </h1>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
                    <h3 class="text-lg font-semibold text-gray-800">Informasi Lengkap</h3>
                </div>
                <div class="p-6">
                    <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-4 gap-y-6">
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">Nama Tamu</dt>
                            <dd class="mt-1 text-base text-gray-900 font-semibold">{{ $reservation->user->name ?? $reservation->nama_tamu }}</dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">Kamar yang Dipesan</dt>
                            <dd class="mt-1 text-base text-gray-900 font-semibold">{{ $reservation->kamar->name ?? 'Belum ditentukan' }}</dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">Tanggal Check-in</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ \Carbon\Carbon::parse($reservation->checkin)->translatedFormat('l, d F Y') }}</dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">Tanggal Check-out</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ \Carbon\Carbon::parse($reservation->checkout)->translatedFormat('l, d F Y') }}</dd>
                        </div>
                        
                        <div class="sm:col-span-2">
                            <dt class="text-sm font-medium text-gray-500 mb-2">Preferensi / Catatan Tambahan</dt>
                            <dd class="text-sm text-gray-800 bg-blue-50 p-4 rounded-lg border border-blue-100 italic">
                                "{{ $reservation->preferences ?? 'Tidak ada catatan atau preferensi khusus dari tamu.' }}"
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>

        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <h3 class="text-lg font-semibold text-gray-800">Manajemen Status</h3>
                </div>
                <div class="p-6">
                    <form method="POST" action="{{ route('admin.reservations.updateStatus', $reservation->id) }}">
                        @csrf
                        <div class="space-y-5">
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Update Status Saat Ini</label>
                                <select id="status" name="status" class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-purple-500 focus:border-purple-500 sm:text-sm py-2.5 px-3 border transition-colors bg-white">
                                    <option value="booked" {{ $reservation->status == 'booked' ? 'selected' : '' }}>Booked (Belum Lunas)</option>
                                    <option value="paid" {{ $reservation->status == 'paid' ? 'selected' : '' }}>Paid (Lunas)</option>
                                    <option value="cancelled" {{ $reservation->status == 'cancelled' ? 'selected' : '' }}>Cancelled (Dibatalkan)</option>
                                </select>
                            </div>
                            
                            <button type="submit" class="w-full flex justify-center items-center py-2.5 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection