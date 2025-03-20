@extends('layouts/layoutMaster')

@section('title', 'Disponer residuos')

@section('content')
<link rel="stylesheet" href="{{ asset('assets/css/stylesGeneral.css') }}">

<h1>Disponer residuos</h1>

{{-- Dropdown --}}
<div class="container-down">
  <x-dropdown-primary/>
</div>

{{-- Título sin que se haga parte de la grilla --}}
<div class="container-down cont-btn">
  <h4>Niveles Actuales</h4>
</div>
{{-- Contenedor de la grilla --}}
<div class="container-grid grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 place-items-center">
  {{-- Orgánico --}}
  <x-card-containers
  title="Orgánico"
  desc="Esta basura se refiere"
  kg="89"
  info=" "
  >
    <x-button-primary buttonName="Vaciar"/>
  </x-card-containers>

  {{-- Metales --}}
  <x-card-containers
  title="Metales"
  desc="Esta basura se refiere"
  kg="89"
  info=" "
  >
    <x-button-primary buttonName="Vaciar"/>
  </x-card-containers>

  {{-- Plásticos --}}
  <x-card-containers
  title="Plásticos"
  desc="Esta basura se refiere"
  kg="89"
  info=" "
  >
    <x-button-primary buttonName="Vaciar"/>
  </x-card-containers>

  {{-- Inorgánica --}}
  <x-card-containers
  title="Inorgánica"
  desc="Esta basura se refiere"
  kg="89"
  info=" "
  >
    {{-- Button --}}
    <x-button-primary buttonName="Vaciar"/>
  </x-card-containers>
</div>

{{-- Tarjeta de vaciado --}}
<x-card-all
  title="Vaciar todos los contenedores"
  desc="Solo debe utilizar esta opción si ya vació todos los contenedores"
>
  <x-button-danger buttonName="Vaciar todo "/>
</x-card-all>

@endsection
