<?php
$myUser = Auth::user();
$adminCondition = $myUser && in_array($myUser->role, [branch_manager_role(), administrator_role()]);
?>
<!-- Main Header -->
<nav class="navbar navbar-expand-md bg-{{ $skin }}-gradient navbar-{{ $skin == 'warning' ? 'light' : 'dark'}} fixed-top ">
  <!-- Logo -->

  <a href="{{ route('welcome') }}" class="mr-5" title="{{ \App\Utils::checkRoute(['welcome']) ? '': 'Trở về trang chủ' }}">
    <img src="{{ asset('images/logo-nobg.png') }}" alt="{{ config('adminlte.name') }}" class="brand-image img-circle elevation-3" style="background: white; width: 30px;">
    <span class="text-light {{ \App\Utils::checkRoute(['welcome']) ? 'active': '' }}">{{ config('adminlte.name') }}</span>
  </a>
  <!-- Fullscreen On Phone -->
  <!-- <a class="fullscreen load-none d-block d-sm-none" title="Phóng to màn hình" onclick="toggleFullScreen(document.body)"><i class="fas fa-expand"></i></a> -->

  <!-- Toggle Icon -->
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <!-- Navbar links -->
  <div class="collapse navbar-collapse" id="navbarColor01">
    <!-- Left navbar links -->
    <ul class="navbar-nav mr-auto">
      <li class="nav-item {{ \App\Utils::checkRoute(['map']) ? 'active': '' }}">
        <a href="{{ route('map') }}" class="nav-link"><i class="fas fa-sitemap"></i> Phả đồ</a>
      </li>
      <li class="nav-item {{ \App\Utils::checkRoute(['introduction']) ? 'active': '' }}">
        <a href="{{ route('introduction') }}" class="nav-link"><i class="fas fa-book"></i> Phả ký</a>
      </li>
      <li class="nav-item {{ \App\Utils::checkRoute(['teaching']) ? 'active': '' }}">
        <a href="{{ route('teaching') }}" class="nav-link"><i class="fas fa-book-open"></i> Gia huấn ca</a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle load-none {{ \App\Utils::checkRoute(['filter', 'propose', 'statistic', 'uppermap']) ? 'active': '' }}" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="nav-icon fas fa-ellipsis-v"></i> Xem thêm
        </a>
        <div class="dropdown-menu">
          @auth
          <a class="dropdown-item {{ \App\Utils::checkRoute(['admin::members.create']) ? 'active': '' }}" href="{{ route('admin::members.create') }}"><i class="fas fa-user-plus"></i> Thêm người</a>
          @endauth
          <a class="dropdown-item {{ \App\Utils::checkRoute(['filter']) ? 'active': '' }}" href="{{ route('filter') }}?filterMode=view"><i class="fas fa-search"></i> Tìm trong phả đồ</a>
          <a class="dropdown-item {{ \App\Utils::checkRoute(['statistic']) ? 'active': '' }}" href="{{ route('statistic').'?id=1' }}"><i class="fas fa-chart-area"></i> Thống kê con cháu</a>
          <a class="dropdown-item {{ \App\Utils::checkRoute(['propose']) ? 'active': '' }}" href="{{ route('propose', 0) }}"><i class="fas fa-comment-dots"></i> Đề xuất sửa đổi</a>
          <a class="dropdown-item {{ \App\Utils::checkRoute(['uppermap']) ? 'active': '' }}" href="{{ route('uppermap') }}"><i class="fas fa-sitemap"></i> Thượng tôn đồ</a>
        </div>
      </li>
    </ul>
    <!-- Right navbar links -->
    <ul class="navbar-nav navbar-right navbar-right-link">
      @guest
      @if (Route::has('login') && !\App\Utils::checkRoute(['login']))
      <li class="nav-item">
        <a class="nav-link" href="{{ route('login') }}"><i class="fas fa-sign-in-alt"></i> Quản lý</a>
      </li>
      @endif
      @else
      @auth
      <li class="nav-item {{ \App\Utils::checkRoute(['guide']) ? 'active': '' }}">
        <a href="{{ route('guide') }}" class="nav-link load-none" target="_blank"><i class="fas fa-question-circle"></i>
          Hướng dẫn</a>
      </li>
      @endauth
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle load-none" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <img src="{{ Auth::user()->getAvatarPath() }}" alt="profile-photo" class="img-circle elevation-4" width="30px;" style="margin-top: -10px;">&nbsp;
          {{ Auth::user()->getUserName() }}
        </a>
        <div class="dropdown-menu mt-1" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="{{ route('dashboard::index') }}">
            <i class="nav-icon fas fa-tachometer-alt"></i> Quản lý
          </a>
          <a class="dropdown-item" href="{{ route('admin::members.edit', Auth::user()->getMemberId()) }}">
            <i class="nav-icon fas fa-user-circle"></i> Hồ sơ cá nhân
          </a>
          <a class="dropdown-item" href="{{ route('admin::users.change-password') }}">
            <i class="nav-icon fas fa-unlock-alt"></i> Đổi mật khẩu
          </a>
          <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="nav-icon fas fa-sign-out-alt"></i> Đăng xuất
          </a>
          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            {{ csrf_field() }}
          </form>
        </div>
      </li>
      @endguest
      <!-- <li class="nav-item d-none d-sm-block">
        <a class="nav-link load-none fullscreen" title="Phóng to màn hình" onclick="toggleFullScreen(document.body)"><i class="fas fa-expand"></i></a>
      </li> -->
    </ul>
    <!-- ./navbar-right-->
  </div>
  <!-- ./navbar-collapse -->
</nav>