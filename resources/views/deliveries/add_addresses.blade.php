
@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Add Pickup and Drop-off Addresses for Package #{{ $package->id }}</h2>

        <form action="{{ route('packages.save_addresses', $package->id) }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="from_address_id">Pickup Address:</label>
                <select name="from_address_id" id="from_address_id" class="form-control">
                    <option value="">Select Pickup Address</option>
                    @foreach($addresses as $address)
                        <option value="{{ $address->id }}" 
                            {{ $package->from_address_id == $address->id ? 'selected' : '' }}>
                            {{ $address->street_address }}, {{ $address->city }}, {{ $address->region }}
                        </option>
                    @endforeach
                </select>
                @error('from_address_id')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="to_address_id">Drop-off Address:</label>
                <select name="to_address_id" id="to_address_id" class="form-control">
                    <option value="">Select Drop-off Address</option>
                    @foreach($addresses as $address)
                        <option value="{{ $address->id }}" 
                            {{ $package->to_address_id == $address->id ? 'selected' : '' }}>
                            {{ $address->street_address }}, {{ $address->city }}, {{ $address->region }}
                        </option>
                    @endforeach
                </select>
                @error('to_address_id')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Save Addresses</button>
        </form>
    </div>
@endsection
