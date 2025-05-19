<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        .logo {
            width: 60px;
        }

        .card {
            border-radius: 12px;
        }

        .btn-primary {
            background-color: #635bff;
            border: none;
        }

        .btn-primary:hover {
            background-color: #5749e7;
        }

        .social-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-google {
            background-color: #db4437;
            color: white;
        }

        .btn-google:hover {
            background-color: #c1351d;
        }

        .btn-facebook {
            background-color: #3b5998;
            color: white;
        }

        .btn-facebook:hover {
            background-color: #2d4373;
        }

    </style>
</head>

<body class="bg-light py-5">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="card shadow-lg p-4">
                    <div class="text-center mb-3">
                        <img src="https://icons.veryicon.com/png/o/miscellaneous/esgcc-basic-icon-library/register-14.png"
                            alt="Logo" class="logo img-fluid" />
                    </div>

                    <h3 class="text-center">Adventure starts here 🚀</h3>
                    <p class="text-center text-muted">Make your app management easy and fun!</p>

                    <form action="{{ route('register-submit') }}" method="POST" class="mx-auto w-100 w-md-75 w-lg-50">
                        @csrf
                        <div class="row g-2 mb-2">
                            <div class="col-md-6">
                                <label class="form-label small">First Name</label>
                                <input type="text" class="form-control form-control-sm" name="first_name"
                                    value="{{ old('first_name') }}" required />
                                @error('first_name')
                                    <div class="alert alert-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small">Last Name</label>
                                <input type="text" class="form-control form-control-sm" name="last_name"
                                    value="{{ old('last_name') }}" required />
                                @error('last_name')
                                    <div class="alert alert-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                                {{-- Name error from full-name check --}}
                        @if ($errors->has('name'))
                        <div class="alert alert-danger d-block">{{ $errors->first('name') }}</div>
                        @endif
                        </div>

                        <div class="row g-2 mb-2">
                            <div class="col-md-6">
                                <label class="form-label small">Age</label>
                                <input type="number" class="form-control form-control-sm" name="age"
                                    value="{{ old('age') }}" required />
                                @error('age')
                                    <div class="alert alert-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small">Phone</label>
                                <input type="tel" class="form-control form-control-sm" name="phone"
                                    pattern="[0-9]{2}-[0-9]{3}-[0-9]{3}" placeholder="12-345-678"
                                    value="{{ old('phone') }}" required />
                                @error('phone')
                                    <div class="alert alert-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-2">
                            <label class="form-label small">Email</label>
                            <input type="email" class="form-control form-control-sm" name="email"
                                value="{{ old('email') }}" required />
                            @error('email')
                                <div class="alert alert-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row g-2 mb-2">
                            <div class="col-md-6">
                                <label class="form-label small">Password</label>
                                <input type="password" class="form-control form-control-sm" name="password" value="{{ old('password') }}"
                                    id="password" required />
                                @error('password')
                                    <div class="alert alert-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small">Confirm Password</label>
                                <input type="password" id="confirm-password" class="form-control form-control-sm"
                                    name="confirm_password" value="" required />
                                @error('confirm_password')
                                    <div class="alert alert-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <input type="hidden" name="role" value="client" />

                        <button type="submit" class="btn btn-primary w-100 btn-sm">Sign Up</button>
                    </form>
                    <div class="text-center mt-3">
                   <p>Already have an account? <a href="{{ route('login') }}" class="text-primary">Login here</a></p>
                    </div>

                    <hr class="my-3" />
                    <div class="text-center mb-3 text-muted">or sign up using</div>

                    <!-- Social Login Buttons -->
                    <div class="d-grid gap-2">
                        <a href="{{ url('/auth/google/redirect') }}" class="btn btn-google social-btn">
                            <img src="https://img.icons8.com/color/16/000000/google-logo.png" /> Sign in with Google
                        </a>
                        <a class="btn btn-dark" href="{{ route('auth.github') }}" style="display: block;">
                            <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="40" height="40"
                                viewBox="0 0 30 30">
                                <path fill="#FFFFFF"
                                    d="M15,3C8.373,3,3,8.373,3,15c0,5.623,3.872,10.328,9.092,11.63C12.036,26.468,12,26.28,12,26.047v-2.051 c-0.487,0-1.303,0-1.508,0c-0.821,0-1.551-0.353-1.905-1.009c-0.393-0.729-0.461-1.844-1.435-2.526 c-0.289-0.227-0.069-0.486,0.264-0.451c0.615,0.174,1.125,0.596,1.605,1.222c0.478,0.627,0.703,0.769,1.596,0.769 c0.433,0,1.081-0.025,1.691-0.121c0.328-0.833,0.895-1.6,1.588-1.962c-3.996-0.411-5.903-2.399-5.903-5.098 c0-1.162,0.495-2.286,1.336-3.233C9.053,10.647,8.706,8.73,9.435,8c1.798,0,2.885,1.166,3.146,1.481C13.477,9.174,14.461,9,15.495,9 c1.036,0,2.024,0.174,2.922,0.483C18.675,9.17,19.763,8,21.565,8c0.732,0.731,0.381,2.656,0.102,3.594 c0.836,0.945,1.328,2.066,1.328,3.226c0,2.697-1.904,4.684-5.894,5.097C18.199,20.49,19,22.1,19,23.313v2.734 c0,0.104-0.023,0.179-0.035,0.268C23.641,24.676,27,20.236,27,15C27,8.373,21.627,3,15,3z">
                                </path>
                            </svg>

                            Login with Github
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById("togglePassword").addEventListener("click", togglePassword);

        function togglePassword() {
            let passwordField = document.getElementById("password");
            passwordField.type = passwordField.type === "password" ? "text" : "password";
        }
    </script>
</body>

</html>
