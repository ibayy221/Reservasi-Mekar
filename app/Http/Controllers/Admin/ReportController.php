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

    public function all(Request $request)
    {
        $data = $this->buildAllReportData();

        return view('admin.reports.all', $data);
    }

    public function allPrint(Request $request)
    {
        $data = $this->buildAllReportData();

        return response()->view('admin.reports.all-print', $data);
    }

    protected function buildAllReportData(): array
    {
        $totalReservations = \App\Models\Reservasi::count();
        $totalRevenue = \App\Models\Reservasi::whereRaw('LOWER(TRIM(status)) = ?', ['paid'])->sum('total_price');

        $recentReservations = \App\Models\Reservasi::with(['kamar', 'user'])->orderBy('check_in', 'desc')->take(8)->get();

        $totalUnits = \App\Models\Kamar::sum('stock');
        $today = now()->toDateString();
        $occupiedRooms = \App\Models\Reservasi::where('status', '!=', 'cancelled')
            ->whereDate('check_in', '<=', $today)
            ->whereDate('check_out', '>', $today)
            ->count();
        $occupancyRate = $totalUnits > 0 ? round(($occupiedRooms / $totalUnits) * 100, 1) : 0;

        $roomStats = [];
        foreach (\App\Models\Kamar::orderBy('name')->get() as $room) {
            $used = \App\Models\Reservasi::where('kamar_id', $room->id)
                ->where('status', '!=', 'cancelled')
                ->whereDate('check_in', '<=', $today)
                ->whereDate('check_out', '>', $today)
                ->count();

            $roomStats[] = [
                'name' => $room->name,
                'stock' => (int) $room->stock,
                'used' => $used,
                'available' => max(0, (int) $room->stock - $used),
                'status' => $used >= (int) $room->stock ? 'Penuh' : ($used > 0 ? 'Sebagian' : 'Kosong'),
            ];
        }

        $guestSummaries = \App\Models\Reservasi::with(['kamar', 'user'])
            ->orderBy('check_in', 'desc')
            ->take(8)
            ->get()
            ->map(function ($reservation) use ($today) {
                $status = strtolower((string) ($reservation->status ?? ''));
                $checkIn = $reservation->check_in ? now()->parse($reservation->check_in)->toDateString() : null;
                $checkOut = $reservation->check_out ? now()->parse($reservation->check_out)->toDateString() : null;
                $isActiveStay = $checkIn && $checkOut && $checkIn <= $today && $checkOut > $today;
                $isCheckedInStatus = in_array($status, ['checked-in', 'check in', 'checked in', 'in house', 'in-house', 'ongoing']);
                $isCompletedStatus = in_array($status, ['completed', 'checked-out', 'checked out', 'checkout', 'done']);
                $isPastCheckout = $checkOut && $checkOut < $today;

                $category = ($isCheckedInStatus || $isActiveStay) ? 'checked-in' : (($isCompletedStatus || $isPastCheckout) ? 'completed' : 'upcoming');
                $label = $category === 'checked-in' ? 'Sedang Check-in' : ($category === 'completed' ? 'Selesai' : 'Akan Datang');

                return [
                    'name' => $reservation->user->name ?? 'Tanpa Nama',
                    'room' => $reservation->kamar->name ?? '-',
                    'label' => $label,
                    'category' => $category,
                    'check_in' => $reservation->check_in,
                    'check_out' => $reservation->check_out,
                ];
            });

        return [
            'totalReservations' => $totalReservations,
            'totalRevenue' => $totalRevenue,
            'recentReservations' => $recentReservations,
            'occupancyRate' => $occupancyRate,
            'roomStats' => $roomStats,
            'guestSummaries' => $guestSummaries,
        ];
    }

    public function revenue(Request $request)
    {
        $paidReservations = \App\Models\Reservasi::whereRaw('LOWER(TRIM(status)) = ?', ['paid'])->count();
        $totalRevenue = \App\Models\Reservasi::whereRaw('LOWER(TRIM(status)) = ?', ['paid'])->sum('total_price');
        $avgRevenue = $paidReservations > 0 ? round($totalRevenue / $paidReservations, 0) : 0;

        $trend = [];
        $maxRevenue = 0;
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->startOfDay();
            $revenue = \App\Models\Reservasi::whereDate('check_in', $date)
                ->whereRaw('LOWER(TRIM(status)) = ?', ['paid'])
                ->sum('total_price');

            $trend[] = [
                'label' => $date->translatedFormat('d M'),
                'revenue' => (float) $revenue,
            ];
            $maxRevenue = max($maxRevenue, (float) $revenue);
        }

        return view('admin.reports.revenue', compact('paidReservations', 'totalRevenue', 'avgRevenue', 'trend', 'maxRevenue'));
    }

    public function occupancy(Request $request)
    {
        $totalRooms = \App\Models\Kamar::count();
        $totalUnits = \App\Models\Kamar::sum('stock');
        $today = now()->toDateString();

        $activeReservations = \App\Models\Reservasi::where('status', '!=', 'cancelled')
            ->whereDate('check_in', '<=', $today)
            ->whereDate('check_out', '>', $today)
            ->count();

        $occupiedRooms = $activeReservations;
        $availableRooms = max(0, $totalUnits - $occupiedRooms);
        $occupancyRate = $totalUnits > 0 ? round(($occupiedRooms / $totalUnits) * 100, 1) : 0;

        $roomStats = [];
        foreach (\App\Models\Kamar::orderBy('name')->get() as $room) {
            $used = \App\Models\Reservasi::where('kamar_id', $room->id)
                ->where('status', '!=', 'cancelled')
                ->whereDate('check_in', '<=', $today)
                ->whereDate('check_out', '>', $today)
                ->count();

            $roomStats[] = [
                'name' => $room->name,
                'stock' => (int) $room->stock,
                'used' => $used,
                'available' => max(0, (int) $room->stock - $used),
                'status' => $used >= (int) $room->stock ? 'Penuh' : ($used > 0 ? 'Sebagian' : 'Kosong'),
            ];
        }

        return view('admin.reports.occupancy', compact('totalRooms', 'totalUnits', 'occupiedRooms', 'availableRooms', 'occupancyRate', 'roomStats'));
    }

    public function availability(Request $request)
    {
        return $this->placeholder('Ketersediaan Kamar');
    }

    public function guests(Request $request)
    {
        $query = \App\Models\Reservasi::with(['kamar', 'user'])
            ->whereNotNull('user_id')
            ->whereHas('user');

        if ($request->filled('date_from')) {
            $query->whereDate('check_in', '>=', $request->query('date_from'));
        }
        if ($request->filled('date_to')) {
            $query->whereDate('check_out', '<=', $request->query('date_to'));
        }
        if ($request->filled('status')) {
            $status = trim(strtolower($request->query('status')));
            $query->whereRaw('LOWER(TRIM(status)) = ?', [$status]);
        }
        if ($request->filled('kamar_id')) {
            $query->where('kamar_id', $request->query('kamar_id'));
        }

        $reservations = $query->orderBy('check_in', 'desc')->get();
        $kamars = \App\Models\Kamar::orderBy('name')->get();

        $guestReservations = $reservations->map(function ($reservation) {
            $user = $reservation->user;

            return [
                'id' => $reservation->id,
                'reservation_id' => $reservation->id,
                'reservation_code' => $reservation->reservation_code ?? '-',
                'guest_name' => $user->name ?? 'Tanpa Nama',
                'guest_email' => $user->email ?? '-',
                'guest_phone' => $user->no_hp ?? '-',
                'guest_id' => $user->nik_ktp ?? '-',
                'room' => $reservation->kamar->name ?? '-',
                'check_in' => $reservation->check_in,
                'check_out' => $reservation->check_out,
                'nights' => $reservation->nights,
                'adults' => $reservation->adults,
                'children' => $reservation->children,
                'status' => $reservation->status,
            ];
        });

        $today = now()->toDateString();
        $totalGuests = $guestReservations->count();
        $checkedInGuests = $guestReservations->filter(function ($guest) use ($today) {
            $status = strtolower((string) ($guest['status'] ?? ''));
            $checkIn = $guest['check_in'] ? now()->parse($guest['check_in'])->toDateString() : null;
            $checkOut = $guest['check_out'] ? now()->parse($guest['check_out'])->toDateString() : null;

            $isActiveStay = $checkIn && $checkOut && $checkIn <= $today && $checkOut > $today;
            $isCheckedInStatus = in_array($status, ['checked-in', 'check in', 'checked in', 'in house', 'in-house', 'ongoing']);

            return $isCheckedInStatus || $isActiveStay;
        })->count();

        $completedGuests = $guestReservations->filter(function ($guest) use ($today) {
            $status = strtolower((string) ($guest['status'] ?? ''));
            $checkOut = $guest['check_out'] ? now()->parse($guest['check_out'])->toDateString() : null;

            $isCompletedStatus = in_array($status, ['completed', 'checked-out', 'checked out', 'checkout', 'done']);
            $isPastCheckout = $checkOut && $checkOut < $today;

            return $isCompletedStatus || $isPastCheckout;
        })->count();

        return view('admin.reports.guests', compact('guestReservations', 'kamars', 'totalGuests', 'checkedInGuests', 'completedGuests'));
    }

    public function guestDetail(Request $request, $id)
    {
        $reservation = \App\Models\Reservasi::with(['kamar', 'user'])->findOrFail($id);

        return view('admin.reports.guest-detail', compact('reservation'));
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
