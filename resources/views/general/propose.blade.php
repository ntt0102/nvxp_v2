<?php
$skin = App\Utils::getColor()->skin;
$_pageTitle = 'Đề xuất sửa đổi';
?>

{{-- Extends Layout --}}
@extends('layouts.frontend', ['skin' => $skin])

{{-- Page Title --}}
@section('page-title', $_pageTitle)

{{-- Header Extras to be Included --}}
@section('head-extras')
@endsection

@section('content')
<div class="row justify-content-center" style="padding: 0 10px;">
  <div class="col-md-12">
    <h3 class="title">Đề xuất</h3>
    <form method="POST" action="{{ route('propose.send') }}">
      {{ csrf_field() }}
      <div class="card card-skin card-{{ $skin }} card-outline">
        <div class="card-body">
          <div class="row">
            <div class="col-md-7">
              <div class="form-group">
                <label for="description" class="form-control-label">Mô tả <i class="far fa-question-circle" id="desc-title"></i></label>
                <textarea id="description" name="description" class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}" rows="10" required autofocus onfocus="var temp_value=this.value; this.value=''; this.value=temp_value"></textarea>
                @if ($errors->has('description'))
                <div class="invalid-feedback">Mô tả {{ $errors->first('description') }}</div>
                @endif
              </div>
            </div>
            <!-- col -->
            <div class="col-md-4">
              <div class="form-group">
                <input type="file" id="image" class="hide" accept="image/*" onchange="readURL(this);">
                <input type="hidden" id="hd-image" name="image">
                <div class="text-center">
                  <label for="image">
                    <div class="btn btn-sm btn-default"><i class="far fa-image"></i> Chọn ảnh</div>
                  </label>
                  <div class="btn btn-sm btn-default hide" id="delete-image" onclick="readURL();"><i class="fas fa-times"></i> Xóa ảnh</div>
                </div>
                <div class="mt-1 text-center"><img id="preview" src="" class="zoom-in" style="max-height: 240px; max-width: 100%;"></div>
              </div>
            </div>
            <!-- col -->
          </div>
          <!-- row -->
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
          <input type="hidden" name="memberId" value="{{ $memberId }}">
          <input type="hidden" name="param" value="">
          <button type="submit" class="btn btn-skin btn-{{ $skin }}"><i class="fas fa-share-square"></i> Gửi</button>
          <span id="btnCancel" route="{{ route("map") }}" class="btn btn-secondary ml-3 load">
            <i class="fas fa-ban"></i> <span>Hủy</span>
          </span>
        </div>
        <!-- /.card-footer -->
      </div>
      <!-- /.card -->
    </form>
    <!-- /form -->
  </div>
  <!-- /.col -->
</div>
<!-- /.row -->
@endsection

{{-- Footer Extras to be Included --}}
@section('footer-extras')
<script src="{{ asset('dist/general/propose/propose.js?update=20190423') }}"></script>
@endsection