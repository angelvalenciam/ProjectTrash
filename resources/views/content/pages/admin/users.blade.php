@php
    $configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Page 2')

@section('content')
  @include('example-content.form-elements.forms-basic-inputs');
  @include('example-content.form-elements.forms-basic-inputs');
  @include('example-content.form-elements.forms-basic-inputs');
@endsection
