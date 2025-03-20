@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Home')

@section('content')
 @include('example-content.dashboard.dashboards-analytics')
@endsection
