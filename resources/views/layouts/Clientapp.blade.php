<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Client Dashboard</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons (for dropdown arrows etc.) -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    body {
      background-color: #f4f5fa;
    }

    .profile {
      display: flex;
      justify-content: center;
      align-items: center;
      margin-bottom: 1rem;
    }
    .profile img {
      width: 120px;
      height: 120px;
      object-fit: cover;
      border-radius: 50%;
      border: 4px solid white;
    }

    .sidebar {
      width: 260px;
      min-height: 100vh;
      background-color: #ffffff;
      padding: 1.5rem 1rem;
      border-right: 1px solid #dee2e6;
    }

    .nav-link {
      color: #212529;
      font-size: 0.95rem;
      padding: 0.5rem 1rem;
      border-radius: 0.375rem;
    }

    .nav-link:hover, .nav-link.active {
      background-color: #e7f1ff;
      color: #0d6efd;
    }

    .sidebar h4 {
      font-weight: bold;
      margin-bottom: 2rem;
      color: #696cff;
      text-align: center;
    }

    .submenu {
      padding-left: 1.5rem;
    }

    .nav-item .collapse .nav-link {
      font-size: 0.9rem;
    }

    .nav-link.active {
  background-color: #e7e7ff;
  color: #696cff;
  font-weight: 600;
  box-shadow: inset 4px 0 0 0 #696cff;
}

  </style>
</head>
<body>

<div class="d-flex">
  <!-- Sidebar -->
  <aside class="sidebar">
    <div class="profile">
      <img src="{{ asset('images/default-avatar.jpg') }}" alt="Client Profile">
    </div>
    <h4>{{ $client->first_name }}'s Dashboard</h4>

    <ul class="nav flex-column">

      <!-- Profile -->
      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('client.profile') ? 'active' : '' }}" href="{{ route('client.profile', $client->id) }}">
          My Profile
        </a>      
      </li>
    
      <!-- Drivers -->
      <li class="nav-item mt-2">
        <a class="nav-link d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#driversSubMenu" role="button" aria-expanded="false" aria-controls="driversSubMenu">
          Drivers <i class="bi bi-chevron-down small"></i>
        </a>
        <div class="collapse submenu" id="driversSubMenu">
          <a class="nav-link" href="{{ route('client.drivers.availability') }}">Availability</a>
          <a class="nav-link" href="{{ route('client.drivers.regions') }}">Regions</a>
          <a class="nav-link" href="{{ route('client.drivers.shifts') }}">Shifts</a>
          <a class="nav-link" href="{{ route('client.drivers.payments') }}">Payments</a>
        </div>
      </li>
    
      <!-- Settings -->
      <li class="nav-item mt-2">
        <a class="nav-link" href="{{ route('client.settings') }}">Settings</a>
      </li>
    </ul>
    
  </aside>

  <!-- Main Content -->
  <main class="flex-fill p-4">
    @yield('content')
  </main>
</div>

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')

</body>
</html>
