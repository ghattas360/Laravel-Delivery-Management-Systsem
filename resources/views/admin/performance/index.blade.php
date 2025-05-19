{{--
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Driver Performance</title>
    <link href="{{ asset('https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <style>
        body {
            background: #f4f6f9;
            font-family: 'Segoe UI', sans-serif;
        }

        .card {
            border-radius: 1rem;
            box-shadow: 0 8px 16px rgba(0,0,0,0.05);
        }

        .table thead th {
            background-color: #1f2937;
            color: #fff;
        }
    </style>
</head>
<body>
<div class="container py-5">
    <h2 class="mb-4 text-center text-primary">Driver Performance Dashboard</h2>

    <form method="GET" action="{{ route('admin.driver.performance') }}" class="mb-4 row g-3 align-items-end">
        <div class="col-md-3">
            <label for="start_date" class="form-label">From:</label>
            <input type="date" id="start_date" name="start_date" class="form-control" value="{{ $startDate }}">
        </div>

        <div class="col-md-3">
            <label for="end_date" class="form-label">To:</label>
            <input type="date" id="end_date" name="end_date" class="form-control" value="{{ $endDate }}">
        </div>

        <div class="col-md-3">
            <label for="sort" class="form-label">Sort By:</label>
            <select name="sort" class="form-select">
                <option value="">-- No Sorting --</option>
                <option value="earnings" {{ request('sort') === 'earnings' ? 'selected' : '' }}>Highest Earnings</option>
                <option value="rating" {{ request('sort') === 'rating' ? 'selected' : '' }}>Highest Rating</option>
            </select>
        </div>

        <div class="col-md-3 d-flex gap-2">
            <button class="btn btn-primary btn-sm w-100">Apply</button>
            <a href="{{ route('admin.driver.performance') }}" class="btn btn-outline-secondary btn-sm">Reset</a>
        </div>
    </form>

    <form action="{{ route('admin.driver.performance.search') }}" method="GET" class="mb-4 row g-3 align-items-end">
        @csrf
        <div class="col-md-4">
            <label for="q" class="form-label">Search by Name</label>
            <input type="text" id="q" name="q" class="form-control" value="{{ request('q') }}" placeholder="Driver name...">
        </div>
        <div class="col-md-2">
            <button class="btn btn-outline-primary w-100">Search</button>
            --}}
{{--<input type="submit" value="submit" class="d-none">--}}{{--

        </div>
    </form>

    <h5 class="text-info mb-4">
        💰 Total Commission Earned (15%): <strong>${{ number_format($totalCommission, 2) }}</strong>
    </h5>

    <h5 class="text-success mb-3">Top 5 Drivers This Week</h5>
    <ul class="list-group mb-4">
        @foreach ($topDrivers as $d)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                {{ $d['name'] }} ({{ $d['total_deliveries'] }} deliveries, ${{ number_format($d['total_earnings'], 2) }}, {{ $d['average_rating'] }}/5 ⭐)
            </li>
        @endforeach
    </ul>



    <div class="card p-4">
        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Plate Number</th>
                    <th>Total Deliveries</th>
                    <th>Total Earnings ($)</th>
                    <th>Average Rating ⭐</th>
                    <th>Last Delivery</th>
                    <th>Chat</th>
                </tr>
                </thead>
                <tbody>
                @foreach($drivers as $driver)
                    <tr onclick="window.location='{{ route('admin.driver.performance.show', $driver['id']) }}';" style="cursor: pointer;">
                        <td>{{ $driver['name'] }}</td>
                        <td>{{ $driver['email'] }}</td>
                        <td>{{ $driver['plate_number'] }}</td>
                        <td>{{ $driver['total_deliveries'] }}</td>
                        <td>${{ number_format($driver['total_earnings'], 2) }}</td>
                        <td>{{ $driver['average_rating'] }}/5</td>
                        <td>{{ $driver['last_delivery'] ? \Carbon\Carbon::parse($driver['last_delivery'])->format('Y-m-d H:i') : 'N/A' }}</td>
                        <td>
                 --}}
{{--           <a href="{{ route('admin.chat.withDriver', ['driverId' => $driver['id']]) }}" class="btn btn-outline-primary">
                                💬 Chat with {{ $driver['name'] }}
                            </a>--}}{{--

                            <a href="{{ route('admin.email.index', $driver['email']) }}" class="btn btn-outline-primary me-2">📧 Email Driver</a>

                        </td>


                    </tr>

                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>
--}}
@extends('layouts.app')

