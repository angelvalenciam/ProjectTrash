<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Vaciado de Contenedor</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        h2 { text-align: center; }
        .section { margin-bottom: 20px; }
        .label { font-weight: bold; }
    </style>
</head>
<body>
    <h2>Resumen de Vaciado de Contenedor</h2>

    <div class="section">
        <h3>Datos del Usuario</h3>
        <p><span class="label">Nombre:</span> {{ $usuario->nombres }} {{ $usuario->apellidos }}</p>
        <p><span class="label">Ciudad:</span> {{ $usuario->ciudad }}</p>
        <p><span class="label">Colonia:</span> {{ $usuario->colonia }}</p>
        <p><span class="label">Número Exterior:</span> {{ $usuario->numero_exterior }}</p>
        <p><span class="label">Descripción Vivienda:</span> {{ $usuario->descripcion_vivienda }}</p>
        <p><span class="label">Email:</span> {{ $usuario->email }}</p>
        <p><span class="label">Tokens:</span> {{ $usuario->tokens }}</p>
    </div>

    <div class="section">
        <h3>Datos del Contenedor</h3>
        <p><span class="label">ID Contenedor:</span> {{ $division->id_contenedor }}</p>
        <p><span class="label">Tipo de Basura:</span> {{ $division->id_tipo_basura }}</p>
        <p><span class="label">Cantidad Vaciada:</span> {{ $division->cantidad_kg }} kg</p>
    </div>

    <p style="text-align: center; margin-top: 30px;">Gracias por contribuir al medio ambiente.</p>
</body>
</html>
