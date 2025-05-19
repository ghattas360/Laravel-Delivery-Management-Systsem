<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Driver;
use Carbon\Carbon;
class AdminMapController extends Controller
{
/*    public function index()
    {
        $drivers = Driver::with(['availabilities.shift', 'deliveries.takeOffAddress', 'deliveries.dropOffAddress'])
            ->whereNotNull('latitude')->whereNotNull('longitude')->get();

        $drivers = $drivers->map(function ($driver) {
            $now = now();

            $isAvailable = $driver->availabilities
                ->contains(fn($a) =>
                    $a->shift &&
                    $now->between($a->shift->starting_time, $a->shift->end_time)
                );

            $latestDelivery = $driver->deliveries->sortByDesc('created_at')->first();

            $shiftToday = $driver->availabilities
                ->first(fn($a) => $a->shift && $a->shift->date == now()->toDateString());

            return [
                'id' => $driver->id,
                'first_name' => $driver->first_name,
                'last_name' => $driver->last_name,
                'email' => $driver->email,
                'pricing_model' => $driver->pricing_model,
                'latitude' => $driver->latitude,
                'longitude' => $driver->longitude,
                'is_available_now' => $isAvailable,
                'is_delivering' => $driver->deliveries->isNotEmpty(),

                'pickup_lat' => optional(optional($latestDelivery)->takeOffAddress)->latitude,
                'pickup_lng' => optional(optional($latestDelivery)->takeOffAddress)->longitude,
                'dropoff_lat' => optional(optional($latestDelivery)->dropOffAddress)->latitude,
                'dropoff_lng' => optional(optional($latestDelivery)->dropOffAddress)->longitude,

                'shift_today_start' => optional(optional($shiftToday)->shift)->starting_time
                    ? Carbon::parse($shiftToday->shift->starting_time)->format('H:i')
                    : null,

                'shift_today_end' => optional(optional($shiftToday)->shift)->end_time
                    ? Carbon::parse($shiftToday->shift->end_time)->format('H:i')
                    : null,
            ];
        });

        return view('admin.map.index', compact('drivers'));
    }*/

    public function index()
    {
        $drivers = Driver::with([
            'availabilities.shift',
            'deliveries.takeOffAddress',
            'deliveries.dropOffAddress'
        ])->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->get();

        $drivers = $drivers->map(function ($driver) {
            $now = now();

            $isAvailable = $driver->availabilities->contains(fn($a) =>
                $a->shift &&
                $now->between(
                    Carbon::parse($a->shift->starting_time),
                    Carbon::parse($a->shift->end_time)
                )
            );

            $latestDelivery = $driver->deliveries->sortByDesc('created_at')->first();

            $shiftToday = $driver->availabilities
                ->first(fn($a) => $a->shift && $a->shift->date === $now->toDateString());

            return [
                'id' => $driver->id,
                'first_name' => $driver->first_name,
                'last_name' => $driver->last_name,
                'email' => $driver->email,
                'pricing_model' => $driver->pricing_model,
                'latitude' => $driver->latitude,
                'longitude' => $driver->longitude,
                'is_available_now' => $isAvailable,
                'is_delivering' => $driver->deliveries->isNotEmpty(),
                'pickup_lat' => optional(optional($latestDelivery)->takeOffAddress)->latitude,
                'pickup_lng' => optional(optional($latestDelivery)->takeOffAddress)->longitude,
                'dropoff_lat' => optional(optional($latestDelivery)->dropOffAddress)->latitude,
                'dropoff_lng' => optional(optional($latestDelivery)->dropOffAddress)->longitude,
                'shift_today_start' => optional(optional($shiftToday)->shift)->starting_time
                    ? Carbon::parse($shiftToday->shift->starting_time)->format('H:i')
                    : null,
                'shift_today_end' => optional(optional($shiftToday)->shift)->end_time
                    ? Carbon::parse($shiftToday->shift->end_time)->format('H:i')
                    : null,
            ];
        });

        return view('admin.map.index', [
            'drivers' => $drivers,
            'showDrivers' => true
        ]);
    }
}
