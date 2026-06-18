<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    protected function placeholder(string $title)
    {
        $html = "<div style=\"font-family:Inter,system-ui,-apple-system,Segoe UI,Roboto,'Helvetica Neue',Arial;max-width:720px;margin:32px auto;padding:24px;border:1px solid #e5e7eb;border-radius:12px;\">" .
                "<h1 style=\"font-size:20px;margin-bottom:12px;color:#111827\">" . htmlspecialchars($title) . "</h1>" .
                "<p style=\"color:#6b7280;margin-bottom:16px\">Halaman laporan ini belum diimplementasikan. Ini adalah placeholder untuk pengembangan cepat.</p>" .
                "<a href=\"" . route('admin.dashboard') . "\" style=\"display:inline-block;padding:8px 12px;background:#7c3aed;color:#fff;border-radius:8px;text-decoration:none\">Kembali ke Dashboard</a>" .
                "</div>";

        return response($html, 200)->header('Content-Type', 'text/html');
    }

    public function index(Request $request)
    {
        // Redirect to reservations report to avoid placeholder page
        return redirect()->route('admin.reports.reservations');
    }

    public function reservations(Request $request)
    {
        // filters: date_from, date_to, status, kamar_id, q (guest name)
        $query = \App\Models\Reservasi::with(['kamar', 'user']);

        if ($request->filled('date_from')) {
            $query->whereDate('check_in', '>=', $request->query('date_from'));
        }
        if ($request->filled('date_to')) {
            $query->whereDate('check_out', '<=', $request->query('date_to'));
        }
        if ($request->filled('status')) {
            $status = $request->query('status');
            // case-insensitive + trim match to handle variations like 'Paid' / ' paid ' / 'PAID'
            $query->whereRaw('LOWER(TRIM(status)) = ?', [trim(strtolower($status))]);
        }
        if ($request->filled('kamar_id')) {
            $query->where('kamar_id', $request->query('kamar_id'));
        }
        if ($request->filled('has_payment')) {
            $v = $request->query('has_payment');
            if ($v === 'with') {
                $query->whereNotNull('payment_id')->where('payment_id', '!=', '');
            } elseif ($v === 'without') {
                $query->where(function($q){
                    $q->whereNull('payment_id')->orWhere('payment_id', '');
                });
            }
        }
        if ($request->filled('q')) {
            $q = $request->query('q');
            $query->whereHas('user', function($u) use ($q) {
                $u->where('name', 'like', "%{$q}%")->orWhere('email', 'like', "%{$q}%");
            });
        }

        // export CSV if requested
        if ($request->query('export') === 'csv') {
            $items = $query->orderBy('check_in', 'desc')->get();
            $filename = 'reservations_' . now()->format('Ymd_His') . '.csv';
            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            ];

            $columns = ['ID', 'Reservation Code', 'Guest', 'Email', 'Kamar', 'Check In', 'Check Out', 'Nights', 'Total Price', 'Status', 'Payment ID'];

            $callback = function() use ($items, $columns) {
                $f = fopen('php://output', 'w');
                fputcsv($f, $columns);
                foreach ($items as $r) {
                    fputcsv($f, [
                        $r->id,
                        $r->reservation_code ?? '',
                        $r->user->name ?? '',
                        $r->user->email ?? '',
                        $r->kamar->name ?? '',
                        $r->check_in,
                        $r->check_out,
                        $r->nights,
                        $r->total_price,
                        $r->status,
                        $r->payment_id ?? '',
                    ]);
                }
                fclose($f);
            };

            return response()->stream($callback, 200, $headers);
        }

        // no debug logging in production flow

        // fetch distinct status values for dropdown
        $distinctStatuses = \App\Models\Reservasi::selectRaw('status')->distinct()->pluck('status')->toArray();

        $reservations = $query->orderBy('check_in', 'desc')->paginate(25)->withQueryString();
        $kamars = \App\Models\Kamar::orderBy('name')->get();

        // chart data: last 14 days (by check_in)
        $end = now()->startOfDay();
        $start = now()->subDays(13)->startOfDay();

        $period = [];
        $labels = [];
        $dayKeys = [];
        for ($i = 0; $i < 14; $i++) {
            $d = $start->copy()->addDays($i);
            $labels[] = $d->format('d M');
            $dayKeys[] = $d->toDateString();
            $period[$d->toDateString()] = ['cnt' => 0, 'revenue' => 0];
        }

        // Only include paid reservations in chart aggregates
        $grouped = \App\Models\Reservasi::selectRaw("DATE(check_in) as day, count(*) as cnt, sum(total_price) as revenue")
            ->whereBetween('check_in', [$start->toDateString(), $end->toDateString()])
            ->whereRaw('LOWER(TRIM(status)) = ?', ['paid'])
            ->groupBy('day')
            ->get();

        foreach ($grouped as $g) {
            $day = $g->day;
            if (isset($period[$day])) {
                $period[$day]['cnt'] = (int) $g->cnt;
                $period[$day]['revenue'] = (float) $g->revenue;
            }
        }

        $chartLabels = $labels;
        $chartCounts = array_values(array_map(function($k) use ($period) { return $period[$k]['cnt']; }, $dayKeys));
        $chartRevenue = array_values(array_map(function($k) use ($period) { return $period[$k]['revenue']; }, $dayKeys));

        return view('admin.reports.reservations', compact('reservations', 'kamars', 'chartLabels', 'chartCounts', 'chartRevenue', 'distinctStatuses'));
    }

    public function reservationsPrint(Request $request)
    {
        // reuse filters similar to reservations(), but return full list and a print-friendly view
        $query = \App\Models\Reservasi::with(['kamar', 'user']);

        if ($request->filled('date_from')) {
            $query->whereDate('check_in', '>=', $request->query('date_from'));
        }
        if ($request->filled('date_to')) {
            $query->whereDate('check_out', '<=', $request->query('date_to'));
        }
        if ($request->filled('status')) {
            $status = $request->query('status');
            $query->whereRaw('LOWER(TRIM(status)) = ?', [trim(strtolower($status))]);
        }
        if ($request->filled('kamar_id')) {
            $query->where('kamar_id', $request->query('kamar_id'));
        }
        if ($request->filled('has_payment')) {
            $v = $request->query('has_payment');
            if ($v === 'with') {
                $query->whereNotNull('payment_id')->where('payment_id', '!=', '');
            } elseif ($v === 'without') {
                $query->where(function($q){
                    $q->whereNull('payment_id')->orWhere('payment_id', '');
                });
            }
        }
        if ($request->filled('q')) {
            $q = $request->query('q');
            $query->whereHas('user', function($u) use ($q) {
                $u->where('name', 'like', "%{$q}%")->orWhere('email', 'like', "%{$q}%");
            });
        }

        $distinctStatuses = \App\Models\Reservasi::selectRaw('status')->distinct()->pluck('status')->toArray();

        // get full reservations list for printing (no paginate)
        $reservations = $query->orderBy('check_in', 'desc')->get();
        $kamars = \App\Models\Kamar::orderBy('name')->get();

        // chart data: last 14 days (by check_in)
        $end = now()->startOfDay();
        $start = now()->subDays(13)->startOfDay();

        $period = [];
        $labels = [];
        $dayKeys = [];
        for ($i = 0; $i < 14; $i++) {
            $d = $start->copy()->addDays($i);
            $labels[] = $d->format('d M');
            $dayKeys[] = $d->toDateString();
            $period[$d->toDateString()] = ['cnt' => 0, 'revenue' => 0];
        }

        $grouped = \App\Models\Reservasi::selectRaw("DATE(check_in) as day, count(*) as cnt, sum(total_price) as revenue")
            ->whereBetween('check_in', [$start->toDateString(), $end->toDateString()])
            ->whereRaw('LOWER(TRIM(status)) = ?', ['paid'])
            ->groupBy('day')
            ->get();

        foreach ($grouped as $g) {
            $day = $g->day;
            if (isset($period[$day])) {
                $period[$day]['cnt'] = (int) $g->cnt;
                $period[$day]['revenue'] = (float) $g->revenue;
            }
        }

        $chartLabels = $labels;
        $chartCounts = array_values(array_map(function($k) use ($period) { return $period[$k]['cnt']; }, $dayKeys));
        $chartRevenue = array_values(array_map(function($k) use ($period) { return $period[$k]['revenue']; }, $dayKeys));

        return view('admin.reports.reservations-print', compact('reservations', 'kamars', 'chartLabels', 'chartCounts', 'chartRevenue', 'distinctStatuses'));
    }

    public function revenue(Request $request)
    {
        return $this->placeholder('Laporan Pendapatan');
    }

    public function occupancy(Request $request)
    {
        return $this->placeholder('Occupancy Rate');
    }

    public function availability(Request $request)
    {
        return $this->placeholder('Ketersediaan Kamar');
    }

    public function guests(Request $request)
    {
        return $this->placeholder('Laporan Tamu');
    }

    public function cancellations(Request $request)
    {
        return $this->placeholder('Pembatalan & No-show');
    }

    public function payments(Request $request)
    {
        return $this->placeholder('Pembayaran & Rekonsiliasi');
    }

    public function events(Request $request)
    {
        return $this->placeholder('Laporan Event');
    }

    public function export(Request $request)
    {
        return $this->placeholder('Export / Cetak Laporan (CSV / PDF)');
    }
}
