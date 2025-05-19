<!-- resources/views/deliveries/user.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Your Deliveries</h2>

        @if ($deliveries->isEmpty())
            <p>You have no deliveries.</p>
        @else
            @foreach ($deliveries as $delivery)
                <div class="card mb-3">
                    <div class="card-body">
                        <p><strong>Package:</strong> {{ $delivery->package->name }}</p>
                        <p><strong>Status:</strong> {{ $delivery->status }}</p>
                        <p><strong>Takeoff Address:</strong> {{ $delivery->takeOffAddress->address }}</p>
                        <p><strong>Dropoff Address:</strong> {{ $delivery->dropOffAddress->address }}</p>
                        <p><strong>Cost:</strong> {{ $delivery->cost }} {{ $delivery->currency }}</p>
                        <p><strong>Scheduled at:</strong> {{ $delivery->scheduled_at }}</p>
                          @if ($delivery->status === 'completed')
                            <a href="{{ route('reviews.show', ['id' => $delivery->id]) }}" class="btn btn-primary mt-2">
                                Leave a Review
                            </a>
                        @endif

                    </div>
                </div>
            @endforeach

        @endif
    </div>
@endsection