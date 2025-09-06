<?php
$color = App\Utils::getColor();
?>

{{-- Extends Layout --}}
@extends('layouts.backend', ['theme' => $color->theme, 'skin' => $color->skin])

<?php
$_pageTitle = ucfirst($resourceTitle);
$_formFiles = isset($classifies['formFiles']) ? $classifies['formFiles'] : false;
$_listLink = route($resourceRoutesAlias . '.index');
$_storeLink = route($resourceRoutesAlias . '.store');
//
$myUser = Auth::user();
?>

{{-- Breadcrumbs --}}
@section('breadcrumbs')
{!! Breadcrumbs::render($resourceRoutesAlias.'.create', $resourceTitle) !!}
@endsection

{{-- Page Title --}}
@section('page-title', $_pageTitle)

{{-- Header Extras to be Included --}}
@section('head-extras')
@includeIf($resourceAlias.'.header.form')
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card card-skin card-{{ $color->skin }} card-outline">
            <form class="form" role="form" method="POST" action="{{ $_storeLink }}" enctype="{{ $_formFiles === true ? 'multipart/form-data' : ''}}">
                {{ csrf_field() }}
                {{ redirect_back_field() }}

                <div class="card-header">
                    <h3 class="card-title col-md-6">&nbsp;<span class="d-none d-sm-inline-block">{{ $createSubtitle }}</span></h3>
                    <div class="card-tools">
                        <span id="btnList" data-link="{{ $_listLink }}" class="btn btn-sm btn-skin btn-{{ $color->skin }} mr-1">
                            {!! $listButtonName !!}
                        </span>
                    </div>
                    <!-- /.card-tools -->
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="row">
                        @includeIf($resourceAlias.'.form')
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer clearfix">
                    <div class="row">
                        <div class="col-md-12">
                            <button class="btn btn-skin btn-success">
                                <i class="fas fa-save"></i> <span>Lưu</span>
                            </button>
                            <span id="btnCancel" data-link="{{ $_listLink }}" class="btn btn-secondary ml-3 load">
                                <i class="fas fa-ban"></i> <span>Hủy</span>
                            </span>
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
@section('footer-extras')
<script src="{{ asset('dist/_resources/form.js') }}?update=20190423"></script>
@includeIf($resourceAlias.'.footer.form')
@endsection