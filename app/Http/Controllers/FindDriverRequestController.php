<?php

namespace App\Http\Controllers;

use App\Models\FindDriverRequest;
use App\Models\Package;
use App\Models\User;
use App\Models\Client;
use App\Models\Address;
use App\Models\DriverOffer;
use App\Models\Delivery;
use App\Models\Region;

use Illuminate\Http\Request;
use App\Notifications\OfferAccept;

class FindDriverRequestController extends Controller
{
    public function create($package_id)
    {
        $user = auth()->user();

        $client = Client::where('user_id', auth()->id())->first();
        $addresses = $client->addresses()->with('region')->get();

        return view('requests.create', [
            'package_id' => $package_id,
            'addresses' => $addresses,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'package_id' => 'required|exists:packages,id',
            'takeof_address_id' => 'required|integer',
            'dropof_address_id' => 'required|integer',
            'scheduled_at' => 'required|date',
        ]);

        FindDriverRequest::create([
            'user_id' => auth()->id(), // Automatically assign to logged-in user
            'package_id' => $request->package_id,
            'takeof_address_id' => $request->takeof_address_id,
            'dropof_address_id' => $request->dropof_address_id,
            'scheduled_at' => $request->scheduled_at,
            'status' => 'pending',
        ]);

        return redirect()->route('requests.index')->with('success', 'Request created.');
    }
    public function index()
    {
        $user = auth()->user();

        $client = Client::where('user_id', auth()->id())->first();

        if (!$client) {
            return redirect()->back()->with('error', 'No client profile associated with your account.');
        }

        $requests = FindDriverRequest::whereHas('package', function ($query) use ($client) {
            $query->where('client_id', $client->id);
        })->with(['package', 'takeofAddress', 'dropoffAddress'])->get();
        return view('requests.index', compact('requests'));
    }
    public function showOffers($id)
    {
        $offers = DriverOffer::where('find_driver_request_id', $id)->with('driver')->get();
        return view('requests.offers', compact('offers'));
    }
    public function acceptOffer($offerId)
    {
        // Find the accepted offer
        $offer = DriverOffer::findOrFail($offerId);

        // Create a new delivery based on the offer and associated FindDriverRequest
        $delivery = new Delivery();
        $delivery->takeOf_Address_id = $offer->request->takeof_address_id;
        $delivery->dropOf_Address_id = $offer->request->dropof_address_id;
        $delivery->packages_id = $offer->request->package_id;  // Change package_id to packages_id
        $delivery->drivers_id = $offer->driver_id;  // Change driver_id to drivers_id
        $delivery->status = 'pending';
        $delivery->cost = $offer->price; // Set the cost from the offer price
        $delivery->currency = $offer->currency; // Set the currency from the offer currency
        $delivery->scheduled_at = $offer->request->scheduled_at;
        $delivery->save();
        // Notify the driver by email
        $offer->driver->notify(new OfferAccept($delivery));

        // Delete all other offers for this request
        DriverOffer::where('find_driver_request_id', $offer->request->id)->delete();

        // Delete the find driver request
        $offer->request->delete();
        if (strtolower($offer->payment_method) === 'visa') {
            return redirect()->route('pay.delivery', ['delivery_id' => $delivery->id]);
        }
        // Redirect back with a success message
        return redirect()->route('deliveries.user')->with('success', 'Offer accepted and delivery created.');
    }

}