<!DOCTYPE html>
<html>
<head>
    <title>Driver Performance PDF</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #333; padding: 6px; }
        th { background: #eee; }
    </style>
</head>
<body>
<h2>{{ $driver->first_name }} - 30 Day Report</h2>

<p><strong>Email:</strong> {{ $driver->email }}</p>
<p><strong>Plate Number:</strong> {{ $driver->plate_number }}</p>
<p><strong>Total Earnings:</strong> ${{ number_format($totalEarnings, 2) }}</p>
<p><strong>Average Rating:</strong> {{ number_format($avgRating, 2) }}/5</p>
<p><strong>Last Delivery:</strong> {{ $lastDelivery }}</p>

<h4>Deliveries:</h4>
<table>
    <thead>
    <tr>
        <th>ID</th>
        <th>Cost</th>
        <th>Pickup</th>
        <th>Dropoff</th>
        <th>Weight</th>
        <th>Date</th>
    </tr>
    </thead>
    <tbody>
    @foreach($deliveries as $d)
        <tr>
            <td>{{ $d->id }}</td>
            <td>${{ $d->cost }}</td>
            <td>{{ $d->takeOffAddress->region->city ?? 'N/A' }}</td>
            <td>{{ $d->dropOffAddress->region->city ?? 'N/A' }}</td>
            <td>{{ $d->package->weight ?? 'N/A' }} {{ $d->package->weight_unit ?? '' }}</td>
            <td>{{ $d->created_at->format('Y-m-d') }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>
