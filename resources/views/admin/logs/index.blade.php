<?php
$color = App\Utils::getColor();
?>

{{-- Extends Layout --}}
@extends('layouts.backend', ['theme' => $color->theme, 'skin' => $color->skin])

<?php
$_pageTitle = 'Nhật ký';
$_pageTitleLower = mb_strtolower($_pageTitle);
$resourceAlias = 'admin.logs';
$resourceRoutesAlias = 'admin::logs';

$tableCounter = 0;
if (count($records) > 0) {
    $tableCounter = ($records->currentPage() - 1) * $records->perPage();
    $tableCounter = $tableCounter > 0 ? $tableCounter : 0;
}
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
<link rel="stylesheet" href="{{ asset('dist/admin/logs/logs.css') }}?update=20190423">
@if ($records && count($records))
<link rel="stylesheet" href="{{ asset('dist/_partials/pagination/pagination.css') }}?update=20190423">
@endif
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card card-skin card-{{ $color->skin }} card-outline">
            <div class="card-header">
                <h3 class="card-title">&nbsp;<span class="d-none d-sm-inline-block">Danh sách</span></h3>
                <!-- Search -->
                <div class="card-tools">
                    <div class="input-group input-group-sm" style="width: 250px;">
                        @includeIf('_partials.search', ['value' => $search, 'link' => route('admin::logs')])
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-skin btn-{{ $color->skin }}"><i class="fa fa-search"></i></button>
                            @if($myUser->role == 2)
                            <button id="btnMultiDelete" class="btn btn-skin btn-danger ml-1"><i class="fas fa-times"></i> Xóa</button>
                            @endif
                        </div>
                    </div>
                </div>
                <!-- END Search -->
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                @includeIf($resourceAlias.'.filter')
                @if (count($records) > 0)
                @includeIf($resourceAlias.'.table')
                @else
                <p class="lead pl-3 pt-2">Không tìm thấy {{ $_pageTitleLower }} nào.</p>
                @endif
            </div>
            <!-- /.card-body -->
            @if (count($records) > 0)
            @includeIf('common.paginate', ['records' => $records, 'show' => $classifies['show'], 'link' =>
            route($resourceRoutesAlias)])
            @endif
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
<script src="{{ asset('dist/admin/logs/logs.js') }}?update=20190423"></script>
@if ($records && count($records))
<script src="{{ asset('dist/_partials/pagination/pagination.js') }}?update=20190423"></script>
@endif
<script src="{{ asset('dist/_partials/search/search.js') }}?update=20190423"></script>
@endsection