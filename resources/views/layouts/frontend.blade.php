<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="robots" content="noindex, nofollow, noarchive">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- PWA Manifest -->
    <link rel="manifest" href="/manifest.json">

    <title>@yield('page-title')</title>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css">
    <!-- Admin LTE -->
    <link rel="stylesheet" href="{{ asset('plugins/adminlte/adminlte.min.css') }}?update=20190423">
    <!-- Jquery Confirm -->
    <link rel="stylesheet" href="{{ asset('plugins/jquery-confirm/jquery-confirm.css') }}?update=20190423">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,400i,700" rel="stylesheet">
    <!-- Layout -->
    <link rel="stylesheet" href="{{ asset('dist/common/common.css') }}?update=20190423">
    <link rel="stylesheet" href="{{ asset('dist/layouts/frontend.css') }}?update=20190423">

    @yield('head-extras')
</head>

<!-- ADD THE CLASS layout-top-nav TO REMOVE THE SIDEBAR. -->

<body class="hold-transition">
    <!-- Back to Top -->
    <span id="goTop"><i class="fas fa-angle-up"></i></span>
    <!-- Loading -->
    <div class="load-waiting">
        <div class="text-center text-{{ $skin }}">
            <i class="fas fa-circle-notch fa-spin fa-3x"></i>
            <div></div>
        </div>
    </div>
    <!-- Site wrapper -->
    <div class="wrapper" style="background: linear-gradient(rgba(255, 255, 255, 0.6), rgba(0, 0, 0, 0.5)),
    url({{ asset('images/background.jpg') }}); background-size1: cover;">
        <!-- Header -->
        @includeIf('layouts.partials.frontend.header', ['skin' => $skin])
        <!-- Content -->
        <div class="content-wrapper">
            @includeIf('flash::message')
            @yield('content')
        </div>
        @yield('footer')
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->
    <!-- jQuery -->
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}?update=20190423"></script>
    <!-- Bootstrap -->
    <script src="{{ asset('plugins/bootstrap/bootstrap.bundle.min.js') }}?update=20190423"></script>
    <!-- AdminLTE -->
    <script src="{{ asset('plugins/adminlte/adminlte.min.js') }}?update=20190423"></script>
    <!-- Jquery Confirm -->
    <script src="{{ asset('plugins/jquery-confirm/jquery-confirm.js') }}?update=20190423"></script>
    <!-- Common -->
    <script src="{{ asset('dist/common/common.js') }}?update=20190423"></script>
    <script src="{{ asset('dist/layouts/frontend.js') }}?update=20190423"></script>

    <!-- OPTIONAL SCRIPTS -->
    <script src="{{ asset('dist/_partials/cookie/cookie.js') }}?update=20190423"></script>
    <script src="{{ asset('dist/_partials/ajax/ajax.js') }}?update=20190423"></script>

    @yield('footer-extras')

    @stack('footer-scripts')
</body>

</html>