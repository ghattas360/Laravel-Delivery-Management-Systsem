<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Client;
use App\Models\Driver;
use App\Models\Employee;
use App\Models\Region;

use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function index()
    {
        $client = Client::where('user_id', auth()->id())->first();

        if (!$client) {
            return redirect()->back()->with('error', 'No client profile found for this user.');
        }

        // Only the client's addresses, eager loading the region
        $addresses = $client->addresses()->with('region')->get();
        $regions = Region::all(); // Optional, used for creating/editing forms

        return view('addresses.index', compact('addresses', 'regions'));
    }

    public function store(Request $request)
{
    $validated = $request->validate([
        'street' => 'required|string|max:255',
        'house_number' => 'required|integer',
        'zip_code' => 'required|integer',
        'type' => 'required|string|max:255',
        'floor' => 'nullable|integer',
        'region_id' => 'required|exists:regions,id',
    ]);

    $address = Address::create($validated);

    // Link to authenticated client
    $client = Client::where('user_id', auth()->id())->first();
    if ($client) {
        $client->addresses()->attach($address->id);
    }

    return redirect()->route('addresses.index')->with('success', 'Address added successfully.');
}


    public function show($id)
    {
        $address = Address::with('region')->findOrFail($id);
        return response()->json($address);
    }

    public function edit($id)
    {
        $editing = Address::findOrFail($id);

        return view('addresses.index', [
            'editing' => $editing,
            'addresses' => Address::with('region')->get(),
            'regions' => Region::all()
        ]);


    }
    public function update(Request $request, $id)
    {
        $address = Address::findOrFail($id);

        $validated = $request->validate([
            'street' => 'sometimes|string|max:255',
            'house_number' => 'sometimes|integer',
            'zip_code' => 'sometimes|integer',
            'type' => 'sometimes|string|max:255',
            'floor' => 'nullable|integer',
            'region_id' => 'sometimes|exists:regions,id',
        ]);

        $address->update($validated);

            return redirect()->route('addresses.index')->with('success', 'Address updated successfully.');

    }

    public function destroy($id)
    {
        $address = Address::findOrFail($id);
        $address->delete();

        return redirect()->route('addresses.index')->with('success', 'Address deleted successfully.');

    }

}
