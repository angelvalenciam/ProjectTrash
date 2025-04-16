@extends('layouts/layoutMaster')

@section('title', 'Históricos de Residuos')

@section('content')
<div class="card">
  <h5 class="card-header">Histórico de Residuos Vaciados</h5>
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
  {{-- Filtro de fechas --}}
  <div class="d-flex justify-content-center mt-3">
    <form method="GET" action="{{ route('historicos-user') }}" class="flex flex-wrap gap-4 mb-4 justify-center">
      <select name="filtro" class="border rounded px-4 py-2">
        <option value="">-- Selecciona un filtro --</option>
        <option value="hoy" {{ request('filtro') == 'hoy' ? 'selected' : '' }}>Hoy</option>
        <option value="semana" {{ request('filtro') == 'semana' ? 'selected' : '' }}>Esta semana</option>
        <option value="mes" {{ request('filtro') == 'mes' ? 'selected' : '' }}>Este mes</option>
        <option value="rango" {{ request('filtro') == 'rango' ? 'selected' : '' }}>Rango personalizado</option>
      </select>

      <input type="date" name="desde" value="{{ request('desde') }}" class="border rounded px-4 py-2" placeholder="Desde">
      <input type="date" name="hasta" value="{{ request('hasta') }}" class="border rounded px-4 py-2" placeholder="Hasta">

      <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Filtrar</button>
    </form>
  </div>

  {{-- Tabla de datos --}}
  <div class="card-datatable text-nowrap px-4 pb-4">
    <table class="table table-bordered w-full">
      <thead>
        <tr>
          <th>Nombre de Dispositivo</th>
          <th>Tipo de Basura</th>
          <th>Cantidad Vaciada (kg)</th>
          <th>Fecha</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($registros as $registro)
          <tr>
            <td>{{ $registro->divisionContenedor->contenedor->nombre ?? 'No disponible' }}</td>
            <td>{{ $registro->divisionContenedor->tipoBasura->nombre ?? 'No disponible' }}</td>
            <td>{{ $registro->cantidad_vaciada }}</td>
            <td>{{ $registro->created_at->format('d/m/Y H:i') }}</td>
          </tr>
        @empty
          <tr>
            <td colspan="4" class="text-center">No hay datos disponibles.</td>
          </tr>
        @endforelse
      </tbody>
    </table>

    {{-- Paginación --}}
    <div class="mt-4 flex justify-center">
      {{ $registros->links() }}
  </div>
  </div>
</div>
@endsection
