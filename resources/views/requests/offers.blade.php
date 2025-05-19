@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Offers for Request</h2>

    @forelse ($offers as $offer)
        <div class="card mb-3">
            <div class="card-body">
                <p><strong>Driver:</strong> {{ $offer->driver->first_name }} {{ $offer->driver->last_name }}</p>
                <p><strong>Price:</strong> {{ $offer->price }} {{ $offer->currency }}</p>
                <p><strong>Payment Method:</strong> {{ $offer->payment_method }}</p>
                  <form action="{{ route('acceptOffer', $offer->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-success">Accept</button>
                </form>
            </div>
        </div>
    @empty
        <p>No offers yet for this request.</p>
    @endforelse
</div>
@endsection
