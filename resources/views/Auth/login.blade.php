<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Informasi Produksi Furnitur</title>

    <!-- Bootstrap 4 CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
        integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <style>
        /* Furniture Theme Colors */
        :root {
            --furniture-primary: #8B4513;
            /* Saddle Brown */
            --furniture-secondary: #A0522D;
            /* Sienna */
            --furniture-light: #DEB887;
            /* Burlywood */
            --furniture-dark: #5D4037;
            /* Dark Brown */
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
        }

        .bg-furniture {
            background: linear-gradient(135deg, var(--furniture-primary) 0%, var(--furniture-secondary) 100%);
        }

        .bg-furniture-light {
            background-color: var(--furniture-light);
        }

        .text-furniture {
            color: var(--furniture-primary);
        }

        .btn-furniture {
            background-color: var(--furniture-primary);
            border-color: var(--furniture-primary);
            color: white;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .btn-furniture:hover {
            background-color: var(--furniture-secondary);
            border-color: var(--furniture-secondary);
            color: white;
        }

        /* Background Image */
        .furniture-bg {
            background-image: url('https://images.unsplash.com/photo-1616486338812-3dadae4b4ace?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');
            background-size: cover;
            background-position: center;
            position: relative;
        }

        .furniture-bg::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.6);
        }

        .furniture-bg>div {
            position: relative;
            z-index: 1;
        }

        /* Form Styling */
        .input-group-text {
            border-right: 0;
            background-color: var(--furniture-light);
        }

        .form-control {
            border-left: 0;
        }

        .form-control:focus {
            border-color: var(--furniture-light);
            box-shadow: 0 0 0 0.2rem rgba(222, 184, 135, 0.25);
        }

        /* Card Shadow */
        .card {
            border-radius: 10px;
            border: none;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }

        /* Logo Styling */
        .logo-circle {
            width: 70px;
            height: 70px;
            background-color: var(--furniture-light);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
        }

        /* Feature List */
        .feature-list li {
            margin-bottom: 12px;
            font-size: 1.1rem;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .min-vh-100 {
                min-height: auto !important;
                padding: 2rem 0;
            }

            .w-75 {
                width: 90% !important;
            }

            .furniture-bg {
                min-height: 300px;
            }
        }
    </style>
</head>

<body>
    <div class="container-fluid bg-furniture min-vh-100">
        <div class="row min-vh-100 no-gutters">
            <!-- Left Side - Furniture Theme Image -->
            <div class="col-md-6 d-none d-md-flex align-items-center justify-content-center furniture-bg">
                <div class="p-4 text-center text-white">
                    <div class="mb-4">
                        <i class="fas fa-couch fa-5x mb-3"></i>
                        <h1 class="display-4 font-weight-bold">SIPM</h1>
                        <p class="lead">Sistem Informasi Produksi Mebel</p>
                    </div>
                    <div class="mt-5">
                        <h3>Manajemen Produksi Terpadu</h3>
                        <p class="mt-3">Kelola produksi mebel Anda dengan mudah dan efisien</p>
                        <ul class="list-unstyled feature-list mt-4">
                            <li><i class="fas fa-check-circle mr-2"></i>Tracking Produksi </li>
                            <li><i class="fas fa-check-circle mr-2"></i>Manajemen Stok Bahan Baku</li>
                            {{-- <li><i class="fas fa-check-circle mr-2"></i>Quality Control Terintegrasi</li> --}}
                            {{-- <li><i class="fas fa-check-circle mr-2"></i>Laporan Produksi Lengkap</li> --}}
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Right Side - Login Form -->
            <div class="col-md-6 d-flex align-items-center justify-content-center bg-white">
                <div class="w-75">
                    <!-- Logo and Title -->
                    <div class="mb-5 text-center">
                        <div class="logo-circle">
                            <i class="fas fa-industry fa-2x text-furniture"></i>
                        </div>
                        <h2 class="font-weight-bold text-furniture">SIPM LOGIN</h2>
                        <p class="text-muted">Masuk ke akun Anda</p>
                    </div>

                    <!-- Login Card -->
                    <div class="card shadow-sm">
                        <div class="card-body p-4">
                            <form action="/login" method="POST">
                                <!-- CSRF Token -->
                                @csrf

                                <!-- Email Input -->
                                <div class="form-group mb-4">
                                    <label for="email" class="font-weight-bold text-furniture">
                                        <i class="fas fa-envelope mr-1"></i> Email
                                    </label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-envelope text-furniture"></i>
                                            </span>
                                        </div>
                                        <input type="email" class="form-control" id="email" name="email"
                                            placeholder="user@gmail.com" value="{{ old('email') }}">
                                    </div>
                                    @if ($errors->has('email'))
                                        <div class="invalid-feedback d-block">
                                            {{ $errors->first('email') }}
                                        </div>
                                    @endif
                                </div>

                                <!-- Password Input -->
                                <div class="form-group mb-4">
                                    <label for="password" class="font-weight-bold text-furniture">
                                        <i class="fas fa-lock mr-1"></i> Password
                                    </label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-lock text-furniture"></i>
                                            </span>
                                        </div>
                                        <input type="password" class="form-control" id="password" name="password"
                                            placeholder="••••••••">
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary" type="button"
                                                id="togglePassword">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                    </div>
                                    @if ($errors->has('password'))
                                        <div class="invalid-feedback d-block">
                                            {{ $errors->first('password') }}
                                        </div>
                                    @endif
                                </div>

                                <!-- Submit Button -->
                                <button type="submit" class="btn btn-furniture btn-block py-2">
                                    <i class="fas fa-sign-in-alt mr-2"></i> MASUK
                                </button>

                            </form>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="mt-4 text-center">
                        <p class="text-muted small mb-0">
                            &copy; {{ date('Y') }} Sistem Informasi Produksi Furnitur. All rights reserved.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 4 JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous">
    </script>

    <script>
        // Toggle password visibility
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
            const icon = this.querySelector('i');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });
    </script>
</body>

</html>
