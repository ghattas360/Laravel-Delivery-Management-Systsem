@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>All Deliveries</h2>

        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Driver</th>
                    <th>Package</th>
                    <th>Status</th>
                    <th>Cost</th>
                    <th>Scheduled At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($deliveries as $delivery)
                    <tr>
                        <td>{{ $delivery->id }}</td>
                        <td>{{ $delivery->driver->name }}</td>
                        <td>{{ $delivery->package->name }}</td>
                        <td>{{ $delivery->status }}</td>
                        <td>{{ $delivery->cost }} USD</td>
                        <td>{{ $delivery->scheduled_at }}</td>
                        <td>
                            <a href="{{ route('deliveries.show', $delivery->id) }}" class="btn btn-info">View</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
