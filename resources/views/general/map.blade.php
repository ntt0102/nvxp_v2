<?php
$skin = App\Utils::getColor()->skin;
?>
@extends('layouts.frontend', ['skin' => $skin])

{{-- Page Title --}}
@section('page-title', 'Phả đồ')

@section('head-extras')
<link rel="stylesheet" href="{{ asset('dist/_partials/treeview/treeview.css') }}?update=20190423">
<link rel="stylesheet" href="{{ asset('dist/general/map/map.css') }}?update=20190423">
@endsection
@section('content')
<div class="row" style="padding: 0 10px;">
	<div class="col-md-12">
		<h3 class="title">Phả đồ</h3>
		<div class="map-container card card-{{ $skin }} card-outline" style="margin-bottom: 0px !important;">
			<div class="card-header">
				<div class="card-title col-md-6">
					<button id="treeToggle" type="button" class="btn btn-sm btn-outline-dark" tree-mode="{{ $treeMode }}" scrolltop="0" scrollleft="0"><i class="fas fa-arrows-alt-{{ $treeMode == 'top' ? 'v' : 'h' }}"></i> <span class="d-none d-sm-inline-block">{{ $treeMode == 'top' ? 'Dạng dọc' : 'Dạng ngang' }}</span></button>
				</div>
				<div class="card-tools" style="top: 0.95rem;">
					<span url="{{ route('filter') }}" filterMode="base" class="filter btn btn-sm btn-outline-primary"><i class="fas fa-project-diagram"></i> <span class="d-none d-sm-inline-block">Chọn gốc</span></span>
					<span url="{{ route('filter') }}" filterMode="view" class="filter btn btn-sm btn-outline-danger"><i class="fas fa-street-view"></i> <span class="d-none d-sm-inline-block">Tìm người</span></span>
				</div>
				<!-- /.card-tools -->
			</div>
			<!-- /.card-header -->
			<div class="card-body">
				<div id="treeContainer" class="tab-content table-responsive" url="{{ route('get-member') }}" tree-mode="">
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
						<button id="btn_ZoomReset" class="btn btn-sm btn-dark"><i class="fas fa-sync-alt"></i></button>
						<button id="btn_ZoomIn" class="btn btn-sm btn-dark"><i class="fas fa-plus"></i></button>
						<button id="btn_FullScreen" class="btn btn-sm btn-dark"><i class="fas fa-expand"></i></button>
					</div>
					<!-- /.zoom -->
					<ul class="contextMenu hide">
						<li class="detailInfo"><i class="far fa-eye"></i> Xem thông tin</li>

						<li class="basePoint"><i class="fas fa-project-diagram"></i> Làm điểm gốc</li>
						<li class="viewMark"><i class="fas fa-street-view"></i> Đánh dấu vị trí</li>

						@guest
						<li class="propose" url="{{ route('propose', 'ID') }}"><i class="fas fa-user-check"></i> Đề xuất sửa đổi
						</li>
						@else
						<li class="edit" url="{{ route('admin::members.edit', 'ID') }}"><i class="fas fa-user-edit"></i> Chỉnh sửa
						</li>
						<li class="branch" url="{{ route('admin::classifies.branch') }}" redirect="{{ route('admin::members.create') }}"><i class="fas fa-users"></i> Chọn làm chi phái</li>
						<li class="addChild" url="{{ route('admin::members.create') }}"><i class="fas fa-user-plus"></i> Thêm
							<select>
								<option></option>
								@foreach ($relations as $relation)
								<option value="{{ $relation->value }}">{{ $relation->name }}</option>
								@endforeach
							</select>
						</li>
						@endguest
					</ul>
					<!-- .contextMenu -->
					<ul class="infoPopup hide">
						<li class="name"></li>
						<li>
							@auth
							<span>
								ID: <span class="memberId"></span>
							</span>
							<br>
							@endauth
							<span>
								Phả hệ: <span class="pedigree"></span>
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
				</div>
				<!-- /.tab-content -->
			</div>
		</div>
	</div>
</div>
@endsection

{{-- Footer Extras to be Included --}}
@section('footer-extras')
<script src="{{ asset('plugins/fullscreen/jquery.fullscreen.min.js') }}?update=20190423"></script>
<script src="{{ asset('dist/_partials/treeview/treeview.js') }}?update=20190423"></script>
<script src="{{ asset('dist/general/map/map.js') }}?update=20190423"></script>
@endsection