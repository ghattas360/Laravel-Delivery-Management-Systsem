@extends('layouts.app')

@section('content')
<div class="profile-container">
    <!-- Profile Header -->
    <div class="profile-header">
        <form action="{{ route('driver.uploadProfileImage', ['id' => $driver->id]) }}" method="POST" enctype="multipart/form-data" id="uploadForm">
            @csrf
            <label for="profileImageInput" style="cursor: pointer;">
                <img src="{{ $driver->profile_image ? asset('storage/' . $driver->profile_image) : asset('images/default-avatar.png') }}"
                     alt="DriverProfile" id="profileImagePreview">
            </label>
            <input type="file" name="profile_image" id="profileImageInput" accept="image/*" hidden
                   onchange="document.getElementById('uploadForm').submit();">
        </form>

        <div>
            <h1>{{ $driver->first_name }} {{ $driver->last_name }}</h1>
            <p class="text-white text-opacity-80">Username: {{ $driver->username }}</p>
        </div>
    </div>

    <!-- Tabs -->
    <div class="tab-buttons">
        <button class="tab-btn active" data-tab="info">Info</button>
        <button class="tab-btn" data-tab="region">Region & District</button>
        <button class="tab-btn" data-tab="availability">Availability</button>
    </div>

    <!-- Tab Content -->
    <div class="tab-content">
        <div class="tab-panel" id="info">
            <div class="card">
                <h2>Personal Information</h2>
                <p><strong>Age:</strong> {{ $driver->age }}</p>
                <p><strong>Phone:</strong> {{ $driver->phone }}</p>
                <p><strong>Email:</strong> {{ $driver->email }}</p>
                <p><strong>Plate Number:</strong> {{ $driver->plate_number }}</p>
                <p><strong>Pricing Model:</strong> {{ $driver->pricing_model }}</p>
            </div>
        </div>

        <div class="tab-panel" id="region" hidden>
            <div class="card">
                <h2>Region & District</h2>
                <form method="POST" action="{{ route('driver.update.region', $driver->id) }}">
                    @csrf
                    @method('PUT')
                    <div>
                        <label for="region">Region:</label>
                        <select name="region" id="region" class="form-select">
                            <option value="">Select a Region</option>
                            @foreach ($regions as $region)
                                <option value="{{ $region->id }}" {{ $region->id == $driver->region_id ? 'selected' : '' }}>
                                    {{ $region->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="district">District:</label>
                        <select name="district" id="district" class="form-select">
                            <option value="">Select a District</option>
                            @foreach ($districts as $district)
                                <option value="{{ $district->id }}" {{ $district->id == $driver->district_id ? 'selected' : '' }}>
                                    {{ $district->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="edit-btn mt-4">Save Region & District</button>
                </form>
            </div>
        </div>

        <div class="tab-panel" id="availability" hidden>
            <div class="card">
                <h2>Weekly Availability</h2>
                <form action="{{ route('driver.update.availability', $driver->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    @foreach (['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'] as $day)
                        <div class="mb-4">
                            <label><strong>{{ $day }}</strong></label><br>
                            <input type="time" name="availability[{{ $day }}][start]" value="{{ $driver->availabilities[$day]['start'] ?? '' }}">
                            to
                            <input type="time" name="availability[{{ $day }}][end]" value="{{ $driver->availabilities[$day]['end'] ?? '' }}">
                        </div>
                    @endforeach

                    <button type="submit" class="edit-btn mt-2">Save Availability</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    document.querySelectorAll('.tab-btn').forEach(button => {
        button.addEventListener('click', () => {
            const tab = button.getAttribute('data-tab');
            document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
            document.querySelectorAll('.tab-panel').forEach(panel => panel.hidden = true);
            document.getElementById(tab).hidden = false;
            button.classList.add('active');
        });
    });

    // Fetch districts based on region selection
    document.getElementById('region').addEventListener('change', function () {
        const regionId = this.value;
        fetch(`/api/regions/${regionId}/districts`)
            .then(response => response.json())
            .then(data => {
                const districtSelect = document.getElementById('district');
                districtSelect.innerHTML = '<option value="">Select a District</option>';
                data.forEach(district => {
                    const option = document.createElement('option');
                    option.value = district.id;
                    option.textContent = district.name;
                    districtSelect.appendChild(option);
                });
            });
    });
</script>
@endsection

@section('styles_Client')
{{-- Reuse same styles as client --}}
@parent
@endsection
