@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Page 2')

@section('content')

@include('example-content.tables.tables-datatables-basic')

{{--  --}}
@endsection
