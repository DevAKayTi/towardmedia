<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">

    <title>Towards</title>

    <meta name="description" content="Towards">

    {{-- csrf token --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/logo/favicon-16x16.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/logo/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('assets/logo/logo.png') }}">

    <!-- Stylesheets -->
    <!-- Fonts and Dashmix framework -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
    {{-- select 2 --}}
    <link rel="stylesheet" href="{{asset('assets/plugins/select2/css/select2.min.css')}}">

    {{-- dropify --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css" />

    {{-- datatable --}}
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-bs5/css/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{asset('assets/plugins/datatables-buttons-bs5/css/buttons.bootstrap5.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/plugins/datatables-responsive-bs5/css/responsive.bootstrap5.min.css')}}">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    {{-- dashmixcss --}}
    <link rel="stylesheet" id="css-main" href="{{asset('assets/css/dashmix.min.css')}}">


    <!-- Styles -->
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">

    {{-- jquery --}}
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>

    {{-- date picker --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.js"></script>

    {{-- toastr --}}
    <link rel="stylesheet" href="{{asset('assets/js/toastr/build/toastr.min.css')}}">
    @yield('css')


</head>

<body>

    <div id="page-container" class="sidebar-o sidebar-dark enable-page-overlay side-scroll page-header-fixed main-content-narrow">
        @include('layouts.backend.rightSideBar')

        @include('layouts.backend.sidebar')

        @include('layouts.backend.nav')

        <main id="main-container">
