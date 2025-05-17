@extends('layouts.app')

@section('content')

<link rel="stylesheet" href="{{ asset('css/reservation.css') }}">

<div class="room-container">
    <div class="room-title">Reservar Habitación - {{ $typeRoom->name }}</div>
    <div class="room-hotel">Hotel: {{ $hotel->name }}</div>

    {{-- Imágenes --}}
    <div class="room-images">
        @foreach ($typeRoom->roomImages->take(2) as $image)
            <img src="{{ asset('storage/' . $image->image_path) }}" alt="{{ $image->alt_text ?? 'Imagen de habitación' }}">
        @endforeach
    </div>

    {{-- Info general --}}
    <div class="room-info">
        <p><strong>Descripción:</strong> {{ $typeRoom->description }}</p>
        <p><strong>Features:</strong> {{ $typeRoom->features }}</p>
        <p class="room-price">Precio por noche: ${{ $typeRoom->base_price }}</p>
        <p><strong>Servicios incluidos:</strong> {{ $typeRoom->amenities }}</p>
    </div>
</div>


<div class="room-container">
<div class="room-title">Formulario de Reserva</div>

<form action="{{ route('reservations.store') }}" method="POST" class="reservation-form">
    @csrf

    <input type="hidden" name="room_id" value="{{ $typeRoom->id }}">

    <div class="form-group">
        <label for="check_in">Fecha de entrada:</label>
        <input type="date" name="check_in" id="check_in" required>
    </div>

    <div class="form-group">
        <label for="check_out">Fecha de salida:</label>
        <input type="date" name="check_out" id="check_out" required>
    </div>

    <div class="form-group">
        <label for="guests">Número de huéspedes:</label>
        <input type="number" name="guests" id="guests" min="1" value="1" required>
    </div>

    <div class="form-group">
        <label for="special_requests">Comentarios o solicitudes especiales:</label>
        <textarea name="special_requests" id="special_requests" rows="3"></textarea>
    </div>

    <button type="submit" class="btn-reserve">Reservar ahora</button>
    {{-- Total (muestra solo si ambas fechas están llenas) --}}
    <div class="form-group">
        <label for="total_price">Precio total estimado:</label>
        <input type="text" id="total_price" readonly style="background-color: #f0f0f0;">
    </div>
</form>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const checkInInput = document.getElementById('check_in');
    const checkOutInput = document.getElementById('check_out');
    const totalInput = document.getElementById('total_price');
    const pricePerNight = {{ $typeRoom->base_price }};

    function updateTotal() {
        const checkIn = new Date(checkInInput.value);
        const checkOut = new Date(checkOutInput.value);

        if (!isNaN(checkIn) && !isNaN(checkOut) && checkOut > checkIn) {
            const diff = (checkOut - checkIn) / (1000 * 60 * 60 * 24);
            totalInput.value = "$" + (diff * pricePerNight).toFixed(2);
        } else {
            totalInput.value = '';
        }
    }

    checkInInput.addEventListener('change', updateTotal);
    checkOutInput.addEventListener('change', updateTotal);
});
</script>
</div>
@endsection
