<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Driver;
use App\Models\Availability;
use App\Models\FindDriverRequest;

class DriverOfferController extends Controller
{
    /**
     * Show all available requests that match the logged-in driver's availability and regions.
     */
    public function showAvailableRequestsForDriver()
    {
        // Get the authenticated user
        $user = Auth::user();

        // Find the driver associated with the logged-in user
        $driver = Driver::where('user_id', $user->id)->first();

        if (!$driver) {
            // Driver profile not found; redirect or handle error
            return redirect()->route('login')->withErrors('Driver profile not found.');
        }

        $driverId = $driver->id;

        // Get all availabilities for this driver
        $availabilities = Availability::with(['getShiftAvailability', 'getRegionAvailability'])
            ->where('drivers_id', $driverId)
            ->get();

        $matchingRequests = collect();

        foreach ($availabilities as $availability) {
            $shift = $availability->getShiftAvailability;
            $regions = $availability->getRegionAvailability;

            if (!$shift) {
                continue;
            }

            $start = $shift->starting_time;
            $end = $shift->end_time;

            foreach ($regions as $region) {
                $requests = FindDriverRequest::with(['takeofAddress.region'])
                    ->whereHas('takeofAddress', function ($query) use ($region) {
                        $query->whereHas('region', function ($query2) use ($region) {
                            $query2->where('id', $region->id);
                        });
                    })
                    ->whereBetween('scheduled_at', [$start, $end])
                    ->get();

                $matchingRequests = $matchingRequests->merge($requests);
            }
        }

        // Remove duplicate requests by id
        $uniqueRequests = $matchingRequests->unique('id');

        // Return the view with the requests for the logged-in driver
        return view('drivers.requests', [
            'requests' => $uniqueRequests
        ]);
    }

    /**
     * Example method to create a new offer for a delivery request.
     * This assumes the offer data is passed in $request.
     */
   public function createOffer(Request $request)
{
    $user = Auth::user();
    $driver = Driver::where('user_id', $user->id)->first();

    if (!$driver) {
        return redirect()->route('login')->withErrors('Driver profile not found.');
    }

    $validated = $request->validate([
        'request_id' => 'required|exists:find_driver_requests,id',
        'price' => 'required|numeric',
        'currency' => 'required|string',
        'payment_method' => 'required|string',
    ]);

    $offer = new \App\Models\DriverOffer();
    $offer->driver_id = $driver->id;

    // Use the actual DB column name here
    $offer->find_driver_request_id = $validated['request_id'];

    $offer->price = $validated['price'];
    $offer->currency = $validated['currency'];
    $offer->payment_method = $validated['payment_method'];
    $offer->save();

    return redirect()->back()->with('success', 'Offer submitted successfully!');
}

    /**
     * Example method to list all offers by the logged-in driver.
     */
    public function listOffers()
    {
        $user = Auth::user();
        $driver = Driver::where('user_id', $user->id)->first();

        if (!$driver) {
            return redirect()->route('login')->withErrors('Driver profile not found.');
        }

        $offers = \App\Models\DriverOffer::where('driver_id', $driver->id)->get();

        return view('drivers.offers', [
            'offers' => $offers,
        ]);
    }
public function makeOffer($requestId)
{
    $user = Auth::user();
    $driver = Driver::where('user_id', $user->id)->first();

    if (!$driver) {
        return redirect()->route('login')->withErrors('Driver profile not found.');
    }

    // Optional: load the request info to display in the form
    $requestData = \App\Models\FindDriverRequest::findOrFail($requestId);

    return view('offers.create', [
        'request' => $requestData,
        'driver' => $driver,
    ]);
}

    // Other controller methods as needed...
}