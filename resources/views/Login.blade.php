<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login</title>
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

<body class="d-flex align-items-center justify-content-center vh-100 bg-light">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="card shadow-lg p-4">
                    <div class="text-center mb-3">
                        <img src="https://www.freeiconspng.com/uploads/am-a-19-year-old-multimedia-artist-student-from-manila--21.png" alt="Logo" class="logo img-fluid" />
                    </div>

                    <h3 class="text-center">Welcome Back!</h3>
                    <p class="text-center text-muted">Log in to your account</p>
                    <form action="{{ route('login.submit') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" placeholder="Enter your email"
                                value="{{old("email")}}" class="form-control"  />
                            @error("email")
                                <div class="alert alert-danger mt-1">{{$message}}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <div class="input-group">
                                <input type="password" id="password" name="password" class="form-control"
                                    placeholder="Enter your password" value="{{old("password")}}" class="form-control"  />
                            @error("password")
                                <div class="alert alert-danger mt-1">{{$message}}</div>
                            @enderror
                                <button class="btn btn-outline-secondary" id="togglePassword" type="button">👁</button>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 mb-3">Log In</button>
                    </form>

                </div>
            </div>
        </div>
    </div>

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