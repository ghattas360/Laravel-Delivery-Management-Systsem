{{--
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Client Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container py-5">
    <h2 class="mb-4">Client: {{ $client->first_name }} {{ $client->last_name }}</h2>

    <div class="card p-4 mb-4">
        <h5>Client Info</h5>
        <p><strong>Email:</strong> {{ $client->email }}</p>
        <p><strong>Username:</strong> {{ $client->user_name }}</p>
        <p><strong>Phone:</strong> {{ $client->phone ?? 'N/A' }}</p>
        <p><strong>Premium Level:</strong> {{ $client->premium_level ?? 'None' }}</p>
        <p><strong>Total Deliveries:</strong> {{ $deliveries->count() }}</p>
        <p><strong>Total Paid:</strong> ${{ number_format($totalPayment, 2) }}</p>
        <p><strong>Average Rating:</strong> {{ number_format($averageRating, 2) }}/5 ⭐</p>
    </div>

    <h5 class="mb-3">Deliveries</h5>
    @if($deliveries->isEmpty())
        <p class="text-muted">No deliveries found for this client.</p>
    @else
        <table class="table table-bordered">
            <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Cost</th>
                <th>Created At</th>
                <th>Driver</th>
                <th>Rating</th>
            </tr>
            </thead>
            <tbody>
            @foreach($deliveries as $d)
                <tr onclick="window.location='{{ route('admin.delivery.show', $d->id) }}';" style="cursor: pointer;">

                <td>{{ $d->id }}</td>
                    <td>${{ $d->cost }}</td>
                    <td>{{ $d->created_at->format('Y-m-d H:i') }}</td>
                    <td>{{ $d->driver->first_name ?? 'N/A' }} {{ $d->driver->last_name ?? '' }}</td>
                    <td>
                        @php
                            $review = $d->reviews->first();
                        @endphp
                        {{ $review ? $review->rating . '/5' : 'Not Rated' }}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif


    <a href="{{ route('admin.clients.search') }}" class="btn btn-secondary">⬅ Back to Clients</a>
  --}}{{--

--}}
{{--  <a href="{{ route('admin.clients.map.single', ['client' => $client->id]) }}" class="btn btn-outline-success">📍 Show on Map</a>--}}{{--
--}}
{{--

    <a href="{{ route('admin.email.index', $client['email']) }}" class="btn btn-outline-primary me-2">
        📧 Email Driver
    </a>
    <a href="{{ route('admin.chat.withClient', $client->id) }}" class="btn btn-outline-primary me-2">💬 Chat</a>
</div>
</body>
</html>
--}}{{--

    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Client Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container py-5">
    <h2 class="mb-4">Client: {{ $client->first_name }} {{ $client->last_name }}</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card p-4 mb-4">
        <h5>Client Info</h5>
        <p><strong>Email:</strong> {{ $client->email }}</p>
        <p><strong>Username:</strong> {{ $client->user_name }}</p>
        <p><strong>Phone:</strong> {{ $client->phone ?? 'N/A' }}</p>
        <p><strong>Premium Level:</strong> {{ ucfirst($client->premium_level) ?? 'None' }}</p>
        <p><strong>Cashback Rate:</strong> {{ number_format($client->cashback_rate, 2) }}%</p>
        <p><strong>Total Deliveries:</strong> {{ $deliveries->count() }}</p>
        <p><strong>Total Paid:</strong> ${{ number_format($totalPayment, 2) }}</p>
        <p><strong>Total Cashback Earned:</strong> ${{ number_format(($totalPayment * $client->cashback_rate / 100), 2) }}</p>
        <p><strong>Average Rating:</strong> {{ number_format($averageRating, 2) }}/5 ⭐</p>
    </div>

    <div class="card p-4 mb-4">
        <h5>Update Loyalty Program</h5>
        <form method="POST" action="{{ route('admin.clients.updateLoyalty', $client->id) }}">
            @csrf
            @method('PATCH')
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="premium_level" class="form-label">Premium Level</label>
                    <select name="premium_level" id="premium_level" class="form-select">
                        <option value="bronze" {{ $client->premium_level === 'bronze' ? 'selected' : '' }}>Bronze</option>
                        <option value="silver" {{ $client->premium_level === 'silver' ? 'selected' : '' }}>Silver</option>
                        <option value="gold" {{ $client->premium_level === 'gold' ? 'selected' : '' }}>Gold</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="cashback_rate" class="form-label">Cashback Rate (%)</label>
                    <input type="number" step="0.01" name="cashback_rate" id="cashback_rate" class="form-control" value="{{ old('cashback_rate', $client->cashback_rate) }}">
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Update Loyalty Info</button>
        </form>
    </div>

    <h5 class="mb-3">Deliveries</h5>
    @if($deliveries->isEmpty())
        <p class="text-muted">No deliveries found for this client.</p>
    @else
        <table class="table table-bordered">
            <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Cost</th>
                <th>Created At</th>
                <th>Driver</th>
                <th>Rating</th>
            </tr>
            </thead>
            <tbody>
            @foreach($deliveries as $d)
                <tr onclick="window.location='{{ route('admin.delivery.show', $d->id) }}';" style="cursor: pointer;">
                    <td>{{ $d->id }}</td>
                    <td>${{ $d->cost }}</td>
                    <td>{{ $d->created_at->format('Y-m-d H:i') }}</td>
                    <td>{{ $d->driver->first_name ?? 'N/A' }} {{ $d->driver->last_name ?? '' }}</td>
                    <td>
                        @php $review = $d->reviews->first(); @endphp
                        {{ $review ? $review->rating . '/5' : 'Not Rated' }}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif

    <a href="{{ route('admin.clients.search') }}" class="btn btn-secondary">⬅ Back to Clients</a>
    <a href="{{ route('admin.email.index', $client['email']) }}" class="btn btn-outline-primary me-2">📧 Email Client</a>
--}}
{{--
    <a href="{{ route('admin.chat.withClient', $client->id) }}" class="btn btn-outline-primary me-2">💬 Chat</a>
--}}{{--

</div>
</body>
</html>
--}}
@extends('layouts.app')

