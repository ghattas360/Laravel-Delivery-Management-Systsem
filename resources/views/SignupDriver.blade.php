<!DOCTYPE html>  
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Driver Sign Up</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body {
            background-color: #f8f9fa;
            min-height: 100vh;
            margin: 0;
            display: flex;
            justify-content: center;
            padding: 40px 10px;
        }

        .wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
        }

        .logo {
            width: 70px;
        }

        .register-card {
            width: 100%;
            max-width: 720px;
            padding: 30px;
            border-radius: 12px;
            background: #fff;
            box-shadow: 0 0 12px rgba(0, 0, 0, 0.08);
        }

        .form-label {
            font-size: 14px;
            margin-bottom: 5px;
        }

        .form-control {
            font-size: 14px;
            padding: 7px 10px;
        }

        .btn-primary {
            background-color: #635bff;
            border: none;
            font-size: 14px;
            padding: 10px;
        }

        .btn-primary:hover {
            background-color: #5749e7;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #842029;
            border: 1px solid #f5c2c7;
            border-radius: 6px;
            padding: 8px 12px;
            font-size: 14px;
            margin-top: 5px;
        }
    </style>
</head>

<body>
<div class="wrapper">
    <div class="register-card">
        <div class="text-center mb-3">
            <img src="https://icons.veryicon.com/png/o/miscellaneous/esgcc-basic-icon-library/register-14.png" alt="Logo" class="logo img-fluid" />
        </div>

        <h4 class="text-center mb-2">Driver Registration 🚗</h4>
        <p class="text-center text-muted mb-3 form-note">Quick sign-up to start delivering!</p>

        <form enctype="multipart/form-data" action="{{ route('registerDriver.submit') }}" method="POST">
            @csrf
            <div class="row">
                @php
                    $fields = [
                        'name' => 'Full Name',
                        'username' => 'Username',
                        'email' => 'Email',
                        'phone' => 'Phone',
                        'password' => 'Password',
                        'password_confirmation' => 'Confirm Password',
                        'plate_number' => 'Plate Number',
                        'pricing_model' => 'Pricing Model',
                    ];
                @endphp

                @foreach ($fields as $field => $label)
                    <div class="col-md-6 mb-3">
                        <label class="form-label">{{ $label }}</label>

                        @if ($field === 'pricing_model')
                            <select name="pricing_model" class="form-control" required>
                                <option value="" disabled selected>Select Pricing Model</option>
                                <option value="per_km" {{ old('pricing_model') == 'per_km' ? 'selected' : '' }}>Per KM</option>
                                <option value="per_delivery" {{ old('pricing_model') == 'per_delivery' ? 'selected' : '' }}>Per Delivery</option>
                            </select>
                        @else
                            <input 
                                type="{{ in_array($field, ['password', 'password_confirmation']) ? 'password' : 'text' }}"
                                name="{{ $field }}" 
                                class="form-control"
                                value="{{ old($field) }}"
                                {{ $field !== 'password' && $field !== 'password_confirmation' ? 'required' : '' }} 
                            />
                        @endif

                        @error($field)
                            <div class="alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                @endforeach

                <input type="hidden" name="role" value="driver" />

                <!-- Driving License Upload -->
                <div class="col-md-6 mb-3">
                    <label class="form-label" for="driving_license">Driving License Image</label>
                    <input id="driving_license" name="driving_license" type="file" class="form-control" required />
                    @error('driving_license')
                        <div class="alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- National ID Upload -->
                <div class="col-md-6 mb-3">
                    <label class="form-label" for="national_id">National ID Image</label>
                    <input id="national_id" name="national_id" type="file" class="form-control" required />
                    @error('national_id')
                        <div class="alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12 mt-3">
                    <button type="submit" class="btn btn-primary w-100">Register</button>
                </div>
            </div>
        </form>
        <div class="text-center mt-3">
            <p>Already have an account? <a href="{{ route('login') }}" class="text-primary">Login here</a></p>
        </div>
    </div>
</div>
</body>
</html>
