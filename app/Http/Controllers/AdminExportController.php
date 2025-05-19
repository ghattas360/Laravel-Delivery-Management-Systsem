<?php

namespace App\Http\Controllers;

use App\Exports\ApprovedDriversExport;
use App\Models\Client;
use App\Models\Driver;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class AdminExportController extends Controller
{
    public function exportExcel()
    {
        return Excel::download(new ApprovedDriversExport, 'approved_drivers.xlsx');
    }

    public function exportPDF()
    {
        $drivers = Driver::where('is_active', true)->get();

        $pdf = Pdf::loadView('admin.drivers.pdf', compact('drivers'));
        return $pdf->download('approved_drivers.pdf');
    }

    public function exportClientLoyaltyPDF()
    {
        $clients = Client::with(['getPackges.deliveries'])->get()->map(function ($client) {
            $totalPayment = $client->getPackges->flatMap->deliveries->sum('cost');
            $cashback = $totalPayment * ($client->cashback_rate ?? 0) / 100;

            return [
                'name' => $client->first_name . ' ' . $client->last_name,
                'email' => $client->email,
                'username' => $client->user_name,
                'premium_level' => ucfirst($client->premium_level ?? 'None'),
                'cashback_rate' => $client->cashback_rate,
                'total_payment' => $totalPayment,
                'total_cashback' => $cashback,
            ];
        });

        $pdf = Pdf::loadView('admin.clients.loyalty_pdf', compact('clients'));
        return $pdf->download('client_loyalty_report.pdf');
    }
}
