@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Assign Driver to Package #{{ $package->id }}</h2>

        <form method="POST" action="{{ route('deliveries.assignDriver', $package->id) }}">
            @csrf

            <div class="form-group">
                <label for="driver_id">Select Driver:</label>
                <select name="driver_id" class="form-control" required>
                    @foreach ($drivers as $driver)
                        <option value="{{ $driver->driver_id }}">
                            {{ $driver->driver_name }} ({{ number_format($driver->distance, 2) }} km away)
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="price">Delivery Cost (USD):</label>
                <input type="number" step="0.01" name="price" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary mt-2">Assign Driver</button>
        </form>
    </div>
@endsection
