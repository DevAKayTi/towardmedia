<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="title" content="@yield('title')">
    <meta name="description" content="@yield('title')">
    <meta property="og:title" content="@yield('title')">
    <meta property="og:description" content="@yield('title')">
    <meta property="og:image" content="@yield('image_url')">
    <meta charset="ISO-8859-1">
    {{-- csrf token --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- <meta name="keywords" content="ideological revolution"> --}}
    <!-- <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/logo/favicon-16x16.png') }}"> -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/logo/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('assets/logo/logo.png') }}">
    <link rel="manifest" href="{{asset('assets/frontend/site.webmanifest')}}">
    <title>@yield('title')</title>

    <link rel="stylesheet" href="{{asset('assets/frontend/plugin/bootstrap/css/bootstrap.css')}}">
    <link rel="stylesheet" href="{{asset('assets/frontend/plugin/fontawesome/css/all.css')}}">
    <link rel="stylesheet" href="{{asset('assets/frontend/css/index.css')}}">

    {{-- fonts  --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Raleway&family=Roboto:ital,wght@0,400;1,300&display=swap" rel="stylesheet">

</head>

<body>
    <div style='width:100vw;height:100vh' class="d-flex justify-content-center">
        <div style="margin-top:120px" class="d-flex align-items-center flex-column">
        <img src="{{asset('assets/logo/logo.png')}}" alt="Logo" width="30%" class="d-inline-block align-top"  style="object-fit: contain;">
        @if(session('success'))
            <h1 style="margin-top:70px" class="fw-bold mb-3">Unsubscribe Successful</h1>
            <h5 class=" opacity-75">We have informed the sender of this email that you don't want to receive more emails from them.</h5>
        @else
            <h1 style="margin-top:70px" class="fw-bold mb-3">unSubscribe?</h1>
            <h5 class=" opacity-75">If you unscribe,we will not be able to send you new release updates.</h5>
            <h5 class=" opacity-75">Do you still want to unsubscribe <span class="text-danger">{{$email}}</span>?</h5>
            <div style="margin-top:40px">
                <form action="{{ route('unsubscribe.destroy', ['email' => $email]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <button class="btn btn-danger" type="submit" style="margin-right:20px;" id="button-addon2">Unsubscribe</button>
                <a href="https://www.towardsmedia.com/" class="btn btn-secondary opacity-50">Cancel</a>
                </form>
            </div>
        @endif
        </div>
    </div>
</body>
<script src="{{asset('assets/frontend/plugin/bootstrap/js/bootstrap.js')}}"></script>
<script src="{{asset('assets/frontend/plugin/fontawesome/js/all.js')}}"></script>


