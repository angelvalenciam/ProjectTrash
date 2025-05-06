@extends('layouts.layoutMaster')

@section('title', 'Consulta de Recolección')

@section('content')
  <div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">Consulta de Recolección</h4>

    <div class="card">
      <div class="table-responsive text-nowrap">
        <table class="table table-striped">
          <thead>
          <tr>
            <th>Nombre del Recolector</th>
            <th>Cantidad Vaciada (kg)</th>
          </tr>
          </thead>
          <tbody>
          @forelse ($recolecciones as $item)
            <tr>
              <td>{{ $item->nombre_completo }}</td>
              <td>{{ number_format($item->cantidad_vaciada, 2) }}</td>
            </tr>
          @empty
            <tr>
              <td colspan="2">No hay registros</td>
            </tr>
          @endforelse
          </tbody>
        </table>
      </div>

      <div class="card-footer d-flex justify-content-center">
        {{ $recolecciones->links() }}
      </div>
    </div>
  </div>
@endsection
