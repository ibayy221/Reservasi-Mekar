@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto p-4 lg:p-8">
    
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Laporan Reservasi</h1>
            <p class="text-sm text-gray-500 mt-1">Pantau performa, filter data, dan kelola laporan reservasi Anda.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.reports.reservations', array_merge(request()->except('page'), ['export' => 'csv'])) }}" 
               class="inline-flex items-center gap-2 px-4 py-2.5 bg-purple-600 hover:bg-purple-700 text-white font-medium rounded-xl text-sm transition-all shadow-sm shadow-purple-600/30">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                Export CSV
            </a>
            <a href="{{ route('admin.reports.reservations.print', array_merge(request()->except('page'), [])) }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-xl text-sm transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 9V2h12v7M6 22h12v-7H6v7z"/></svg>
                Print PDF
            </a>
        </div>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 mb-8">
        <div class="flex items-center gap-2 mb-4 text-gray-800 font-semibold text-sm">
            <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
            Filter Data
        </div>
        <form method="GET" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
            <div>
                <label class="block text-xs font-medium text-gray-500 mb-1">Dari Tanggal</label>
                <input type="date" name="date_from" value="{{ request('date_from') }}" class="w-full p-2.5 bg-gray-50 border border-gray-200 text-sm rounded-xl focus:ring-2 focus:ring-purple-600 focus:border-purple-600 transition-all">
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-500 mb-1">Sampai Tanggal</label>
                <input type="date" name="date_to" value="{{ request('date_to') }}" class="w-full p-2.5 bg-gray-50 border border-gray-200 text-sm rounded-xl focus:ring-2 focus:ring-purple-600 focus:border-purple-600 transition-all">
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-500 mb-1">Status Pembayaran</label>
                <select name="status" class="w-full p-2.5 bg-gray-50 border border-gray-200 text-sm rounded-xl focus:ring-2 focus:ring-purple-600 focus:border-purple-600 transition-all">
                    <option value="">Semua Status</option>
                    @if(!empty($distinctStatuses) && is_array($distinctStatuses))
                        @foreach($distinctStatuses as $s)
                            <option value="{{ $s }}" {{ request('status') == $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                        @endforeach
                    @else
                        <option value="pending" {{ request('status')=='pending' ? 'selected' : '' }}>Pending</option>
                        <option value="paid" {{ request('status')=='paid' ? 'selected' : '' }}>Paid (Lunas)</option>
                        <option value="cancelled" {{ request('status')=='cancelled' ? 'selected' : '' }}>Cancelled</option>
                    @endif
                </select>
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-500 mb-1">Tipe Kamar</label>
                <select name="kamar_id" class="w-full p-2.5 bg-gray-50 border border-gray-200 text-sm rounded-xl focus:ring-2 focus:ring-purple-600 focus:border-purple-600 transition-all">
                    <option value="">Semua Kamar</option>
                    @foreach($kamars as $k)
                        <option value="{{ $k->id }}" {{ request('kamar_id') == $k->id ? 'selected' : '' }}>{{ $k->name }}</option>
                    @endforeach
                </select>
            </div>
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1">Pembayaran</label>
                    <select name="has_payment" class="w-full p-2.5 bg-gray-50 border border-gray-200 text-sm rounded-xl focus:ring-2 focus:ring-purple-600 focus:border-purple-600 transition-all">
                        <option value="">Semua</option>
                        <option value="with" {{ request('has_payment')=='with' ? 'selected' : '' }}>Dengan Kode Bayar</option>
                        <option value="without" {{ request('has_payment')=='without' ? 'selected' : '' }}>Tanpa Kode Bayar</option>
                    </select>
                </div>
            <div class="lg:col-span-1 flex items-end gap-2">
                <button type="submit" class="w-full px-4 py-2.5 bg-gray-900 hover:bg-gray-800 text-white font-medium rounded-xl text-sm transition-all">
                    Terapkan Filter
                </button>
                <a href="{{ route('admin.reports.reservations') }}" class="inline-flex items-center gap-2 px-3 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-xl text-sm transition-all">
                    Bersihkan Filter
                </a>
            </div>
            
            <div class="md:col-span-2 lg:col-span-5">
                <label class="block text-xs font-medium text-gray-500 mb-1">Pencarian Cepat</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama tamu, email, atau kode reservasi..." class="w-full pl-10 p-2.5 bg-gray-50 border border-gray-200 text-sm rounded-xl focus:ring-2 focus:ring-purple-600 focus:border-purple-600 transition-all">
                </div>
            </div>
        </form>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-200 h-48">
            <h4 class="text-sm font-bold mb-2">Reservasi (14 hari)</h4>
            <div class="h-36"><div id="reservationsChart" class="w-full h-full"></div></div>
        </div>
        <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-200 h-48">
            <h4 class="text-sm font-bold mb-2">Pendapatan (14 hari)</h4>
            <div class="h-36"><div id="revenueChart" class="w-full h-full"></div></div>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-5 border-b border-gray-100 bg-white flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="text-sm font-medium text-gray-600">
                Menampilkan <span class="font-bold text-gray-900">{{ $reservations->total() }}</span> reservasi ditemukan
            </div>
            <div class="text-sm">
                {{ $reservations->onEachSide(1)->links() }}
            </div>
        </div>

        

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left whitespace-nowrap">
                <thead class="bg-gray-50/50 text-gray-500 text-xs uppercase tracking-wider font-semibold">
                    <tr>
                        <th class="p-4 pl-6">ID & Kode</th>
                        <th class="p-4">Tamu</th>
                        <th class="p-4">Kamar</th>
                        <th class="p-4">Tgl In & Out</th>
                        <th class="p-4 text-center">Durasi</th>
                        <th class="p-4 text-right">Total Biaya</th>
                        <th class="p-4 pr-6">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($reservations as $r)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="p-4 pl-6">
                                <div class="font-bold text-gray-900">#{{ $r->id }}</div>
                                <div class="text-xs text-gray-500">{{ $r->reservation_code }}</div>
                            </td>
                            <td class="p-4">
                                <div class="font-semibold text-gray-900">{{ $r->user->name ?? '-' }}</div>
                                <div class="text-xs text-gray-500">{{ $r->user->email ?? '' }}</div>
                            </td>
                            <td class="p-4">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium bg-purple-50 text-purple-700 border border-purple-100">
                                    {{ $r->kamar->name ?? '-' }}
                                </span>
                            </td>
                            <td class="p-4">
                                <div class="text-gray-900">{{ \Carbon\Carbon::parse($r->check_in)->format('d M Y') }}</div>
                                <div class="text-xs text-gray-500">ke {{ \Carbon\Carbon::parse($r->check_out)->format('d M Y') }}</div>
                            </td>
                            <td class="p-4 text-center">
                                <div class="inline-block px-2 py-1 bg-gray-100 rounded-lg text-xs font-bold text-gray-600">
                                    {{ $r->nights }} Malam
                                </div>
                            </td>
                            <td class="p-4 text-right font-bold text-gray-900">
                                Rp {{ number_format($r->total_price, 0, ',', '.') }}
                            </td>
                            <td class="p-4 pr-6">
                                @php $st = strtolower(trim($r->status ?? '')); @endphp
                                @if($st === 'paid')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">
                                        <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Paid
                                    </span>
                                @elseif($st === 'pending')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-700">
                                        <span class="w-1.5 h-1.5 rounded-full bg-yellow-500"></span> Pending
                                    </span>
                                @elseif($st === 'booked')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-700">
                                        <span class="w-1.5 h-1.5 rounded-full bg-yellow-500"></span> Booked
                                    </span>
                                @elseif($st === 'cancelled' || $st === 'canceled')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700">
                                        <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> Cancelled
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-700">
                                        <span class="w-1.5 h-1.5 rounded-full bg-gray-500"></span> {{ ucfirst($st ?: 'unknown') }}
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="p-8 text-center text-gray-500">
                                <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                                <p class="font-medium text-gray-600">Tidak ada data reservasi ditemukan.</p>
                                <p class="text-xs mt-1">Coba sesuaikan filter pencarian Anda.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-5 border-t border-gray-100 bg-gray-50/50 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="text-sm text-gray-500 font-medium">
                Halaman {{ $reservations->currentPage() }} dari {{ $reservations->lastPage() }}
            </div>
            <div>
                {{ $reservations->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const labels = {!! json_encode($chartLabels ?? []) !!};
    const counts = {!! json_encode($chartCounts ?? []) !!};
    const revenue = {!! json_encode($chartRevenue ?? []) !!};

    const totalCount = (counts || []).reduce((s, v) => s + (Number(v) || 0), 0);
    const totalRevenue = (revenue || []).reduce((s, v) => s + (Number(v) || 0), 0);

    function showNoData(containerId) {
        const c = document.getElementById(containerId);
        if (!c) return;
        c.innerHTML = '<div class="h-36 flex items-center justify-center text-gray-400">Tidak ada data (14 hari)</div>';
    }

    if (!labels || labels.length === 0 || (totalCount === 0 && totalRevenue === 0)) {
        showNoData('reservationsChart');
        showNoData('revenueChart');
        return;
    }

    const commonChartOptions = {
        chart: { toolbar: { show: false }, zoom: { enabled: false } },
        stroke: { curve: 'smooth' },
        dataLabels: { enabled: false },
        xaxis: { categories: labels, labels: { rotate: -45, style: { colors: '#6b7280' } } },
        tooltip: { theme: 'light' },
    };

    const reservationsOptions = Object.assign({}, commonChartOptions, {
        chart: Object.assign({}, commonChartOptions.chart, { type: 'area', height: 140 }),
        series: [{ name: 'Reservasi', data: counts }],
        fill: { type: 'gradient', gradient: { shadeIntensity: 1, opacityFrom: 0.12, opacityTo: 0.02 } },
        colors: ['#7c3aed']
    });

    const revenueOptions = Object.assign({}, commonChartOptions, {
        chart: Object.assign({}, commonChartOptions.chart, { type: 'bar', height: 140 }),
        series: [{ name: 'Pendapatan', data: revenue }],
        plotOptions: { bar: { borderRadius: 6, columnWidth: '40%' } },
        colors: ['#6366f1'],
        yaxis: { labels: { formatter: function (val) { return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 }).format(val); } } }
    });

    const reservationsChart = new ApexCharts(document.querySelector('#reservationsChart'), reservationsOptions);
    reservationsChart.render();

    const revenueChart = new ApexCharts(document.querySelector('#revenueChart'), revenueOptions);
    revenueChart.render();
});
</script>
@endpush