<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Lengkap Admin - {{ now()->format('Ymd') }}</title>
    <style>
        /* Base Variables untuk konsistensi */
        :root {
            --primary: #7e22ce; /* Purple 700 */
            --primary-light: #f3e8ff; /* Purple 100 */
            --text-main: #111827;
            --text-muted: #6b7280;
            --border-color: #e5e7eb;
            --bg-light: #f9fafb;
        }

        /* Reset & Base Styles */
        * { box-sizing: border-box; }
        body { 
            font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; 
            color: var(--text-main); 
            line-height: 1.5; 
            margin: 0; 
            padding: 40px; 
            background: #fff;
        }

        /* Header Laporan */
        .report-header {
            border-bottom: 2px solid var(--primary);
            padding-bottom: 16px;
            margin-bottom: 32px;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
        }
        .report-header h1 { margin: 0; font-size: 28px; color: var(--primary); letter-spacing: -0.5px; }
        .report-header p { margin: 4px 0 0; color: var(--text-muted); font-size: 14px; }
        .header-meta { text-align: right; font-size: 12px; color: var(--text-muted); }

        /* KPI Cards Grid */
        .kpi-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-bottom: 32px;
        }
        .kpi-card {
            background-color: var(--primary-light);
            border: 1px solid #d8b4fe;
            border-radius: 8px;
            padding: 20px;
        }
        .kpi-label { font-size: 12px; text-transform: uppercase; font-weight: 700; color: #6b21a8; letter-spacing: 0.5px; }
        .kpi-value { font-size: 28px; font-weight: 900; color: var(--primary); margin-top: 8px; }

        /* Section Cards */
        .section-card {
            margin-bottom: 32px;
            page-break-inside: avoid; /* Mencegah tabel terpotong di halaman baru */
        }
        .section-title {
            font-size: 18px;
            font-weight: 700;
            color: var(--text-main);
            margin: 0 0 16px 0;
            padding-left: 12px;
            border-left: 4px solid var(--primary);
        }

        /* Modern Tables */
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
        }
        th {
            background-color: var(--bg-light);
            color: var(--text-muted);
            font-weight: 600;
            text-transform: uppercase;
            font-size: 11px;
            letter-spacing: 0.5px;
            padding: 12px 16px;
            border-bottom: 2px solid var(--border-color);
            text-align: left;
        }
        td {
            padding: 12px 16px;
            border-bottom: 1px solid var(--border-color);
            vertical-align: middle;
        }
        tbody tr:nth-child(even) { background-color: #fafafa; }
        
        /* Badge Status (Text based untuk print aman) */
        .status-badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 11px;
            font-weight: bold;
            background: #f3f4f6;
            border: 1px solid #d1d5db;
        }

        /* Print Specific Rules */
        @media print {
            body { padding: 0; margin: 20mm; }
            .kpi-card { 
                background-color: var(--primary-light) !important; 
                -webkit-print-color-adjust: exact; 
                print-color-adjust: exact; 
            }
            th { 
                background-color: var(--bg-light) !important;
                -webkit-print-color-adjust: exact; 
                print-color-adjust: exact;
            }
        }
    </style>
</head>
<body>

    <div class="report-header">
        <div>
            <h1>Laporan Eksekutif Admin</h1>
            <p>Ringkasan Data Operasional Hotel</p>
        </div>
        <div class="header-meta">
            <strong>Tanggal Cetak:</strong><br>
            {{ now()->translatedFormat('d F Y, H:i') }} WIB<br>
            <strong>Dicetak oleh:</strong> {{ auth()->user()->name ?? 'Administrator' }}
        </div>
    </div>

    <div class="kpi-grid">
        <div class="kpi-card">
            <div class="kpi-label">Total Reservasi</div>
            <div class="kpi-value">{{ $totalReservations ?? 0 }}</div>
        </div>
        <div class="kpi-card">
            <div class="kpi-label">Total Pendapatan</div>
            <div class="kpi-value">Rp {{ number_format($totalRevenue ?? 0, 0, ',', '.') }}</div>
        </div>
        <div class="kpi-card">
            <div class="kpi-label">Tingkat Okupansi</div>
            <div class="kpi-value">{{ $occupancyRate ?? 0 }}%</div>
        </div>
    </div>

    <div class="section-card">
        <h3 class="section-title">Reservasi Terbaru</h3>
        <table>
            <thead>
                <tr>
                    <th>Nama Tamu</th>
                    <th>Kamar</th>
                    <th>Check-in</th>
                    <th>Check-out</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentReservations as $reservation)
                    <tr>
                        <td style="font-weight: 600;">{{ $reservation->user->name ?? '-' }}</td>
                        <td>{{ $reservation->kamar->name ?? '-' }}</td>
                        <td>{{ $reservation->check_in ? \Carbon\Carbon::parse($reservation->check_in)->format('d/m/Y') : '-' }}</td>
                        <td>{{ $reservation->check_out ? \Carbon\Carbon::parse($reservation->check_out)->format('d/m/Y') : '-' }}</td>
                        <td><span class="status-badge">{{ strtoupper($reservation->status) }}</span></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align: center; color: var(--text-muted);">Tidak ada data reservasi.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="section-card">
        <h3 class="section-title">Aktivitas Tamu Hari Ini</h3>
        <table>
            <thead>
                <tr>
                    <th>Nama Tamu</th>
                    <th>Kamar</th>
                    <th>Periode Inap</th>
                    <th>Status Tamu</th>
                </tr>
            </thead>
            <tbody>
                @forelse($guestSummaries as $guest)
                    <tr>
                        <td style="font-weight: 600;">{{ $guest['name'] }}</td>
                        <td>{{ $guest['room'] }}</td>
                        <td style="color: var(--text-muted);">{{ \Carbon\Carbon::parse($guest['check_in'])->format('d M') }} - {{ \Carbon\Carbon::parse($guest['check_out'])->format('d M Y') }}</td>
                        <td><span class="status-badge">{{ strtoupper($guest['label']) }}</span></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" style="text-align: center; color: var(--text-muted);">Tidak ada aktivitas tamu.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="section-card">
        <h3 class="section-title">Inventaris & Status Kamar</h3>
        <table>
            <thead>
                <tr>
                    <th>Tipe Kamar</th>
                    <th>Status General</th>
                    <th style="text-align: center;">Total Stok</th>
                    <th style="text-align: center;">Terpakai</th>
                    <th style="text-align: center;">Tersedia</th>
                </tr>
            </thead>
            <tbody>
                @forelse($roomStats as $room)
                    <tr>
                        <td style="font-weight: 600;">{{ $room['name'] }}</td>
                        <td>{{ $room['status'] }}</td>
                        <td style="text-align: center;">{{ $room['stock'] }}</td>
                        <td style="text-align: center; color: #dc2626; font-weight: 600;">{{ $room['used'] }}</td>
                        <td style="text-align: center; color: #16a34a; font-weight: 600;">{{ $room['available'] }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align: center; color: var(--text-muted);">Data kamar tidak tersedia.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</body>
</html>