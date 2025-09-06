<?php
  $skin = App\Utils::getColor()->skin;
?>
@extends('layouts.errors', ['skin' => $skin])

@section('title', 'Lỗi 401')

@section('code', '401')
@section('message', 'Không được phép truy cập.')

