@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Set Your Shift Times</h2>

    <form method="POST" action="">
        @csrf
        @method('PUT')

        <div class="form-group mb-3">
            <label for="start_time">Start Time</label>
            <input type="time" name="start_time" id="start_time" class="form-control" required />
        </div>

        <div class="form-group mb-3">
            <label for="end_time">End Time</label>
            <input type="time" name="end_time" id="end_time" class="form-control" required />
        </div>

        <button id="saveBtn" type="submit" class="btn btn-primary">Save Shift</button>
    </form>
</div>
<script>



        // Show popup on Save button clic
        const saveBtn = document.getElementById('saveBtn');
        saveBtn.addEventListener('click', function(event) {
            // Create and display popup
            const alertBox = document.createElement('div');
            alertBox.className = 'alert alert-success position-fixed top-0 end-0 m-3';
            alertBox.innerText = 'Your shift has been updated!';
            document.body.appendChild(alertBox);
            setTimeout(() => alertBox.remove(), 3000);
        });
  </script>
@endsection
