<?php
  $skin = App\Utils::getColor()->skin;
?>
@extends('layouts.errors', ['skin' => $skin])

@section('title', 'Lỗi 404')

@section('code', '404')
@section('message', 'Xin lỗi, trang này không tìm thấy.')
