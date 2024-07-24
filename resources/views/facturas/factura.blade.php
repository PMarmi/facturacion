<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>Hola Pau</h1>

    <p>{{ $factura->id }}</p>
    <p>{{ $factura->total_factura }}</p>

    @foreach ($detallesFactura as $detalle )

    <div>
        <p>
            {{ $detalle->concepto }}
        </p>
    </div>
        
    @endforeach
</body>
</html>