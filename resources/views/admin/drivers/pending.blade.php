{{--
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Pending Driver Approvals</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom Styles -->
    <style>
        body {
            background: linear-gradient(135deg, #f0f4f8, #d9e2ec);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .card {
            backdrop-filter: blur(10px);
            background-color: rgba(255, 255, 255, 0.75);
            border: none;
            border-radius: 1rem;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        }

        .card h4 {
            font-weight: bold;
            color: #1f2937;
        }

        .btn-approve {
            background-color: #10b981;
            color: #fff;
        }

        .btn-reject {
            background-color: #ef4444;
            color: #fff;
        }

        .btn-approve:hover {
            background-color: #059669;
        }

        .btn-reject:hover {
            background-color: #dc2626;
        }

        .img-thumbnail {
            border-radius: 0.5rem;
        }

        .alert {
            border-radius: 0.5rem;
        }
    </style>
</head>
<body>
<div class="container py-5">
    <h2 class="mb-4 text-center text-primary">Pending Driver Approvals</h2>

    <!-- Flash Messages -->
    @if(session('success'))
        <div class="alert alert-success mt-2">{{ session('success') }}</div>
    @endif

    @if(session('danger'))
        <div class="alert alert-danger mt-2">{{ session('danger') }}</div>
    @endif

    @foreach ($drivers as $driver)
        <div class="card p-4 mb-4">
            <div class="row">
                <div class="col-md-6">
                    <h4>{{ $driver->first_name }} ({{ $driver->username }})</h4>
                    <p><strong>Email:</strong> {{ $driver->email }}</p>
                    <p><strong>Phone:</strong> {{ $driver->phone }}</p>
                    <p><strong>Plate Number:</strong> {{ $driver->plate_number }}</p>
                    <p><strong>Pricing Model:</strong> {{ ucfirst(str_replace('_', ' ', $driver->pricing_model)) }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Driving License:</strong></p>
                    <img src="{{ asset($driver->path1) }}" class="img-thumbnail mb-2" width="200">

                    <p><strong>National ID:</strong></p>
                    <img src="{{ asset($driver->path2) }}" class="img-thumbnail" width="200">
                </div>
            </div>

            <div class="mt-3 text-end">
                <form method="POST" action="{{ route('admin.drivers.approve', $driver->id) }}" class="d-inline">
                    @csrf
                    <button class="btn btn-approve">✅ Approve</button>
                </form>

                <form method="POST" action="{{ route('admin.drivers.reject', $driver->id) }}" class="d-inline ms-2">
                    @csrf
                    <button class="btn btn-reject">❌ Reject</button>
                </form>
            </div>
        </div>
    @endforeach
</div>

<!-- Bootstrap JS -->
--}}{{--

--}}
{{--
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
--}}{{--
--}}
{{--

<script src="{{ asset('https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js') }}"></script>

</body>
</html>
--}}{{--


    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Pending Driver Approvals</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap 5 -->
    <link href="{{ asset('https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css') }}" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #f0f4f8, #d9e2ec);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .card {
            backdrop-filter: blur(10px);
            background-color: rgba(255, 255, 255, 0.75);
            border: none;
            border-radius: 1rem;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        }
        .btn-approve {
            background-color: #10b981;
            color: #fff;
        }
        .btn-reject {
            background-color: #ef4444;
            color: #fff;
        }
        .btn-approve:hover {
            background-color: #059669;
        }
        .btn-reject:hover {
            background-color: #dc2626;
        }
        .img-thumbnail {
            border-radius: 0.5rem;
        }
        .filter-bar {
            background-color: rgba(255, 255, 255, 0.7);
            border-radius: 1rem;
            padding: 1rem 2rem;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }
    </style>
</head>
<body>
<div class="container py-5">

    <h2 class="mb-4 text-center text-primary">Pending Driver Approvals</h2>

    <!-- Flash Messages -->
    @if(session('success'))
        <div class="alert alert-success mt-2">{{ session('success') }}</div>
    @endif
    @if(session('danger'))
        <div class="alert alert-danger mt-2">{{ session('danger') }}</div>
    @endif

    <!-- Search and Filter -->
    <form method="GET" action="{{ route('admin.drivers.pending') }}" class="filter-bar mb-4 d-flex flex-wrap justify-content-between align-items-center gap-3">
        <div class="col-md-6">
            <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Search by name or email">
        </div>

        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="today" id="today" value="1" {{ request('today') ? 'checked' : '' }}>
            <label class="form-check-label" for="today">
                Show today's submissions only
            </label>
        </div>

        <div class="d-flex flex-wrap gap-2">
            <button class="btn btn-primary btn-sm">Filter</button>
            <a href="{{ route('admin.drivers.pending') }}" class="btn btn-secondary btn-sm">Reset</a>
            <a href="{{ route('admin.drivers.export.excel') }}" class="btn btn-outline-success btn-sm">📥 Excel</a>
            <a href="{{ route('admin.drivers.export.pdf') }}" class="btn btn-outline-danger btn-sm">📄 PDF</a>
        </div>
--}}
{{--        <div class="mb-4 text-end">
            <a href="{{ route('admin.drivers.export.excel') }}" class="btn btn-outline-success me-2">📥 Export Excel</a>
            <a href="{{ route('admin.drivers.export.pdf') }}" class="btn btn-outline-danger">📄 Export PDF</a>
        </div>--}}{{--

    </form>

    <!-- Driver Cards -->
    @if($drivers->isEmpty())
        <div class="alert alert-info text-center">There are no drivers pending approval.</div>
    @endif

    @foreach ($drivers as $driver)
        <div class="card p-4 mb-4">
            <div class="row">
                <div class="col-md-6">
                    <h4>{{ $driver->first_name }} ({{ $driver->username }})</h4>
                    <p><strong>Email:</strong> {{ $driver->email }}</p>
                    <p><strong>Phone:</strong> {{ $driver->phone }}</p>
                    <p><strong>Plate Number:</strong> {{ $driver->plate_number }}</p>
                    <p><strong>Pricing Model:</strong> {{ ucfirst(str_replace('_', ' ', $driver->pricing_model)) }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Driving License:</strong></p>
                    <img src="{{ asset($driver->path1) }}" class="img-thumbnail mb-2" width="200">

                    <p><strong>National ID:</strong></p>
                    <img src="{{ asset($driver->path2) }}" class="img-thumbnail" width="200">
                </div>
            </div>

            <div class="mt-3 text-end">
                <form method="POST" action="{{ route('admin.drivers.approve', $driver->id) }}" class="d-inline">
                    @csrf
                    <button class="btn btn-approve">Approve</button>
                </form>

                <form method="POST" action="{{ route('admin.drivers.reject', $driver->id) }}" class="d-inline ms-2">
                    @csrf
                    <button class="btn btn-reject">Reject</button>
                </form>
            </div>
        </div>
    @endforeach

    <!-- Pagination -->
    <div class="mt-4">
        {{ $drivers->withQueryString()->links('pagination::bootstrap-5') }}
    </div>
</div>

<!-- Bootstrap JS -->
<script src="{{ asset('https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
--}}

@extends('layouts.app')

@section('styles')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #f0f4f8, #d9e2ec);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .card {
            backdrop-filter: blur(10px);
            background-color: rgba(255, 255, 255, 0.75);
            border: none;
            border-radius: 1rem;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        }
        .btn-approve {
            background-color: #10b981;
            color: #fff;
        }
        .btn-reject {
            background-color: #ef4444;
            color: #fff;
        }
        .btn-approve:hover {
            background-color: #059669;
        }
        .btn-reject:hover {
            background-color: #dc2626;
        }
        .img-thumbnail {
            border-radius: 0.5rem;
        }
        .filter-bar {
            background-color: rgba(255, 255, 255, 0.7);
            border-radius: 1rem;
            padding: 1rem 2rem;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }
    </style>
@endsection

@section('content')
    <div class="container py-5">
        <h2 class="mb-4 text-center text-primary">Pending Driver Approvals</h2>

        <!-- Flash Messages -->
        @if(session('success'))
            <div class="alert alert-success mt-2">{{ session('success') }}</div>
        @endif
        @if(session('danger'))
            <div class="alert alert-danger mt-2">{{ session('danger') }}</div>
        @endif

        <!-- Search and Filter -->
        <form method="GET" action="{{ route('admin.drivers.pending') }}" class="filter-bar mb-4 d-flex flex-wrap justify-content-between align-items-center gap-3">
            <div class="col-md-6">
                <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Search by name or email">
            </div>

            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="today" id="today" value="1" {{ request('today') ? 'checked' : '' }}>
                <label class="form-check-label" for="today">
                    Show today's submissions only
                </label>
            </div>

            <div class="d-flex flex-wrap gap-2">
                <button class="btn btn-primary btn-sm">Filter</button>
                <a href="{{ route('admin.drivers.pending') }}" class="btn btn-secondary btn-sm">Reset</a>
                <a href="{{ route('admin.drivers.export.excel') }}" class="btn btn-outline-success btn-sm">📥 Excel</a>
                <a href="{{ route('admin.drivers.export.pdf') }}" class="btn btn-outline-danger btn-sm">📄 PDF</a>
            </div>
        </form>

        <!-- Driver Cards -->
        @if($drivers->isEmpty())
            <div class="alert alert-info text-center">There are no drivers pending approval.</div>
        @endif

        @foreach ($drivers as $driver)
            <div class="card p-4 mb-4">
                <div class="row">
                    <div class="col-md-6">
                        <h4>{{ $driver->first_name }} ({{ $driver->username }})</h4>
                        <p><strong>Email:</strong> {{ $driver->email }}</p>
                        <p><strong>Phone:</strong> {{ $driver->phone }}</p>
                        <p><strong>Plate Number:</strong> {{ $driver->plate_number }}</p>
                        <p><strong>Pricing Model:</strong> {{ ucfirst(str_replace('_', ' ', $driver->pricing_model)) }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Driving License:</strong></p>
                        <img src="{{ asset($driver->path1) }}" class="img-thumbnail mb-2" width="200">

                        <p><strong>National ID:</strong></p>
                        <img src="{{ asset($driver->path2) }}" class="img-thumbnail" width="200">
                    </div>
                </div>

                <div class="mt-3 text-end">
                    <form method="POST" action="{{ route('admin.drivers.approve', $driver->id) }}" class="d-inline">
                        @csrf
                        <button class="btn btn-approve">Approve</button>
                    </form>

                    <form method="POST" action="{{ route('admin.drivers.reject', $driver->id) }}" class="d-inline ms-2">
                        @csrf
                        <button class="btn btn-reject">Reject</button>
                    </form>
                </div>
            </div>
        @endforeach

        <!-- Pagination -->
        <div class="mt-4">
            {{ $drivers->withQueryString()->links('pagination::bootstrap-5') }}
        </div>
    </div>
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@endsection
