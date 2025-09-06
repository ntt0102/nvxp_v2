<?php
$skin = App\Utils::getColor()->skin;
?>
@extends('layouts.frontend', ['skin' => $skin])

{{-- Page Title --}}
@section('page-title', 'Hướng dẫn')

@section('head-extras')
<link rel="stylesheet" href="{{ asset('dist/general/guide/guide.css') }}?update=20190423">
@endsection
@section('content')
<nav id="mySidebar" class="sidebar">
  <a href="javascript:void(0)" class="closebtn load-none" onclick="closeNav()">&times;</a>
  <a href="#search" class="nav-link load-none">Tìm trong phả đồ</a>
  <a href="#add" class="nav-link load-none">Thêm thành viên</a>
  <a href="#edit" class="nav-link load-none">Sửa thành viên</a>
  <a href="#del" class="nav-link load-none">Xóa thành viên</a>
  <a href="#branch" class="nav-link load-none">Xóa chi phái</a>
</nav>

<div id="main">
  <button class="openbtn" onclick="openNav()">&#9776;</button>
  <div class="container">
    <div class="row mb-3">
      <div class="col-md-12 text-center">
        @mobile
        <?php
        if ($mode == "") {
          $mode = "mobile";
        }
        ?>
        @elsemobile
        <?php
        if ($mode == "") {
          $mode = "desktop";
        }
        ?>
        @endmobile
        <p>Hướng dẫn dành cho:</p>
        <div class="btn-group btn-group-toggle" data-toggle="buttons">
          <label class="btn btn-danger {{ $mode == "desktop" ? 'active' : '' }}">
            <input type="radio" name="mode" value="desktop" autocomplete="off" {{ $mode == "desktop" ? 'checked' : '' }}>
            Máy tính
          </label>
          <label class="btn btn-danger {{ $mode == "mobile" ? 'active' : '' }}">
            <input type="radio" name="mode" value="mobile" autocomplete="off" {{ $mode == "mobile" ? 'checked' : '' }}>
            Điện thoại
          </label>
        </div>
      </div>
    </div>
    <div class="site-section bg-light" id="search">
      <div class="row">
        <div class="col-12 text-center mb-5">
          <div class="block-heading-1">
            <h2 class="over-text">Tìm trong phả đồ</h2>
          </div>
        </div>
      </div>
      <div class="row my-5">
        <div class="col-12">
          <p>Bước 1: Vào màn hình <a target="_blank" href="{{ route('map') }}" class="load-none">Phả đồ</a>.</p>
          <p>Bước 2: Nhấn Tìm người</p>
          <img src="{{ asset('images/guides/'.$mode.'/search/search-1.png') }}" class="zoom-in mb-2">
          <p>Bước 3: Nhập thông tin tìm kiếm (nhập nhiều thông tin để giới hạn kết quả tìm kiếm).</p>
          <p>Bước 4: Nhấn Tìm kiếm.</p>
          <p>Bước 5: Chọn kết quả cần tìm.</p>
          <img src="{{ asset('images/guides/'.$mode.'/search/search-2.png') }}" class="zoom-in mb-2">
          <p>Người cần tìm sẽ hiển thị chữ màu đỏ.</p>
          <img src="{{ asset('images/guides/'.$mode.'/search/search-3.png') }}" class="zoom-in mb-2">
        </div>
      </div>
    </div>
    <div class="site-section bg-light" id="add">
      <div class="row">
        <div class="col-12 text-center mb-5">
          <div class="block-heading-1">
            <h2 class="over-text">Thêm thành viên</h2>
          </div>
        </div>
      </div>
      <div class="row my-5">
        <div class="col-12">
          <h5 class="mb-4">Cách 1: Áp dụng khi thêm số lượng ít.</h5>
          <p>Bước 1: Nhấn vào biểu tượng <i class="fas fa-info-circle text-muted"></i> của người muốn thêm thành viên.
          </p>
          <p>Bước 2: Ở mục Thêm, chọn quan hệ với người ở bước 2 là Con trai, Con gái hoặc Vợ.</p>
          <img src="{{ asset('images/guides/'.$mode.'/add/add-1-1.png') }}" class="zoom-in mb-2">
          <p>Bước 3: Nhập họ và tên.</p>
          <p>Bước 4: Nhập thứ tự anh em (nếu quan hệ là Con trai hoặc Con gái).</p>
          <p>Bước 5: Các mục Đời mẹ (Đời vợ), Quê quán, Ghi chú có thể nhập hoặc để trống.</p>
          <p>Bước 6: Lưu thông tin.</p>
          <img src="{{ asset('images/guides/'.$mode.'/add/add-1-2.png') }}" class="zoom-in">
        </div>
      </div>
      <div class="row my-5">
        <div class="col-12">
          <h5 class="mb-4">Cách 2: Áp dụng khi thêm số lượng lớn.</h5>
          <p>Bước 1: Nhấn vào biểu tượng <i class="fas fa-info-circle text-muted"></i> của người muốn chọn làm đầu chi
            phái (Lưu ý, chọn gần với những thành viên muốn thêm để tải dữ liệu nhanh hơn).
          </p>
          <p>Bước 2: Nhấn Chọn làm chi phái.</p>
          <img src="{{ asset('images/guides/'.$mode.'/add/add-2-1.png') }}" class="zoom-in mb-2">
          <p>Bước 3: Nhập Hệ.</p>
          <p>Bước 4: Nhập quan hệ gia phả là Con trai, Con gái hoặc Vợ.</p>
          <img src="{{ asset('images/guides/'.$mode.'/add/add-2-2.png') }}" class="zoom-in mb-2">
          <p>Bước 5: Nhập họ và tên.</p>
          <p>Bước 6: Nhập cha (hoặc chồng).</p>
          <p>Bước 7: Nhập thứ tự anh em (nếu quan hệ là Con trai hoặc Con gái).</p>
          <p>Bước 8: Các mục Đời mẹ (Đời vợ), Quê quán, Ghi chú có thể nhập hoặc để trống.</p>
          <p>Bước 9: Lưu thông tin.</p>
          <img src="{{ asset('images/guides/'.$mode.'/add/add-2-3.png') }}" class="zoom-in mb-2">
          <br>
          <p><b>Thêm thành viên mới trong cùng chi phái:</b></p>
          <p>Bước 10: Chọn thêm mới thành viên.</p>
          <p>Bước 11: Chọn Chi phái đã thêm ở bước 2, và làm tương tự như bước 3 đến 9.</p>
          <img src="{{ asset('images/guides/'.$mode.'/add/add-2-4.png') }}" class="zoom-in">
        </div>
      </div>
    </div>
    <div class="site-section bg-light" id="edit">
      <div class="row">
        <div class="col-12 text-center mb-5">
          <div class="block-heading-1">
            <h2 class="over-text">Sửa thành viên</h2>
          </div>
        </div>
      </div>
      <div class="row my-5">
        <div class="col-12">
          <p>Bước 1: Nhấn vào biểu tượng <i class="fas fa-info-circle text-muted"></i> của người muốn sửa.
          </p>
          <p>Bước 2: Nhấn Chỉnh sửa.</p>
          <img src="{{ asset('images/guides/'.$mode.'/edit/edit-1.png') }}" class="zoom-in mb-2">
          <p>Bước 3: Sửa thông tin sau đó nhấn Lưu.</p>
          <img src="{{ asset('images/guides/'.$mode.'/edit/edit-2.png') }}" class="zoom-in mb-2">
        </div>
      </div>
    </div>
    <div class="site-section bg-light" id="del">
      <div class="row">
        <div class="col-12 text-center mb-5">
          <div class="block-heading-1">
            <h2 class="over-text">Xóa thành viên</h2>
          </div>
        </div>
      </div>
      <div class="row my-5">
        <div class="col-12">
          <p>Bước 1: Nhấn vào tên của mình và chọn Quản lý</p>
          <img src="{{ asset('images/guides/'.$mode.'/del/del-1.png') }}" class="zoom-in mb-2">
          <p>Bước 2: Chọn danh sách thành viên.</p>
          <p>Bước 3: Nhấn tìm kiếm để tìm thành viên muốn xóa.</p>
          <img src="{{ asset('images/guides/'.$mode.'/del/del-2.png') }}" class="zoom-in mb-2">
          <p>Bước 4: Nhập thông tin tìm kiếm và nhấn Tìm kiếm.</p>
          <img src="{{ asset('images/guides/'.$mode.'/del/del-3.png') }}" class="zoom-in mb-2">
          <p>Bước 5: Nhấn Xóa vào hàng của thành viên muốn xóa (Chú ý kiểm tra chính xác thông tin trước khi nhấn Xóa).
          </p>
          <img src="{{ asset('images/guides/'.$mode.'/del/del-4.png') }}" class="zoom-in mb-2">
          <p>Bước 6: Kiểm tra lại một lần nữa trước khi nhấn Có để xác nhận.</p>
          <img src="{{ asset('images/guides/'.$mode.'/del/del-5.png') }}" class="zoom-in">
        </div>
      </div>
    </div>
    <div class="site-section bg-light" id="branch">
      <div class="row">
        <div class="col-12 text-center mb-5">
          <div class="block-heading-1">
            <h2 class="over-text">Xóa chi phái</h2>
          </div>
        </div>
      </div>
      <div class="row my-5">
        <div class="col-12">
          <p>Bước 1: Nhấn vào tên của mình và chọn Quản lý</p>
          <img src="{{ asset('images/guides/'.$mode.'/branch/branch-1.png') }}" class="zoom-in mb-2">
          <p>Bước 2: Chọn danh sách chi phái.</p>
          <p>Bước 3: Nhấn Xóa vào hàng của chi phái muốn xóa (Chú ý kiểm tra chính xác thông tin trước khi nhấn Xóa).
          </p>
          <img src="{{ asset('images/guides/'.$mode.'/branch/branch-2.png') }}" class="zoom-in mb-2">
          <p>Bước 4: Kiểm tra lại một lần nữa trước khi nhấn Có để xác nhận.</p>
          <img src="{{ asset('images/guides/'.$mode.'/branch/branch-3.png') }}" class="zoom-in">
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

{{-- Footer Extras to be Included --}}
@section('footer-extras')
<script src="{{ asset('dist/general/guide/guide.js') }}?update=20190423"></script>
@endsection