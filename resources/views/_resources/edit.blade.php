<?php
$color = App\Utils::getColor();
?>

{{-- Extends Layout --}}
@extends('layouts.backend', ['theme' => $color->theme, 'skin' => $color->skin])

<?php
$_pageTitle = ucfirst($resourceTitle);
$_formFiles = isset($classifies['formFiles']) ? $classifies['formFiles'] : false;
$_listLink = route($resourceRoutesAlias . '.index');
$_createLink = route($resourceRoutesAlias . '.create');
$_updateLink = route($resourceRoutesAlias . '.update', $record->id);
$deleteLink = route($resourceRoutesAlias . '.destroy', $record->id);
//
$myUser = Auth::user();
?>

{{-- Breadcrumbs --}}
@section('breadcrumbs')
{!! Breadcrumbs::render($resourceRoutesAlias.'.edit', $resourceTitle, $record->id) !!}
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
            <form class="form" role="form" method="POST" action="{{ $_updateLink }}" enctype="{{ $_formFiles === true ? 'multipart/form-data' : ''}}">
                {{ csrf_field() }}
                {{ method_field('PUT') }}
                {{ redirect_back_field() }}

                <div class="card-header">
                    <h3 class="card-title">&nbsp;<span class="d-none d-sm-inline-block">{{ $editSubtitle }}</span></h3>
                    <div class="card-tools">
                        <span id="btnList" data-link="{{ $_listLink }}" class="btn btn-sm btn-skin btn-{{ $color->skin }} mr-1">
                            {!! $listButtonName !!}
                        </span>
                        <span id="btnCreate" data-link="{{ $_createLink }}" class="btn btn-sm btn-skin btn-{{ $color->skin }} mr-1">
                            {!! $createButtonName !!}
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
                            <span id="btnDelete" class="btn btn-danger ml-3 float-right">
                                <i class="fas fa-trash-alt"></i> <span>Xóa</span>
                            </span>
                        </div>
                        <!-- /.col-md-9 -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.card-footer -->
            </form>
            <!-- /form -->
            <form id="formDelete" action="{{ $deleteLink }}" method="POST" class="hide form-inline">
                {{ csrf_field() }}
                {{ method_field('DELETE') }}
            </form>
        </div>
        <!-- /.card -->
    </div>
</div>
<div class="row">
    <div class="col-12">
    </div>
</div>
@endsection

{{-- Footer Extras to be Included --}}
@section('footer-extras')
<script src="{{ asset('dist/_resources/form.js') }}?update=20190423"></script>
@includeIf($resourceAlias.'.footer.form')
@endsection