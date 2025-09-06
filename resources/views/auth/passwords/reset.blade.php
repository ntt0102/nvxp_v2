<?php
$skin = App\Utils::getColor()->skin;
?>
@extends('layouts.frontend', ['skin' => $skin])

{{-- Page Title --}}
@section('page-title', 'Đặt lại mật khẩu')
<!-- Main content -->
@section('content')
<div class="login-box">
    <div class="card card-{{ $skin }} card-outline">
        <div class="card-header">
            <p class="card-title text-center">Đổi mật khẩu mới</p>
        </div>
        <!-- /.card-header -->
        <div class="card-body login-card-body1">
            <form method="POST" action="{{ route('password.request') }}">
                {{ csrf_field() }}

                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="email" class="form-control-label">Email</label>
                            <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" required autofocus>
                            @if ($errors->has('email'))
                            <div class="invalid-feedback">{{ $errors->first('email') }}</div>
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
                            <label for="password" class="form-control-label">Mật khẩu</label>
                            <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" value="{{ old('password') }}" required>
                            @if ($errors->has('password'))
                            <div class="invalid-feedback">Mật khẩu {{ $errors->first('password') }}</div>
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
                            <label for="password-confirm" class="form-control-label">Xác nhận mật khẩu</label>
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                        </div>
                        <!-- /.form-group -->
                    </div>
                    <!-- col-md-12 -->
                </div>
                <!-- row -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <button type="submit" class="btn btn-{{ $skin }}">Đặt lại mật khẩu</button>
                        </div>
                        <!-- /.form-group -->
                    </div>
                    <!-- col-md-12 -->
                </div>
                <!-- row -->
            </form>
            <!-- /form -->
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
</div>
<!-- /.login-box -->
@endsection