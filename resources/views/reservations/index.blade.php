<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Habitaciones disponibles</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h1 class="text-center">Habitaciones Disponibles</h1>
    <div class="row">
        @foreach($habitaciones as $habitacion)
            <div class="col-md-4 mb-4">
                <div class="card">
                    <img src="{{ asset('images/habitaciones/' . $habitacion->imagen) }}" class="card-img-top" alt="Imagen habitación">
                    <div class="card-body">
                        <h5 class="card-title">Habitación {{ $habitacion->numero }}</h5>
                        <p class="card-text">Tipo: {{ $habitacion->tipo }}<br>Precio: ${{ $habitacion->precio }}</p>
                        <form action="{{ route('reservas.create') }}" method="GET">
                            <input type="hidden" name="habitacion_id" value="{{ $habitacion->id }}">
                            <button class="btn btn-primary w-100">Reservar</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
</body>
</html>
