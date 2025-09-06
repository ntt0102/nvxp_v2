<!-- Navbar -->
<nav
  class="main-header navbar navbar-expand bg-{{ $skin }}-gradient navbar-{{ $skin == 'warning' ? 'light' : 'dark'}} fixed-top">
  <!-- Left navbar links -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link load-none" href="#" data-widget="pushmenu"><i class="fas fa-bars"></i></a>
    </li>
    <li class="nav-item">
      <a href="{{ route('welcome') }}" class="nav-link"><i class="fas fa-home"></i> <span
          class="d-none d-sm-inline-block">Trang chủ</span></a>
    </li>
    <li class="nav-item">
      <a href="{{ route('map') }}" class="nav-link"><i class="fas fa-sitemap"></i> <span
          class="d-none d-sm-inline-block">Phả đồ</span></a>
    </li>
    <li class="nav-item">
      <?php
        switch (Route::currentRouteName()) {
          case "admin::index":
            $filterParam = "?filterMode=statistic";
            $filterIcon = "fas fa-search";
            $filterTitle = "Tìm chi phái";
            break;
          case "admin::members.index":
          case "admin::members.edit":
            $filterParam = "?filterMode=modify";
            $filterIcon = "fas fa-search";
            $filterTitle = "Tìm kiếm";
            break;
          case "admin::members.create":
          case "admin::classifies.index":
          case "admin::classifies.create":
          case "admin::classifies.edit":
            $filterParam = "?filterMode=branch";
            $filterIcon = "fas fa-search-plus";
            $filterTitle = "Thêm chi phái mới";
            break;
          default:
            $filterParam = "?filterMode=view";
            $filterIcon = "fas fa-search";
            $filterTitle = "Tìm kiếm";
            break;
        }
        ?>
      <a id="btnFilter" href="#" data-link="{{ route('filter').$filterParam }}" class="nav-link"><i
          class="{{$filterIcon}}"></i> <span class="d-none d-sm-inline-block">{{$filterTitle}}</span></a>
    </li>
  </ul>
  <!-- Right navbar links -->
  <ul class="navbar-nav ml-auto">
    {{-- <li class="nav-item">
      <a class="fullscreen nav-link load-none" title="Phóng to màn hình" onclick="toggleFullScreen(document.body)"><i
          class="fas fa-expand"></i></a>
    </li> --}}
    <li class="nav-item">
      <a href="{{ route('guide') }}" class="nav-link load-none" target="_blank"><i class="far fa-question-circle"></i>
        <span class="d-none d-sm-inline-block">Hướng dẫn</span></a>
    </li>
  </ul>
</nav>
<!-- /.navbar -->