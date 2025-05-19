@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Submit Offer for Request #{{ $request->id }}</h2>

    <form action="{{ route('driver.offers.create') }}" method="POST">
        @csrf

        <!-- Hidden input for request ID -->
        <input type="hidden" name="request_id" value="{{ $request->id }}">

        <div class="mb-3">
            <label>Price:</label>
            <input type="number" step="0.01" name="price" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Currency:</label>
            <input type="text" name="currency" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Payment Method:</label>
            <select name="payment_method" class="form-select" required>
                <option value="cash_on_delivery">Cash on Delivery</option>
                <option value="visa">Visa</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Send Offer</button>
    </form>
</div>
@endsection