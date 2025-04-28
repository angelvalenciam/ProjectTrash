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

        .flex-dd {
            display: flex;
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
            <button onclick="vaciarContenedor(currentId)"
                class="bg-blue-500 text-white rounded px-4 py-2 mt-4">Confirmar</button>
            <button onclick="closeConfirmModal()" class="bg-gray-500 text-white rounded px-4 py-2 mt-4">Cancelar</button>
        </div>
    </div>

    {{-- Modal de éxito --}}
    <div id="success-modal" class="flex items-center justify-center flex-dd">
        <div class="modal-content">
            <h4 class="text-lg font-medium">Contenedor vaciado exitosamente.</h4>

            <button onclick="closeSuccessModal()" class="bg-green-500 text-white rounded px-4 py-2 mt-4">Cerrar</button>

            <a class="bg-green- text-white rounded px-4 py-2 mt-4" href=" {{ route('ticket.vaciado') }} " src= " ">
                <h4>Descargar pdf</h4>
                <?xml version="1.0" encoding="iso-8859-1"?>
                <!-- Uploaded to: SVG Repo, www.svgrepo.com, Generator: SVG Repo Mixer Tools -->
                <svg height="50px" width="50px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg"
                    xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 303.188 303.188" xml:space="preserve">
                    <g>
                        <polygon style="fill:#E8E8E8;"
                            points="219.821,0 32.842,0 32.842,303.188 270.346,303.188 270.346,50.525 	" />
                        <path style="fill:#FB3449;"
                            d="M230.013,149.935c-3.643-6.493-16.231-8.533-22.006-9.451c-4.552-0.724-9.199-0.94-13.803-0.936
          c-3.615-0.024-7.177,0.154-10.693,0.354c-1.296,0.087-2.579,0.199-3.861,0.31c-1.314-1.36-2.584-2.765-3.813-4.202
          c-7.82-9.257-14.134-19.755-19.279-30.664c1.366-5.271,2.459-10.772,3.119-16.485c1.205-10.427,1.619-22.31-2.288-32.251
          c-1.349-3.431-4.946-7.608-9.096-5.528c-4.771,2.392-6.113,9.169-6.502,13.973c-0.313,3.883-0.094,7.776,0.558,11.594
          c0.664,3.844,1.733,7.494,2.897,11.139c1.086,3.342,2.283,6.658,3.588,9.943c-0.828,2.586-1.707,5.127-2.63,7.603
          c-2.152,5.643-4.479,11.004-6.717,16.161c-1.18,2.557-2.335,5.06-3.465,7.507c-3.576,7.855-7.458,15.566-11.815,23.02
          c-10.163,3.585-19.283,7.741-26.857,12.625c-4.063,2.625-7.652,5.476-10.641,8.603c-2.822,2.952-5.69,6.783-5.941,11.024
          c-0.141,2.394,0.807,4.717,2.768,6.137c2.697,2.015,6.271,1.881,9.4,1.225c10.25-2.15,18.121-10.961,24.824-18.387
          c4.617-5.115,9.872-11.61,15.369-19.465c0.012-0.018,0.024-0.036,0.037-0.054c9.428-2.923,19.689-5.391,30.579-7.205
          c4.975-0.825,10.082-1.5,15.291-1.974c3.663,3.431,7.621,6.555,11.939,9.164c3.363,2.069,6.94,3.816,10.684,5.119
          c3.786,1.237,7.595,2.247,11.528,2.886c1.986,0.284,4.017,0.413,6.092,0.335c4.631-0.175,11.278-1.951,11.714-7.57
          C231.127,152.765,230.756,151.257,230.013,149.935z M119.144,160.245c-2.169,3.36-4.261,6.382-6.232,9.041
          c-4.827,6.568-10.34,14.369-18.322,17.286c-1.516,0.554-3.512,1.126-5.616,1.002c-1.874-0.11-3.722-0.937-3.637-3.065
          c0.042-1.114,0.587-2.535,1.423-3.931c0.915-1.531,2.048-2.935,3.275-4.226c2.629-2.762,5.953-5.439,9.777-7.918
          c5.865-3.805,12.867-7.23,20.672-10.286C120.035,158.858,119.587,159.564,119.144,160.245z M146.366,75.985
          c-0.602-3.514-0.693-7.077-0.323-10.503c0.184-1.713,0.533-3.385,1.038-4.952c0.428-1.33,1.352-4.576,2.826-4.993
          c2.43-0.688,3.177,4.529,3.452,6.005c1.566,8.396,0.186,17.733-1.693,25.969c-0.299,1.31-0.632,2.599-0.973,3.883
          c-0.582-1.601-1.137-3.207-1.648-4.821C147.945,83.048,146.939,79.482,146.366,75.985z M163.049,142.265
          c-9.13,1.48-17.815,3.419-25.979,5.708c0.983-0.275,5.475-8.788,6.477-10.555c4.721-8.315,8.583-17.042,11.358-26.197
          c4.9,9.691,10.847,18.962,18.153,27.214c0.673,0.749,1.357,1.489,2.053,2.22C171.017,141.096,166.988,141.633,163.049,142.265z
          M224.793,153.959c-0.334,1.805-4.189,2.837-5.988,3.121c-5.316,0.836-10.94,0.167-16.028-1.542
          c-3.491-1.172-6.858-2.768-10.057-4.688c-3.18-1.921-6.155-4.181-8.936-6.673c3.429-0.206,6.9-0.341,10.388-0.275
          c3.488,0.035,7.003,0.211,10.475,0.664c6.511,0.726,13.807,2.961,18.932,7.186C224.588,152.585,224.91,153.321,224.793,153.959z" />
                        <polygon style="fill:#FB3449;" points="227.64,25.263 32.842,25.263 32.842,0 219.821,0 	" />
                        <g>
                            <path style="fill:#A4A9AD;" d="M126.841,241.152c0,5.361-1.58,9.501-4.742,12.421c-3.162,2.921-7.652,4.381-13.472,4.381h-3.643
           v15.917H92.022v-47.979h16.606c6.06,0,10.611,1.324,13.652,3.971C125.321,232.51,126.841,236.273,126.841,241.152z
           M104.985,247.387h2.363c1.947,0,3.495-0.546,4.644-1.641c1.149-1.094,1.723-2.604,1.723-4.529c0-3.238-1.794-4.857-5.382-4.857
           h-3.348C104.985,236.36,104.985,247.387,104.985,247.387z" />
                            <path style="fill:#A4A9AD;" d="M175.215,248.864c0,8.007-2.205,14.177-6.613,18.509s-10.606,6.498-18.591,6.498h-15.523v-47.979
           h16.606c7.701,0,13.646,1.969,17.836,5.907C173.119,235.737,175.215,241.426,175.215,248.864z M161.76,249.324
           c0-4.398-0.87-7.657-2.609-9.78c-1.739-2.122-4.381-3.183-7.926-3.183h-3.773v26.877h2.888c3.939,0,6.826-1.143,8.664-3.43
           C160.841,257.523,161.76,254.028,161.76,249.324z" />
                            <path style="fill:#A4A9AD;" d="M196.579,273.871h-12.766v-47.979h28.355v10.403h-15.589v9.156h14.374v10.403h-14.374
           L196.579,273.871L196.579,273.871z" />
                        </g>
                        <polygon style="fill:#D1D3D3;" points="219.821,50.525 270.346,50.525 219.821,0 	" />
                    </g>
                </svg>
            </a>
        </div>
        <div id="success-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 items-center justify-center z-50">
            <div class="modal-content bg-white p-6 rounded shadow-lg text-center">
                <h4 class="text-lg font-medium">Contenedor vaciado exitosamente.</h4>
                <button onclick="closeSuccessModal()" class="bg-green-500 text-white rounded px-4 py-2 mt-4">Cerrar</button>
            </div>
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
            }, 100000);
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
        fetch('/ruta/a/vaciarContenedor', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    id_division_contenedor: ID_DEL_CONTENEDOR
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // 1. Crear un enlace temporal para descargar el PDF automáticamente
                    const link = document.createElement('a');
                    link.href = data.pdf_url;
                    link.download = 'ticket_vaciado.pdf'; // nombre sugerido
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);

                    // 2. Mostrar el modal solo después de un pequeño retraso para asegurar descarga
                    setTimeout(() => {
                        document.getElementById('success-modal').style.display = 'flex';
                    }, 1000); // espera 1 segundo antes de mostrar modal
                } else {
                    alert('Error: ' + data.error);
                }
            })
            .catch(err => {
                console.error('Error en vaciado:', err);
            });
    </script>

@endsection
