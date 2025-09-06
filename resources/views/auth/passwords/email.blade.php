<?php
  $skin = App\Utils::getColor()->skin;
?>
@extends('layouts.frontend', ['skin' => $skin])

{{-- Page Title --}}
@section('page-title', 'Quên mật khẩu')
<!-- Main content -->
@section('content')

@if (session('status')) 
    <div class="alert alert-success mt-3" >
        Chúng tôi đã gửi đường dẫn đặt lại mật khẩu tới email của bạn. Nếu không nhận được email xin vui lòng gửi lại.
    </div>
@endif
<div class="login-box">
    <div class="card card-{{ $skin }} card-outline">
        <div class="card-header">
          <p class="card-title text-center">Đặt lại mật khẩu</p>
        </div>
        <!-- /.card-header --> 
        <div class="card-body">
            <form id="email-form" method="POST" action="{{ route('password.email') }}">
                {{ csrf_field() }}

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="email" class="form-control-label">Email</label>
                            <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" required autofocus>
                            @if ($errors->has('email'))
                                <div class="invalid-feedback">Email {{ $errors->first('email') }}</div>
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
                            <button type="submit" class="btn btn-{{ $skin }}">Gửi email</button>
                        </div>
                        <p>Hoặc liên hệ với ban quản lý trang web.</p>
                        <!-- /.form-group -->
                    </div>
                    <!-- col-md-12 -->
                </div>
                <!-- row -->
            </form>
            <!-- /form -->
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            <p class="text-center"><em>Nếu bạn còn nhớ mật khẩu thì hãy bấm vào <a href="{{ route('login') }}">đây</a> để đăng nhập hoặc <a href="{{ route('welcome') }}">quay về trang chủ</a></em></p>
        </div>
        <!-- /.card-footer -->
    </div>
    <!-- /.card -->
</div>
<!-- /.login-box -->
@endsection

{{-- Footer --}}
@section('footer')
  @includeIf('layouts.partials.frontend.footer2')
@endsection