@section('styles')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f4f6f9;
            font-family: 'Segoe UI', sans-serif;
        }

        .card {
            border-radius: 1rem;
            box-shadow: 0 8px 16px rgba(0,0,0,0.05);
        }

        .table thead th {
            background-color: #1f2937;
            color: #fff;
        }
    </style>
@endsection

@section('content')
    <div class="container py-5">
        <h2 class="mb-4 text-center text-primary">Driver Performance Dashboard</h2>

        <!-- Filter Form -->
        <form method="GET" action="{{ route('admin.driver.performance') }}" class="mb-4 row g-3 align-items-end">
            <div class="col-md-3">
                <label for="start_date" class="form-label">From:</label>
                <input type="date" id="start_date" name="start_date" class="form-control" value="{{ $startDate }}">
            </div>

            <div class="col-md-3">
                <label for="end_date" class="form-label">To:</label>
                <input type="date" id="end_date" name="end_date" class="form-control" value="{{ $endDate }}">
            </div>

            <div class="col-md-3">
                <label for="sort" class="form-label">Sort By:</label>
                <select name="sort" class="form-select">
                    <option value="">-- No Sorting --</option>
                    <option value="earnings" {{ request('sort') === 'earnings' ? 'selected' : '' }}>Highest Earnings</option>
                    <option value="rating" {{ request('sort') === 'rating' ? 'selected' : '' }}>Highest Rating</option>
                </select>
            </div>

            <div class="col-md-3 d-flex gap-2">
                <button class="btn btn-primary btn-sm w-100">Apply</button>
                <a href="{{ route('admin.driver.performance') }}" class="btn btn-outline-secondary btn-sm">Reset</a>
            </div>
        </form>

        <h5 class="text-info mb-4">
            💰 Total Commission Earned (15%): <strong>${{ number_format($totalCommission, 2) }}</strong>
        </h5>

        <h5 class="text-success mb-3">Top 5 Drivers This Week</h5>
        <ul class="list-group mb-4">
            @foreach ($topDrivers as $d)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    {{ $d['name'] }} ({{ $d['total_deliveries'] }} deliveries, ${{ number_format($d['total_earnings'], 2) }}, {{ $d['average_rating'] }}/5 ⭐)
                </li>
            @endforeach
        </ul>

        <div class="card p-4">
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Plate Number</th>
                        <th>Total Deliveries</th>
                        <th>Total Earnings ($)</th>
                        <th>Average Rating ⭐</th>
                        <th>Last Delivery</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($drivers as $driver)
                        <tr onclick="window.location='{{ route('admin.driver.performance.show', $driver['id']) }}';" style="cursor: pointer;">
                            <td>{{ $driver['name'] }}</td>
                            <td>{{ $driver['email'] }}</td>
                            <td>{{ $driver['plate_number'] }}</td>
                            <td>{{ $driver['total_deliveries'] }}</td>
                            <td>${{ number_format($driver['total_earnings'], 2) }}</td>
                            <td>{{ $driver['average_rating'] }}/5</td>
                            <td>{{ $driver['last_delivery'] ? \Carbon\Carbon::parse($driver['last_delivery'])->format('Y-m-d H:i') : 'N/A' }}</td>
                            <td>
                                <a href="{{ route('admin.email.index', $driver['email']) }}" class="btn btn-outline-primary me-2">📧 Email Driver</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@endsection
