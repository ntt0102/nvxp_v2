<?php
$color = App\Utils::getColor();
//
$myUser = Auth::user();
?>

{{-- Extends Layout --}}
@extends('layouts.backend', ['theme' => $color->theme, 'skin' => $color->skin])

{{-- Breadcrumbs --}}
@section('breadcrumbs')
{!! Breadcrumbs::render('admin') !!}
@endsection

{{-- Page Title --}}
@section('page-title', 'Tổng quan')

{{-- Header Extras to be Included --}}
@section('head-extras')
<link rel="stylesheet" href="{{ asset('dist/admin/index.css') }}?update=20190423">
@endsection

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card card-skin card-{{ $color->skin }} card-outline">
      <div class="card-body">
        <div class="group">
          <div class="item row">
            <div class="title">Tổng số hệ:</div>
            <div class="value">{{ $report->getPedigrees() }}</div>
          </div>
        </div>
        <div class="group">
          <div class="item row">
            <div class="title">Tổng số thành viên:</div>
            <div class="value">{{ $report->getMembers() }}</div>
          </div>
        </div>
        <div class="group">
          <div class="item row">
            <div class="title">Tổng số con trai:</div>
            <div class="value">{{ $report->getSons() }}</div>
          </div>
        </div>
        <div class="group">
          <div class="item row">
            <div class="title">Tổng số con gái:</div>
            <div class="value">{{ $report->getDaughters() }}</div>
          </div>
        </div>
        <div class="group">
          <div class="item row">
            <div class="title">Tổng số con dâu:</div>
            <div class="value">{{ $report->getDaughterInLaws() }}</div>
          </div>
        </div>
        <!-- /.card-body-->
      </div>
    </div>
    <!-- /.card -->
  </div>
</div>
@endsection

{{-- Footer Extras to be Included --}}
@section('footer-extras')
<script src="{{ asset('dist/admin/index.js') }}?update=20190423"></script>
@endsection