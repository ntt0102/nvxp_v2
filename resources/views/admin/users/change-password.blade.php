<?php
$color = App\Utils::getColor();
?>

{{-- Extends Layout --}}
@extends('layouts.backend', ['theme' => $color->theme, 'skin' => $color->skin])

<?php
$resourceTitle = "Đổi mật khẩu";
$_pageTitle = ucfirst($resourceTitle);
$_storeLink = route($resourceRoutesAlias . '.change-password');
//
$myUser = Auth::user();
?>

{{-- Breadcrumbs --}}
@section('breadcrumbs')
{!! Breadcrumbs::render($resourceRoutesAlias.'.change-password') !!}
@endsection

{{-- Page Title --}}
@section('page-title', $_pageTitle)

{{-- Header Extras to be Included --}}
{{-- @section('head-extras')
@includeIf($resourceAlias.'.header.form')
@endsection --}}

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card card-skin card-{{ $color->skin }} card-outline">
            <form class="form" role="form" method="POST" action="{{ $_storeLink }}">
                {{ csrf_field() }}
                {{ redirect_back_field() }}

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="oldpassword" class="form-control-label">Mật khẩu hiện tại</label>
                                        <input id="oldpassword" type="password" class="form-control{{ $errors->has('oldpassword') ? ' is-invalid' : '' }}" name="oldpassword" value="{{ old('oldpassword') }}" autofocus>
                                        @if ($errors->has('oldpassword'))
                                        <div class="invalid-feedback">Mật khẩu hiện tại
                                            {{ $errors->first('oldpassword') }}
                                        </div>
                                        @endif
                                    </div>
                                    <!-- /.form-group -->
                                </div>
                                <!-- col-md-12 -->
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="password" class="form-control-label">Mật khẩu mới</label>
                                        <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" {{ !$errors->has('oldpassword') && $errors->has('password') ? 'autofocus' : '' }}>
                                        @if ($errors->has('password'))
                                        <div class="invalid-feedback">Mật khẩu mới {{ $errors->first('password') }}
                                        </div>
                                        @endif
                                    </div>
                                    <!-- /.form-group -->
                                </div>
                                <!-- col-md-12 -->
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="password-confirm" class="form-control-label">Nhập lại mật khẩu
                                            mới</label>
                                        <input id="password-confirm" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password_confirmation">
                                    </div>
                                    <!-- /.form-group -->
                                </div>
                                <!-- col-md-12 -->
                            </div>
                            <!-- row -->
                        </div>
                        <!-- /.col-md-12 -->
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer clearfix">
                    <div class="row">
                        <div class="col-md-12">
                            <button class="btn btn-skin btn-success">
                                <i class="fas fa-save"></i> <span>Lưu</span>
                            </button>
                        </div>
                        <!-- /.col-md-9 -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.card-footer -->
            </form>
            <!-- /form -->
        </div>
        <!-- /.card -->
    </div>
</div>
@endsection

{{-- Footer Extras to be Included --}}
{{-- @section('footer-extras')
<script src="{{ asset('dist/_resources/form.js') }}?update=20190423"></script>
@includeIf($resourceAlias.'.footer.form')
@endsection --}}