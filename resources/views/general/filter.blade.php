<?php
$color = App\Utils::getColor();
//
$myUser = Auth::user();

$showResult = true;
switch ($classifies['filterMode']) {
  case 'base':
  case 'view':
    $url = route('map');
    $fnc = '1';
    $ajax = '';
    break;
  case 'branch':
    $url = route('admin::members.create') . "?filterMode=" . $classifies['filterMode'];
    $fnc = '2';
    $ajax = route('admin::classifies.branch');
    break;
  case 'modify':
    $url = route('admin::members.index');
    $fnc = '3';
    $ajax = '';
    $showResult = false;
    break;
  case 'manager':
    $url = route('admin::users.create');
    $fnc = '3';
    $ajax = '';
    break;
  case 'statistic':
    $url = route('statistic');
    $fnc = '3';
    $ajax = '';
    break;
  default:
    $url = '';
    $fnc = '';
    $ajax = '';
}
?>

{{-- Extends Layout --}}
@extends('layouts.frontend', ['theme' => $color->theme, 'skin' => $color->skin])

{{-- Page Title --}}
@section('page-title', 'Tìm kiếm')

{{-- Header Extras to be Included --}}
@section('head-extras')
<link rel="stylesheet" href="{{ asset('dist/_partials/select2/select2.css') }}?update=20190423">
<link rel="stylesheet" href="{{ asset('dist/general/filter/filter.css') }}?update=20190423">
@if (count($records))
<link rel="stylesheet" href="{{ asset('dist/_partials/pagination/pagination.css') }}?update=20190423">
@endif
@endsection

