<?php
$color = App\Utils::getColor();
?>

{{-- Extends Layout --}}
@extends('layouts.backend', ['theme' => $color->theme, 'skin' => $color->skin])

<?php
$_pageTitle = 'Khôi phục';
$_pageTitleLower = mb_strtolower($_pageTitle);
$resourceAlias = 'admin.import';
$resourceRoutesAlias = 'admin::import';
$importLink = route($resourceRoutesAlias . '.do');
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
<link rel="stylesheet" href="{{ asset('dist/_partials/select2/select2.css') }}?update=20190423">
<link rel="stylesheet" href="{{ asset('dist/admin/import/import.css') }}?update=20190423">
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
                        <button id="btnImport" class="btn btn-skin btn-success">
                            <i class="fas fa-file-import"></i> <span>Khôi phục</span>
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
<script src="{{ asset('plugins/select2/select2.full.min.js') }}?update=20190423"></script>
<script src="{{ asset('dist/_partials/select2/select2.js') }}?update=20190423"></script>
<script src="{{ asset('dist/admin/import/import.js') }}?update=20190423"></script>
@endsection