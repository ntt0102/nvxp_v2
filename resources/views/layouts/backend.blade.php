<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <meta name="robots" content="noindex, nofollow, noarchive">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="user-id" content="{{ Auth::user()->id }}">
  <meta name="user-role" content="{{ Auth::user()->role }}">

  <!-- PWA Manifest -->
  <link rel="manifest" href="/manifest.json">

  <title>@hasSection('page-title') @yield('page-title') @endif</title>

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
  <link rel="stylesheet" href="{{ asset('dist/layouts/backend.css') }}?update=20190423">

  @yield('head-extras')
</head>

<!-- ADD THE CLASS layout-top-nav TO REMOVE THE SIDEBAR. -->

<body class="hold-transition sidebar-mini">
  <!-- Back to Top -->
  <span id="goTop"><i class="fas fa-angle-up"></i></span>
  <!-- Loading -->
  <div class="load-waiting">
    <div class="text-center text-{{ $skin }}">
      <i class="fas fa-circle-notch fa-spin fa-3x"></i>
      <div></div>
      <datalist class="ajax">
      </datalist>
    </div>
  </div>

  <!-- Site wrapper -->
  <div class="wrapper">
    <!-- Header -->
    @includeIf('layouts.partials.backend.header', ['theme' => $theme, 'skin' => $skin])
    <!-- Main Sidebar -->
    @includeIf('layouts.partials.backend.main-sidebar', ['theme' => $theme, 'skin' => $skin])

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0 text-dark">
                @yield('page-title')
              </h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              @yield('breadcrumbs')
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

      <!-- Main content -->
      <div class="content">
        <div class="container-fluid">
          @includeIf('flash::message')

          @yield('content')
        </div>
        <!-- /.container-fluid -->
      </div>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    @includeIf('layouts.partials.backend.control-sidebar', ['theme' => $theme, 'skin' => $skin])
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
  <script src="{{ asset('dist/layouts/backend.js') }}?update=20190423"></script>

  <!-- OPTIONAL SCRIPTS -->
  <script src="{{ asset('dist/_partials/cookie/cookie.js') }}?update=20190423"></script>
  <script src="{{ asset('dist/_partials/ajax/ajax.js') }}?update=20190423"></script>

  @yield('footer-extras')

  @stack('footer-scripts')
</body>

</html>