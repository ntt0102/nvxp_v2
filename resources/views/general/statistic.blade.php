<?php
$skin = App\Utils::getColor()->skin;
$_pageTitle = 'Thống kê';
?>

{{-- Extends Layout --}}
@extends('layouts.frontend', ['skin' => $skin])

{{-- Page Title --}}
@section('page-title', $_pageTitle)

{{-- Header Extras to be Included --}}
@section('head-extras')
<link rel="stylesheet" href="{{ asset('dist/general/statistic/statistic.css') }}?update=20190423">
@endsection

@section('content')
<div class="row justify-content-center" style="padding: 0 10px;">
  <div class="col-md-12">
    <h3 class="title">Thống kê</h3>
    <div class="card card-skin card-{{ $skin }} card-outline">
      <div class="card-header">
        <h4 class="card-title col-md-6">&nbsp;</h4>
        <div class="card-tools">
          <span url="{{ route('filter') }}" class="filter btn btn-sm btn-danger">Tìm chi phái</span>
        </div>
        <!-- /.card-tools -->
      </div>
      <!-- /.card-header -->
      <div class="card-body">
        <div class="row">
          <div class="col-md-12">
            @if($report)
            <div>
              <h4 class="name">Cao tổ <a class="user-link-dark" href="{{ route('map').'?view='.$report['id'] }}">{{ $report['name'] }}</a><br>(Hệ
                {{ $report['pedigree'] }})
              </h4>
            </div>
            <div class="group">
              <div class="item row">
                <div class="report-title">Tổng số hệ:</div>
                <div class="value">{{ $report['pedigrees'] }}</div>
              </div>
              <div class="item row">
                <div class="report-title">Tổng số thành viên:</div>
                <div class="value">{{ $report['members'] }}</div>
              </div>
              <!-- <div class="item row">
                <div class="report-title">Số người đang sống:</div>
                <div class="value">??? $report['livingMembers'] }}</div>
              </div>
              <div class="item row">
                <div class="report-title">Số người đã chết:</div>
                <div class="value">??? $report['deadMembers'] }}</div>
              </div> -->
            </div>
            <div class="group">
              <div class="item row">
                <div class="report-title">Tổng số con trai:</div>
                <div class="value">{{ $report['sons'] }}</div>
              </div>
              <!-- <div class="item row">
                <div class="report-title">Số con trai đang sống:</div>
                <div class="value">??? $report['livingSons'] }}</div>
              </div> -->
            </div>
            <div class="group">
              <div class="item row">
                <div class="report-title">Tổng số con gái:</div>
                <div class="value">{{ $report['daughters'] }}</div>
              </div>
              <!-- <div class="item row">
                <div class="report-title">Số con gái đang sống:</div>
                <div class="value">??? $report['livingDaughters'] }}</div>
              </div> -->
            </div>
            <div class="group">
              <div class="item row">
                <div class="report-title">Tổng số con dâu:</div>
                <div class="value">{{ $report['daughterInLaws'] }}</div>
              </div>
              <!-- <div class="item row">
                <div class="report-title">Số con dâu đang sống:</div>
                <div class="value">??? $report['livingDaughterInLaws'] }}</div>
              </div> -->
            </div>
            @else
            <div>
              Hãy chọn chi phái cần thống kê
            </div>
            @endif
          </div>
          <!-- col -->
        </div>
        <!-- row -->
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
  </div>
  <!-- /.col -->
</div>
<!-- /.row -->
@endsection

{{-- Footer Extras to be Included --}}
@section('footer-extras')
<script src="{{ asset('dist/general/statistic/statistic.js?update=20190423') }}"></script>
@endsection