@extends('layouts.app')

@section('title', 'Detalle de habitación - ' . $roomType->name)
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@section('content')
    <link rel="stylesheet" href="{{ asset('css/roomtype.css') }}">
    <link rel="stylesheet" href="{{ asset('css/reservation.css') }}"> {{-- SOLO AQUÍ, NO EN CADA MODAL --}}

    <div class="roomtype-container">
        <div class="room-header">
            <h2>{{ $roomType->name }}</h2>
            <p><strong>Hotel:</strong> {{ $roomType->hotel->name }} - {{ $roomType->hotel->address }}</p>
        </div>

        {{-- Galería --}}
        <div class="roomtype-gallery">
            <div class="main-image">
                @if ($roomType->images->isNotEmpty())
                    <img src="{{ $roomType->images->first()->img_path }}" alt="Imagen principal">
                @endif
            </div>
            <div class="thumbnail-images">
                @foreach ($roomType->images->skip(1)->take(4) as $image)
                    <div class="thumbnail">
                        <img src="{{ $image->img_path }}" alt="Imagen">
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Información --}}
        <div class="roomtype-info">
            <div class="info-row">
                <span><strong>Capacidad:</strong> {{ $roomType->capacity }} personas</span>
                <span><strong>Precio por noche:</strong> S/ {{ number_format($roomType->base_price, 2) }}</span>
            </div>
            <p><strong>Descripción:</strong> {{ $roomType->description }}</p>
        </div>

        {{-- Características --}}
        <div class="roomtype-characteristics">
            <h4>Servicios incluidos</h4>
            <ul>
                @foreach ($roomType->characteristics as $char)
                    <li>{{ $char->name }}</li>
                @endforeach
            </ul>
        </div>

        {{-- Habitaciones disponibles --}}
        <div class="roomtype-availability">
            <h4>Habitaciones disponibles</h4>
            @if ($availableRooms->isEmpty())
                <p>No hay habitaciones disponibles.</p>
            @else
                <p>{{ $availableRooms->count() }} habitaciones disponibles:</p>

                <div class="available-rooms-list">
                    @foreach ($availableRooms as $room)
                        <div class="room-card">
                            <p><strong>Habitación #:</strong> {{ $room->room_number }}</p>
                            <p><strong>Piso:</strong> {{ $room->floor }}</p>

                            @auth
                                {{-- BOTÓN Y FORMULARIO para usuarios logueados --}}
                                <a href="#" class="btn-reserve" onclick="openReservationForm({{ $room->id }})">
                                    Reservar habitación
                                </a>

                                <div class="reservation-modal" id="modal-{{ $room->id }}" style="display: none;">
                                    <div class="reservation-modal-content">
                                        <span class="close-button"
                                            onclick="closeReservationForm({{ $room->id }})">&times;</span>
                                        <h3>Formulario de Reserva</h3>
                                        <form action="{{ route('reservations.store') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="room_id" value="{{ $room->id }}">

                                            <div class="form-group">
                                                <label for="nombre_completo">Nombre completo del huésped:</label>
                                                <input type="text" name="nombre_completo" id="nombre_completo" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="email">Correo electrónico:</label>
                                                <input type="email" name="email" id="email" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="telefono">Teléfono:</label>
                                                <input type="tel" name="telefono" id="telefono" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="check_in">Fecha de ingreso:</label>
                                                <input type="date" name="check_in" id="check_in" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="check_out">Fecha de salida:</label>
                                                <input type="date" name="check_out" id="check_out" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="cantidad_huespedes">Cantidad de huéspedes:</label>
                                                <input type="number" name="cantidad_huespedes" id="cantidad_huespedes"
                                                    min="1" value="1" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="total_price">Precio total :</label>
                                                <input type="text" id="total_price_{{ $room->id }}" readonly
                                                    style="background-color: #f0f0f0;">
                                            </div>
                                            <button type="submit" class="btn btn-success">Confirmar Reserva</button>
                                        </form>
                                    </div>
                                </div>
                            @endauth

                            @guest
                                {{-- MENSAJE para usuarios NO logueados --}}
                                @guest
                                    <a href="#" class="btn-reserve" onclick="showLoginAlert()">Reservar habitación</a>
                                @endguest

                            @endguest

                        </div>
                        <hr>
                    @endforeach
                </div>
            @endif
        </div>
        {{-- Modal de alerta de login --}}
        <div id="login-alert-modal" class="reservation-modal" style="display: none;">
            <div class="reservation-modal-content">
                <span class="close-button" onclick="closeLoginAlert()">&times;</span>
                <h3>Iniciar sesión requerido</h3>
                <p>Debes <a href="{{ route('login') }}">iniciar sesión</a> para reservar una habitación.</p>
            </div>
        </div>

    </div>

    {{-- JavaScript para abrir/cerrar modal --}}
    <script>
        function openReservationForm(roomId) {
            document.getElementById(`modal-${roomId}`).style.display = 'flex';
        }

        function closeReservationForm(roomId) {
            document.getElementById(`modal-${roomId}`).style.display = 'none';
        }
    </script>
    <script>
        const basePrice = {{ $roomType->base_price }};

        function calculatePrice(roomId) {
            const inField = document.querySelector(`#modal-${roomId} input[name="check_in"]`);
            const outField = document.querySelector(`#modal-${roomId} input[name="check_out"]`);
            const totalField = document.getElementById(`total_price_${roomId}`);

            const checkIn = new Date(inField.value);
            const checkOut = new Date(outField.value);

            if (!isNaN(checkIn) && !isNaN(checkOut) && checkOut > checkIn) {
                const diff = (checkOut - checkIn) / (1000 * 60 * 60 * 24);
                const total = diff * basePrice;
                totalField.value = "S/ " + total.toFixed(2);
            } else {
                totalField.value = '';
            }
        }

        function openReservationForm(roomId) {
            document.getElementById(`modal-${roomId}`).style.display = 'flex';

            const inField = document.querySelector(`#modal-${roomId} input[name="check_in"]`);
            const outField = document.querySelector(`#modal-${roomId} input[name="check_out"]`);

            inField.addEventListener('change', () => calculatePrice(roomId));
            outField.addEventListener('change', () => calculatePrice(roomId));
        }

        function closeReservationForm(roomId) {
            document.getElementById(`modal-${roomId}`).style.display = 'none';
        }
    </script>
    <script>
        function showLoginAlert() {
            document.getElementById('login-alert-modal').style.display = 'flex';
        }

        function closeLoginAlert() {
            document.getElementById('login-alert-modal').style.display = 'none';
        }
    </script>


@endsection
