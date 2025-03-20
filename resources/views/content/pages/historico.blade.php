@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Page 2')

@section('content')
{{-- @include('example-content.user-interface.ui-buttons') --}}
{{-- @include('example-content.cards.cards-advance') --}}
{{-- @include('example-content.laravel-example.user-management') --}}
{{-- @include('example-content.dashboard.dashboards-analytics') --}}
{{-- @include('example-content.user-interface.ui-dropdowns') --}}
{{-- @include('example-content.icons.icons-boxicons') --}}
{{-- @include('example-content.modal.modal-examples') --}}
{{-- @include('example-content.pages.pages-pricing') --}}
{{-- @include('example-content.pages.pages-account-settings-connections') --}}
{{-- @include('example-content.user-interface.ui-tabs-pills') --}}
@include('example-content.tables.tables-datatables-basic')

{{--  --}}
@endsection
