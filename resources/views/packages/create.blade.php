@extends('layouts.app')

@section('content')

<form action="{{ route('packages.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <!-- Height -->
    <div class="form-group">
        <label for="height">Height</label>
        <input type="text" name="height" class="form-control" value="{{ old('height') }}" required>
    </div>

    <!-- Width -->
    <div class="form-group">
        <label for="width">Width</label>
        <input type="text" name="width" class="form-control" value="{{ old('width') }}" required>
    </div>

    <!-- Depth -->
    <div class="form-group">
        <label for="depth">Depth</label>
        <input type="text" name="depth" class="form-control" value="{{ old('depth') }}" required>
    </div>

    <!-- Weight -->
    <div class="form-group">
        <label for="weight">Weight</label>
        <input type="text" name="weight" class="form-control" value="{{ old('weight') }}" required>
    </div>

    <!-- Weight Unit -->
    <div class="form-group">
        <label for="weight_unit">Weight Unit</label>
        <input type="text" name="weight_unit" class="form-control" value="{{ old('weight_unit') }}" required>
    </div>

    <!-- Measurement Unit -->
    <div class="form-group">
        <label for="measurement_unit">Measurement Unit</label>
        <input type="text" name="measurement_unit" class="form-control" value="{{ old('measurement_unit') }}" required>
    </div>

    <!-- Is Breakable -->
    <div class="form-group">
        <label for="is_breakable">Is Breakable</label>
        <input type="checkbox" name="is_breakable" value="1" {{ old('is_breakable') ? 'checked' : '' }}>
    </div>

    <!-- Is Flammable -->
    <div class="form-group">
        <label for="is_flammable">Is Flammable</label>
        <input type="checkbox" name="is_flammable" value="1" {{ old('is_flammable') ? 'checked' : '' }}>
    </div>

    <!-- Has Fluid -->
    <div class="form-group">
        <label for="has_fluid">Has Fluid</label>
        <input type="checkbox" name="has_fluid" value="1" {{ old('has_fluid') ? 'checked' : '' }}>
    </div>

   

    <!-- Picture -->
    <div class="form-group">
        <label for="image">Picture</label>
        <input id="image" name="image" type="file" class="form-control" accept="image/*" required>
        @error('image')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <button type="submit" class="btn btn-success">Create Package</button>
</form>

@endsection
