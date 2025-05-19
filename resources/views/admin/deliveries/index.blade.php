{{--
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Client Insights</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap CSS (CDN) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f8f9fa;
            font-family: 'Segoe UI', sans-serif;
        }

        h4 {
            font-weight: bold;
        }

        .table thead th {
            background-color: #343a40;
            color: white;
        }

        .form-label {
            font-weight: 500;
        }

        .container {
            padding-top: 40px;
            padding-bottom: 40px;
        }
    </style>
</head>
<body>
    <div class="container py-4">
        <h2 class="mb-4">All Deliveries</h2>

        <div class="card p-3">
            <table class="table table-hover">
                <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Status</th>
                    <th>Client</th>
                    <th>Driver</th>
                    <th>Pickup</th>
                    <th>Dropoff</th>
                    <th>Cost</th>
                    <th>Date</th>
                </tr>
                </thead>
                <tbody>
                @foreach($deliveries as $delivery)
                    <tr onclick="window.location='{{ route('admin.delivery.show', $delivery->id) }}';" style="cursor:pointer;">
                        <td>{{ $delivery->id }}</td>
                        <td>
                            <span class="badge
                                @if($delivery->status === 'Delivered') bg-success
                                @elseif($delivery->status === 'In Progress') bg-warning
                                @elseif($delivery->status === 'Pending') bg-secondary
                                @elseif($delivery->status === 'Canceled') bg-danger
                                @endif">
                                {{ $delivery->status }}
                            </span>
                        </td>
                        <td>{{ $delivery->package->client->first_name ?? 'N/A' }}</td>
                        <td>{{ $delivery->driver->first_name ?? 'N/A' }}</td>
                        <td>{{ $delivery->takeOffAddress->region->city ?? 'N/A' }}</td>
                        <td>{{ $delivery->dropOffAddress->region->city ?? 'N/A' }}</td>
                        <td>${{ number_format($delivery->cost, 2) }}</td>
                        <td>{{ $delivery->created_at->format('Y-m-d H:i') }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <!-- Bootstrap JS (Optional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
--}}

@extends('layouts.app')

@section('styles')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f8f9fa;
            font-family: 'Segoe UI', sans-serif;
        }

        h2 {
            font-weight: bold;
        }

        .table thead th {
            background-color: #343a40;
            color: white;
        }

        .container {
            padding-top: 40px;
            padding-bottom: 40px;
        }
    </style>
@endsection

@section('content')
    <div class="container py-4">
        <h2 class="mb-4">All Deliveries</h2>

        <div class="card p-3 shadow-sm">
            <table class="table table-hover">
                <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Status</th>
                    <th>Client</th>
                    <th>Driver</th>
                    <th>Pickup</th>
                    <th>Dropoff</th>
                    <th>Cost</th>
                    <th>Date</th>
                </tr>
                </thead>
                <tbody>
                @foreach($deliveries as $delivery)
                    <tr onclick="window.location='{{ route('admin.delivery.show', $delivery->id) }}';" style="cursor:pointer;">
                        <td>{{ $delivery->id }}</td>
                        <td>
                            <span class="badge
                                @if($delivery->status === 'Delivered') bg-success
                                @elseif($delivery->status === 'In Progress') bg-warning
                                @elseif($delivery->status === 'Pending') bg-secondary
                                @elseif($delivery->status === 'Canceled') bg-danger
                                @endif">
                                {{ $delivery->status }}
                            </span>
                        </td>
                        <td>{{ $delivery->package->client->first_name ?? 'N/A' }}</td>
                        <td>{{ $delivery->driver->first_name ?? 'N/A' }}</td>
                        <td>{{ $delivery->takeOffAddress->region->city ?? 'N/A' }}</td>
                        <td>{{ $delivery->dropOffAddress->region->city ?? 'N/A' }}</td>
                        <td>${{ number_format($delivery->cost, 2) }}</td>
                        <td>{{ $delivery->created_at->format('Y-m-d H:i') }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@endsection
