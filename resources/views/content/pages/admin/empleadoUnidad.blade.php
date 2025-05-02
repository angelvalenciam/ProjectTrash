@php
  $configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Page 2')

@section('content')
  <div class="row justify-content-center">
    <div class="col-md-8 col-lg-6">
      <div class="card mb-4 shadow-sm">
        <h5 class="card-header text-center fw-semibold">Registrar unidad</h5>
        <div class="card-body">
          <form action="{{ route('registrar-store') }}" method="POST">
            @csrf

            <div class="mb-4">
              <label for="placa" class="form-label">Placa</label>
              <input name="input_placa" type="text" class="form-control" id="placa" placeholder="Placas"/>
            </div>

            <div class="d-grid d-md-block text-center">
              <button type="submit" class="btn btn-primary px-4 py-2">Registrar</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
