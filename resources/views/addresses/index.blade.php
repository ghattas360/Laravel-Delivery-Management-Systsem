@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Addresses</h2>

    {{-- Create / Edit Form --}}
    @if ($errors->any())
    <div class="alert alert-danger">
        <strong>Whoops!</strong> There were some problems with your input:
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
    <form method="POST" action="{{ isset($editing) ? route('addresses.update', $editing->id) : route('addresses.store') }}">
        @csrf
        @if(isset($editing))
            @method('PUT')
        @endif

        <div class="mb-3">
            <label class="form-label">Street</label>
            <input type="text" name="street" class="form-control" value="{{ old('street', $editing->street ?? '') }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">House Number</label>
            <input type="number" name="house_number" class="form-control" value="{{ old('house_number', $editing->house_number ?? '') }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Zip Code</label>
            <input type="number" name="zip_code" class="form-control" value="{{ old('zip_code', $editing->zip_code ?? '') }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Type</label>
            <input type="text" name="type" class="form-control" value="{{ old('type', $editing->type ?? '') }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Floor</label>
            <input type="number" name="floor" class="form-control" value="{{ old('floor', $editing->floor ?? '') }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Region</label>
            <select name="region_id" class="form-select" required>

                <option value="">-- Select Region --</option>
                @foreach($regions as $region)
                    <option value="{{ $region->id }}" 
                        {{ old('region_id', $editing->region_id ?? '') }}>
                        {{ $region->region_name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="d-flex justify-content-between">
            <button type="submit" class="btn btn-success">
                {{ isset($editing) ? 'Update Address' : 'Add Address' }}
            </button>

            @if(isset($editing))
                <a href="{{ route('addresses.index') }}" class="btn btn-secondary">Cancel</a>
            @endif
        </div>
    </form>

    <hr class="my-4">

    {{-- Existing Addresses --}}
    <h4>Existing Addresses</h4>
    <table class="table table-striped mt-3">
        <thead>
            <tr>
                <th>ID</th>
                <th>Street</th>
                <th>House</th>
                <th>Zip</th>
                <th>Region</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($addresses as $address)
                <tr>
                    <td>{{ $address->id }}</td>
                    <td>{{ $address->street }}</td>
                    <td>{{ $address->house_number }}</td>
                    <td>{{ $address->zip_code }}</td>
                    <td>{{ $address->region->region_name ?? 'N/A' }}</td>

                    <td>
                        <a href="{{ route('addresses.edit', $address->id) }}" class="btn btn-sm btn-primary">Edit</a>
                        <form action="{{ route('addresses.destroy', $address->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
