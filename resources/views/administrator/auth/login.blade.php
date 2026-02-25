<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <title>Login | Administrator</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
    <link rel="icon" type="imagepng" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('site.webmanifest') }}">

    <!-- App css -->
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/app.css') }}" rel="stylesheet" type="text/css" id="light-style" />

    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            font-weight: normal;
        }

        .h1,
        .h2,
        .h3,
        .h4,
        .h5,
        .h6,
        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-weight: 500;
        }

        label {
            font-weight: 500;
        }
    </style>
</head>

<body class="">

    <div class="auth-fluid">
        <!--Auth fluid left content -->
        <div class="auth-fluid-form-box pb-4 px-3">
            <div class="align-items-center d-flex h-100">
                <div class="card-body">

                    <!-- Logo -->
                    <div class="auth-brand text-start">
                        <a href="/" class="logo-dark">
                            <span><img src="{{ asset('assets/images/logo/login-logo.png') }}" width="60%"></span>
                        </a>
                        <a href="/" class="logo-light">
                            <span><img src="{{ asset('assets/images/logo/login-logo.png') }}" width="60%"></span>
                        </a>
                    </div>

                    <!-- title-->
                     <br>
                    <h4 class="mt-0">Administrator Login</h4>
                    <p class="text-danger mb-4">Enter your email address and password to access account.</p>

                    <!-- form -->
                    <form method="POST" action="{{ route('administrator.login') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label">Email address</label>
                            <input id="email" type="email"
                                class="form-control @error('email') is-invalid @enderror" name="email"
                                value="{{ old('email') }}" autocomplete="email" autofocus>
                            @error('email')
                                <code id="email-error" class="text-danger">{{ $message }}</code>
                            @enderror
                        </div>
                        <div class="mb-3">

                            <a href="{{ route('administrator.password.request') }}"
                                class="text-danger float-end"><small>Forgot
                                    your password?</small></a>

                            <label for="password" class="form-label">Password</label>
                            <input id="password" type="password"
                                class="form-control @error('password') is-invalid @enderror" name="password"
                                autocomplete="current-password">
                            @error('password')
                                <code id="password-error" class="text-danger">{{ $message }}</code>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <div class="form-check">
                                <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}
                                    class="form-check-input" id="checkbox-signin">
                                <label class="form-check-label" for="checkbox-signin">Remember me</label>
                            </div>
                        </div>
                        <div class="d-grid mb-0 text-center">
                            <button class="btn btn-danger btn-userlogin" type="submit"><i class="mdi mdi-login"></i>
                                Log In
                            </button>
                        </div>
                    </form>
                    <!-- end form-->

                </div> <!-- end .card-body -->
            </div> <!-- end .align-items-center.d-flex.h-100-->
        </div>
        <!-- end auth-fluid-form-box-->

        <!-- Auth fluid right content -->
        <div class="auth-fluid-right">
            <div class="auth-user-testimonial align-items-center d-flex h-100">
                {{-- <h2 class="mb-3">I love the Mosaiek Expo!</h2>
                <p class="lead"><i class="mdi mdi-format-quote-open"></i> It's a elegent platform. I love it very
                    much! . <i class="mdi mdi-format-quote-close"></i>
                </p>
                <p>
                    - Mosaiek Expo User
                </p> --}}

            </div>
        </div>
        <!-- end Auth fluid right content -->
    </div>
    <!-- end auth-fluid-->

    <!-- bundle -->

</body>

</html>
