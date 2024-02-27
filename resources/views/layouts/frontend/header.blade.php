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
    <div class="container-fullwidth" style="min-height: calc(100vh - 120px);">
        <!-- Nav Bar -->
        <div class="container">
            <nav class="navbar navbar-expand-md navbar-light">
                <a class="navbar-brand" href="{{route('welcome')}}">
                    <img src="{{asset('assets/logo/logo.png')}}" alt="Logo" width="70" class="d-inline-block align-top"  style="object-fit: cover;">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#toggleMobileMenu" aria-controls="toggleMobileMenu" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="toggleMobileMenu">
                    <ul class="navbar-nav ms-auto text-center">
                        <li class="mx-3">
                            <a class="nav-link {{ request()->routeIs('welcome') ? 'active' : ' '}} " href="{{route('welcome')}}">Home</a>
                        </li>
                        <li class="mx-3">
                            <a class="nav-link {{ request()->routeIs('articles') ? 'active' : ' '}} " href="{{route('articles')}}">News/Articles</a>
                        </li>
                        <li class="mx-3">
                            <a class="nav-link {{ request()->routeIs('volumes') ? 'active' : ' '}} " href="{{route('volumes')}}">Newsletter</a>
                        </li>
                        <li class="mx-3">
                            <a class="nav-link {{ request()->routeIs('bulletins') ? 'active' : ' '}} " href="{{route('bulletins')}}">Bulletin</a>
                        </li>
                        <li class=" mx-3">
                            <a class="nav-link {{ request()->routeIs('podcasts') ? 'active' : ' '}} " href="{{route('podcasts')}}">Podcasts</a>
                        </li>
                        <li class="mx-3">
                            <a class="nav-link {{ request()->routeIs('about-us') ? 'active' : ' '}} " href="{{route('about-us')}}">About</a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>

        <hr class="mt-0" />
