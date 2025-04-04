@extends('layouts/layoutMaster')

@section('title', 'Registrar Recompensas')

@section('content')
    <link rel="stylesheet" href="{{ asset('assets/css/stylesGeneral.css') }}">
    <div>
        <h2>Registrar catálogo de recompensas nuevas </h2>
    </div>
    <form action="{{ route('recompensa-admin.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="container-recompensas-inputs">
            <x-input-float idInput="inputServicio" idphp="nameServicio" pnombre="Servicio"
                nombre="Escriba el nombre del servicio" />
        </div>

        <div class="container-recompensas-inputs">
            <x-text-area idname="descripcion" descripcion="Ingrese la descripción" />
        </div>

        <div class="container-recompensas-inputs">
            <x-input-float idInput="" idphp="precio" pnombre="Ingrese el precio" nombre="Precio" />
        </div>

        <div class="container-recompensas-inputs">
            <label for="imagen" class="block">Imagen</label>
            <input type="file" name="imagen" id="imagen" accept="image/*">
        </div>

        <div class="container-recompensas-inputs">
            <x-button-primary buttonType="submit" buttonName="Registrar" />
        </div>
    </form>

    <div>
        <h2>Lista de Recompensas</h2>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Servicio</th>
                <th>Descripción</th>
                <th>Precio</th>
                <th>Imagen</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($recompensas as $recompensa)
                <tr>
                    <td>{{ $recompensa->id }}</td>
                    <td>{{ $recompensa->titulo }}</td>
                    <td>{{ $recompensa->descripcion }}</td>
                    <td>${{ $recompensa->precio }}</td>
                    <td><img src="{{ Storage::url($recompensa->imagen) }}" alt="Imagen" width="50"></td>
                    <td>
                        <button class="btn btn-warning btn-edit" data-id="{{ $recompensa->id }}"
                            data-titulo="{{ $recompensa->titulo }}" data-descripcion="{{ $recompensa->descripcion }}"
                            data-precio="{{ $recompensa->precio }}" data-imagen="{{ Storage::url($recompensa->imagen) }}"
                            data-bs-toggle="modal" data-bs-target="#editModal">
                            Editar
                        </button>
                        <form action="{{ route('recompensa.destroy', $recompensa->id) }}" method="POST"
                            style="display:inline;">
                            @csrf
                            <button type="button" class="btn btn-danger btn-delete" data-id="{{ $recompensa->id }}">
                                Eliminar
                            </button>

                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Modal para editar recompensa -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Editar Recompensa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <input type="hidden" id="editId">
                        <div class="mb-3">
                            <label for="editTitulo" class="form-label">Servicio</label>
                            <input type="text" class="form-control" id="editTitulo" name="titulo">
                        </div>
                        <div class="mb-3">
                            <label for="editDescripcion" class="form-label">Descripción</label>
                            <textarea class="form-control" id="editDescripcion" name="descripcion"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="editPrecio" class="form-label">Precio</label>
                            <input type="text" class="form-control" id="editPrecio" name="precio">
                        </div>
                        <div class="mb-3">
                            <label for="editImagen" class="form-label">Imagen Actual</label>
                            <img id="editImagenPreview" src="" width="100" alt="Imagen de recompensa">
                        </div>
                        <div class="mb-3">
                            <label for="editNewImage" class="form-label">Subir Nueva Imagen</label>
                            <input type="file" class="form-control" name="imagen" id="editNewImage" accept="image/*">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Guardar cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- No lo edita porque le falta el accion quizas? --}}
    {{-- Modal --}}
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirmar Eliminación</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ¿Estás seguro de que quieres eliminar esta recompensa? Esta acción no se puede deshacer.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <form id="deleteForm" action="" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- end --}}
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll(".btn-edit").forEach(button => {
                button.addEventListener("click", function() {
                    const id = this.getAttribute("data-id");
                    const titulo = this.getAttribute("data-titulo");
                    const descripcion = this.getAttribute("data-descripcion");
                    const precio = this.getAttribute("data-precio");
                    const imagen = this.getAttribute("data-imagen");

                    document.getElementById("editId").value = id;
                    document.getElementById("editTitulo").value = titulo;
                    document.getElementById("editDescripcion").value = descripcion;
                    document.getElementById("editPrecio").value = precio;
                    document.getElementById("editImagenPreview").src = imagen;

                    // Asegúrate de que la acción del formulario esté configurada correctamente
                    document.getElementById("editForm").action = `/recompensasA/${id}`;
                });
            });
        });

        // modal
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
    </script>
@endsection
