<?php

namespace App\Http\Controllers;

use App\Models\Delivery;
use Illuminate\Http\Request;

class AdminDeliveryController extends Controller
{

    public function index()
    {
        $deliveries = Delivery::with([
            'package.client',
            'takeOffAddress.region',
            'dropOffAddress.region',
            'driver',
        ])->orderByDesc('created_at')->get();

        return view('admin.deliveries.index', compact('deliveries'));
    }


    // AdminDeliveryController.php
    public function show(Delivery $delivery)
    {
        $delivery->load(['package.client', 'driver', 'takeOffAddress.region', 'dropOffAddress.region', 'reviews']);
        return view('admin.deliveries.show', compact('delivery'));
    }

}
