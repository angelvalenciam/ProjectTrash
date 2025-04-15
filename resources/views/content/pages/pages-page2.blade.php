@extends('layouts.layoutMaster')

@section('title', 'Disponer residuos')

@section('content')
    <link rel="stylesheet" href="{{ asset('assets/css/stylesGeneral.css') }}">

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

    <script>
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
                                    <x-card-containers
                                    title="${tipo.id_tipo_basura}"
                                    desc="Esta basura se refiere a ${tipo.id_tipo_basura.toLowerCase()}"
                                    kg="${tipo.cantidad_kg}"
                                    info=" ">
                                    <button onclick="vaciarContenedor(${tipo.id})">Vaciar</button>
                                  </x-card-containers>
                          `;
                            nivelesContainer.innerHTML += card;
                            console.log(tipo.id)
                        });
                    })
                    .catch(error => console.error('Error al obtener los niveles:', error));
            }

        });

        function vaciarContenedor(id) {
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
                        alert('Contenedor vaciado exitosamente.');
                        document.getElementById('contenedor-select').dispatchEvent(new Event('change'));
                    } else {
                        alert('Error: ' + (result.error || 'No se pudo vaciar el contenedor.'));
                    }
                })
                .catch(error => console.error('Error al vaciar:', error));
                console.log(id);
        }
    </script>
    {{-- <script>
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
            <x-card-containers
              title="${tipo.id_tipo_basura}"
              desc="Esta basura se refiere a ${tipo.id_tipo_basura.toLowerCase()}"
              kg="${tipo.cantidad_kg}"
              info=" "
            >
              <button onclick="vaciarContenedor(${tipo.id})">Vaciar</button>
            </x-card-containers>
          `;
                            nivelesContainer.innerHTML += card;
                        });
                    })
                    .catch(error => console.error('Error al obtener los niveles:', error));
            }
        });
    </script> --}}


@endsection
