<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class StripePaymentController extends Controller
{
    /**
     * Show the Stripe payment page for a specific delivery.
     *
     * @param int $delivery_id
     * @return \Illuminate\View\View
     */
    public function stripe($delivery_id)
    {
        // Fetch the delivery details from the database
        $delivery = DB::table('deliveries')->find($delivery_id);

        // Pass the delivery data to the view
        return view('stripe', ['delivery' => $delivery]);
    }

    /**
     * Handle Stripe payment submission.
     *
     * @param Request $request
     * @param int $delivery_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function stripePost(Request $request, $delivery_id)
    {
        // Set Stripe API secret key
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
    
        try {
            // Capture cost, currency, and zip from the form submission
            $currency = $request->currency;
            $cost = $request->cost * 100;  // Convert to cents (Stripe works with the smallest unit)
            $zip = $request->zip;
    
            // Create a charge on Stripe
            $charge = Stripe\Charge::create([
                "amount" => $cost,  // Amount in cents
                "currency" => $currency,  // Currency passed from the form
                "source" => $request->stripeToken,
                "description" => "Payment for delivery ID " . $delivery_id,
                "billing_details" => [
                    "address" => [
                        "postal_code" => $zip,  // Include zip code in billing details
                    ]
                ]
            ]);
    
            // Check if the charge was successful
            if ($charge->status === 'succeeded') {
                // Update the delivery status to 'paid, awaiting delivery'
                DB::table('deliveries')
                    ->where('id', $delivery_id)
                    ->update(['status' => 'paid, awaiting delivery']);
    
                // Redirect back with a success message
                return  redirect()->route('deliveries.user')->with('success', 'Payment successful and delivery status updated!');
            } else {
                // If the charge failed, redirect back with an error message
                return back()->with('error', 'Payment failed!');
            }
        } catch (\Exception $e) {
            // Handle any errors that occur during the payment process
            return back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }
    
}