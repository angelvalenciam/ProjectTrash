@extends('layouts.layoutMaster')

@section('title', 'Disponer residuos')

@section('content')
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
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

        .btn-red {
            background-color: rgb(18, 56, 223);
            color: white;
        }

        .btn-red:hover {
            background-color: rgb(241, 38, 11);
            color: #fff;
        }
    </style>

    <h1 class="text-3xl font-semibold text-center my-4">Disponer residuos</h1>

    {{-- Dropdown --}}
    <div class="mb-6">
        <select id="contenedor-select"
                class="h-12 border border-gray-300 text-gray-600 text-base rounded-lg block w-full py-2.5 px-4 focus:outline-none">
            <option value="">Selecciona un contenedor</option>
            @foreach ($contenedores as $contenedor)
                <option value="{{ $contenedor->id }}">{{ $contenedor->nombre }}</option>
            @endforeach
        </select>
    </div>

    {{-- Título de niveles --}}
    <div class="mb-4">
        <h4 class="text-xl font-semibold text-center">Niveles Actuales</h4>
    </div>

    {{-- Contenedor de la grilla --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4" id="niveles-container">
        {{-- Se llenarán dinámicamente con JavaScript --}}
    </div>

    {{-- Modal de confirmación --}}
    <div id="confirm-modal" class="flex items-center justify-center">
        <div class="modal-content">
            <h4 class="text-lg font-medium">¿Estás seguro de vaciar el contenedor?</h4>
            <button onclick="vaciarContenedor(currentId)" class="bg-blue-500 text-white rounded px-4 py-2 mt-4">Confirmar</button>
            <button onclick="closeConfirmModal()" class="bg-gray-500 text-white rounded px-4 py-2 mt-4">Cancelar</button>
        </div>
    </div>

    {{-- Modal de éxito --}}
    <div id="success-modal" class="flex items-center justify-center">
        <div class="modal-content">
            <h4 class="text-lg font-medium">Contenedor vaciado exitosamente.</h4>
            <button onclick="closeSuccessModal()" class="bg-green-500 text-white rounded px-4 py-2 mt-4">Cerrar</button>
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

        document.getElementById('contenedor-select').addEventListener('change', function() {
            const contenedorId = this.value;

            if (contenedorId) {
                fetch(`/page-3/contenedor/${contenedorId}/niveles`)
                    .then(response => response.json())
                    .then(data => {
                        const nivelesContainer = document.getElementById('niveles-container');
                        nivelesContainer.innerHTML = '';

                        data.forEach(tipo => {
                            const card = `
                              <div class="bg-white p-4 rounded-lg shadow-lg border border-gray-200 w-full">
                                  <h5 class="text-lg font-semibold">${tipo.id_tipo_basura}</h5>
                                  <p class="text-sm text-gray-500">Esta basura se refiere a ${tipo.id_tipo_basura.toLowerCase()}</p>
                                  <p class="text-md font-semibold mt-2">Cantidad: ${tipo.cantidad_kg} kg</p>
                                  <button class="btn-red w-full mt-4 py-2 rounded" onclick="showConfirmModal(${tipo.id})">Vaciar</button>
                              </div>
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
 {{-- prueba  --}}
 {{-- <h1>Ticket de Vaciado</h1>
 <div class="qr">
   <img src="data:image/png;base64,{{ $qr }}" alt="QR Code">
   <p>ID Escaneable: {{ $id }}</p>
 </div>
 <div class="datos">
   <p><strong>Nombre:</strong> {{ $nombre }}</p>
   <p><strong>Tipo de Basura:</strong> {{ $tipo_basura }}</p>
   <p><strong>Cantidad:</strong> {{ $cantidad }} Kg</p>
   <p><strong>Colonia:</strong> {{ $colonia }}</p>
 </div> --}}
@endsection
