@extends('layouts.frontend', ['skin' => $skin])

{{-- Header Extras to be Included --}}
@section('head-extras')
    <style>
        body{
            background: var(--{{ $skin }});
            color: #{{$skin == 'warning' ? '000' :'fff'}};
        }
        .navbar {
            background: var(--{{ $skin }});
        }
        hr {
            border-top: 5px solid #{{$skin == 'warning' ? '000' :'fff'}} !important;
        }
        hr:after {
            background: var(--{{ $skin }});
        }
        .btn {
            color: var(--{{ $skin }});
        }
    </style>
  <link rel="stylesheet" href="{{ asset('/dist/layouts/error.css') }}?update=20190505">
@endsection

@section('content')
    <div id="clouds">
        <div class="cloud x1"></div>
        <div class="cloud x1_5"></div>
        <div class="cloud x2"></div>
        <div class="cloud x3"></div>
        <div class="cloud x4"></div>
        <div class="cloud x5"></div>
    </div>
    <div class='c'>
        <div class='_404'>@yield('code')</div>
        <hr>
        <div class='_1'>@yield('message')</div>
        <div class='_2'>&nbsp;</div>
        <a class='btn' href="{{ route('admin::index') }}">QUAY LẠI</a>
    </div>
@endsection



