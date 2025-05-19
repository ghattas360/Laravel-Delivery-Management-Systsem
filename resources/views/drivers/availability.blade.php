@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">My Availability</h2>

    <form id="availabilityForm" method="POST" action="">
        @csrf
        @method('PUT')

        <div class="form-group mb-3">
            <label for="mode">Availability Mode</label>
            <select id="mode" name="mode" class="form-control" onchange="toggleAvailabilityFields()">
                <option value="daily" {{ old('mode')=='daily' ? 'selected' : '' }}>Daily</option>
                <option value="weekly" {{ old('mode')=='weekly' ? 'selected' : '' }}>Weekly</option>
            </select>
        </div>

        {{-- Daily Input: start and end time --}}
        <div id="daily-input" class="form-group mb-3">
            <label>Today's Availability</label>
            <div class="d-flex gap-2">
                <input type="time" name="daily[start]" value="{{ old('daily.start') }}" class="form-control" placeholder="Start time" />
                <input type="time" name="daily[end]"   value="{{ old('daily.end') }}" class="form-control" placeholder="End time" />
            </div>
        </div>

        {{-- Weekly Inputs: start and end per day --}}
        <div id="weekly-inputs" class="mb-3 d-none">
            @foreach(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day)
                <div class="form-group mb-2">
                    <label>{{ $day }}</label>
                    <div class="d-flex gap-2">
                        <input type="time" name="weekly[{{ $day }}][start]" value="{{ old('weekly.'.$day.'.start') }}" class="form-control" placeholder="Start time" />
                        <input type="time" name="weekly[{{ $day }}][end]"   value="{{ old('weekly.'.$day.'.end') }}" class="form-control" placeholder="End time" />
                    </div>
                </div>
            @endforeach
        </div>

        <button id="saveBtn" type="submit" class="btn btn-primary mt-3">Save Availability</button>
    </form>
</div>

<script>
    function toggleAvailabilityFields() {
        const mode = document.getElementById('mode').value;
        document.getElementById('daily-input').classList.toggle('d-none', mode !== 'daily');
        document.getElementById('weekly-inputs').classList.toggle('d-none', mode !== 'weekly');
    }

    document.addEventListener('DOMContentLoaded', () => {
        toggleAvailabilityFields();

        // Show popup on Save button click
        const saveBtn = document.getElementById('saveBtn');
        saveBtn.addEventListener('click', function(event) {
            // Create and display popup
            const alertBox = document.createElement('div');
            alertBox.className = 'alert alert-success position-fixed top-0 end-0 m-3';
            alertBox.innerText = 'Your availability has been updated!';
            document.body.appendChild(alertBox);
            setTimeout(() => alertBox.remove(), 3000);
        });
    });
</script>
@endsection
