<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Models\Review;

use Illuminate\Http\Request;
use App\Models\Delivery;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class AdminPerformanceController extends Controller
{
/*    public function index(Request $request)
    {
        $startDate = $request->input('start_date') ?? Carbon::now()->subDays(30)->toDateString();
        $endDate = $request->input('end_date') ?? Carbon::now()->toDateString();
        $commissionRate = 0.15;

        $drivers = Driver::where('is_active', true)
            ->with(['deliveries', 'reviews'])
            ->get()
            ->map(function ($driver) use ($startDate, $endDate) {
                $deliveries = $driver->deliveries->filter(function ($d) use ($startDate, $endDate) {
                    return $d->created_at >= $startDate && $d->created_at <= $endDate;
                });

                $reviews = $driver->reviews->filter(function ($r) use ($startDate, $endDate) {
                    return $r->created_at >= $startDate && $r->created_at <= $endDate;
                });

                return [
                    'id' => $driver->id,
                    'name' => $driver->first_name,
                    'email' => $driver->email,
                    'plate_number' => $driver->plate_number,
                    'total_deliveries' => $deliveries->count(),
                    'total_earnings' => $deliveries->sum('cost'),
                    'average_rating' => round($reviews->avg('rating') ?? 0, 2),
                    'last_delivery' => $deliveries->max('created_at'),
                ];
            });

        $totalCommission = $drivers->sum(function ($driver) use ($commissionRate) {
            return $driver['total_earnings'] * $commissionRate;
        });

        if ($request->input('sort') === 'earnings') {
            $drivers = $drivers->sortByDesc('total_earnings');
        } elseif ($request->input('sort') === 'rating') {
            $drivers = $drivers->sortByDesc('average_rating');
        }

        $topDrivers = $drivers->take(5);

        return view('admin.performance.index', compact(
            'drivers', 'topDrivers', 'startDate', 'endDate', 'totalCommission'
        ));
    }*/

   /* public function index(Request $request)
    {
        $startDate = $request->has('start_date')
            ? Carbon::parse($request->input('start_date'))
            : Carbon::now()->subDays(30);

        $endDate = $request->has('end_date')
            ? Carbon::parse($request->input('end_date'))
            : Carbon::now();

        $commissionRate = 0.15;

        $drivers = Driver::where('is_active', true)
            ->with(['deliveries', 'reviews'])
            ->get()
            ->map(function ($driver) use ($startDate, $endDate) {
                $deliveries = $driver->deliveries->filter(function ($d) use ($startDate, $endDate) {
                    return $d->created_at >= $startDate && $d->created_at <= $endDate;
                });

                $reviews = $driver->reviews->filter(function ($r) use ($startDate, $endDate) {
                    return $r->created_at >= $startDate && $r->created_at <= $endDate;
                });

                return [
                    'id' => $driver->id,
                    'name' => $driver->first_name,
                    'email' => $driver->email,
                    'plate_number' => $driver->plate_number,
                    'total_deliveries' => $deliveries->count(),
                    'total_earnings' => $deliveries->sum('cost'),
                    'average_rating' => round($reviews->avg('rating') ?? 0, 2),
                    'last_delivery' => optional($deliveries->max('created_at'))->format('Y-m-d H:i'),
                ];
            });

        $totalCommission = $drivers->sum(function ($d) use ($commissionRate) {
            return $d['total_earnings'] * $commissionRate;
        });

        $topDrivers = $drivers->sortByDesc('total_earnings')->take(5);

        return view('admin.performance.index', compact(
            'drivers', 'topDrivers', 'startDate', 'endDate', 'totalCommission'
        ));
    }*/
    public function index(Request $request)
    {
/* $startDate = Carbon::parse('2025-05-01');
$endDate = Carbon::parse('2025-05-31');
*/

        $startDate = $request->filled('start_date')
            ? Carbon::parse($request->input('start_date'))->startOfDay()
            : Carbon::now()->subDays(30)->startOfDay();

        $endDate = $request->filled('end_date')
            ? Carbon::parse($request->input('end_date'))->endOfDay()
            : Carbon::now()->endOfDay();

        $sort = $request->input('sort');
        $commissionRate = 0.15;

        $drivers = Driver::where('is_active', true)
            ->with(['deliveries', 'reviews'])
            ->get()
            ->map(function ($driver) use ($startDate, $endDate) {
                $deliveries = $driver->deliveries->filter(fn($d) => $d->created_at >= $startDate && $d->created_at <= $endDate);
                $reviews = $driver->reviews->filter(fn($r) => $r->created_at >= $startDate && $r->created_at <= $endDate);

                return [
                    'id' => $driver->id,
                    'name' => $driver->first_name,
                    'email' => $driver->email,
                    'plate_number' => $driver->plate_number,
                    'total_deliveries' => $deliveries->count(),
                    'total_earnings' => $deliveries->sum('cost'),
                    'average_rating' => round($reviews->avg('rating') ?? 0, 2),
                    'last_delivery' => optional($deliveries->max('created_at'))->format('Y-m-d H:i'),
                ];
            });

        // Apply sorting before passing to view
        if ($sort === 'earnings') {
            $drivers = $drivers->sortByDesc('total_earnings')->values();
        } elseif ($sort === 'rating') {
            $drivers = $drivers->sortByDesc('average_rating')->values();
        } else {
            $drivers = $drivers->values(); // just reindex
        }

        // For top 5, always sort by earnings (or apply same sort as main if needed)
        $topDrivers = $drivers->sortByDesc('total_earnings')->take(5)->values();

        $totalCommission = $drivers->sum(fn($d) => $d['total_earnings'] * $commissionRate);

        return view('admin.performance.index', compact(
            'drivers', 'topDrivers', 'startDate', 'endDate', 'totalCommission'
        ));
    }
/*
    public function index(Request $request)
    {
        // Define default date ranges
        $startDate = $request->has('start_date')
            ? Carbon::parse($request->input('start_date'))
            : Carbon::now()->subDays(30);

        $endDate = $request->has('end_date')
            ? Carbon::parse($request->input('end_date'))
            : Carbon::now();

        $sort = $request->input('sort');
        $commissionRate = 0.15;

        // Load drivers with deliveries and reviews within the date range
        $drivers = Driver::where('is_active', true)
            ->with([
                'deliveries' => function ($query) use ($startDate, $endDate) {
                    $query->whereBetween('created_at', [$startDate, $endDate]);
                },
                'reviews' => function ($query) use ($startDate, $endDate) {
                    $query->whereBetween('created_at', [$startDate, $endDate]);
                }
            ])
            ->get()
            ->map(function ($driver) {
                return [
                    'id' => $driver->id,
                    'name' => $driver->first_name,
                    'email' => $driver->email,
                    'plate_number' => $driver->plate_number,
                    'total_deliveries' => $driver->deliveries->count(),
                    'total_earnings' => $driver->deliveries->sum('cost'),
                    'average_rating' => round($driver->reviews->avg('rating') ?? 0, 2),
                    'last_delivery' => optional($driver->deliveries->max('created_at'))->format('Y-m-d H:i'),
                ];
            });

        // Apply sorting based on user's input
        if ($sort === 'earnings') {
            $drivers = $drivers->sortByDesc('total_earnings')->values();
        } elseif ($sort === 'rating') {
            $drivers = $drivers->sortByDesc('average_rating')->values();
        } else {
            $drivers = $drivers->values(); // Just reindex
        }

        // Identify top 5 drivers (sorted by earnings)
        $topDrivers = $drivers->sortByDesc('total_earnings')->take(5)->values();

        // Calculate total commission
        $totalCommission = $drivers->sum(fn($d) => $d['total_earnings'] * $commissionRate);

        return view('admin.performance.index', compact(
            'drivers', 'topDrivers', 'startDate', 'endDate', 'totalCommission'
        ));
    }*/


    public function search(Request $request)
    {
        $search = $request->input('q');

        $drivers = Driver::where('is_active', true)
            ->where(function ($query) use ($search) {
                $query->where('first_name', 'like', '%' . $search . '%')
                    ->orWhere('last_name', 'like', '%' . $search . '%');
            })
            ->with(['deliveries', 'reviews'])
            ->get()
            ->map(function ($driver) {
                $deliveries = $driver->deliveries;
                $reviews = $driver->reviews;

                return [
                    'id' => $driver->id,
                    'name' => $driver->first_name,
                    'email' => $driver->email,
                    'plate_number' => $driver->plate_number,
                    'total_deliveries' => $deliveries->count(),
                    'total_earnings' => $deliveries->sum('cost'),
                    'average_rating' => round($reviews->avg('rating') ?? 0, 2),
                    'last_delivery' => $deliveries->max('created_at'),
                ];
            });

        $topDrivers = $drivers->take(5);
        $startDate = null;
        $endDate = null;

        $totalCommission = $drivers->sum(fn($d) => $d['total_earnings'] * 0.15);
        return view('admin.performance.index', compact('drivers', 'topDrivers', 'startDate', 'endDate', 'totalCommission'));


        //return view('admin.performance.index', compact('drivers', 'topDrivers', 'startDate', 'endDate'));
    }


    public function show(Driver $driver)
    {
        $startDate = Carbon::now()->subDays(30);
        $endDate = Carbon::now();

        $deliveries = Delivery::where('drivers_id', $driver->id)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->with([
                'package.client',
                'takeOffAddress.region',
                'dropOffAddress.region',
            ])
            ->get();

        $totalEarnings = $deliveries->sum('cost');
        $commissionRate = 0.15; // 15%
        $commissionAmount = $totalEarnings * $commissionRate;
        $netEarnings = $totalEarnings - $commissionAmount;

        $lastDelivery = $deliveries->max('created_at');
        $avgRating = Review::whereIn('deliveries_id', $deliveries->pluck('id'))->avg('rating');

        $chartLabels = [];
        $chartEarnings = [];
        $chartDeliveries = [];

        $grouped = $deliveries->groupBy(fn($d) => Carbon::parse($d->created_at)->format('Y-m-d'));

        foreach ($grouped as $date => $dList) {
            $chartLabels[] = $date;
            $chartEarnings[] = $dList->sum('cost');
            $chartDeliveries[] = $dList->count();
        }

        return view('admin.performance.show', compact(
            'driver', 'deliveries', 'totalEarnings', 'avgRating', 'lastDelivery',
            'chartLabels', 'chartEarnings', 'chartDeliveries',
            'commissionAmount', 'netEarnings' // <== pass to blade
        ));
    }


    public function exportPDF(Driver $driver)
    {
        $startDate = Carbon::now()->subDays(30);
        $endDate = Carbon::now();

        $deliveries = Delivery::where('drivers_id', $driver->id)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->with(['package', 'takeOffAddress', 'dropOffAddress'])
            ->get();

        $totalEarnings = $deliveries->sum('cost');
        $lastDelivery = $deliveries->max('created_at');
        $avgRating = Review::whereIn('deliveries_id', $deliveries->pluck('id'))->avg('rating');

        $pdf = Pdf::loadView('admin.performance.pdf', compact('driver', 'deliveries', 'totalEarnings', 'avgRating', 'lastDelivery'));
        return $pdf->download("Driver_{$driver->id}_Performance.pdf");
    }

    public function deactivate($id)
    {
        $driver = Driver::findOrFail($id);

        $driver->is_active = false;
        $driver->save();

        // Send email notification
        Mail::raw("Hello {$driver->first_name},\n\nYour driver account has been deactivated by the admin.\n\nIf you believe this was a mistake, please contact support.\n\nPlate Number: {$driver->plate_number}", function ($message) use ($driver) {
            $message->to($driver->email)
                ->subject('Account Deactivation Notice');
        });

        return redirect()->back()->with('success', 'Driver has been deactivated and notified via email.');
    }


}
