<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Resumen</title>
  <style>
    :root {
      --color-bg: #f7f7ff;
      --color-primary: #279AF1;
      --color-title: #070600;
      --color-subtitle: #23b5d3;
      --color-card: #ffffff;
      --color-border: #ddd;
      --shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
      font-family: "Arial", sans-serif;
    }

    body {
      background-color: var(--color-bg);
      color: var(--color-title);
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
      page-break-before: always;
    }

    .ticket {
      width: 340px;
      height: 800px;
      /* Más largo */
      padding: 20px;
      background-color: var(--color-card);
      border-radius: 10px;
      box-shadow: var(--shadow);
      font-size: 14px;
      line-height: 1.6;
      color: #333;
      border: 1px solid var(--color-border);
      text-align: center;
      overflow: hidden;
      margin: auto;
    }

    .ticket h1 {
      font-size: 18px;
      font-weight: bold;
      color: var(--color-primary);
      margin-bottom: 10px;
    }

    .ticket p {
      margin-bottom: 5px;
    }

    .ticket .section-title {
      font-weight: bold;
      color: var(--color-primary);
      margin-top: 15px;
    }

    .ticket .line {
      margin: 10px 0;
      border-top: 1px dashed var(--color-border);
    }

    .ticket .total {
      font-size: 16px;
      font-weight: bold;
      color: var(--color-primary);
      margin-top: 10px;
    }

    .ticket .footer {
      font-size: 12px;
      color: #777;
      margin-top: 30px;
    }

    .ticket .logo {
      width: 100%;
      max-width: 240px;
      height: auto;
      border-radius: 1.5rem;
      margin: 1rem auto;
      box-shadow: 1px 1px 20px rgba(0, 0, 0, 0.2);
    }

    @page {
      size: A4;
      margin: 0;
    }

    body {
      margin: 0;
      padding: 0;
      height: 100%;
    }
  </style>
</head>

<body>
<div class="ticket">
  <h1>Vaciado</h1>
  <img class="logo" src="assets/img/logo.jpg" alt="Logo">
  <div class="line"></div>
  <p class="section-title">Datos usuario</p>
  <p>Nombre: {{ $usuario->nombres }}, {{ $usuario->apellidos }}</p>
  <p>Colonia: {{ $usuario->colonia }}, <br> Ciudad: {{ $usuario->ciudad }}</p>
  <p>Número exterior: {{ $usuario->numero_exterior }}</p>
  <p>Tipo de basura: {{ $tipoBasura }}</p>
  <p>Contenedor: {{ $contenedorNombre }}</p>
  <div class="line"></div>

  <p class="section-title">Último Vaciado</p>
  <p>{{ $vaciado ?? 'No hay registro' }} kg</p>
  <div class="line"></div>


  <div class="line"></div>

  <img src="{{ $qrCode }}" alt="QR Code" style="margin-top: 10px; width: 150px; height: 150px;">

  <h1>ID: {{  $id }}</h1>


  <p class="footer">¡Gracias por tu uso!</p>
  <div class="line"></div>

  <p>Juntos por un mejor mundo</p>
  <div class="line"></div>
</div>
</body>

</html>
