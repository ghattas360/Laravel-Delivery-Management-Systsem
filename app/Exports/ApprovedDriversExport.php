<?php

namespace App\Exports;

use App\Models\Driver;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ApprovedDriversExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Driver::where('is_active', true)->select(
            'id', 'first_name', 'email', 'phone', 'plate_number', 'pricing_model', 'created_at'
        )->get();
    }

    public function headings(): array
    {
        return [
            'ID', 'Name', 'Email', 'Phone', 'Plate Number', 'Pricing Model', 'Registered At'
        ];
    }
}
