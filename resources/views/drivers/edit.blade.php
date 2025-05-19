@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Driver</h1>

    <form action="{{ route('drivers.update', $driver->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div>
            <label>Username:</label>
            <input type="text" name="username" value="{{ $driver->username }}" required>
        </div>

        <div>
            <label>Password:</label>
            <input type="password" name="password">
        </div>

        <div>
            <label>First Name:</label>
            <input type="text" name="first_name" value="{{ $driver->first_name }}" required>
        </div>

        <div>
            <label>Last Name:</label>
            <input type="text" name="last_name" value="{{ $driver->last_name }}" required>
        </div>

        <div>
            <label>Age:</label>
            <input type="number" name="age" value="{{ $driver->age }}">
        </div>

        <div>
            <label>Phone:</label>
            <input type="text" name="phone" value="{{ $driver->phone }}">
        </div>

        <div>
            <label>Email:</label>
            <input type="email" name="email" value="{{ $driver->email }}" required>
        </div>

        <div>
            <label>Driving License:</label>
            <input type="text" name="driving_license" value="{{ $driver->driving_license }}" required>
        </div>

        <div>
            <label>National ID:</label>
            <input type="text" name="national_id" value="{{ $driver->national_id }}" required>
        </div>

        <div>
            <label>Plate Number:</label>
            <input type="text" name="plate_number" value="{{ $driver->plate_number }}" required>
        </div>

        <div>
            <label>Pricing Model:</label>
            <input type="text" name="pricing_model" value="{{ $driver->pricing_model }}" required>
        </div>

        <div>
            <label>Is Active:</label>
            <select name="is_active">
                <option value="1" {{ $driver->is_active ? 'selected' : '' }}>Yes</option>
                <option value="0" {{ !$driver->is_active ? 'selected' : '' }}>No</option>
            </select>
        </div>

        <div>
            <label>User ID:</label>
            <input type="number" name="user_id" value="{{ $driver->user_id }}" required>
        </div>

        <button type="submit">Update Driver</button>
    </form>
</div>
@endsection
