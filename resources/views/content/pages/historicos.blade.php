@extends('layouts/layoutMaster')

@section('title', 'Históricos de Residuos')

@section('content')
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <div class="card">
        <h5 class="card-header">Histórico de Residuos Vaciados</h5>
        {{-- Filtro de fechas --}}
        <div class="d-flex justify-content-center mt-3">
            <form method="GET" action="{{ route('historicos-user') }}" class="flex flex-wrap gap-4 mb-4 justify-center">
                <select name="filtro" class="border rounded px-4 py-2">
                    <option value="">-- Selecciona un filtro --</option>
                    <option value="hoy" {{ request('filtro') == 'hoy' ? 'selected' : '' }}>Hoy</option>
                    <option value="semana" {{ request('filtro') == 'semana' ? 'selected' : '' }}>Esta semana</option>
                    <option value="mes" {{ request('filtro') == 'mes' ? 'selected' : '' }}>Este mes</option>
                    <option value="rango" {{ request('filtro') == 'rango' ? 'selected' : '' }}>Rango personalizado</option>
                </select>
                <input type="date" name="desde" value="{{ request('desde') }}" class="border rounded px-4 py-2"
                    placeholder="Desde">
                <input type="date" name="hasta" value="{{ request('hasta') }}" class="border rounded px-4 py-2"
                    placeholder="Hasta">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Filtrar</button>
            </form>
        </div>

        {{-- Tabla de datos --}}
        <div class="overflow-x-auto mt-6 rounded-lg shadow">
            <table class="min-w-full divide-y divide-gray-200 bg-white text-sm text-left">
                <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <th scope="col" class="px-6 py-3 font-medium">Nombre de Dispositivo</th>
                        <th scope="col" class="px-6 py-3 font-medium">Tipo de Basura</th>
                        <th scope="col" class="px-6 py-3 font-medium">Cantidad Vaciada (kg)</th>
                        <th scope="col" class="px-6 py-3 font-medium">Fecha</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse ($registros as $registro)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ $registro->divisionContenedor->contenedor->nombre ?? 'No disponible' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ $registro->divisionContenedor->tipoBasura->nombre ?? 'No disponible' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $registro->cantidad_vaciada }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $registro->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center px-6 py-4 text-gray-500">No hay datos disponibles.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <h5 class="card-header mt-5">Histórico Cantidades Totales</h5>
            <table class="min-w-full divide-y divide-gray-200 bg-white text-sm text-left">
                <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <th scope="col" class="px-6 py-3 font-medium">Nombre dispositivo</th>
                        <th scope="col" class="px-6 py-3 font-medium">Tipo basura</th>
                        <th scope="col" class="px-6 py-3 font-medium">Total Vaciado KG</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($resumen as $item)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">{{ $item->nombre_contenedor }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $item->nombre_tipo_basura }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ number_format($item->total_kg, 2) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center px-6 py-4 text-gray-500">No hay datos disponibles.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>


        </div>
        <a href="{{ route('exportar-historico') }}"
        class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 mt-4  ">
        Exportar a Excel
    </a>
    

        {{-- Paginación --}}
        <div class="mt-4 flex justify-center">
            {{ $registros->links() }}
        </div>
    </div>
    </div>
@endsection
