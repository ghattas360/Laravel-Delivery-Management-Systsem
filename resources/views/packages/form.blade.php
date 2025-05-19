<div class="mb-3">
    <label>Picture</label>
    <input type="file" name="picture" class="form-control">
    @if(isset($package) && $package->picture)
        <img src="{{ asset('storage/' . $package->picture) }}" width="100" class="mt-2">
    @endif
</div>

<div class="mb-3">
    <label>Height</label>
    <input type="number" name="height" class="form-control" value="{{ old('height', $package->height ?? '') }}" step="0.1" required>
</div>

<div class="mb-3">
    <label>Width</label>
    <input type="number" name="width" class="form-control" value="{{ old('width', $package->width ?? '') }}" step="0.1" required>
</div>

<div class="mb-3">
    <label>Depth</label>
    <input type="number" name="depth" class="form-control" value="{{ old('depth', $package->depth ?? '') }}" step="0.1" required>
</div>

<div class="mb-3">
    <label>Weight</label>
    <input type="number" name="weight" class="form-control" value="{{ old('weight', $package->weight ?? '') }}" step="0.1" required>
</div>

<div class="mb-3">
    <label>Weight Unit</label>
    <select name="weight_unit" class="form-control">
        <option value="kg" {{ old('weight_unit', $package->weight_unit ?? '') == 'kg' ? 'selected' : '' }}>Kilograms</option>
        <option value="g" {{ old('weight_unit', $package->weight_unit ?? '') == 'g' ? 'selected' : '' }}>Grams</option>
    </select>
</div>

<div class="mb-3">
    <label>Measurement Unit</label>
    <select name="measurement_unit" class="form-control">
        <option value="cm" {{ old('measurement_unit', $package->measurement_unit ?? '') == 'cm' ? 'selected' : '' }}>Centimeters</option>
        <option value="m" {{ old('measurement_unit', $package->measurement_unit ?? '') == 'm' ? 'selected' : '' }}>Meters</option>
    </select>
</div>

<div class="form-check">
    <input class="form-check-input" type="checkbox" name="is_breakable" value="1" {{ old('is_breakable', $package->is_breakable ?? false) ? 'checked' : '' }}>
    <label class="form-check-label">Is Breakable</label>
</div>

<div class="form-check">
    <input class="form-check-input" type="checkbox" name="is_flammable" value="1" {{ old('is_flammable', $package->is_flammable ?? false) ? 'checked' : '' }}>
    <label class="form-check-label">Is Flammable</label>
</div>

<div class="form-check">
    <input class="form-check-input" type="checkbox" name="has_fluid" value="1" {{ old('has_fluid', $package->has_fluid ?? false) ? 'checked' : '' }}>
    <label class="form-check-label">Has Fluid</label>
</div>
