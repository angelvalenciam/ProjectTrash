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
                        nivelesContainer.innerHTML = ''; // Limpiar los niveles previos

                        data.forEach(tipo => {
                            const card = `
                                    <x-card-containers
                                     title="${tipo.id_tipo_basura}"
                                    desc="Esta basura se refiere a ${tipo.id_tipo_basura.toLowerCase()}"
                                   kg="${tipo.cantidad_kg}"
                                   info=" "
                                 >
                               <button onclick="vaciarContenedor( 104)">Vaciar</button>
                               </x-card-containers>
    `;
                            nivelesContainer.innerHTML += card;
                        });
                    })
                    .catch(error => console.error('Error al obtener los niveles:', error));
            }
        });
    </script>
    <script>
        function vaciarContenedor(idDivision) {
            if (!idDivision) {
                alert("ID de división no válido");
                return;
            }

            const cantidad = prompt("Ingrese la cantidad a vaciar en kg:");
            if (!cantidad || isNaN(cantidad)) {
                alert("Cantidad inválida");
                return;
            }

            fetch("/contenedor/vaciar", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        id_division_contenedor: idDivision,
                        cantidad_vaciada: cantidad
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        alert("Vaciado exitoso");
                        document.getElementById('contenedor-select').dispatchEvent(new Event('change'));
                    } else {
                        alert(data.error || "Error al vaciar");
                    }
                })
                .catch(err => {
                    console.error("Error:", err);
                    alert("Error al vaciar contenedor.");
                });
        }
    </script>

@endsection
