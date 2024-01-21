<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">

    <title>Login</title>

    <!-- Fonts and Dashmix framework -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">

    {{-- dashmix css --}}
    <link rel="stylesheet" id="css-main" href="{{asset('assets/css/dashmix.min.css')}}">

    {{-- logo --}}
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('assets/logo/logo.png') }}">
    {{-- jquery --}}
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>

</head>
<body>

    <div id="page-container">

        <!-- Main Container -->
        <main id="main-container">
            <!-- Page Content -->
            <div class="row g-0 justify-content-center bg-body-dark ">
                <div class="hero-static col-sm-10 col-md-8 col-xl-6 d-flex align-items-center p-2 px-sm-0 ">
                    <!-- Sign In Block -->
                    <div class="block block-rounded block-transparent block-fx-pop w-100 mb-0 overflow-hidden bg-image bg-white" style="background-image: url('/assets/logo/logo.jpeg'); background-repeat: no-repeat; background-size: contain;
                    ">
                        <div class=" row g-0">
                            <div class="col-md-6 order-md-1 bg-body-extra-light ">
                                <div class="block-content block-content-full px-lg-5 py-md-5 py-lg-6">
                                    <!-- Header -->
                                    <div class="mb-2 text-center">
                                        <a class="link-fx fw-bold fs-1" href="{{route('welcome')}}">
                                            <span class="text-dark">To</span><span style="color: #dc3545">wards</span>
                                        </a>
                                        <p class="text-uppercase fw-bold fs-sm text-muted">Sign In</p>
                                    </div>

                                    <form method="POST" action="{{ route('login') }}">
                                        @csrf
                                        <div class="mb-4">

                                            <input id="email" type="email" class="form-control form-control-alt @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Email">

                                            @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="mb-4">

                                            <input id="password" type="password" class="form-control form-control-alt @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Password">

                                            @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="mb-4">
                                            <button type="submit" class="btn w-100 btn-hero " style="background-color: #dc3545; color: white;">
                                                <i class="fa fa-fw fa-sign-in-alt opacity-50 me-1"></i> Sign In
                                            </button>
                                        </div>
                                    </form>
                                    <!-- END Sign In Form -->
                                </div>
                            </div>
                            <div class="col-md-6 order-md-0  d-flex align-items-center">
                                <div class="block-content block-content-full px-lg-5 py-md-5 py-lg-6">
                                    <div class="d-flex">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END Sign In Block -->
                </div>
            </div>
            <!-- END Page Content -->
        </main>
        <!-- END Main Container -->
    </div>


</body>
</html>
