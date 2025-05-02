@php
  $configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Page 2')

@section('content')
  <h1>Registrar unidades</h1>


  <div class="row justify-content-center">
    <div class="col-md-8 col-lg-6">
      <div class="card mb-4 shadow-sm">
        <h5 class="card-header text-center fw-semibold">Registrar unidad</h5>
        <div class="card-body">
          <form action="{{ route('registrar-store') }}" method="POST">
            @csrf

            <div class="mb-3">
              <label for="marca" class="form-label">Marca</label>
              <input name="input_marca" type="text" class="form-control" id="marca" placeholder="Nissan"/>
            </div>

            <div class="mb-3">
              <label for="modelo" class="form-label">Modelo</label>
              <input name="input_modelo" type="text" class="form-control" id="modelo" placeholder="Modelo"/>
            </div>

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

  @if(session('success'))
    <div id="alert-success" style="margin-top: 1rem;" class="alert alert-success" role="alert">
      <h6 class="alert-heading mb-1">¡Éxito!</h6>
      <span>{{ session('success') }}</span>
    </div>
    </div>
  @endif

  <script>
    setTimeout(() => {
      const alert = document.getElementById('alert-success');
      if (alert) {
        alert.style.transition = 'opacity 0.5s ease';
        alert.opacity = '0';
        setTimeout(() => alert.remove(), 500);
      }
    }, 2000);
  </script>
@endsection
