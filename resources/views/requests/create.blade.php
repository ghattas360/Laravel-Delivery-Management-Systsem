@extends('layouts.app')

@section('content')
<div class="container">
    {{-- <pre>
@php dd($addresses); @endphp
</pre> --}}
    <form method="POST" action="{{ route('requests.store') }}" class="p-4 shadow rounded bg-light">
        @csrf
        <input type="hidden" name="package_id" value="{{ $package_id }}">

        <h4 class="mb-4">Send Delivery Request</h4>

        {{-- Show validation errors --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Pick-up address --}}
        <div class="form-group mb-3">
            <label for="takeof_address_id" class="form-label">Pick-up Address</label>
            <select name="takeof_address_id" id="takeof_address_id" class="form-select" required>
                <option value="" disabled {{ old('takeof_address_id') ? '' : 'selected' }}>Select pick-up location</option>
                @foreach($addresses as $address)
                    <option value="{{ $address->id }}" {{ old('takeof_address_id') == $address->id ? 'selected' : '' }}>
                        {{ $address->street }}, Floor {{ $address->floor ?? '-' }}, {{ $address->region->region_name ?? '' }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Drop-off address --}}
        <div class="form-group mb-3">
            <label for="dropof_address_id" class="form-label">Drop-off Address</label>
            <select name="dropof_address_id" id="dropof_address_id" class="form-select" required>
                <option value="" disabled {{ old('dropof_address_id') ? '' : 'selected' }}>Select drop-off location</option>
                @foreach($addresses as $address)
                    <option value="{{ $address->id }}" {{ old('dropof_address_id') == $address->id ? 'selected' : '' }}>
                        {{ $address->street }}, Floor {{ $address->floor ?? '-' }}, {{ $address->region->region_name ?? '' }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Scheduled time --}}
        <div class="form-group mb-4">
            <label for="scheduled_at" class="form-label">Scheduled Time</label>
            <input type="datetime-local" name="scheduled_at" id="scheduled_at" class="form-control"
                   value="{{ old('scheduled_at') }}" required>
        </div>

        <button type="submit" class="btn btn-success w-100">Send Request</button>
    </form>
</div>
@endsection
