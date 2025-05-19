<?php

namespace App\Http\Controllers;
use App\Models\Driver;

use Illuminate\Http\Request;

class DriversOnMap extends Controller
{
    public function index()
{
    $drivers = Driver::with([
        'availabilities.shift',
        'deliveries.takeOffAddress',
        'deliveries.dropOffAddress'
    ])
    ->whereNotNull('latitude')
    ->whereNotNull('longitude')
    ->get();

    $drivers = $drivers->map(function ($driver) {
        $now = now();

        // Check if the driver is available right now
        $isAvailable = $driver->availabilities->contains(function ($a) use ($now) {
            return $a->shift && $now->between($a->shift->starting_time, $a->shift->end_time);
        });

        // Get the latest delivery
        $latestDelivery = $driver->deliveries->sortByDesc('created_at')->first();

        // Get today's shift
        $shiftToday = $driver->availabilities->first(function ($a) {
            return $a->shift && $a->shift->date == now()->toDateString();
        });

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
                ? \Carbon\Carbon::parse($shiftToday->shift->starting_time)->format('H:i')
                : null,
            'shift_today_end' => optional(optional($shiftToday)->shift)->end_time
                ? \Carbon\Carbon::parse($shiftToday->shift->end_time)->format('H:i')
                : null,
        ];
    });

    return view('map.index', compact('drivers'));
}

}
