@extends('layouts.layoutMaster')

@section('title', 'Disponer residuos')

@section('content')
    <link rel="stylesheet" href="{{ asset('assets/css/stylesGeneral.css') }}">
    <style>
        #confirm-modal,
        #success-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            width: 300px;
            text-align: center;
        }

        .modal-content button {
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #279AF1;
            color: white;
            border: none;
            cursor: pointer;
        }
        .btn-red{
          background-color: rgb(18, 56, 223);
          color: white;
        }
        .btn-red:hover{
          background-color: rgb(241, 38, 11);
          color: #fff;
        }
    </style>
    <h1>Disponer residuos</h1>

    {{-- Dropdown --}}
    <div class="container-down">
        <select id="contenedor-select">
            <option value="">Selecciona un contenedor</option>
            @foreach ($contenedores as $contenedor)
                <option value="{{ $contenedor->id }}">{{ $contenedor->nombre }}</option>
            @endforeach
        </select>
    </div>

    {{-- Título sin que se haga parte de la grilla --}}
    <div class="container-down cont-btn">
        <h4>Niveles Actuales</h4>
    </div>

    {{-- Contenedor de la grilla --}}
    <div class="container-grid grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 place-items-center"
        id="niveles-container">
        {{-- Se llenarán dinámicamente con JavaScript --}}
    </div>

    {{-- Modal de confirmación --}}
    <div id="confirm-modal">
        <div class="modal-content">
            <h4>¿Estás seguro de vaciar el contenedor?</h4>
            <button onclick="vaciarContenedor(currentId)">Confirmar</button>
            <button onclick="closeConfirmModal()">Cancelar</button>
        </div>
    </div>

    {{-- Modal de éxito --}}
    <div id="success-modal">
        <div class="modal-content">
            <h4>Contenedor vaciado exitosamente.</h4>
            <button onclick="closeSuccessModal()">Cerrar</button>
        </div>
    </div>

    <script>
      let currentId = null;

      // Mostrar modal de confirmación
      function showConfirmModal(id) {
          currentId = id;
          document.getElementById('confirm-modal').style.display = 'flex';
      }

      // Cerrar modal de confirmación
      function closeConfirmModal() {
          currentId = null;
          document.getElementById('confirm-modal').style.display = 'none';
      }

      // Mostrar y cerrar modal de éxito automáticamente
      function showSuccessModal() {
          const successModal = document.getElementById('success-modal');
          successModal.style.display = 'flex';

          // Cerrar automáticamente después de 3 segundos
          setTimeout(() => {
              closeSuccessModal();
          }, 3000);
      }

      // Cerrar modal de éxito manualmente
      function closeSuccessModal() {
          document.getElementById('success-modal').style.display = 'none';
      }

      document.getElementById('contenedor-select').addEventListener('change', function () {
          const contenedorId = this.value;

          if (contenedorId) {
              fetch(`/page-3/contenedor/${contenedorId}/niveles`)
                  .then(response => response.json())
                  .then(data => {
                      const nivelesContainer = document.getElementById('niveles-container');
                      nivelesContainer.innerHTML = '';

                      data.forEach(tipo => {
                          const card = `
                              <x-card-containers
                                  title="${tipo.id_tipo_basura}"
                                  desc="Esta basura se refiere a ${tipo.id_tipo_basura.toLowerCase()}"
                                  kg="${tipo.cantidad_kg}"
                                  info=" ">
                                <button class="btn btn-red" onclick="showConfirmModal(${tipo.id})">Vaciar</button>

                              </x-card-containers>
                          `;
                          nivelesContainer.innerHTML += card;
                      });
                  })
                  .catch(error => console.error('Error al obtener los niveles:', error));
          }
      });

      function vaciarContenedor(id) {
          closeConfirmModal(); // Cierra el modal de confirmación al instante

          fetch('/contenedor/vaciar', {
              method: 'POST',
              headers: {
                  'Content-Type': 'application/json',
                  'X-CSRF-TOKEN': '{{ csrf_token() }}'
              },
              body: JSON.stringify({
                  id_division_contenedor: id
              })
          })
          .then(response => response.json())
          .then(result => {
              if (result.success) {
                  showSuccessModal(); // Mostrar el modal de éxito
                  document.getElementById('contenedor-select').dispatchEvent(new Event('change'));
              } else {
                  alert('Error: ' + (result.error || 'No se pudo vaciar el contenedor.'));
              }
          })
          .catch(error => console.error('Error al vaciar:', error));
      }
  </script>

@endsection