@section('styles')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
@endsection

@section('content')
    <div class="container py-5">
        <h2 class="mb-4">Client: {{ $client->first_name }} {{ $client->last_name }}</h2>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card p-4 mb-4">
            <h5>Client Info</h5>
            <p><strong>Email:</strong> {{ $client->email }}</p>
            <p><strong>Username:</strong> {{ $client->user_name }}</p>
            <p><strong>Phone:</strong> {{ $client->phone ?? 'N/A' }}</p>
            <p><strong>Premium Level:</strong> {{ ucfirst($client->premium_level) ?? 'None' }}</p>
            <p><strong>Cashback Rate:</strong> {{ number_format($client->cashback_rate, 2) }}%</p>
            <p><strong>Total Deliveries:</strong> {{ $deliveries->count() }}</p>
            <p><strong>Total Paid:</strong> ${{ number_format($totalPayment, 2) }}</p>
            <p><strong>Total Cashback Earned:</strong> ${{ number_format(($totalPayment * $client->cashback_rate / 100), 2) }}</p>
            <p><strong>Average Rating:</strong> {{ number_format($averageRating, 2) }}/5 ⭐</p>
        </div>

        <div class="card p-4 mb-4">
            <h5>Update Loyalty Program</h5>
            <form method="POST" action="{{ route('admin.clients.updateLoyalty', $client->id) }}">
                @csrf
                @method('PATCH')
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="premium_level" class="form-label">Premium Level</label>
                        <select name="premium_level" id="premium_level" class="form-select">
                            <option value="bronze" {{ $client->premium_level === 'bronze' ? 'selected' : '' }}>Bronze</option>
                            <option value="silver" {{ $client->premium_level === 'silver' ? 'selected' : '' }}>Silver</option>
                            <option value="gold" {{ $client->premium_level === 'gold' ? 'selected' : '' }}>Gold</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="cashback_rate" class="form-label">Cashback Rate (%)</label>
                        <input type="number" step="0.01" name="cashback_rate" id="cashback_rate" class="form-control" value="{{ old('cashback_rate', $client->cashback_rate) }}">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Update Loyalty Info</button>
            </form>
        </div>

        <h5 class="mb-3">Deliveries</h5>
        @if($deliveries->isEmpty())
            <p class="text-muted">No deliveries found for this client.</p>
        @else
            <table class="table table-bordered">
                <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Cost</th>
                    <th>Created At</th>
                    <th>Driver</th>
                    <th>Rating</th>
                </tr>
                </thead>
                <tbody>
                @foreach($deliveries as $d)
                    <tr onclick="window.location='{{ route('admin.delivery.show', $d->id) }}';" style="cursor: pointer;">
                        <td>{{ $d->id }}</td>
                        <td>${{ $d->cost }}</td>
                        <td>{{ $d->created_at->format('Y-m-d H:i') }}</td>
                        <td>{{ $d->driver->first_name ?? 'N/A' }} {{ $d->driver->last_name ?? '' }}</td>
                        <td>
                            @php $review = $d->reviews->first(); @endphp
                            {{ $review ? $review->rating . '/5' : 'Not Rated' }}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif

        <a href="{{ route('admin.clients.search') }}" class="btn btn-secondary">⬅ Back to Clients</a>
        <a href="{{ route('admin.email.index', $client['email']) }}" class="btn btn-outline-primary me-2">📧 Email Client</a>
    </div>
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@endsection
