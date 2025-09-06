<?php
$color = App\Utils::getColor();
?>

{{-- Extends Layout --}}
@extends('layouts.backend', ['theme' => $color->theme, 'skin' => $color->skin])

<?php
$_pageTitle = ucfirst($resourceTitle);
$_pageTitleLower = mb_strtolower($resourceTitle);
$_listLink = route($resourceRoutesAlias . '.index');
$_createLink = route($resourceRoutesAlias . '.create');
//
$myUser = Auth::user();
//
$tableCounter = 0;
if (count($records)) {
    $tableCounter = ($records->currentPage() - 1) * $records->perPage();
    $tableCounter = $tableCounter > 0 ? $tableCounter : 0;
}
?>

{{-- Breadcrumbs --}}
@section('breadcrumbs')
{!! Breadcrumbs::render($resourceRoutesAlias, $resourceTitle) !!}
@endsection

{{-- Page Title --}}
@section('page-title', $_pageTitle)

{{-- Header Extras to be Included --}}
@section('head-extras')
<link rel="stylesheet" href="{{ asset('dist/_partials/select2/select2.css') }}?update=20190423">
@includeIf($resourceAlias.'.header.filter')
@includeIf($resourceAlias.'.header.table')
@if (count($records))
<link rel="stylesheet" href="{{ asset('dist/_partials/pagination/pagination.css') }}?update=20190423">
@endif
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card card-skin card-{{ $color->skin }} card-outline">
            <div class="card-header">
                <h3 class="card-title">&nbsp;<span class="d-none d-sm-inline-block">{{ $indexSubtitle }}</span></h3>
                <!-- Search -->
                <div class="card-tools">
                    <div class="input-group input-group-sm" style="width: 250px;">
                        @includeIf('_partials.search', ['value' => $search, 'link' => $_listLink])
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-skin btn-{{ $color->skin }}"><i class="fa fa-search"></i></button>
                            <span id="btnCreate" data-role="{{ Auth::user()->role }}" data-link="{{ $_createLink }}" class="btn btn-skin btn-{{ $color->skin }} ml-1">
                                {!! $createButtonName !!}
                            </span>
                        </div>
                    </div>
                </div>
                <!-- END Search -->
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                @includeIf($resourceAlias.'.filter')
                @if (count($records))
                @includeIf($resourceAlias.'.table')
                @else
                <p class="lead pl-3 pt-2">Không tìm thấy {{ $_pageTitleLower }} nào.</p>
                @endif
            </div>
            <!-- /.card-body -->
            @if (count($records))
            @includeIf('common.paginate', ['records' => $records, 'show' => $classifies['show'], 'link' => $_listLink])
            @endif
        </div>
        <!-- /.card -->
    </div>
</div>
@endsection

{{-- Footer Extras to be Included --}}
@section('footer-extras')
<script src="{{ asset('plugins/select2/select2.full.min.js') }}?update=20190423"></script>
<script src="{{ asset('dist/_partials/select2/select2.js') }}?update=20190423"></script>
<script src="{{ asset('dist/_resources/index.js') }}?update=20190423"></script>
@includeIf($resourceAlias.'.footer.filter')
@includeIf($resourceAlias.'.footer.table')
@if (count($records))
<script src="{{ asset('dist/_partials/pagination/pagination.js') }}?update=20190423"></script>
@endif
<script src="{{ asset('dist/_partials/search/search.js') }}?update=20190423"></script>
@endsection