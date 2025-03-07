<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de reconocimientos recibidos PDF</title>
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
                <th>Categoría 1</th>
                <th>Categoría 2</th>
                <th>Categoría 3</th>
                <th>Categoría 4</th>
                <th>Categoría 5</th>
                <th>Total</th>
                <th>Fecha Min</th>
                <th>Fecha Max</th>
            </tr>
        </thead>
        <tbody>
        @foreach ($data as $subArray)
            @foreach($subArray as $item)
                <tr>
                    <td>{{ $item->nombre }}</td>
                    <td>{{ $item->ape }}</td>
                    <td>{{ $item->c1 ?? '0' }}</td>
                    <td>{{ $item->c2 ?? '0' }}</td>
                    <td>{{ $item->c3 ?? '0' }}</td>
                    <td>{{ $item->c4 ?? '0' }}</td>
                    <td>{{ $item->c5 ?? '0' }}</td>
                    <td>{{ $item->tot ?? '0' }}</td>
                    <td>{{ $item->fecmin ?? 'N/A' }}</td>
                    <td>{{ $item->fecmax ?? 'N/A' }}</td>
                </tr>
            @endforeach
        @endforeach
        </tbody>
    </table>
</body>
</html>
