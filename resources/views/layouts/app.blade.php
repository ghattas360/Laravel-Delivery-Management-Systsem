<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Dashboard</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  @yield('styles')
  @yield('styles_Client')
  @yield('Review_styles')

  <style>
    body {
      background-color: #f4f5fa;
    }

/*    .sidebar {
      width: 260px;
      min-height: 100vh;
      background-color: #ffffff;
      padding: 1.5rem 1rem;
      border-right: 1px solid #dee2e6;
    }*/

    .sidebar {
        position: fixed;
        top: 0;
        left: 0;
        width: 260px; /* Adjust based on your layout */
        height: 100vh; /* Full height */
        overflow-y: auto; /* Allows scrolling inside the sidebar if needed */
        background-color: #ffffff;
        padding: 1.5rem 1rem;
        border-right: 1px solid #dee2e6;
    }

    .nav-link {
      color: #212529;
      padding: 0.5rem 1rem;
      border-radius: 0.375rem;
      transition: all 0.3s ease;
    }

    .nav-link:hover,
    .nav-link.active {
      background-color: #e7f1ff;
      color: #0d6efd;
    }

    .sidebar h4 {
      font-weight: bold;
      margin-bottom: 2rem;
      color: #696cff;
    }

    main {
      padding: 2rem;
        margin-left: 260px;
      flex-grow: 1;
    }
  </style>
</head>

<body>
  <div class="d-flex">
    @auth
      @php $user = auth()->user(); @endphp

      @if(auth()->user()->role === 'admin' || auth()->user()->role === 'driver' || auth()->user()->role === 'client')
      <aside class="sidebar">
        <h4>Dashboard</h4>
        <ul class="nav flex-column">

        @if(auth()->user()->role === 'driver')
          @php
        $driver = \App\Models\Driver::where('email', auth()->user()->email)->first();
        @endphp
        <li class="nav-item">
        <a class="nav-link" href="{{ route('driver.availability') }}">My Availability</a>
        <a class="nav-link" href="{{ route('driver.regions') }}">Regions</a>
        <a class="nav-link" href="{{ route('driver.shifts') }}">Shifts</a>
        <a class="nav-link" href="/driver/requests">available requests</a>
        <a class="nav-link" href="/driver/offers">offers you made</a>
        <a class="nav-link" href="/driver/deliveries">deliveries</a>
        <a class="nav-link" href={{ route("driver.reviews", $driver->id) }}>Reviews</a>
        <a class="nav-link">
        <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-danger">Logout</button>
        </form>
        </a>
        </li>
      @endif

        @if(auth()->user()->role === 'client')
        @php
        $client = \App\Models\Client::where('email', auth()->user()->email)->first();
        @endphp
        <li class="nav-item">
        <a class="nav-link" href="#">Addresses</a>
        <a class="nav-link" href="#">Packages</a>
        <a class="nav-link" href="="{{ route("reviews.show", $client->id)}}">Reviews</a>
        <a class="nav-link" href={{ route("client.profile", $client->id) }}>Profile</a>
        <a class="nav-link">
        <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-danger">Logout</button>
        </form>
        </a>
        </li>
      @endif

        @if(auth()->user()->role === 'admin')
        <li class="nav-item">

            <a class="nav-link" href="{{Route("admin.deliveries.index")}}">Deliveries</a>
            <a class="nav-link" href="{{Route("admin.clients.index")}}">Clients</a>
            <a class="nav-link" href="{{Route("admin.driver.performance")}}">Drivers</a>
            <a class="nav-link" href="{{Route("admin.drivers.pending")}}">Approval</a>
            <a class="nav-link" href="{{Route("admin.email.index")}}">Emails</a>
            <a class="nav-link" href="{{Route("admin.drivers.map")}}">MAP</a>
            <br> <br> <br> <br> <br> <br><br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br>
            <a class="nav-link" href="{{Route("admin.profile.edit")}}">Profile</a>
            <a class="nav-link">
                <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-danger">Logout</button>
                </form>
            </a>
        </li>
      @endif

        </ul>
      </aside>
      @endif
  @endauth

    <main>
      @yield('content')
    </main>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  @yield('script')
  @yield('Review_script')
</body>

</html>
