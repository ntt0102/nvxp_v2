<?php
$color = App\Utils::getColor();
?>

{{-- Extends Layout --}}
@extends('layouts.backend', ['theme' => $color->theme, 'skin' => $color->skin])

<?php
$_pageTitle = 'Sao lưu';
$_pageTitleLower = mb_strtolower($_pageTitle);
$resourceAlias = 'admin.export';
$resourceRoutesAlias = 'admin::export';
$exportLink = route($resourceRoutesAlias . '.do');
$myUser = Auth::user();
?>

{{-- Breadcrumbs --}}
@section('breadcrumbs')
{!! Breadcrumbs::render($resourceRoutesAlias) !!}
@endsection

{{-- Page Title --}}
@section('page-title', $_pageTitle)

{{-- Header Extras to be Included --}}
@section('head-extras')
<link rel="stylesheet" href="{{ asset('dist/admin/export/export.css') }}?command">
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card card-skin card-{{ $color->skin }} card-outline">
            <div class="card-body">
                <div class="row">
                    @includeIf($resourceAlias.'.form')
                </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer clearfix">
                <div class="row">
                    <div class="col-md-12">
                        <button id="btnExport" class="btn btn-skin btn-success">
                            <i class="fas fa-file-export"></i> <span>Sao lưu</span>
                        </button>
                    </div>
                    <!-- /.col-md-9 -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.card-footer -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.col-md-9 -->
</div>
<!-- /.row -->
@endsection

{{-- Footer Extras to be Included --}}
@section('footer-extras')
<script src="{{ asset('dist/admin/export/export.js') }}?update=20190423"></script>
@endsection