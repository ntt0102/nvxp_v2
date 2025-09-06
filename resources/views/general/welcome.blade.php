<?php
$skin = App\Utils::getColor()->skin;
?>
@extends('layouts.frontend', ['skin' => $skin])

{{-- Page Title --}}
@section('page-title', 'Trang chủ')

@section('head-extras')
<link rel="stylesheet" href="{{ asset('dist/general/welcome/welcome.css') }}?update=20190423">
@endsection
@section('content')

<div style="background: url({{ asset('images/welcome.jpg') }}) no-repeat center; background-size: cover; height: calc(100vh - 56px); @mobile padding-top: 30px; padding-bottom: 30px; @endmobile">
  <div style="height: 100%; overflow-y: auto; padding: 0 5px; text-align: justify; @notmobile margin-left: 60px; padding-right: 50px; @endnotmobile">
    {!! $content !!}
  </div>
</div>
@auth
@if(Auth::user()->role == 2)
<div class="card-footer" style="background: white">
  <a target="_blank" class="load-none" href="{{ route('admin::constants.edit', 7) }}">Chỉnh sửa <i class="far fa-edit"></i></a>
</div>
@endif
@endauth
@endsection

{{-- Footer Extras to be Included --}}
@section('footer-extras')
<script src="{{ asset('dist/general/welcome/welcome.js') }}?update=20190423"></script>
@endsection