@section('content')
<input type="hidden" id="url" value="{{ $url }}" fnc="{{ $fnc }}" ajax="{{ $ajax }}">
<div class="row" style="padding: 10px;">
  <div class="col-md-4">
    <form action="{{ route('filter') }}" method="get">
      <div class="card card-{{ $color->skin }} card-outline">
        <div class="card-header">
          <h3 class="card-title">
            <i class="fas fa-filter"></i>
            Bộ lọc
          </h3>
          <div class="card-tools">
            <button id="btnFilter" type="button" class="btn btn-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
          </div>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-12">
              <div class="form-group-sm">
                <label for="filterMode" style="width: 80px;">Loại: </label>
                <select id="filterMode" name="filterMode" style="width: calc(100% - 80px - 5px); height: 30px;">
                  <option value="">&nbsp;</option>
                  @foreach ($classifies['filterModes'] as $filterMode)
                  <option value="{{ $filterMode->value }}" {{ $classifies['filterMode'] == $filterMode->value ? 'selected' : '' }}>{{ $filterMode->name }}
                  </option>
                  @endforeach
                </select>
              </div>
              <!-- /.form-group -->
            </div>
            <!-- /.col -->
            <div class="col-12">
              <div class="form-group-sm">
                <label for="id" style="width: 80px;">ID: </label>
                <input id="id" type="text" style="width: calc(100% - 80px - 5px);" name="id" value="{{ $classifies['id'] }}" {{ $classifies['id'] ? 'autofocus' : '' }} onfocus="var temp_value=this.value; this.value=''; this.value=temp_value">
              </div>
              <!-- /.form-group -->
            </div>
            <!-- /.col -->
            <div class="col-12">
              <div class="form-group-sm">
                <label for="name" style="width: 80px;">Họ tên: </label>
                <input id="name" type="text" style="width: calc(100% - 80px - 5px);" name="name" value="{{ $classifies['name'] }}" {{ !($classifies['id'] || $classifies['parent'] || $classifies['couple']) ? 'autofocus' : '' }} onfocus="var temp_value=this.value; this.value=''; this.value=temp_value">
              </div>
              <!-- /.form-group -->
            </div>
            <!-- /.col -->
            <div class="col-12">
              <div class="form-group-sm">
                <label for="pedigree" style="width: 80px;">Hệ: </label>
                <select id="pedigree" name="pedigree" style="width: calc(100% - 80px - 5px); height: 30px;">
                  <option value="">&nbsp;</option>
                  @for ($i = 1; $i <= $classifies['pedigrees']; $i++) <option value="{{ $i }}" {{ $classifies['pedigree'] == $i ? 'selected' : '' }}>{{ $i }}</option>
                    @endfor
                </select>
              </div>
              <!-- /.form-group -->
            </div>
            <!-- /.col -->
            <div class="col-12">
              <div class="form-group-sm">
                <label for="relation" style="width: 80px;">Quan hệ: </label>
                <select id="relation" name="relation" style="width: calc(100% - 80px - 5px); height: 30px;">
                  <option value="">&nbsp;</option>
                  @foreach ($classifies['relations'] as $relation)
                  <option value="{{ $relation->value }}" {{ $classifies['relation'] == $relation->value ? 'selected' : '' }}>{{ $relation->name }}</option>
                  @endforeach
                </select>
              </div>
              <!-- /.form-group -->
            </div>
            <!-- /.col -->
            <div class="col-12">
              <div class="form-group-sm">
                <label for="parent" style="width: 80px;">Cha: </label>
                <input id="parent" type="text" style="width: calc(100% - 80px - 5px);" name="parent" value="{{ $classifies['parent'] }}" {{ $classifies['parent'] ? 'autofocus' : '' }} onfocus="var temp_value=this.value; this.value=''; this.value=temp_value">
              </div>
              <!-- /.form-group -->
            </div>
            <!-- /.col -->
            <div class="col-12">
              <div class="form-group-sm">
                <label for="couple" style="width: 80px;">Chồng: </label>
                <input id="couple" type="text" style="width: calc(100% - 80px - 5px);" name="couple" value="{{ $classifies['couple'] }}" {{ $classifies['couple'] ? 'autofocus' : '' }} onfocus="var temp_value=this.value; this.value=''; this.value=temp_value">
              </div>
              <!-- /.form-group -->
            </div>
            <!-- /.col -->
            <div class="col-12">
              <div class="form-group-sm">
                <label for="note" style="width: 80px;">Ghi chú: </label>
                <input id="note" type="text" style="width: calc(100% - 80px - 5px);" name="note" value="{{ $classifies['note'] }}" {{ $classifies['note'] ? 'autofocus' : '' }} onfocus="var temp_value=this.value; this.value=''; this.value=temp_value">
              </div>
              <!-- /.form-group -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
        </div>
        <!-- /.card-body-->
        <div class="card-footer clearfix">
          <div class="row">
            <div class="col-md-12">
              <input type="hidden" name="base" value="{{ $classifies['base'] }}" />
              <input type="hidden" name="view" value="{{ $classifies['view'] }}" />
              <span class="btn btn-secondary" onclick="event.preventDefault(); window.history.back();">
                <i class="fas fa-undo"></i> <span>Trở về</span>
              </span>
              <button type="button" class="btn btn-{{ $color->skin }} float-right" onclick="filterOrRedirect()">
                <i class="fas fa-search"></i> <span>Tìm kiếm</span>
              </button>
            </div>
            <!-- /.col-md-9 -->
          </div>
          <!-- /.row -->
        </div>
        <!-- /.card-footer -->
      </div>
      <!-- /.card -->
    </form>
  </div>
  <div class="col-md-8">
    <div class="card card-{{ $color->skin }} card-outline">
      <div class="card-header">
        <h3 class="card-title">
          <i class="fas fa-list-ul"></i>
          Kết quả
        </h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-widget="collapse"><i class="fa fa-minus"></i>
          </button>
        </div>
      </div>
      <div class="card-body">
        @if($showResult)
        @if(count($records) > 0)
        @foreach ($records as $record)
        <?php
        if ($record->gender == 1) {
          if ($record->pedigree == 1) {
            $relationName = 'Ông tổ';
          } else {
            $relationName = 'Con trai';
          }
        } else {
          if ($record->couple_id) {
            if ($record->pedigree == 1) {
              $relationName = 'Bà tổ';
            } else {
              $relationName = 'Con dâu';
            }
          } else {
            $relationName = 'Con gái';
          }
        }
        ?>
        <div class="card result-item" style="width:" dataId="{{ $record->id }}" dataName="{{ $record->name }}" dataPedigree="{{ $record->pedigree }}" dataGender="{{ $record->gender }}">
          <div class="card-body">
            <h4 class="card-title" style="font-size: 1.5em;">{{ $record->name }}</h4>
            <p class="card-text">
              @if(!Auth::guest())
              ID: {{ $record->id }}
              <br>
              @endif
              Hệ: {{ $record->pedigree }}
              <br>
              Quan hệ: {{ $relationName }}
              @if($record->parent_name)
              <br>
              Cha: {{ $record->parent_name }}
              @endif
              @if($record->couple_name)
              <br>
              {{ $record->gender == '1' ? 'Vợ' : 'Chồng' }}: {{ $record->couple_name }}
              @endif
              @if($record->note && $classifies['note'])
              <br>
              Ghi chú: {{ $record->note }}
              @endif
            </p>
          </div>
        </div>
        @endforeach
        @else
        @if($classifies['isExecuted'] == 1)
        <div>Kết quả không tìm thấy.</div>
        @else
        <div>Hãy nhập thông tin để tìm kiếm.</div>
        @endif
        @endif
        @else
        <div>Nhấn Tìm kiếm để hiển thị kết quả ở trang danh sách.</div>
        @endif
      </div>
      <!-- /.card-body-->
      @if($showResult)
      @if (count($records))
      <?php $_pageTitleLower = 'kết quả'; ?>
      @includeIf('common.paginate', ['records' => $records, 'show' => $classifies['show'], 'link' => route('filter')])
      @endif
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
<script src="{{ asset('dist/general/filter/filter.js') }}?update=20190423"></script>
@if (count($records))
<script src="{{ asset('dist/_partials/pagination/pagination.js') }}?update=20190423"></script>
@endif
@endsection