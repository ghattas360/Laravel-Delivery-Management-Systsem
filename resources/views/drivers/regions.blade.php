@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Select Your Region</h2>

    <form method="POST" action="">
        @csrf
        @method('PUT')

        <div class="form-group mb-3">
            <label for="country">Country/Region</label>
            <select name="region" id="country" class="form-control" required>
                <option value="">-- Select Region --</option>
                <option value="Region A">Mount Lebanon</option>
                <option value="Region B">Janoub</option>
                <option value="Region C">Bekaa</option>
                <option value="Region D">North</option>
                <option value="Region E">aakar</option>
                <option value="Region F">Baalbak Hermel</option>
                <option value="Region G">Nabatieh</option>
            </select>
        </div>

        <button id="saveBtn" type="submit" class="btn btn-primary">Save Region</button>
    </form>
</div>
<script>
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
</script>
@endsection
