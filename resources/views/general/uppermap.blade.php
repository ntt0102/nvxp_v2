<?php
$skin = App\Utils::getColor()->skin;
?>
@extends('layouts.frontend', ['skin' => $skin])

{{-- Page Title --}}
@section('page-title', 'Thượng tôn đồ')

@section('head-extras')
<link rel="stylesheet" href="{{ asset('dist/_partials/treeview/treeview.css') }}?update=20190423">
<link rel="stylesheet" href="{{ asset('dist/general/uppermap/uppermap.css') }}?update=20190423">
@endsection
@section('content')
<div class="row" style="padding: 0 10px;">
	<div class="col-md-12">
		<h3 class="title">Thượng tôn đồ</h3>
		<div class="uppermap-container card card-{{ $skin }} card-outline" style="margin-bottom: 0px !important;">
			<div class="card-header">
				<div class="card-title col-md-6">
					<button id="treeToggle" type="button" class="btn btn-sm btn-outline-dark" tree-mode="{{ $treeMode }}" scrolltop="0" scrollleft="0"><i class="fas fa-arrows-alt-{{ $treeMode == 'top' ? 'v' : 'h' }}"></i>
						<span>{{ $treeMode == 'top' ? 'Dạng dọc' : 'Dạng ngang' }}</span></button>
				</div>
				<!-- /.card-tools -->
			</div>
			<!-- /.card-header -->
			<div class="card-body">
				<div id="treeContainer" class="tab-content table-responsive" url="{{ route('get-member') }}">
					<div id="idTreeLeft" class="text-left container {{ $treeMode == 'left' ? '' : 'hide' }}"><br>
						<ul class="hide" style="margin-top: -20px;margin-left: -20px;">
							{!! str_replace('[_]', ' ', $html) !!}
						</ul>
					</div>
					<div id="idTreeTop" class="text-center container {{ $treeMode == 'top' ? '' : 'hide' }}"><br>
						<ul class="hide" style="margin-top: -10px;">
							{!! str_replace('[_]', '<div></div>', $html) !!}
						</ul>
					</div>
					<div class="zoom-container input-group-append">
						<button id="btn_ZoomOut" class="btn btn-sm btn-dark"><i class="fas fa-minus"></i></button>
						<button id="btn_ZoomReset" class="btn btn-sm btn-dark"><i class="fas fa-undo"></i></button>
						<button id="btn_ZoomIn" class="btn btn-sm btn-dark"><i class="fas fa-plus"></i></button>
						<button id="btn_FullScreen" class="btn btn-sm btn-dark"><i class="fas fa-expand"></i></button>
					</div>
					<!-- /.zoom -->
				</div>
				<!-- /.tab-content -->
			</div>
		</div>
	</div>
</div>
<ul class="contextMenu hide">
	<li class="detailInfo"><i class="far fa-eye"></i> Xem thông tin</li>
	@if(!Auth::guest())
	@if(Auth::user()->role == 2)
	<li class="edit" url="{{ route('admin::members.edit', 'ID') }}"><i class="fas fa-user-edit"></i> Chỉnh sửa</li>
	@endif
	@endif
</ul>
<!-- .contextMenu -->
<ul class="infoPopup hide">
	<li class="name"></li>
	<li>
		@if(!Auth::guest())
		@if(Auth::user()->role)
		<span>
			ID: <span class="memberId"></span>
		</span>
		<br>
		@endif
		@endif
		<span>
			Hệ tôn đồ: <span class="pedigree"></span>
		</span>
		<span>
			<br>
			Quan hệ: <span class="relation"></span>
		</span>
		<span>
			<br>
			<span class="linkTitle" style="font-weight: bold;"></span>: <span class="linkName"></span>
		</span>
		<span>
			<br>
			Ghi chú: <span class="note"></span>
		</span>
	</li>
</ul>
<!-- /.infoPopup -->
@endsection

{{-- Footer Extras to be Included --}}
@section('footer-extras')
<script src="{{ asset('plugins/fullscreen/jquery.fullscreen.min.js') }}?update=20190423"></script>
<script src="{{ asset('dist/_partials/treeview/treeview.js') }}?update=20190423"></script>
<script src="{{ asset('dist/general/uppermap/uppermap.js') }}?update=20190423"></script>
@endsection