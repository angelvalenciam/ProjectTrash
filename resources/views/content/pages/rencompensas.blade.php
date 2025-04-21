@extends('layouts.layoutMaster')

@section('title', 'Recompensas')

<link rel="stylesheet" href="{{ asset('assets/css/stylesGeneral.css') }}">
<script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

@section('content')
    <div class="container-down cont-btn">
        <h4>
            <p>Token ganados: {{ $token }}</p>
        </h4>
    </div>
    <div class="container-down cont-btn">
        <p>Seleccione una recompensa la cual desea canjear</p>
    </div>


    <!-- Comprobamos si hay recompensas -->
    @if ($recompensas->isEmpty())
        <div class="container-down cont-btn">
            <h1>No hay recompensas para canjear</h1>
        </div>
    @else
        <div class="container-grid">
            @foreach ($recompensas as $recompensa)
                <div class="card-sale">
                    <img src="{{ asset('storage/recompensas/' . basename($recompensa->imagen)) }}"
                        alt="{{ $recompensa->titulo }}">
                    <h3>{{ $recompensa->titulo }}</h3>
                    <p>{{ $recompensa->descripcion }}</p>
                    <p>{{ $recompensa->precio }} / Token</p>
                    <!-- Botón que abre el modal -->
                    <button
                        onclick="openModal({{ $recompensa->id }}, '{{ $recompensa->titulo }}', {{ $recompensa->precio }})"
                        class="bg-blue-500 text-white px-4 py-2 rounded">Canjear</button>
                </div>
            @endforeach
        </div>
    @endif
    <!-- Paginación debajo de las recompensas -->
    <div class="mt-4 flex justify-center">
        {{ $recompensas->links() }}
    </div>
    <!-- Modal de confirmación -->
    <div id="redeemModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="bg-white p-6 rounded shadow-md w-[90%] md:w-[400px] text-center">
            <h2 class="text-xl font-bold mb-4">Confirmar Canje</h2>
            <p id="modalText" class="mb-4">¿Estás seguro de que deseas canjear esta recompensa?</p>

            <form id="redeemForm" method="POST" action="{{ route('recompensas-user.redeem') }}">
                @csrf
                <input type="hidden" name="recompensa_id" id="recompensa_id">
                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded mr-2">Sí, canjear</button>
                <button type="button" onclick="closeModal()"
                    class="bg-red-500 text-white px-4 py-2 rounded">Cancelar</button>
            </form>
        </div>
    </div>

    <script>
        function openModal(id, titulo, precio) {
            document.getElementById('redeemModal').classList.remove('hidden');
            document.getElementById('modalText').innerText =
                `¿Estás seguro de que deseas canjear "${titulo}" por ${precio} tokens?`;
            document.getElementById('recompensa_id').value = id;
        }

        function closeModal() {
            document.getElementById('redeemModal').classList.add('hidden');
        }
    </script>
    @if (session('success'))
        <div class="bg-green-100 text-green-700 p-2 rounded mb-4 text-center">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="bg-red-100 text-red-700 p-2 rounded mb-4 text-center">
            {{ session('error') }}
        </div>
    @endif

@endsection
