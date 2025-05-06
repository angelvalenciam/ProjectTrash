@php
  $configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Recolectar basura')

@section('content')
  <h2>Recolectar basura</h2>

  <form method="GET" action="{{ route('recolectar') }}">
    <div class="form-floating">
      <input required type="text" class="form-control" id="floatingInput" name="ticket_id" placeholder="456"
             aria-describedby="floatingInputHelp" value="{{ request('ticket_id') }}"/>
      <label for="floatingInput">ID de vaciado</label>
      <button style="margin-top: 1rem" type="submit" class="btn btn-primary d-grid w-100">Buscar</button>
    </div>
  </form>

  @if($vaciado && $usuario)
    <div class="card mt-4 p-4">
      <h4>Datos del Usuario</h4>
      <p>Nombre: {{ $usuario->nombres }} {{ $usuario->apellidos }}</p>
      <p>Dirección: {{ $usuario->colonia }}, {{ $usuario->ciudad }} - Ext: {{ $usuario->numero_exterior }}</p>
      <p>Tipo de basura: {{ $vaciado->tipo_basura ?? 'Desconocido' }}</p>
      <p>Cantidad: {{ $vaciado->cantidad_vaciada }} kg</p>
      <p>Contenedor: {{ $vaciado->contenedor_nombre ?? 'Desconocido' }}</p>
      <hr>
      @if(isset($qrCode))
        <div class="text-center">
          <img src="{{ $qrCode }}" alt="QR Code" style="margin-top: 10px; width: 150px; height: 150px;">
        </div>
      @endif
      <p class="text-center">Juntos por un mejor mundo</p>
      <form action=" {{ route('recolectar.registrar') }} " method="POST">
        @csrf
        <input type="hidden" name="id_user" value="{{ $vaciado->id_usuario }}">
        <input type="hidden" name="id_vaciado" value="{{ $vaciado->id }}">
        <h3>Usuario: {{ $vaciado->id_usuario }}</h3>
        <h3>ID Vaciado: {{ $vaciado->id }}</h3>
        <button style="margin-top: 1rem" type="submit" class="btn btn-success d-grid w-100">Recolectar
          residuos
        </button>
      </form>
    </div>
  @endif


  @if(session('success'))
    <div id="alert-success" style="margin-top: 1rem;" class="alert alert-success" role="alert">
      <h6 class="alert-heading mb-1">¡Éxito!</h6>
      <span>{{ session('success') }}</span>
    </div>
  @endif

  <script>
    // Espera 2 segundos y luego oculta la alerta
    setTimeout(() => {
      const alert = document.getElementById('alert-success');
      if (alert) {
        alert.style.transition = 'opacity 0.5s ease';
        alert.style.opacity = '0';
        setTimeout(() => alert.remove(), 500); // se elimina del DOM después de la animación
      }
    }, 2000); // 2000 milisegundos = 2 segundos
  </script>

  @if(request('ticket_id') && (!$vaciado || !$usuario))
    <div class="alert alert-danger mt-4">
      No se encontraron datos para el ID ingresado.
    </div>
  @endif
@endsection
