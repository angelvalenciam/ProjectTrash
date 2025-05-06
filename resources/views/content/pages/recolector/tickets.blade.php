@php
  $configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Reportar Falla')

@section('content')
  <style>
    .titulo-falla {
      color: #f18738;
      font-weight: bold;
      font-size: 24px;
      text-align: center;
      margin-bottom: 1.5rem;
    }

    .form-section {
      background-color: #fff;
      border: 5px solid #8da1bd;
      padding: 30px;
      border-radius: 10px;
      position: relative;
    }

    .form-label {
      font-weight: 600;
    }

    .unidad-info label {
      font-weight: bold;
      display: block;
    }

    .unidad-info span {
      color: #0d3c89;
      display: block;
      margin-bottom: 5px;
    }

    .prioridad-label {
      font-weight: bold;
    }

    .btn-foto {
      background-color: #6c7b95;
      color: #fff;
      padding: 6px 12px;
      border-radius: 5px;
      border: none;
    }

    .btn-foto:hover {
      background-color: #566276;
    }

    .btn-enviar {
      background-color: #6c7b95;
      color: white;
      font-weight: bold;
      padding: 10px 25px;
      border: none;
      border-radius: 8px;
    }

    .btn-enviar:hover {
      background-color: #566276;
    }

  </style>

  <div class="container mt-4">
    <div class="form-section">
      <div class="d-flex justify-content-between">

        <div><strong>Fecha:</strong> <span class="text-primary">23/Mayo/2025</span></div>
      </div>

      <div class="titulo-falla">REPORTAR FALLA</div>

      <form method="POST" action=" {{ route('registrarproblemas-recolector') }} " enctype="multipart/form-data">
        @csrf

        <div class="row mb-3">
          <div class="col-md-6">
            <label for="unidad" class="form-label">Unidad #</label>
            <input name="search_unidad" type="text" class="form-control" id="defaultFormControlInput"
                   placeholder="NOG-LB-014"
                   aria-describedby="defaultFormControlHelp"/>
          </div>

          <div class="col-md-6">
            <label for="ruta" class="form-label">Ruta</label>
            <input name="input_ruta" type="text" class="form-control" id="defaultFormControlInput"
                   placeholder="NOG-KENEDY"
                   aria-describedby="defaultFormControlHelp"/>
          </div>
        </div>

        <div class="row unidad-info mb-4">
          <div class="col-md-4">
            <label>Marca:</label>
            <span name="spn_marca">Freightliner</span>
          </div>
          <div class="col-md-4">
            <label>Modelo:</label>
            <span name="spn_modelo">M2 106</span>
          </div>
          <div class="col-md-4">
            <label>Placa:</label>
            <span name="spn_placa">ZNOG22-53</span>
          </div>
        </div>

        <div class="mb-3">
          <label for="detalle" class="form-label">Describa de manera detallada el incidente:</label>
          <textarea name="area_detalle" id="detalle" class="form-control" rows="4"
                    placeholder="Problema en brazo elevador de contenedores"></textarea>
        </div>

        <div class="mb-4">
          <label class="prioridad-label d-block">Prioridad</label>
          <select id="ruta" name="status" class="form-select">
            <option> -- Seleccione la prioridad --</option>
            @foreach($prioridades as $row)
              <option value="{{ $row->id }}"> {{$row->nombre}}</option>
            @endforeach
            <!-- Agrega más opciones si es necesario -->
          </select>

        </div>
        <label for="ruta" class="form-label">Estatus</label>
        <select id="ruta" name="status" class="form-select">
          <option selected>Seleccione el estatus</option>
          <option selected>Sin resolver</option>
          <option selected>En progreso</option>
          <option selected>Completo</option>
          <!-- Agrega más opciones si es necesario -->
        </select>

        {{--        <div class="mb-3">--}}
        {{--          <label for="foto" class="form-label d-block">Foto del incidente</label>--}}
        {{--          <input type="file" name="foto" id="foto" class="form-control mb-2" accept="image/*">--}}
        {{--          <button type="button" class="btn-foto">Tomar Foto</button>--}}
        {{--        </div>--}}

        <div class="text-center mt-4">
          <button type="submit" class="btn-enviar">Enviar Reporte</button>
        </div>
      </form>
    </div>
  </div>

  @if(session('success'))
    <h1>Correcto</h1>
  @endif
@endsection
