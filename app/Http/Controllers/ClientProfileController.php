<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Address;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class ClientProfileController extends Controller
{
    // Show the client profile
    public function show($clientId)
    {
        \Log::info("Client Profile ID: $clientId"); // Log the client ID
        $client = Client::with([ 'reviews'])->findOrFail($clientId);

        return view('client.clientprofile', compact('client'));
    }
    public function uploadProfileImage(Request $request, $id)
    {
        $request->validate([
            'profile_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $client = Client::findOrFail($id);

        // Delete old image if exists
        if ($client->profile_image && Storage::exists($client->profile_image)) {
            Storage::delete($client->profile_image);
        }

        $path = $request->file('profile_image')->store('profile_images', 'public');
        $client->profile_image = $path;
        $client->save();

        return redirect()->route('client.profile', ['id' => $id])->with('success', 'Profile image updated!');
    }


    // Update the client profile
    public function update(Request $request, $clientId)
    {
        $client = Client::findOrFail($clientId);

        // Validate the incoming request data
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'premium_level' => 'nullable|string|max:50',
            'user_name' => 'nullable|string|max:255',
            // You can add other validation rules as per your requirements
        ]);

        // Update the client data
        $client->update($validated);

        return response()->json([
            'message' => 'Profile updated successfully!',
            'client' => $client
        ]);
    }

    // Add or update client address
    public function addAddress(Request $request, $clientId)
    {
        $client = Client::findOrFail($clientId);

        // Validate the incoming address data
        $validated = $request->validate([
            'address' => 'required|string|max:255',
        ]);

        // Create or attach address to the client
        $address = Address::create($validated);
        $client->getAddress()->attach($address);

        return response()->json([
            'message' => 'Address added successfully!',
            'address' => $address
        ]);
    }

}
