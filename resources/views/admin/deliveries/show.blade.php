{{--
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delivery #{{ $delivery->id }} Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container py-5">
    <h2 class="mb-4">Delivery #{{ $delivery->id }} Details</h2>

    <div class="card p-4 mb-4">
        <h5 class="text-primary">Client Info</h5>
        <p><strong>Name:</strong> {{ $delivery->package->client->first_name }} {{ $delivery->package->client->last_name }}</p>
        <p><strong>Email:</strong> {{ $delivery->package->client->email }}</p>
        <a href="{{ route('admin.clients.show', $delivery->package->client->id) }}" class="btn btn-outline-primary btn-sm">View Client</a>
    </div>
    <div class ="card p-4 mb-4">
        @if($delivery->reviews->isNotEmpty())
            @php $review = $delivery->reviews->first(); @endphp
            <hr>
            <h5 class="text-primary">Review</h5>
            <p><strong>Rating:</strong> {{ $review->rating }}/5</p>
            <p><strong>Comment:</strong> {{ $review->review }}</p>
        @endif

    </div>
    <div class="card p-4 mb-4">
        <h5 class="text-success">Driver Info</h5>
        <p><strong>Name:</strong> {{ $delivery->driver->first_name }} {{ $delivery->driver->last_name }}</p>
        <p><strong>Email:</strong> {{ $delivery->driver->email }}</p>
        <a href="{{ route('admin.driver.performance.show', $delivery->driver->id) }}" class="btn btn-outline-success btn-sm">View Driver</a>
    </div>

    <div class="card p-4 mb-4">
        <h5 class="text-dark">Package Info</h5>
        <p><strong>Weight:</strong> {{ $delivery->package->weight }} {{ $delivery->package->weight_unit }}</p>
        <p><strong>Breakable:</strong> {{ $delivery->package->is_breakable ? 'Yes' : 'No' }}</p>
        <p><strong>Flammable:</strong> {{ $delivery->package->is_flammable ? 'Yes' : 'No' }}</p>
        <p><strong>Has Fluid:</strong> {{ $delivery->package->has_fluid ? 'Yes' : 'No' }}</p>
    </div>

    <div class="card p-4 mb-4">
        <h5 class="text-info">Addresses</h5>
        <p><strong>Pickup:</strong> {{ $delivery->takeOffAddress->region->city ?? 'N/A' }}</p>
        <p><strong>Dropoff:</strong> {{ $delivery->dropOffAddress->region->city ?? 'N/A' }}</p>
    </div>

    <div class="card p-4 mb-4">
        <h5 class="text-warning">Delivery Summary</h5>
        <p><strong>Cost:</strong> ${{ $delivery->cost }}</p>
        <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($delivery->created_at)->format('Y-m-d H:i') }}</p>
        @if($delivery->review)
            <hr>
            <h6 class="mt-3">Review</h6>
            <p><strong>Rating:</strong> {{ $delivery->review->rating }}/5</p>
            <p><strong>Comment:</strong> {{ $delivery->review->comment }}</p>
        @endif
    </div>

    <a href="{{ url()->previous() }}" class="btn btn-secondary">⬅ Back</a>
</div>
</body>
</html>
--}}


@extends('layouts.app')

@section('styles')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
@endsection

@section('content')
    <div class="container py-5">
        <h2 class="mb-4">Delivery #{{ $delivery->id }} Details</h2>

        <div class="card p-4 mb-4">
            <h5 class="text-primary">Client Info</h5>
            <p><strong>Name:</strong> {{ $delivery->package->client->first_name }} {{ $delivery->package->client->last_name }}</p>
            <p><strong>Email:</strong> {{ $delivery->package->client->email }}</p>
            <a href="{{ route('admin.clients.show', $delivery->package->client->id) }}" class="btn btn-outline-primary btn-sm">View Client</a>
        </div>

        <div class="card p-4 mb-4">
            @if($delivery->reviews->isNotEmpty())
                @php $review = $delivery->reviews->first(); @endphp
                <hr>
                <h5 class="text-primary">Review</h5>
                <p><strong>Rating:</strong> {{ $review->rating }}/5</p>
                <p><strong>Comment:</strong> {{ $review->review }}</p>
            @endif
        </div>

        <div class="card p-4 mb-4">
            <h5 class="text-success">Driver Info</h5>
            <p><strong>Name:</strong> {{ $delivery->driver->first_name }} {{ $delivery->driver->last_name }}</p>
            <p><strong>Email:</strong> {{ $delivery->driver->email }}</p>
            <a href="{{ route('admin.driver.performance.show', $delivery->driver->id) }}" class="btn btn-outline-success btn-sm">View Driver</a>
        </div>

        <div class="card p-4 mb-4">
            <h5 class="text-dark">Package Info</h5>
            <p><strong>Weight:</strong> {{ $delivery->package->weight }} {{ $delivery->package->weight_unit }}</p>
            <p><strong>Breakable:</strong> {{ $delivery->package->is_breakable ? 'Yes' : 'No' }}</p>
            <p><strong>Flammable:</strong> {{ $delivery->package->is_flammable ? 'Yes' : 'No' }}</p>
            <p><strong>Has Fluid:</strong> {{ $delivery->package->has_fluid ? 'Yes' : 'No' }}</p>
        </div>

        <div class="card p-4 mb-4">
            <h5 class="text-info">Addresses</h5>
            <p><strong>Pickup:</strong> {{ $delivery->takeOffAddress->region->city ?? 'N/A' }}</p>
            <p><strong>Dropoff:</strong> {{ $delivery->dropOffAddress->region->city ?? 'N/A' }}</p>
        </div>

        <div class="card p-4 mb-4">
            <h5 class="text-warning">Delivery Summary</h5>
            <p><strong>Cost:</strong> ${{ $delivery->cost }}</p>
            <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($delivery->created_at)->format('Y-m-d H:i') }}</p>
            @if($delivery->review)
                <hr>
                <h6 class="mt-3">Review</h6>
                <p><strong>Rating:</strong> {{ $delivery->review->rating }}/5</p>
                <p><strong>Comment:</strong> {{ $delivery->review->comment }}</p>
            @endif
        </div>

        <a href="{{ url()->previous() }}" class="btn btn-secondary">⬅ Back</a>
    </div>
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@endsection
