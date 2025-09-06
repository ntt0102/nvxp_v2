<?php
$myUser = Auth::user();
?>
<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-{{ $theme }}-{{ $skin }} elevation-4">
  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel d-flex">
      <div class="image">
        <a href="{{ route('admin::members.edit', $myUser->id) }}">
          <img src="{{ $myUser->getAvatarPath() }}" class="img-circle elevation-2" alt="Ảnh đại diện">
        </a>
      </div>
      <div class="info">
        <a href="{{ route('admin::members.edit', $myUser->id) }}" class="d-block">{{ $myUser->getUserName() }}</a>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
        <?php
        $isCurrentRoute = App\Utils::checkRoute(['dashboard::index', 'admin::index']);
        ?>
        <li class="nav-item">
          <a href="{{ route('dashboard::index') }}" class="nav-link {{ $isCurrentRoute ? 'active': '' }}">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>Tổng quan</p>
          </a>
        </li>
        <div class="nav-divider"></div>
        <?php
        $isCurrentRoute = App\Utils::checkRoute(['admin::members.index', 'admin::members.create', 'admin::members.edit', 'admin::logs']);
        ?>
        <li class="nav-item has-treeview {{ $isCurrentRoute ? 'menu-open': '' }}">
          <a class="nav-link load-none {{ $isCurrentRoute ? 'active': '' }}" href="#">
            <i class="nav-icon fas fa-user"></i>
            <p>
              Thành viên
              <i class="right fa fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('admin::members.index') }}" class="nav-link {{ \App\Utils::checkRoute(['admin::members.index', 'admin::members.edit']) ? 'active': '' }}">
                <i class="fas fa-list-alt nav-icon"></i>
                <p>Danh sách</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('admin::members.create') }}" class="nav-link {{ \App\Utils::checkRoute(['admin::members.create']) ? 'active': '' }}">
                <i class="fas fa-user-plus nav-icon"></i>
                <p>Thêm mới</p>
              </a>
            </li>
          </ul>
        </li>
        @if($myUser->role == 2)
        <div class="nav-divider"></div>
        <li class="nav-item">
          <a href="{{ route('admin::logs') }}" class="nav-link {{ \App\Utils::checkRoute(['admin::logs']) ? 'active': '' }}">
            <i class="nav-icon fas fa-history"></i>
            <p>Lịch sử</p>
          </a>
        </li>
        @endif
        @if($myUser->role == 1)
        <div class="nav-divider"></div>
        <?php
        $isCurrentRoute = App\Utils::checkRoute(['admin::classifies.index', 'admin::classifies.create', 'admin::classifies.edit']);
        ?>
        <li class="nav-item has-treeview {{ $isCurrentRoute ? 'menu-open': '' }}">
          <a class="nav-link load-none {{ $isCurrentRoute ? 'active': '' }}" href="#">
            <i class="nav-icon fas fa-users"></i>
            <p>
              Chi phái
              <i class="right fa fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('admin::classifies.index').($myUser->role == 1 ? '?constant=4' : '') }}" class="nav-link {{ \App\Utils::checkRoute(['admin::classifies.index', 'admin::classifies.edit']) ? 'active': '' }}">
                <i class="fas fa-list-ul nav-icon"></i>
                <p>Danh sách</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('admin::classifies.create') }}" class="nav-link {{ \App\Utils::checkRoute(['admin::classifies.create']) ? 'active': '' }}">
                <i class="fas fa-plus nav-icon"></i>
                <p>Tạo mới</p>
              </a>
            </li>
          </ul>
        </li>
        @endif
        <div class="nav-divider"></div>
        <?php
        $isCurrentRoute = App\Utils::checkRoute(['admin::proposes', 'admin::proposes.detail']);
        $proposes = App\Utils::getProposes();
        ?>
        <li class="nav-item">
          <a href="{{ route('admin::proposes') }}" class="nav-link {{ $isCurrentRoute ? 'active': '' }}">
            <i class="nav-icon fas fa-user-edit"></i>
            <p>Đề xuất</p>
            @if($proposes)
            <span class="badge badge-warning float-right">{{ $proposes }}</span>
            @endif
          </a>
        </li>
        @if($myUser->role == 2)
        <div class="nav-divider"></div>
        <?php
        $isCurrentRoute = App\Utils::checkRoute(['admin::users.index', 'admin::users.create', 'admin::users.edit']);
        ?>
        <li class="nav-item has-treeview {{ $isCurrentRoute ? 'menu-open': '' }}">
          <a class="nav-link load-none {{ $isCurrentRoute ? 'active': '' }}" href="#">
            <i class="nav-icon fas fa-user-shield"></i>
            <p>
              Quản trị viên
              <i class="right fa fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('admin::users.index') }}" class="nav-link {{ \App\Utils::checkRoute(['admin::users.index', 'admin::users.edit']) ? 'active': '' }}">
                <i class="fas fa-list-ul nav-icon"></i>
                <p>Danh sách</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('admin::users.create') }}" class="nav-link {{ \App\Utils::checkRoute(['admin::users.create']) ? 'active': '' }}">
                <i class="fas fa-plus nav-icon"></i>
                <p>Tạo mới</p>
              </a>
            </li>
          </ul>
        </li>
        @endif
        @if($myUser->role == 2)
        <div class="nav-divider"></div>
        <?php
        $isCurrentRoute = App\Utils::checkRoute(['admin::constants.index', 'admin::constants.create', 'admin::constants.edit']);
        ?>
        <li class="nav-item has-treeview {{ $isCurrentRoute ? 'menu-open': '' }}">
          <a class="nav-link load-none {{ $isCurrentRoute ? 'active': '' }}" href="#">
            <i class="nav-icon fab fa-adn"></i>
            <p>
              Định danh
              <i class="right fa fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('admin::constants.index') }}" class="nav-link {{ \App\Utils::checkRoute(['admin::constants.index', 'admin::constants.edit']) ? 'active': '' }}">
                <i class="fas fa-list-ul nav-icon"></i>
                <p>Danh sách</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('admin::constants.create') }}" class="nav-link {{ \App\Utils::checkRoute(['admin::constants.create']) ? 'active': '' }}">
                <i class="fas fa-plus nav-icon"></i>
                <p>Tạo mới</p>
              </a>
            </li>
          </ul>
        </li>
        <div class="nav-divider"></div>
        <?php
        $isCurrentRoute = App\Utils::checkRoute(['admin::classifies.index', 'admin::classifies.create', 'admin::classifies.edit']);
        ?>
        <li class="nav-item has-treeview {{ $isCurrentRoute ? 'menu-open': '' }}">
          <a class="nav-link load-none {{ $isCurrentRoute ? 'active': '' }}" href="#">
            <i class="nav-icon fas fa-list-ol"></i>
            <p>
              Danh mục
              <i class="right fa fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('admin::classifies.index').($myUser->role == 1 ? '?constant=4' : '') }}" class="nav-link {{ \App\Utils::checkRoute(['admin::classifies.index', 'admin::classifies.edit']) ? 'active': '' }}">
                <i class="fas fa-list-ul nav-icon"></i>
                <p>Danh sách</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('admin::classifies.create') }}" class="nav-link {{ \App\Utils::checkRoute(['admin::classifies.create']) ? 'active': '' }}">
                <i class="fas fa-plus nav-icon"></i>
                <p>Tạo mới</p>
              </a>
            </li>
          </ul>
        </li>
        <div class="nav-divider"></div>
        <?php
        $isCurrentRoute = App\Utils::checkRoute(['admin::command']);
        ?>
        <li class="nav-item">
          <a href="{{ route('admin::command') }}" class="nav-link {{ $isCurrentRoute ? 'active': '' }}">
            <i class="nav-icon fas fa-terminal"></i>
            <p>Chạy lệnh</p>
          </a>
        </li>
        @endif
        @auth
        <div class="nav-divider"></div>
        <?php
        $isCurrentRoute = App\Utils::checkRoute(['admin::users.change-password']);
        ?>
        <li class="nav-item">
          <a href="{{ route('admin::users.change-password') }}" class="nav-link {{ $isCurrentRoute ? 'active': '' }}">
            <i class="nav-icon fas fa-unlock-alt"></i>
            <p>Đổi mật khẩu</p>
          </a>
        </li>
        @endauth
        <li class="nav-separator"></li>
        <li class="nav-item">
          <a href="#" class="nav-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="nav-icon  fas fa-sign-out-alt"></i>
            <p>Đăng xuất</p>
          </a>

          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            {{ csrf_field() }}
          </form>
        </li>
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>