<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de puntos recibidos PDF</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: center;
        }
    </style>
</head>
<body>
  <div style="width: 100%;">
        <div style="display: inline-block; vertical-align: middle; text-align: left;">
            <h2 style="margin: 0;">Reporte de puntos obtenidos</h2>
        </div>
        <div style="display: inline-block; vertical-align: middle; float:right;">
            <img src="{{ public_path('dist/img/logo-reconoser-icono.png') }}" width="80%">
        </div>
    </div>

    <h3>Desde: {{ $fecmin }} </h3>
    <h3>Hasta: {{ $fecmax }} </h3>

    <table>
        <thead>
            <tr>
                <th>Nombre y apellido</th>
                <th>Cargo</th>
                <th>Ärea</th>
                <th>Puntos acumulados</th>
            </tr>
        </thead>
        <tbody>
        @foreach ($data as $subArray)
            @foreach($subArray as $item)
                <tr>
                    <td>{{ $item->nombre }} {{ $item->ape }}</td>
                    <td>{{ $item->nomcar }}</td>
                    <td>{{ $item->nomarea }}</td>
                    <td>{{ $item->puntostot ?? '0' }}</td>
                </tr>
            @endforeach
        @endforeach
        </tbody>
    </table>
</body>
</html>
