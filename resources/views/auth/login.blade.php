<?php
$skin = App\Utils::getColor()->skin;
?>
<!-- @extends('layouts.frontend', ['skin' => $skin]) -->

{{-- Page Title --}}
@section('page-title', 'Đăng nhập')

{{-- Main conten --}}
@section('content')
<div class="login-box mb-5">
  <div class="card card-{{ $skin }} card-outline">
    <div class="card-header">
      <h3 class="card-title text-center"><span>Đăng nhập</span></h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
      <form method="POST" action="{{ route('login') }}">
        {{ csrf_field() }}

        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label for="login" class="control-label">Tên đăng nhập | Email</label>
              <input id="login" type="text" class="form-control{{ $errors->has('username') || $errors->has('email') ? ' is-invalid' : '' }}" name="login" value="{{ old('username') ?: old('email') }}" required autofocus onfocus="var temp_value=this.value; this.value=''; this.value=temp_value">

              @if ($errors->has('username') || $errors->has('email'))
              <span class="invalid-feedback">
                <strong>{{ $errors->first('username') ?: $errors->first('email') }}</strong>
              </span>
              @endif
            </div>
            <!-- /.form-group -->
          </div>
          <!-- col-md-12 -->
        </div>
        <!-- row -->
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label for="password" class="control-label">Mật khẩu</label>
              <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

              @if ($errors->has('password'))
              <span class="invalid-feedback">
                <strong>{{ $errors->first('password') }}</strong>
              </span>
              @endif
            </div>
            <!-- /.form-group -->
          </div>
          <!-- col-md-12 -->
        </div>
        <!-- row -->
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                <label class="custom-control-label" for="remember">Ghi nhớ đăng nhập</label>
              </div>
              <!-- /.custom-control -->
            </div>
            <!-- /.form-group -->
          </div>
          <!-- col-md-12 -->
        </div>
        <!-- row -->
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <button type="submit" class="btn btn-{{ $skin }}">Đăng nhập</button>
            </div>
            <!-- /.form-group -->
          </div>
          <!-- col-md-6 -->
        </div>
        <!-- row -->
      </form>
      <!-- /form -->
    </div>
    <!-- /.card-body -->
    <div class="card-footer">
      <a href="{{ route('password.request') }}" id="resetPassword" class="text-center">Quên mật khẩu</a>
    </div>
    <!-- /.card-footer -->
  </div>
  <!-- /.card -->
</div>
<!-- /.login-box -->
@endsection