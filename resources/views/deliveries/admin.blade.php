<!-- resources/views/deliveries/admin.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container">
    <h2>All Deliveries</h2>

    @if ($deliveries->isEmpty())
        <p>No deliveries available.</p>
    @else
        @foreach ($deliveries as $delivery)
            <div class="card mb-3">
                <div class="card-body">
                  
                    <p><strong>Status:</strong> {{ $delivery->status }}</p>
                    <p><strong>Takeoff Address:</strong> {{ $delivery->takeOffAddress }}</p>
                    <p><strong>Dropoff Address:</strong> {{ $delivery->dropOffAddress }}</p>
                    <p><strong>Cost:</strong> {{ $delivery->cost }} {{ $delivery->currency }}</p>
                    <p><strong>Scheduled at:</strong> {{ $delivery->scheduled_at }}</p>
                    
                </div>
            </div>
        @endforeach
    @endif
</div>
@endsection
