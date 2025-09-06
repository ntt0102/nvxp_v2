<?php
  $skin = App\Utils::getColor()->skin;
?>
@extends('layouts.errors', ['skin' => $skin])

@section('title', 'Lỗi 405')

@section('code', '405')
@section('message', 'Phương pháp không được phép.')



