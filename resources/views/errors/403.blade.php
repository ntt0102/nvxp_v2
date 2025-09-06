<?php
  $skin = App\Utils::getColor()->skin;
?>
@extends('layouts.errors', ['skin' => $skin])

@section('title', 'Lỗi 403')

@section('code', '403')
@section('message', 'Không cho phép truy cập.')


