<?php

namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use App\Models\Contenedor;
use Illuminate\Http\Request;

class ContenedorController extends Controller
{
    public function index()
    {
        return view('content.pages.registercontainer');
    }

    public function store(Request $request)
    {
        // Validación de datos
        $request->validate([
            'nombre' => 'required|string|max:255',
            'numero_serie' => 'required|string|unique:contenedores,numero_de_serie',
            'id_usuario' => 'required|exists:usuarios,id',
            'id_tipo_basura' => 'required|exists:tipobasura,id',
            'cantidad_kg' => 'required|numeric|min:0',
        ]);

        // Iniciar una transacción para garantizar integridad de los datos
        \DB::beginTransaction();
        try {
            // 1️⃣ Crear el contenedor
            $contenedor = Contenedor::create([
                'nombre' => $request->nombre,
                'numero_de_serie' => $request->numero_serie,
            ]);

            // 2️⃣ Registrar en usuario_contenedor
            UsuarioContenedor::create([
                'id_usuario' => $request->id_usuario,
                'id_contenedor' => $contenedor->id,
            ]);

            // 3️⃣ Registrar la división del contenedor con tipo de basura
            $divisionContenedor = DivisionContenedor::create([
                'id_contenedor' => $contenedor->id,
                'id_tipo_basura' => $request->id_tipo_basura,
                'cantidad_kg' => $request->cantidad_kg,
            ]);

            // 4️⃣ Simulación de vaciado del contenedor
            $vaciado = VaciadoContenedor::create([
                'id_division_contenedor' => $divisionContenedor->id,
                'id_usuario' => $request->id_usuario,
                'fecha_vaciado' => Carbon::now(),
                'cantidad_vaciada' => $request->cantidad_kg,
            ]);

            // 5️⃣ Asignar tokens al usuario en historial_tokens
            $tokensAsignados = intval($request->cantidad_kg * 10); // Ejemplo: 10 tokens por kg
            HistorialTokens::create([
                'id_usuario' => $request->id_usuario,
                'id_vaciado' => $vaciado->id,
                'tokens_asignados' => $tokensAsignados,
                'fecha_asignacion' => Carbon::now(),
            ]);

            // 6️⃣ Actualizar los tokens del usuario en la tabla usuarios
            $usuario = \App\Models\Usuario::find($request->id_usuario);
            $usuario->tokens += $tokensAsignados;
            $usuario->save();

            \DB::commit();

            return response()->json([
                'message' => 'Contenedor registrado exitosamente',
                'contenedor' => $contenedor,
                'tokens_asignados' => $tokensAsignados,
            ], 201);
        } catch (\Exception $e) {
            \DB::rollBack();
            return response()->json(['error' => 'Error al registrar el contenedor: ' . $e->getMessage()], 500);
        }
    }
}
