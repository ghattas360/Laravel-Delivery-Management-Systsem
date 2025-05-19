<!-- resources/views/deliveries/driver.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Your Deliveries</h2>

    @if ($deliveries->isEmpty())
        <p>You have no deliveries assigned.</p>
    @else
        @foreach ($deliveries as $delivery)
            <div class="card mb-3">
                <div class="card-body">
                    <p><strong>Package:</strong> {{ $delivery->package->name }}</p>
                    <p><strong>Status:</strong> {{ $delivery->status }}</p>
                    <p><strong>Takeoff Address:</strong> {{ $delivery->takeOffAddress->address }}</p>
                    <p><strong>Dropoff Address:</strong> {{ $delivery->dropOffAddress->address }}</p>
                    <p><strong>Cost:</strong> {{ $delivery->cost }} {{ $delivery->currency }}</p>
                    <p><strong>Scheduled at:</strong> {{ $delivery->scheduled_at }}</p>
                    
                    <!-- Form to update delivery status -->
                    <form action="{{ route('driver.updateStatus', $delivery->id) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="status">Update Status</label>
                            <select name="status" id="status" class="form-control">
                                 <option value="paid_awaiting_delivery" {{ $delivery->status == 'paid_awaiting_delivery' ? 'selected' : '' }}>Paid, Awaiting Delivery</option>
    <option value="pending" {{ $delivery->status == 'pending' ? 'selected' : '' }}>Pending</option>
    <option value="on_my_way_to_pickup" {{ $delivery->status == 'on_my_way_to_pickup' ? 'selected' : '' }}>On My Way to Pickup</option>
    <option value="on_my_way_to_dropoff" {{ $delivery->status == 'on_my_way_to_dropoff' ? 'selected' : '' }}>On My Way to Dropoff</option>
   
    <option value="completed" {{ $delivery->status == 'completed' ? 'selected' : '' }}>Completed</option>
    <option value="cancelled" {{ $delivery->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
</select>

                        </div>
                        <button type="submit" class="btn btn-primary mt-3">Update Status</button>
                    </form>
                </div>
            </div>
        @endforeach
    @endif
</div>
@endsection