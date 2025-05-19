{{--
@extends('layouts.app')
@section('content')
    <div class="container py-5">
        <h2 class="mb-4 text-primary">👤 Edit Admin Profile</h2>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('admin.profile.update') }}">
            @csrf
            @method('PATCH')

            <div class="mb-3">
                <label for="name" class="form-label">Full Name</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $admin->name) }}" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">New Password (optional)</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>

            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirm New Password</label>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
            </div>

            <button type="submit" class="btn btn-primary">Update Profile</button>
        </form>
    </div>
@endsection
--}}
@extends('layouts.app')
@section('content')
    <div class="container py-5">

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="text-center mb-4">
{{--            <form action="{{ route('admin.profile.uploadPhoto') }}" method="POST" enctype="multipart/form-data" id="photoUploadForm">
                @csrf
                <label for="photo" style="cursor: pointer;">
                    <img src="{{ $admin->photo ? asset('storage/' . $admin->photo) : asset('images/default-avatar.png') }}" alt="Admin Photo" class="rounded-circle" style="width: 120px; height: 120px; object-fit: cover; border: 3px solid #ccc;">
                </label>
                <input type="file" name="photo" id="photo" accept="image/*" hidden onchange="document.getElementById('photoUploadForm').submit();">
            </form>--}}
            <div class="text-center mb-4">
                <form action="{{ route('admin.profile.uploadPhoto') }}" method="POST" enctype="multipart/form-data" id="uploadForm">
                    @csrf
                    <label for="profileImageInput" style="cursor: pointer;">
                        <img src="{{ $admin->photo ? asset('storage/' . $admin->photo) : asset('images/default-avatar.png') }}"
                             alt="ClientProfile" id="profileImagePreview"
                             class="rounded-circle" style="width: 120px; height: 120px; object-fit: cover; border: 3px solid #ccc;">
                    </label>
                    <input type="file" name="photo" id="profileImageInput" accept="image/*" hidden
                           onchange="document.getElementById('uploadForm').submit();">
                </form>
            </div>
        </div>

        <h2 class="mb-4 text-primary">👤 Edit Admin Profile</h2>

        <form method="POST" action="{{ route('admin.profile.update') }}">
            @csrf
            @method('PATCH')

            <div class="mb-3">
                <label for="name" class="form-label">Full Name</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $admin->name) }}">
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">New Password</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>

            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirm New Password</label>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
            </div>

            <button type="submit" class="btn btn-primary">Update Profile</button>
        </form>
    </div>
@endsection
