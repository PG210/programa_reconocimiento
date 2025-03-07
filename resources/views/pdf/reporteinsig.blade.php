<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de insignias recibidas PDF</title>
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
    <h1>Reporte de Datos</h1>
    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Oro</th>
                <th>Plata</th>
                <th>Bronce</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $item)
                <tr>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->ape }}</td>
                    <td>{{ $item->oro ?? '0' }}</td>
                    <td>{{ $item->plata ?? '0' }}</td>
                    <td>{{ $item->bronce ?? '0' }}</td>
                    <td>{{ $item->total ?? '0' }}</td>
                </tr>
        @endforeach
        </tbody>
    </table>
</body>
</html>
