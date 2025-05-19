@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>All Driver Requests</h2>

        @foreach ($requests as $request)
            <div class="card mb-3">
                <div class="card-body">

                    @if($request->package)
                        <p><strong>Package Details:</strong></p>
                        <ul>
                            <li>Height: {{ $request->package->height }}</li>
                            <li>Width: {{ $request->package->width }}</li>
                            <li>Depth: {{ $request->package->depth }}</li>
                            <li>Weight: {{ $request->package->weight }} {{ $request->package->weight_unit }}</li>
                            <li>Measurement Unit: {{ $request->package->measurement_unit }}</li>
                            <li>Breakable: {{ $request->package->is_breakable ? 'Yes' : 'No' }}</li>
                            <li>Flammable: {{ $request->package->is_flammable ? 'Yes' : 'No' }}</li>
                            <li>Has Fluid: {{ $request->package->has_fluid ? 'Yes' : 'No' }}</li>
                            @if($request->package->picture)
                                <li><img src="{{ asset('storage/' . $request->package->picture) }}" width="80" alt="Package Picture">
                                </li>
                            @endif
                        </ul>
                    @else
                        <p><em>No package details available</em></p>
                    @endif
                    <p><strong>Takeoff Address:</strong>
                        {{ $request->takeoffAddress->street ?? 'N/A' }},
                        House #: {{ $request->takeoffAddress->house_number ?? 'N/A' }},
                        Building: {{ $request->takeoffAddress->building ?? 'N/A' }},
                        Zip Code: {{ $request->takeoffAddress->zip_code ?? 'N/A' }},
                        Coordinates: {{ $request->takeoffAddress->coordinates ?? 'N/A' }},
                        Floor: {{ $request->takeoffAddress->floor ?? 'N/A' }},
                        Type: {{ $request->takeoffAddress->type ?? 'N/A' }},
                        Region: {{ $request->takeoffAddress->region->name ?? 'N/A' }},
                        Latitude: {{ $request->takeoffAddress->latitude ?? 'N/A' }},
                        Longitude: {{ $request->takeoffAddress->longitude ?? 'N/A' }}
                    </p>

                    <p><strong>Dropoff Address:</strong>
                        {{ $request->dropoffAddress->street ?? 'N/A' }},
                        House #: {{ $request->dropoffAddress->house_number ?? 'N/A' }},
                        Building: {{ $request->dropoffAddress->building ?? 'N/A' }},
                        Zip Code: {{ $request->dropoffAddress->zip_code ?? 'N/A' }},
                        Coordinates: {{ $request->dropoffAddress->coordinates ?? 'N/A' }},
                        Floor: {{ $request->dropoffAddress->floor ?? 'N/A' }},
                        Type: {{ $request->dropoffAddress->type ?? 'N/A' }},
                        Region: {{ $request->dropoffAddress->region->name ?? 'N/A' }},
                        Latitude: {{ $request->dropoffAddress->latitude ?? 'N/A' }},
                        Longitude: {{ $request->dropoffAddress->longitude ?? 'N/A' }}
                    </p>
                    <p><strong>Scheduled At:</strong> {{ $request->scheduled_at ?? 'N/A' }}</p>


                    <a href="{{ route('requests.offers', $request->id) }}" class="btn btn-sm btn-info">View Offers</a>
                    <a href="{{ route('available.drivers', ['regionId' => $request->takeOfAddress->region_id, 'scheduledTime' => $request->scheduled_at]) }}"
                        class="btn btn-sm btn-success">
                        Show Available Drivers
                    </a>

                </div>
            </div>
        @endforeach
    </div>
@endsection