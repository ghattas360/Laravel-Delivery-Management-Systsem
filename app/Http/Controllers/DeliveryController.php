<?php

namespace App\Http\Controllers;

use App\Models\Delivery;
use App\Models\User;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeliveryController extends Controller
{
    // Display the user's own deliveries
public function userDeliveries()
{
    $user = auth()->user();

    // Get the client record for the logged-in user
    $client = Client::where('user_id', $user->id)->first();

    if (!$client) {
        return redirect()->back()->withErrors('Client not found.');
    }

        $deliveries = Delivery::with(['takeOffAddress', 'dropOffAddress', 'package'])
        ->whereHas('package', function ($query) use ($client) {
            $query->where('client_id', $client->id);
        })
        ->get();

    return view('deliveries.user', compact('deliveries'));
}


    // Display the driver's deliveries where they can update status
    public function driverDeliveries()
    {
        $driver = \App\Models\Driver::where('email', auth()->user()->email)->first();
        $deliveries = Delivery::where('drivers_id', $driver->id)->get(); // Get deliveries for the specific driver
        return view('deliveries.driver', compact('deliveries'));
    }

    // Allow the driver to update the delivery status
   public function updateStatus(Request $request, $deliveryId)
{
    $request->validate([
        'status' => 'required|string|in:pending,on_my_way_to_pickup,on_my_way_to_dropoff,paid_awaiting_delivery,completed,cancelled',
    ]);

    $delivery = Delivery::findOrFail($deliveryId);
    $delivery->status = $request->status;
    $delivery->save();

    return redirect()->route('driver.deliveries')->with('success', 'Delivery status updated.');
}


    // Admin view for all deliveries
   public function adminDeliveries()
{
    $deliveries = Delivery::with(['driver', 'takeOfAddress', 'dropOfAddress', 'package'])->get(); // Eager load the necessary relationships
    return view('deliveries.admin', compact('deliveries'));
}

}