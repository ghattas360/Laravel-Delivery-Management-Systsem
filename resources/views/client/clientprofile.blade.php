@extends('layouts.app')

@section('content')
<div class="profile-container">
    <!-- Profile Header -->
    <div class="profile-header">
        <form action="{{ route('client.uploadProfileImage', ['id' => $client->id]) }}" method="POST"
            enctype="multipart/form-data" id="uploadForm">
            @csrf
            <label for="profileImageInput" style="cursor: pointer;">
                <img src="{{ $client->profile_image ? asset('storage/' . $client->profile_image) : asset('images/default-avatar.png') }}"
                    alt="ClientProfile" id="profileImagePreview">
            </label>
            <input type="file" name="profile_image" id="profileImageInput" accept="image/*" hidden
                onchange="document.getElementById('uploadForm').submit();">
        </form>

        <div>
            <h1>{{ $client->first_name }} {{ $client->last_name }}</h1>
            <p class="text-white text-opacity-80">Username: {{ $client->user_name }}</p>
        </div>
    </div>

    <!-- Tabs -->
    <div class="tab-buttons">
        <button class="tab-btn active" data-tab="info">Info</button>
        <!-- <button class="tab-btn" data-tab="addresses">Addresses</button> -->
        <button class="tab-btn" data-tab="social">Social Media</button>
        <!-- <button class="tab-btn" data-tab="packages">Packages</button>
        <button class="tab-btn" data-tab="reviews">Reviews</button> -->
    </div>

    <!-- Tab Content -->
    <div class="tab-content">
        <div class="tab-panel" id="info">
            <div class="card">
                <h2>Personal Information</h2>
                <p><strong>Age:</strong> {{ $client->age }}</p>
                <p><strong>Phone:</strong> {{ $client->phone }}</p>
                <p><strong>Email:</strong> {{ $client->email }}</p>
                <p><strong>Premium Level:</strong> {{ $client->premium_level }}</p>
            </div>
        </div>

        <!-- <div class="tab-panel" id="addresses" hidden>
            <div class="card">
                <h2>Addresses</h2>
                <ul>
                    @forelse ($client->getAddress ?? [] as $address)
                        <li>{{ $address->address }}</li>
                    @empty
                        <li>No addresses added.</li>
                    @endforelse
                </ul>
            </div>
        </div> -->

        <div class="tab-panel" id="social" hidden>
            <div class="card">
                <h2>Social Media Accounts</h2>
                <ul>
                    @forelse ($client->getClientSocialMediaAccount ?? [] as $account)
                        <li>{{ $account->platform }}: {{ $account->handle }}</li>
                    @empty
                        <li>No social media accounts found.</li>
                    @endforelse
                </ul>
            </div>
        </div>

        <!-- <div class="tab-panel" id="packages" hidden>
            <div class="card">
                <h2>Packages</h2>
                <ul>
                    @forelse ($client->getPackages ?? [] as $package)
                        <li>{{ $package->name }} — {{ $package->description }}</li>
                    @empty
                        <li>No packages found.</li>
                    @endforelse
                </ul>
            </div>
        </div>

        <div class="tab-panel" id="reviews" hidden>
            <div class="card">
                <h2>Reviews</h2>
                <ul>
                    @forelse ($client->getReviews ?? [] as $review)
                        <li>
                            <strong>Rating:</strong> {{ $review->rating }}<br>
                            <em>"{{ $review->review }}"</em>
                        </li>
                    @empty
                        <li>No reviews yet.</li>
                    @endforelse
                </ul>
            </div>
        </div> -->

        {{-- <a href="{{ route('clients.edit', $client->id) }}" class="edit-btn">Edit Profile</a>
        --}}
    </div>
</div>
@endsection

@section('script')
<script>
    document.querySelectorAll('.tab-btn').forEach(button => {
        button.addEventListener('click', () => {
            const tab = button.getAttribute('data-tab');

            // Remove active class from all buttons
            document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));

            // Hide all panels
            document.querySelectorAll('.tab-panel').forEach(panel => panel.hidden = true);

            // Show selected panel and set active button
            document.getElementById(tab).hidden = false;
            button.classList.add('active');
        });
    });
</script>
@endsection

@section('styles_Client')
<style>
    body {
        background-color: #f3f4f6;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .profile-container {
        max-width: 1000px;
        margin: 3rem auto;
        background: white;
        border-radius: 1rem;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
        overflow: hidden;
    }

    .profile-header {
        background: linear-gradient(to right, #6b21a8, #9333ea);
        color: white;
        padding: 2rem;
        display: flex;
        align-items: center;
        gap: 2rem;
    }

    .profile-header img {
        width: 120px;
        height: 120px;
        object-fit: cover;
        border-radius: 50%;
        border: 4px solid white;
    }

    .profile-header h1 {
        font-size: 2rem;
        font-weight: bold;
        margin: 0;
    }

    .tab-buttons {
        display: flex;
        border-bottom: 2px solid #e5e7eb;
    }

    .tab-buttons button {
        flex: 1;
        padding: 1rem;
        font-weight: 600;
        background: none;
        border: none;
        border-bottom: 3px solid transparent;
        cursor: pointer;
        transition: all 0.3s;
    }

    .tab-buttons button.active {
        border-color: #6b21a8;
        color: #6b21a8;
        background-color: #f9f5ff;
    }

    .tab-content {
        padding: 2rem;
    }

    .card {
        background: #f9fafb;
        padding: 1.5rem;
        border-left: 5px solid #6b21a8;
        border-radius: 0.75rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.03);
    }

    .card h2 {
        margin-bottom: 1rem;
        font-size: 1.25rem;
        color: #6b21a8;
    }

    .card p,
    .card li {
        font-size: 1rem;
        margin-bottom: 0.5rem;
    }

    .edit-btn {
        display: inline-block;
        margin-top: 1rem;
        padding: 0.75rem 1.5rem;
        background-color: #6b21a8;
        color: white;
        font-weight: 600;
        border-radius: 0.5rem;
        text-decoration: none;
        transition: background-color 0.3s ease;
    }

    .edit-btn:hover {
        background-color: #581c87;
    }

    [hidden] {
        display: none;
    }
</style>
@endsection