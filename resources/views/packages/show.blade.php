@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Package Details</h2>
        
        <p><strong>Package ID:</strong> {{ $package->id }}</p>
        <p><strong>From Address:</strong> {{ $package->fromAddress->street }}</p>
        <p><strong>To Address:</strong> {{ $package->toAddress->street }}</p>
        
        <form action="{{ route('deliveries.assign_driver', $package->id) }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="driver_id">Select Driver</label>
                <select name="driver_id" class="form-control">
                    <option value="">Select a driver</option>
                    @foreach ($drivers as $driver)
                        <option value="{{ $driver->driver_id }}">
                            {{ $driver->driver_name }} - {{ number_format($driver->distance, 2) }} km away
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="price">Price</label>
                <input type="number" name="price" class="form-control" step="0.01" required>
            </div>
            <button type="submit" class="btn btn-primary">Assign Driver</button>
        </form>
    </div>
@endsection
