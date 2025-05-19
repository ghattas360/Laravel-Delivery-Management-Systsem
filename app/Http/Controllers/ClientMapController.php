<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Driver;

use App\Models\Availability;
use Carbon\Carbon;

class ClientMapController extends Controller
{
   public function index()
{
    // Get drivers with latitude and longitude only
    $drivers = Driver::whereNotNull('latitude')
        ->whereNotNull('longitude')
        ->get()
        ->map(function ($driver) {
            return [
                'id' => $driver->id,
                'first_name' => $driver->first_name,
                'last_name' => $driver->last_name,
                'email' => $driver->email,
                'pricing_model' => $driver->pricing_model,
                'latitude' => $driver->latitude,
                'longitude' => $driver->longitude,
                // Skip availability & deliveries for now
                'is_available_now' => null,
                'is_delivering' => null,
                'pickup_lat' => null,
                'pickup_lng' => null,
                'dropoff_lat' => null,
                'dropoff_lng' => null,
                'shift_today_start' => null,
                'shift_today_end' => null,
            ];
        });

    return view('map.index', compact('drivers'));
}
public function showAvailableDriversForRegionAndTime($regionId, $scheduledTime)
{
    $scheduledTime = \Carbon\Carbon::parse($scheduledTime);

    $availabilities = Availability::with(['getShiftAvailability', 'driver'])
        ->whereHas('getRegionAvailability', function ($query) use ($regionId) {
            $query->where('regions.id', $regionId);
        })
        ->get();

    $availableDriverIds = $availabilities->filter(function ($availability) use ($scheduledTime) {
        $shift = $availability->getShiftAvailability;
        if (!$shift) return false;

        return $scheduledTime->between($shift->starting_time, $shift->end_time);
    })->pluck('driver.id')->unique();

    $drivers = Driver::whereIn('id', $availableDriverIds)
        ->whereNotNull('latitude')
        ->whereNotNull('longitude')
        ->get();

    return view('map.available', compact('drivers'));
}


}