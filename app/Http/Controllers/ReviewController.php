<?php

namespace App\Http\Controllers;

use App\Models\Delivery;
use App\Models\Driver;
use App\Models\Review;
use Illuminate\Http\Request;
class ReviewController extends Controller
{

    public function showReview(string $id){
        $deliveries=Delivery::find($id);
        return view ("Review.Review",compact("deliveries"));
    }
    public function store(Request $request,string $id)
    {
        $deliveries=Delivery::find($id);
        $request->validate([
            'deliveries_id' => 'required|exists:deliveries,id',
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'nullable|string|max:1000',
        ]);
        $client = \App\Models\Client::where('email', auth()->user()->email)->first();
        Review::create([
            'deliveries_id' => $deliveries->id,
            'clients_id' => $client->id,
            'rating' => $request->rating,
            'review' => $request->review,
        ]);

        return back()->with('success', 'Review submitted successfully!');
    }

    public function showDriverReviews($driverId)
    {
        $reviews = Review::whereHas('delivery', function ($q) use ($driverId) {
            $q->where('drivers_id', $driverId);
        })->with('client')->latest()->get();

        return view('Review.driverReview', compact('reviews'));
    }
}
