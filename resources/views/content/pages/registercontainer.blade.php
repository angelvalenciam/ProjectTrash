@php
    $configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Page 2')

@section('content')
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
                        <div class="mb-3">
                            <label class="form-label" for="numero_serie">Número de serie</label>
                            <input type="text" class="form-control" id="numero_serie" name="numero_serie"
                                placeholder="Ingrese el número de serie" required />
                        </div>
                        <button type="submit" class="btn btn-primary">Registrar</button>
                    </form>
                    <table class="table">
                        <thead>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Serial</th>
                            <th>Accion</th>
                        </thead>
                        <tbody>
                            @foreach ($containers as $content)
                                <tr>
                                    <td> {{ $content->id }} </td>
                                    <td> {{ $content->nombre }} </td>
                                    <td> {{ $content->numero_serie }} </td>
                                    <td>
                                        <button class="btn btn-warning">Editar</button>
                                        <form action="{{ route('contenedores.destroy', $content->id) }}" method="POST"
                                            style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" data-id="{{ $content->id }}"
                                                class="btn btn-danger btn-delete">Eliminar</button>
                                        </form>
                                        @if (session('success'))
                                            <div>Eliminado</div>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


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
