{{--
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Client Insights</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap CSS (CDN) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f8f9fa;
            font-family: 'Segoe UI', sans-serif;
        }

        h4 {
            font-weight: bold;
        }

        .table thead th {
            background-color: #343a40;
            color: white;
        }

        .form-label {
            font-weight: 500;
        }

        .container {
            padding-top: 40px;
            padding-bottom: 40px;
        }
    </style>
</head>
<body>

<div class="container">
    <h4 class="mb-4 text-primary text-center">Client Insights</h4>

    <!-- Filter Form -->
    <form method="GET" action="{{ route('admin.clients.index') }}" class="row g-3 mb-4">
        <div class="col-md-3">
            <label for="start_date" class="form-label">Start Date</label>
            <input type="date" name="start_date" id="start_date" class="form-control" value="{{ $start }}">
        </div>
        <div class="col-md-3">
            <label for="end_date" class="form-label">End Date</label>
            <input type="date" name="end_date" id="end_date" class="form-control" value="{{ $end }}">
        </div>
        <div class="col-md-3">
            <label for="sort" class="form-label">Sort By</label>
            <select name="sort" id="sort" class="form-select">
                <option value="">-- No Sorting --</option>
                <option value="deliveries" {{ request('sort') === 'deliveries' ? 'selected' : '' }}>Most Deliveries</option>
                <option value="payments" {{ request('sort') === 'payments' ? 'selected' : '' }}>Top Spenders</option>
            </select>
        </div>
        <div class="col-md-3 d-flex align-items-end">
            <button class="btn btn-primary w-100">Apply</button>
        </div>
    </form>

    <form method="GET" action="{{ route('admin.clients.search') }}" class="row g-3 mb-4 align-items-end">
        <div class="col-md-6">
            <label for="search" class="form-label">Search by Name / Username / Email</label>
            <input type="text" id="search" name="search" placeholder="Type to search..." class="form-control" value="{{ request('search') }}">
        </div>
        <div class="col-md-2">
            <button class="btn btn-outline-primary w-100">🔍 Search</button>
        </div>
        <div class="col-md-2">
            <a href="{{ route('admin.clients.search') }}" class="btn btn-outline-secondary w-100">↩️ Reset</a>
        </div>
    </form>

    <a href="{{ route('admin.clients.exportLoyaltyPDF') }}" class="btn btn-outline-danger mb-4">📄 Export Loyalty PDF</a>


    <!-- Table -->
    <div class="card p-3 shadow-sm">
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-dark">
                <tr>
                    <th>Name</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Deliveries</th>
                    <th>Total Paid ($)</th>
                    <th>Chat</th>
                </tr>
                </thead>
                <tbody>
 --}}
{{--               @forelse($clients as $c)
                    <tr>
                        <td>{{ $c['name'] }}</td>
                        <td>{{ $c['username'] }}</td>
                        <td>{{ $c['email'] }}</td>
                        <td>{{ $c['total_deliveries'] }}</td>
                        <td>${{ number_format($c['total_payment'], 2) }}</td>
                        <td>
                            <a href="{{ route('admin.chat.withClient', $c['id']) }}" class="btn btn-outline-primary btn-sm">
                                💬 Chat
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted">No clients found for the selected date range.</td>
                    </tr>
                @endforelse--}}{{--

                 @foreach($clients as $c)
                     <tr onclick="window.location='{{ route('admin.clients.show', $c['id']) }}';" style="cursor: pointer;">
                         <td>{{ $c['name'] }}</td>
                         <td>{{ $c['username'] }}</td>
                         <td>{{ $c['email'] }}</td>
                         <td>{{ $c['total_deliveries'] }}</td>
                         <td>${{ number_format($c['total_payment'], 2) }}</td>
                         <td>
             --}}
{{--                <a href="{{ route('admin.chat.withClient', $c['id']) }}" class="btn btn-outline-primary btn-sm">
                                 💬 Chat
                             </a>--}}{{--

                             <a href="{{ route('admin.email.index', $c['email']) }}" class="btn btn-outline-primary me-2">📧 Email Client</a>

                         </td>
                     </tr>
                 @endforeach

                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Bootstrap JS (Optional) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
--}}

@extends('layouts.app')

@section('styles')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f8f9fa;
            font-family: 'Segoe UI', sans-serif;
        }

        h4 {
            font-weight: bold;
        }

        .table thead th {
            background-color: #343a40;
            color: white;
        }

        .form-label {
            font-weight: 500;
        }

        .container {
            padding-top: 40px;
            padding-bottom: 40px;
        }
    </style>
@endsection

@section('content')
    <div class="container">
        <h4 class="mb-4 text-primary text-center">Client Insights</h4>

        <!-- Filter Form -->
        <form method="GET" action="{{ route('admin.clients.index') }}" class="row g-3 mb-4">
            <div class="col-md-3">
                <label for="start_date" class="form-label">Start Date</label>
                <input type="date" name="start_date" id="start_date" class="form-control" value="{{ $start }}">
            </div>
            <div class="col-md-3">
                <label for="end_date" class="form-label">End Date</label>
                <input type="date" name="end_date" id="end_date" class="form-control" value="{{ $end }}">
            </div>
            <div class="col-md-3">
                <label for="sort" class="form-label">Sort By</label>
                <select name="sort" id="sort" class="form-select">
                    <option value="">-- No Sorting --</option>
                    <option value="deliveries" {{ request('sort') === 'deliveries' ? 'selected' : '' }}>Most Deliveries</option>
                    <option value="payments" {{ request('sort') === 'payments' ? 'selected' : '' }}>Top Spenders</option>
                </select>
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <button class="btn btn-primary w-100">Apply</button>
            </div>
        </form>

        <form method="GET" action="{{ route('admin.clients.search') }}" class="row g-3 mb-4 align-items-end">
            <div class="col-md-6">
                <label for="search" class="form-label">Search by Name / Username / Email</label>
                <input type="text" id="search" name="search" placeholder="Type to search..." class="form-control" value="{{ request('search') }}">
            </div>
            <div class="col-md-2">
                <button class="btn btn-outline-primary w-100">🔍 Search</button>
            </div>
            <div class="col-md-2">
                <a href="{{ route('admin.clients.search') }}" class="btn btn-outline-secondary w-100">↩️ Reset</a>
            </div>
        </form>

        <a href="{{ route('admin.clients.exportLoyaltyPDF') }}" class="btn btn-outline-danger mb-4">📄 Export Loyalty PDF</a>

        <!-- Table -->
        <div class="card p-3 shadow-sm">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-dark">
                    <tr>
                        <th>Name</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Deliveries</th>
                        <th>Total Paid ($)</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($clients as $c)
                        <tr onclick="window.location='{{ route('admin.clients.show', $c['id']) }}';" style="cursor: pointer;">
                            <td>{{ $c['name'] }}</td>
                            <td>{{ $c['username'] }}</td>
                            <td>{{ $c['email'] }}</td>
                            <td>{{ $c['total_deliveries'] }}</td>
                            <td>${{ number_format($c['total_payment'], 2) }}</td>
                            <td>
                                <a href="{{ route('admin.email.index', $c['email']) }}" class="btn btn-outline-primary me-2">📧 Email Client</a>
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
