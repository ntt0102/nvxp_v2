<?php
$skin = App\Utils::getColor()->skin;
$_pageTitle = 'Gia huấn ca';
?>
@extends('layouts.frontend', ['skin' => $skin])

{{-- Page Title --}}
@section('page-title', $_pageTitle)
@section('head-extras')
<link rel="stylesheet" href="{{ asset('dist/general/teaching/teaching.css') }}?update=20190423">
@endsection
@section('content')
<div class="row justify-content-center" style="padding: 0 10px;">
	<div class="col-md-12">
		<h3 class="title">Gia huấn ca</h3>
		<div class="card card-{{ $skin }} card-outline">
			<div class="card-body">
				{!! $content !!}
			</div>
			@auth
			@if(Auth::user()->role == 2)
			<div class="card-footer">
				<a target="_blank" class="load-none" href="{{ route('admin::constants.edit', 3) }}">Chỉnh sửa <i class="far fa-edit"></i></a>
			</div>
			@endif
			@endauth
		</div>
	</div>
</div>
@endsection