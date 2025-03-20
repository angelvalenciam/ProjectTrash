@extends('layouts.layoutMaster')

@section('title', 'Recompensas')

<link rel="stylesheet" href="{{ asset('assets/css/stylesGeneral.css') }}">
<script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

@section('content')

    <div class="container-down cont-btn">
        <h4>Estimado cliente, usted cuenta con: 400 créditos</h4>
    </div>
    <div class="container-down cont-btn">
        <p>Seleccione una recompensa la cual desea canjear</p>
    </div>

    <!-- Comprobamos si hay recompensas -->
    @if($recompensas->isEmpty())
        <div class="container-down cont-btn">
            <h1>No hay recompensas para canjear</h1>
        </div>
    @else
    <div class="container-grid">
        @foreach ($recompensas as $recompensa)
          <div class="card-sale">
            <img src="{{ asset('storage/recompensas/' . basename($recompensa->imagen)) }}" alt="{{ $recompensa->titulo }}">
            <h3>{{ $recompensa->titulo }}</h3>
            <p>{{ $recompensa->descripcion }}</p>
            <p>{{ $recompensa->precio }} / Token</p>
            <button>Canjear</button>
          </div>
        @endforeach
      </div>
      
    
    @endif

    <!-- Paginación debajo de las recompensas -->
    <div class="mt-4 flex justify-center">
        {{ $recompensas->links() }}
    </div>

@endsection
