@php
    $configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Page 2')

@section('content')
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <h1> Registrar Dispositivos </h1>

    <div class="row">
        <div class="col-xl">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Asigne los datos de su contenedor</h5> <small class="text-muted float-end"></small>
                </div>
                <div class="card-body">
                    <form action="{{ route('contenedores.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label" for="nombre">Nombre del dispositivo</label>
                            <input type="text" class="form-control" id="nombre" name="nombre"
                                placeholder="Nombre del dispositivo" required />
                        </div>

                        <button type="submit" class="btn btn-primary">Registrar</button>
                    </form>
{{--                    <table class="table">--}}
{{--                        <thead>--}}
{{--                            <th>ID</th>--}}
{{--                            <th>Nombre</th>--}}
{{--                            <th>Serial</th>--}}
{{--                            <th>Accion</th>--}}
{{--                        </thead>--}}
{{--                        <tbody>--}}
{{--                            @foreach ($containers as $content)--}}
{{--                                <tr>--}}
{{--                                    <td> {{ $content->id }} </td>--}}
{{--                                    <td> {{ $content->nombre }} </td>--}}
{{--                                    <td> {{ $content->numero_serie }} </td>--}}
{{--                                    <td>--}}
{{--                                        <button class="btn btn-warning">Editar</button>--}}
{{--                                        <form action="{{ route('contenedores.destroy', $content->id) }}" method="POST"--}}
{{--                                            style="display: inline;">--}}
{{--                                            @csrf--}}
{{--                                            @method('DELETE')--}}
{{--                                            <button type="submit" data-id="{{ $content->id }}"--}}
{{--                                                class="btn btn-danger btn-delete">Eliminar</button>--}}
{{--                                        </form>--}}
{{--                                        @if (session('success'))--}}
{{--                                            <div>Eliminado</div>--}}
{{--                                        @endif--}}
{{--                                    </td>--}}
{{--                                </tr>--}}
{{--                            @endforeach--}}
{{--                        </tbody>--}}
{{--                    </table>--}}
                </div>
            </div>
        </div>

      @if($containers->isEmpty())
        <div class="flex flex-col items-center justify-center h-64 text-center bg-gray-100 rounded-xl shadow-md p-6">
          <h1 class="text-xl font-semibold text-gray-600">No tienes contenedores registrados</h1>
        </div>
      @else
        <div class="grid gap-6 grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 mt-4">
          @foreach ($containers as $container)
            <div class="bg-white rounded-xl shadow-lg p-5 hover:shadow-xl transition duration-300">
              <h3 class="text-lg font-bold text-blue-600 mb-2">{{ $container->nombre }}</h3>
              <p class="text-gray-700 mb-4">Número de serie: <span class="font-semibold">{{ $container->numero_serie }}</span></p>

              {{-- Más información opcional aquí --}}

              <form action="{{ route('contenedores.destroy', $container->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600 transition duration-200">
                  Eliminar
                </button>
              </form>
            </div>
          @endforeach
        </div>
      @endif




      <!-- Paginación debajo de las recompensas -->


        {{-- <script>
          document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll(".btn-delete").forEach(button => {
                button.addEventListener("click", function() {
                    const id = this.getAttribute("data-id");

                    // Establecer la acción del formulario con el id correcto
                    document.getElementById("deleteForm").action = `/recompensasA/${id}`;

                    // Mostrar el modal de confirmación
                    new bootstrap.Modal(document.getElementById('deleteModal')).show();
                });
            });
        });
        </script> --}}
    @endsection
