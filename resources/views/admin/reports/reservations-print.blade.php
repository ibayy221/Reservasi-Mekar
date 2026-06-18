<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cetak - Laporan Reservasi</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');
        
        body {
            font-family: 'Inter', sans-serif;
            background-color: #fff;
            color: #111827;
        }

        /* Aturan Khusus Saat Dicetak */
        @media print {
            body { 
                -webkit-print-color-adjust: exact !important; 
                print-color-adjust: exact !important;
                padding: 0 !important;
            }
            .no-print { display: none !important; }
            .avoid-break { page-break-inside: avoid; }
            @page { margin: 1.5cm; }
        }

        .chart-wrap { height: 200px; }
        
        /* Styling Tabel Print */
        table { width: 100%; border-collapse: collapse; margin-bottom: 1rem; }
        table th { background-color: #f3f4f6; color: #374151; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; }
        table th, table td { border: 1px solid #e5e7eb; padding: 10px 12px; font-size: 11px; }
        table tr:nth-child(even) { background-color: #f9fafb; }
    </style>
</head>
<body class="p-8 max-w-5xl mx-auto">

    <div class="flex items-end justify-between border-b-2 border-gray-900 pb-4 mb-6">
        <div>
            <h1 class="text-3xl font-black tracking-tight text-gray-900 uppercase">Laporan Reservasi</h1>
            <p class="text-sm text-gray-500 mt-1">Dokumen Resmi Rincian Transaksi & Okupansi Kamar</p>
        </div>
        <div class="text-right">
            <div class="no-print mb-3">
                <button onclick="window.print()" class="px-4 py-2 bg-purple-600 text-white text-sm font-semibold rounded shadow hover:bg-purple-700 mr-2">Cetak Sekarang</button>
                <button onclick="window.close()" class="px-4 py-2 bg-gray-200 text-gray-800 text-sm font-semibold rounded shadow hover:bg-gray-300">Tutup</button>
            </div>
            <div class="text-xs font-semibold text-gray-500 uppercase tracking-widest">Waktu Cetak</div>
            <div class="text-sm font-bold text-gray-900">{{ now()->format('d F Y - H:i') }} WIB</div>
        </div>
    </div>

    <div class="grid grid-cols-3 gap-4 mb-8 avoid-break">
        <div class="bg-gray-50 p-4 border border-gray-200 rounded-lg">
            <div class="text-xs text-gray-500 font-semibold uppercase mb-1">Total Reservasi Dicetak</div>
            <div class="text-2xl font-black text-gray-900">{{ $reservations->count() }} <span class="text-sm font-medium text-gray-500">transaksi</span></div>
        </div>
        <div class="bg-gray-50 p-4 border border-gray-200 rounded-lg">
            <div class="text-xs text-gray-500 font-semibold uppercase mb-1">Estimasi Pendapatan</div>
            <div class="text-2xl font-black text-purple-700">Rp {{ number_format($reservations->sum('total_price'), 0, ',', '.') }}</div>
        </div>
        <div class="bg-gray-50 p-4 border border-gray-200 rounded-lg">
            <div class="text-xs text-gray-500 font-semibold uppercase mb-1">Status Laporan</div>
            <div class="text-xl font-bold text-gray-900 mt-1">
                <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-sm">Verified</span>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8 avoid-break">
        <div class="p-4 border border-gray-200 rounded-lg bg-white">
            <h4 class="text-sm font-bold text-gray-800 mb-2">Tren Reservasi (14 Hari Terakhir)</h4>
            <div id="reservationsChart" class="chart-wrap"></div>
        </div>
        <div class="p-4 border border-gray-200 rounded-lg bg-white">
            <h4 class="text-sm font-bold text-gray-800 mb-2">Tren Pendapatan (14 Hari Terakhir)</h4>
            <div id="revenueChart" class="chart-wrap"></div>
        </div>
    </div>

    <div class="avoid-break">
        <h3 class="text-lg font-bold text-gray-900 mb-3 border-b pb-2">Rincian Data Reservasi</h3>
        <table>
            <thead>
                <tr>
                    <th class="text-left" style="width: 5%">ID</th>
                    <th class="text-left" style="width: 15%">Kode Rsv</th>
                    <th class="text-left" style="width: 20%">Nama Tamu</th>
                    <th class="text-left" style="width: 15%">Kamar</th>
                    <th class="text-center" style="width: 12%">Check In</th>
                    <th class="text-center" style="width: 12%">Check Out</th>
                    <th class="text-right" style="width: 13%">Total (IDR)</th>
                    <th class="text-center" style="width: 8%">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reservations as $r)
                    <tr>
                        <td class="font-bold text-gray-700">#{{ $r->id }}</td>
                        <td class="font-mono text-gray-600">{{ $r->reservation_code }}</td>
                        <td class="font-semibold text-gray-900">{{ $r->user->name ?? '-' }}</td>
                        <td>{{ $r->kamar->name ?? '-' }}</td>
                        <td class="text-center">{{ \Carbon\Carbon::parse($r->check_in)->format('d/m/Y') }}</td>
                        <td class="text-center">{{ \Carbon\Carbon::parse($r->check_out)->format('d/m/Y') }}</td>
                        <td class="text-right font-bold text-gray-900">{{ number_format($r->total_price, 0, ',', '.') }}</td>
                        <td class="text-center">
                            @if(strtolower($r->status) == 'paid')
                                <span class="font-bold text-green-600">PAID</span>
                            @elseif(strtolower($r->status) == 'pending')
                                <span class="font-bold text-yellow-600">PEND</span>
                            @else
                                <span class="font-bold text-red-600">CANC</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center py-6 text-gray-500 italic">Tidak ada data reservasi untuk ditampilkan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-12 pt-4 border-t border-gray-300 text-xs text-gray-400 text-center avoid-break">
        Laporan ini digenerate secara otomatis oleh sistem. Dokumen sah tanpa tanda tangan basah.
    </div>

    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        const labels = {!! json_encode($chartLabels ?? []) !!};
        const counts = {!! json_encode($chartCounts ?? []) !!};
        const revenue = {!! json_encode($chartRevenue ?? []) !!};

        const reservationsOptions = {
            chart: { type: 'area', height: 180, toolbar: { show: false }, animations: { enabled: false } }, // Matikan animasi untuk print cepat
            series: [{ name: 'Reservasi', data: counts }],
            xaxis: { categories: labels, labels: { rotate: -45, style: { fontSize: '10px' } } },
            colors: ['#7c3aed'],
            stroke: { curve: 'smooth', width: 2 },
            dataLabels: { enabled: false },
            fill: { opacity: 0.15 }
        };

        const revenueOptions = {
            chart: { type: 'bar', height: 180, toolbar: { show: false }, animations: { enabled: false } }, // Matikan animasi
            series: [{ name: 'Pendapatan', data: revenue }],
            xaxis: { categories: labels, labels: { rotate: -45, style: { fontSize: '10px' } } },
            colors: ['#6366f1'],
            plotOptions: { bar: { borderRadius: 4, columnWidth: '50%' } },
            dataLabels: { enabled: false },
            yaxis: { 
                labels: { 
                    formatter: function (val) { return "Rp " + val.toLocaleString("id-ID"); },
                    style: { fontSize: '10px' }
                } 
            }
        };

        const rChart = new ApexCharts(document.querySelector('#reservationsChart'), reservationsOptions);
        const revChart = new ApexCharts(document.querySelector('#revenueChart'), revenueOptions);

        Promise.all([rChart.render(), revChart.render()]).then(() => {
            // Memberikan waktu browser untuk menggambar grafik sebelum memicu print
            setTimeout(() => { 
                window.print(); 
            }, 800);
        });
    </script>
</body>
</html>