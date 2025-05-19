<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Carbon\Carbon; //This is the correct import

class AdminClientController extends Controller
{


    public function index(Request $request)
    {
        $start = $request->filled('start_date')
            ? Carbon::parse($request->input('start_date'))->startOfDay()
            : Carbon::now()->subDays(30)->startOfDay();

        $end = $request->filled('end_date')
            ? Carbon::parse($request->input('end_date'))->endOfDay()
            : Carbon::now()->endOfDay();

        $sort = $request->input('sort');

        $clients = Client::with(['getPackges.deliveries'])
            ->get()
            ->map(function ($client) use ($start, $end) {
                $deliveries = $client->getPackges
                    ->flatMap->deliveries
                    ->filter(function ($d) use ($start, $end) {
                        return $d->created_at >= $start && $d->created_at <= $end;
                    });

                return [
                    'id' => $client->id,
                    'name' => $client->first_name . ' ' . $client->last_name,
                    'username' => $client->user_name,
                    'email' => $client->email,
                    'total_deliveries' => $deliveries->count(),
                    'total_payment' => $deliveries->sum('cost'),
                ];
            });

        // Apply sorting
        if ($sort === 'deliveries') {
            $clients = $clients->sortByDesc('total_deliveries');
        } elseif ($sort === 'payments') {
            $clients = $clients->sortByDesc('total_payment');
        }

        return view('admin.clients.index', [
            'clients' => $clients,
            'start' => $start->toDateString(),
            'end' => $end->toDateString()
        ]);
    }


/*    public function searchByName(Request $request)
    {
        $search = $request->input('search');

        $clients = Client::with('getPackges.deliveries')
            ->get()
            ->map(function ($client) {
                $deliveries = $client->getPackges->flatMap->deliveries;
                $totalPayment = $deliveries->sum('cost');

                return [
                    'id' => $client->id,
                    'name' => $client->first_name . ' ' . $client->last_name,
                    'username' => $client->user_name,
                    'email' => $client->email,
                    'total_deliveries' => $deliveries->count(),
                    'total_payment' => $totalPayment,
                ];
            })
            ->filter(function ($client) use ($search) {
                return stripos($client['name'], $search) !== false;
            });

        return view('admin.clients.index', [
            'clients' => $clients,
            'start' => null,
            'end' => null,
            'search' => $search,
        ]);
    }*/

    public function searchByName(Request $request)
    {
        $search = strtolower($request->input('search'));

        $clients = Client::with('getPackges.deliveries')
            ->get()
            ->map(function ($client) {
                $deliveries = $client->getPackges->flatMap->deliveries;
                $totalPayment = $deliveries->sum('cost');

                return [
                    'id' => $client->id,
                    'name' => $client->first_name . ' ' . $client->last_name,
                    'username' => $client->user_name,
                    'email' => $client->email,
                    'total_deliveries' => $deliveries->count(),
                    'total_payment' => $totalPayment,
                ];
            })
            ->filter(function ($client) use ($search) {
                return str_contains(strtolower($client['name']), $search)
                    || str_contains(strtolower($client['username']), $search)
                    || str_contains(strtolower($client['email']), $search);
            });

        return view('admin.clients.index', [
            'clients' => $clients,
            'start' => null,
            'end' => null,
            'search' => $search,
        ]);
    }

    public function show(Client $client)
    {
        $packages = $client->getPackges()->with('deliveries.reviews')->get();

        $deliveries = $packages->flatMap->deliveries;
        $totalPayment = $deliveries->sum('cost');
        $averageRating = $deliveries->flatMap->reviews->avg('rating');

        return view('admin.clients.show', compact('client', 'packages', 'deliveries', 'totalPayment', 'averageRating'));
    }

    public function updateLoyalty(Request $request, Client $client)
    {
        $request->validate([
            'premium_level' => 'required|in:bronze,silver,gold',
            'cashback_rate' => 'required|numeric|min:0|max:100',
        ]);

        $client->premium_level = $request->input('premium_level');
        $client->cashback_rate = $request->input('cashback_rate');
        $client->save();

        return redirect()->route('admin.clients.show', $client->id)->with('success', 'Loyalty program updated.');
    }




}
