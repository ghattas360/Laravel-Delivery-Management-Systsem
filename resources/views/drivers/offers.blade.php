@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Your Delivery Offers</h2>

    @if ($offers->isEmpty())
        <p>You have not submitted any offers yet.</p>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Offer ID</th>
                    <th>Request ID</th>
                    <th>Price</th>
                    <th>Currency</th>
                    <th>Payment Method</th>
                    <th>Submitted At</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($offers as $offer)
                    <tr>
                        <td>{{ $offer->id }}</td>
                        <td>{{ $offer->request_id }}</td>
                        <td>{{ $offer->price }}</td>
                        <td>{{ strtoupper($offer->currency) }}</td>
                        <td>{{ ucfirst(str_replace('_', ' ', $offer->payment_method)) }}</td>
                        <td>{{ $offer->created_at->format('Y-m-d H:i') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection