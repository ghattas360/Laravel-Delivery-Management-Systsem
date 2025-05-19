{{--<!DOCTYPE html>
<html>
<head>
    <title>Driver Locations Map</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        html, body {
            height: 100%;
            margin: 0;
        }

        #map {
            height: 90vh;
            width: 100%;
        }

        h2 {
            text-align: center;
            margin-top: 20px;
            font-family: Arial, sans-serif;
        }
    </style>
</head>
<body>

<h2>📍 Active Driver Map</h2>

<div style="text-align: center; margin-top: 20px;">
    <label for="driverFilter" style="font-weight: bold;">Filter Drivers:</label>
    <select id="driverFilter" class="form-select d-inline w-auto ms-2" onchange="filterMarkers()">
        <option value="all">All</option>
        <option value="available">Available Now</option>
        <option value="delivering">Currently Delivering</option>
    </select>
</div>

<div id="map"></div>


<script>
    let markers = [];
    let directionsService;
    let directionsRenderer;
    let map;

    function initMap() {
        directionsService = new google.maps.DirectionsService();
        directionsRenderer = new google.maps.DirectionsRenderer({ suppressMarkers: true });

        map = new google.maps.Map(document.getElementById('map'), {
            zoom: 10,
            center: { lat: 33.8938, lng: 35.5018 },
        });

        directionsRenderer.setMap(map);

        const drivers = @json($drivers);
        window.markers = [];

        drivers.forEach(driver => {
            const marker = new google.maps.Marker({
                position: {
                    lat: parseFloat(driver.latitude),
                    lng: parseFloat(driver.longitude)
                },
                map: map,
                label: driver.first_name.charAt(0),
                title: driver.first_name + ' ' + driver.last_name,
            });

            const infoWindow = new google.maps.InfoWindow({
                content: `
<div class="card shadow-sm" style="min-width: 250px;">

            <div class="card-body p-3">
                <h5 class="card-title mb-1">${driver.first_name} ${driver.last_name}</h5>
                <p class="card-subtitle text-muted mb-2" style="font-size: 0.9em;">${driver.email}</p>

                <span class="badge bg-primary mb-2">${driver.pricing_model.replace('_', ' ').toUpperCase()}</span><br>
                <span class="text-muted mb-3 d-block">🕒 <strong>Shift:</strong> ${driver.shift_today_start || 'N/A'} - ${driver.shift_today_end || 'N/A'}</span>

                <div class="d-flex justify-content-between mt-3">
                    <a href="#" onclick="drawRoute(${Number(driver.pickup_lat) || 0}, ${Number(driver.pickup_lng) || 0}, ${Number(driver.dropoff_lat) || 0}, ${Number(driver.dropoff_lng) || 0}); return false;" class="btn btn-sm btn-outline-primary">🗺️ Route</a>
                    <a href="/admin/driver-performance/${driver.id}" target="_blank" class="btn btn-sm btn-primary">🔍 Profile</a>
                </div>
            </div>
        </div>
    `
            });



            marker.addListener('click', () => {
                infoWindow.open(map, marker);
            });

            marker.driverStatus = {
                available: driver.is_available_now,
                delivering: driver.is_delivering
            };

            markers.push(marker);
        });
    }

    function drawRoute(pickupLat, pickupLng, dropoffLat, dropoffLng) {
        const request = {
            origin: { lat: pickupLat, lng: pickupLng },
            destination: { lat: dropoffLat, lng: dropoffLng },
            travelMode: 'DRIVING',
        };

        if (directionsService && directionsRenderer) {
            directionsService.route(request, (result, status) => {
                if (status === 'OK') {
                    directionsRenderer.setDirections(result);
                } else {
                    alert("Unable to draw route: " + status);
                }
            });
        } else {
            alert("Map has not initialized yet.");
        }
    }

    function filterMarkers() {
        const filter = document.getElementById('driverFilter').value;

        markers.forEach(marker => {
            const isAvailable = marker.driverStatus.available;
            const isDelivering = marker.driverStatus.delivering;

            if (filter === 'all') {
                marker.setMap(map);
            } else if (filter === 'available') {
                marker.setMap(isAvailable ? map : null);
            } else if (filter === 'delivering') {
                marker.setMap(isDelivering ? map : null);
            }
        });
    }

    let shiftLabel = '';

    if (driver.shift_today_start && driver.shift_today_end) {
        shiftLabel = `Today: ${driver.shift_today_start} - ${driver.shift_today_end}`;
    }

    const marker = new google.maps.Marker({
        position: { lat: parseFloat(driver.latitude), lng: parseFloat(driver.longitude) },
        map: map,
        icon: { url: iconUrl, scaledSize: new google.maps.Size(32, 32) },
        title: `${driver.first_name} ${driver.last_name}\n${shiftLabel}`, // hover tooltip
        Shift: `${driver.shift_today_start || 'N/A'} - ${driver.shift_today_end || 'N/A'}`,
    });

</script>

<style>
    .gm-style .card {
        font-family: 'Segoe UI', sans-serif;
        font-size: 1.35rem;
        border-radius: 10px;
        line-height: 1.3;
        word-break: break-word;
    }

    .gm-style .btn {
        font-size: 1.25rem;
        padding: 4px 8px;
    }

    .gm-style .badge {
        font-size: 1.20rem;
    }

    .gm-style .info-icons {
        font-size: 1.30rem;
    }

</style>



<script
    async
    defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyADbzomFDA-lmyBD6836Jx7XYsxTRrH3R8&callback=initMap">
</script>

</body>
</html>
    <!DOCTYPE html>
<html>
<head>
    <title>Location Map</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        html, body { height: 100%; margin: 0; }
        #map { height: 90vh; width: 100%; }
    </style>
</head>
<body>

<h2 class="text-center">📍 Location Map</h2>

@if(isset($showDrivers))
    <div style="text-align: center; margin-top: 20px;">
        <label for="driverFilter"><strong>Filter Drivers:</strong></label>
        <select id="driverFilter" onchange="filterMarkers()">
            <option value="all">All</option>
            <option value="available">Available</option>
            <option value="delivering">Delivering</option>
        </select>
    </div>
@endif

<div id="map"></div>

<script>
    let map, markers = [], directionsService, directionsRenderer;

    function initMap() {
        directionsService = new google.maps.DirectionsService();
        directionsRenderer = new google.maps.DirectionsRenderer({ suppressMarkers: true });

        map = new google.maps.Map(document.getElementById('map'), {
            center: { lat: 33.8938, lng: 35.5018 },
            zoom: 10
        });

        directionsRenderer.setMap(map);

        @if(isset($showClients))
        const clients = @json($clients);
        clients.forEach(client => {
            const marker = new google.maps.Marker({
                position: { lat: parseFloat(client.latitude), lng: parseFloat(client.longitude) },
                map,
                label: client.first_name.charAt(0),
                title: `${client.first_name} ${client.last_name}`,
            });

            const infoWindow = new google.maps.InfoWindow({
                content: `
                        <div style="min-width:200px">
                            <h5>${client.first_name} ${client.last_name}</h5>
                            <p>${client.email}</p>
                            <a href='/admin/client-performance/${client.id}' class='btn btn-sm btn-outline-primary'>🔍 Profile</a>
                        </div>`
            });
            marker.addListener('click', () => infoWindow.open(map, marker));
            markers.push(marker);
        });
        @endif

        @if(isset($showDrivers))
        const drivers = @json($drivers);
        drivers.forEach(driver => {
            const marker = new google.maps.Marker({
                position: { lat: parseFloat(driver.latitude), lng: parseFloat(driver.longitude) },
                map,
                label: driver.first_name.charAt(0),
                title: `${driver.first_name} ${driver.last_name}`
            });

            const infoWindow = new google.maps.InfoWindow({
                content: `
                        <div style="min-width:200px">
                            <h5>${driver.first_name} ${driver.last_name}</h5>
                            <p>${driver.email}</p>
                            <a href='/admin/driver-performance/${driver.id}' class='btn btn-sm btn-outline-primary'>🔍 Profile</a>
                        </div>`
            });
            marker.driverStatus = {
                available: driver.is_available_now,
                delivering: driver.is_delivering
            };
            marker.addListener('click', () => infoWindow.open(map, marker));
            markers.push(marker);
        });
        @endif
    }

    function filterMarkers() {
        const filter = document.getElementById('driverFilter').value;
        markers.forEach(marker => {
            if (!marker.driverStatus) return;
            if (filter === 'all') marker.setMap(map);
            else if (filter === 'available') marker.setMap(marker.driverStatus.available ? map : null);
            else if (filter === 'delivering') marker.setMap(marker.driverStatus.delivering ? map : null);
        });
    }
</script>

<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyADbzomFDA-lmyBD6836Jx7XYsxTRrH3R8&callback=initMap">
</script>

</body>
</html>--}}
{{--
    <!DOCTYPE html>
<html>
<head>
    <title>Location Map</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        html, body { height: 100%; margin: 0; }
        #map { height: 90vh; width: 100%; }
    </style>
</head>
<body>

<h2 class="text-center">📍 Location Map</h2>

@if(isset($showDrivers))
    <div style="text-align: center; margin-top: 20px;">
        <label for="driverFilter"><strong>Filter Drivers:</strong></label>
        <select id="driverFilter" onchange="filterMarkers()">
            <option value="all">All</option>
            <option value="available">Available</option>
            <option value="delivering">Delivering</option>
        </select>
    </div>
@endif

<div id="map"></div>

<script>
    let map, markers = [], directionsService, directionsRenderer;

    function initMap() {
        directionsService = new google.maps.DirectionsService();
        directionsRenderer = new google.maps.DirectionsRenderer({ suppressMarkers: true });

        map = new google.maps.Map(document.getElementById('map'), {
            center: { lat: 33.8938, lng: 35.5018 },
            zoom: 10
        });

        directionsRenderer.setMap(map);

        @if(isset($showClients))
        const clients = @json($clients);
        clients.forEach(client => {
            const marker = new google.maps.Marker({
                position: { lat: parseFloat(client.latitude), lng: parseFloat(client.longitude) },
                map,
                label: client.first_name.charAt(0),
                title: `${client.first_name} ${client.last_name}`,
            });

            const infoWindow = new google.maps.InfoWindow({
                content: `
                    <div style="min-width:200px">
                        <h5>${client.first_name} ${client.last_name}</h5>
                        <p>${client.email}</p>
                        <a href='/admin/clients/${client.id}' class='btn btn-sm btn-outline-primary'>🔍 Profile</a>
                    </div>`
            });

            marker.addListener('click', () => infoWindow.open(map, marker));
            markers.push(marker);
        });
        @endif

        @if(isset($showDrivers))
        const drivers = @json($drivers);
        drivers.forEach(driver => {
            const marker = new google.maps.Marker({
                position: { lat: parseFloat(driver.latitude), lng: parseFloat(driver.longitude) },
                map,
                label: driver.first_name.charAt(0),
                title: `${driver.first_name} ${driver.last_name}`
            });

            const infoWindow = new google.maps.InfoWindow({
                content: `
                    <div style="min-width:200px">
                        <h5>${driver.first_name} ${driver.last_name}</h5>
                        <p>${driver.email}</p>
                        <a href='/admin/driver-performance/${driver.id}' class='btn btn-sm btn-outline-primary'>🔍 Profile</a>
                    </div>`
            });

            marker.driverStatus = {
                available: driver.is_available_now,
                delivering: driver.is_delivering
            };

            marker.addListener('click', () => infoWindow.open(map, marker));
            markers.push(marker);
        });
        @endif
    }

    function filterMarkers() {
        const filter = document.getElementById('driverFilter').value;
        markers.forEach(marker => {
            if (!marker.driverStatus) return;
            if (filter === 'all') marker.setMap(map);
            else if (filter === 'available') marker.setMap(marker.driverStatus.available ? map : null);
            else if (filter === 'delivering') marker.setMap(marker.driverStatus.delivering ? map : null);
        });
    }
</script>

<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyADbzomFDA-lmyBD6836Jx7XYsxTRrH3R8&callback=initMap">
</script>

</body>
</html>

--}}
@extends('layouts.app')

@section('styles')
    <style>
        html, body { height: 100%; margin: 0; }
        #map { height: 90vh; width: 100%; }
        h2 { text-align: center; margin-top: 20px; font-family: Arial, sans-serif; }
    </style>
@endsection

@section('content')
    <h2 class="text-center">📍 Active Driver Map</h2>

    <div class="text-center my-3">
        <label for="driverFilter"><strong>Filter Drivers:</strong></label>
        <select id="driverFilter" class="form-select d-inline w-auto ms-2" onchange="filterMarkers()">
            <option value="all">All</option>
            <option value="available">Available Now</option>
            <option value="delivering">Currently Delivering</option>
        </select>
    </div>

    <div id="map"></div>
@endsection

@section('script')
    <script>
        let markers = [], directionsService, directionsRenderer, map;

        function initMap() {
            directionsService = new google.maps.DirectionsService();
            directionsRenderer = new google.maps.DirectionsRenderer({ suppressMarkers: true });

            map = new google.maps.Map(document.getElementById('map'), {
                zoom: 10,
                center: { lat: 33.8938, lng: 35.5018 },
            });

            directionsRenderer.setMap(map);

            const drivers = @json($drivers);
            markers = [];

            drivers.forEach(driver => {
                const marker = new google.maps.Marker({
                    position: { lat: parseFloat(driver.latitude), lng: parseFloat(driver.longitude) },
                    map: map,
                    label: driver.first_name.charAt(0),
                    title: driver.first_name + ' ' + driver.last_name,
                });

                const infoWindow = new google.maps.InfoWindow({
                    content: `
                    <div class="card shadow-sm" style="min-width: 250px;">
                        <div class="card-body p-3">
                            <h5 class="card-title mb-1">${driver.first_name} ${driver.last_name}</h5>
                            <p class="card-subtitle text-muted mb-2">${driver.email}</p>
                            <span class="badge bg-primary mb-2">${driver.pricing_model.replace('_', ' ').toUpperCase()}</span><br>
                            <span class="text-muted mb-3 d-block">🕒 <strong>Shift:</strong> ${driver.shift_today_start || 'N/A'} - ${driver.shift_today_end || 'N/A'}</span>
                            <div class="d-flex justify-content-between mt-3">
                                <a href="#" onclick="drawRoute(${Number(driver.pickup_lat) || 0}, ${Number(driver.pickup_lng) || 0}, ${Number(driver.dropoff_lat) || 0}, ${Number(driver.dropoff_lng) || 0}); return false;" class="btn btn-sm btn-outline-primary">🗺️ Route</a>
                                <a href="/admin/driver-performance/${driver.id}" target="_blank" class="btn btn-sm btn-primary">🔍 Profile</a>
                            </div>
                        </div>
                    </div>
                `
                });

                marker.addListener('click', () => {
                    infoWindow.open(map, marker);
                });

                marker.driverStatus = {
                    available: driver.is_available_now,
                    delivering: driver.is_delivering
                };

                markers.push(marker);
            });
        }

        function drawRoute(pickupLat, pickupLng, dropoffLat, dropoffLng) {
            const request = {
                origin: { lat: pickupLat, lng: pickupLng },
                destination: { lat: dropoffLat, lng: dropoffLng },
                travelMode: 'DRIVING',
            };

            if (directionsService && directionsRenderer) {
                directionsService.route(request, (result, status) => {
                    if (status === 'OK') {
                        directionsRenderer.setDirections(result);
                    } else {
                        alert("Unable to draw route: " + status);
                    }
                });
            } else {
                alert("Map has not initialized yet.");
            }
        }

        function filterMarkers() {
            const filter = document.getElementById('driverFilter').value;

            markers.forEach(marker => {
                const isAvailable = marker.driverStatus.available;
                const isDelivering = marker.driverStatus.delivering;

                if (filter === 'all') {
                    marker.setMap(map);
                } else if (filter === 'available') {
                    marker.setMap(isAvailable ? map : null);
                } else if (filter === 'delivering') {
                    marker.setMap(isDelivering ? map : null);
                }
            });
        }
    </script>

    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyADbzomFDA-lmyBD6836Jx7XYsxTRrH3R8&callback=initMap"></script>
@endsection
