@extends('layouts.app')

@section('content')
<h2 class="mb-4">Available Requests</h2>

@if($requests->isEmpty())
    <p class="text-muted">No available requests found for this driver.</p>
@else
    <div class="row row-cols-1 row-cols-md-2 g-4">
        @foreach($requests as $request)
            <div class="col">
                <div class="card shadow-sm h-100 d-flex flex-column justify-content-between">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Request #{{ $request->id }}</h5>
                        <p class="card-text mb-1">
                            <strong>Scheduled At:</strong> 
                            {{ \Carbon\Carbon::parse($request->scheduled_at)->format('M d, Y - h:i A') }}
                        </p>
                        <p class="card-text mb-3">
                            <strong>Takeoff Region:</strong> 
                            {{ $request->takeoffAddress->region->region_name ?? 'N/A' }}
                        </p>
                    </div>
                    <div class="card-footer bg-transparent border-0">
                    <a href="{{ route('offers.make', ['id' => $request->id]) }}">Make Offer</a>

                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif
@endsection