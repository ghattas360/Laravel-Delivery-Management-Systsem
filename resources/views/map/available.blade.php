@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html>
<head>
    <title>Drivers Map (Free)</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />

    <style>
        #map {
            height: 90vh;
            width: 100%;
        }
    </style>
</head>
<body>

<h2 style="text-align:center;">Drivers Available Now</h2>
<div id="map"></div>

<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<script>
    const drivers = @json($drivers);

    // Default center (Beirut)
    const map = L.map('map').setView([33.8938, 35.5018], 11);

    // Load OpenStreetMap tiles (free)
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    // Add driver markers
    drivers.forEach(driver => {
        const lat = parseFloat(driver.latitude);
        const lng = parseFloat(driver.longitude);

        if (!isNaN(lat) && !isNaN(lng)) {
            const marker = L.marker([lat, lng]).addTo(map);

            const popupContent = `
                <strong>${driver.first_name} ${driver.last_name}</strong><br>
                Email: ${driver.email}<br>
               
            `;

            marker.bindPopup(popupContent);
        }
    });
</script>

</body>
</html>
@endsection