@extends('layouts.admin')
@section('title', 'reservations')
@section('content')

<style>
    .reservations-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }

    .reservation-form {
        background: #f8f9fa;
        padding: 25px;
        border-radius: 8px;
        margin-bottom: 30px;
        border: 1px solid #e9ecef;
    }

    .reservations-table {
        background: white;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .table-header {
        background: #343a40;
        color: white;
        padding: 15px 20px;
        font-weight: bold;
        border-bottom: 1px solid #dee2e6;
    }

    .reservation-row {
        border-bottom: 1px solid #e9ecef;
        padding: 15px 20px;
        transition: background-color 0.2s;
        cursor: pointer;
    }

    .reservation-row:hover {
        background-color: #f8f9fa;
    }

    .reservation-row.unread {
        background-color: #fff3cd;
        border-left: 4px solid #ffc107;
    }

    .status-badge {
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 12px;
        font-weight: bold;
        text-transform: uppercase;
    }

    .status-confirmed { background-color: #d4edda; color: #155724; }
    .status-pending { background-color: #fff3cd; color: #856404; }
    .status-cancelled { background-color: #f8d7da; color: #721c24; }

    .payment-badge {
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 12px;
        font-weight: bold;
        text-transform: uppercase;
    }

    .payment-paid { background-color: #d1ecf1; color: #0c5460; }
    .payment-pending { background-color: #ffeaa7; color: #8b6914; }
    .payment-refunded { background-color: #f5c6cb; color: #721c24; }

    .reservation-details {
        display: grid;
        grid-template-columns: 2fr 1fr 1fr 1fr 1fr 1fr;
        gap: 15px;
        align-items: center;
    }

    .guest-info {
        font-weight: bold;
        color: #343a40;
    }

    .hotel-info {
        color: #6c757d;
        font-size: 14px;
    }

    .dates-info {
        font-size: 14px;
        color: #495057;
    }

    .price-info {
        font-weight: bold;
        color: #28a745;
        font-size: 16px;
    }

    .actions {
        display: flex;
        gap: 5px;
    }

    .btn-small {
        padding: 4px 8px;
        font-size: 12px;
        border-radius: 4px;
        border: none;
        cursor: pointer;
        text-decoration: none;
        display: inline-block;
    }

    .btn-view { background-color: #007bff; color: white; }
    .btn-edit { background-color: #ffc107; color: #212529; }
    .btn-delete { background-color: #dc3545; color: white; }

    .form-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 15px;
        margin-bottom: 20px;
    }

    .form-group {
        display: flex;
        flex-direction: column;
    }

    .form-group label {
        font-weight: bold;
        margin-bottom: 5px;
        color: #495057;
    }

    .form-control {
        padding: 8px 12px;
        border: 1px solid #ced4da;
        border-radius: 4px;
        font-size: 14px;
    }

    .btn-primary {
        background-color: #007bff;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 16px;
    }

    .btn-primary:hover {
        background-color: #0056b3;
    }

    .alert {
        padding: 12px 20px;
        border-radius: 4px;
        margin-bottom: 20px;
    }

    .alert-success {
        background-color: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }

    .pagination {
        display: flex;
        justify-content: center;
        margin-top: 20px;
    }
</style>

<div class="reservations-container">
    <h1>Gestión de Reservas</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Formulario para crear nueva reserva -->
    <div class="reservation-form">
        <h2>Nueva Reserva</h2>
        <form action="{{ route('admin.reservations.store') }}" method="POST">
            @csrf

            <!-- Información del Cliente -->
            <h3>Información del Cliente</h3>
            <div class="form-grid">
                <div class="form-group">
                    <label for="name">Nombre:</label>
                    <input type="text" id="name" name="name" class="form-control" required value="{{ old('name') }}">
                </div>

                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" class="form-control" required value="{{ old('email') }}">
                </div>

                <div class="form-group">
                    <label for="phone">Teléfono:</label>
                    <input type="text" id="phone" name="phone" class="form-control" required value="{{ old('phone') }}">
                </div>
            </div>

            <!-- Selección de Hotel -->
            <h3>Seleccionar Hotel</h3>
            <div class="form-grid">
                <div class="form-group">
                    <label for="hotel">Hotel:</label>
                    <select id="hotel" name="hotel_id" class="form-control" onchange="loadRoomTypes()" required>
                        <option value="">Seleccione un hotel</option>
                        @foreach($hotels as $hotel)
                            <option value="{{ $hotel->id }}" {{ old('hotel_id') == $hotel->id ? 'selected' : '' }}>
                                {{ $hotel->name }} - {{ $hotel->city }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="roomType">Tipo de Habitación:</label>
                    <select id="roomType" name="room_type_id" class="form-control" onchange="loadRooms()" required>
                        <option value="">Seleccione tipo de habitación</option>
                    </select>
                </div>
            </div>

            <!-- Fechas de Estadía -->
            <h3>Fechas de Estadía</h3>
            <div class="form-grid">
                <div class="form-group">
                    <label for="checkIn">Fecha de Ingreso:</label>
                    <input type="date" id="checkIn" name="check_in_date" class="form-control" onchange="loadAvailableRooms()" required value="{{ old('check_in_date') }}">
                </div>

                <div class="form-group">
                    <label for="checkOut">Fecha de Salida:</label>
                    <input type="date" id="checkOut" name="check_out_date" class="form-control" onchange="loadAvailableRooms()" required value="{{ old('check_out_date') }}">
                </div>

                <div class="form-group">
                    <label for="room">Habitación Disponible:</label>
                    <select id="room" name="room_id" class="form-control" onchange="calculateTotal()" required>
                        <option value="">Seleccione una habitación</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="guests">Cantidad de Huéspedes:</label>
                    <select id="guests" name="number_of_guests" class="form-control" onchange="validateCapacity()" required>
                        <option value="">Seleccione cantidad</option>
                        @for($i = 1; $i <= 6; $i++)
                            <option value="{{ $i }}" {{ old('number_of_guests') == $i ? 'selected' : '' }}>
                                {{ $i }} {{ $i == 1 ? 'Huésped' : 'Huéspedes' }}
                            </option>
                        @endfor
                    </select>
                </div>
            </div>

            <!-- Resumen de Reserva -->
            <h3>Resumen de Reserva</h3>
            <div class="form-grid">
                <div class="form-group">
                    <label for="nights">Número de Noches:</label>
                    <input type="text" id="nights" name="nights" class="form-control" readonly>
                </div>

                <div class="form-group">
                    <label for="totalPrice">Precio Total:</label>
                    <input type="text" id="totalPriceDisplay" class="form-control" readonly>
                    <input type="hidden" id="totalPrice" name="total_price" value="{{ old('total_price') }}">
                </div>
            </div>

            <button type="submit" class="btn-primary">Confirmar Reserva</button>
        </form>
    </div>

    <!-- Tabla de Reservas -->
    <div class="reservations-table">
        <div class="table-header">
            📧 Bandeja de Reservas ({{ $reservations->total() }} reservas)
        </div>

        @if($reservations->count() > 0)
            @foreach($reservations as $index => $reservation)
                <div class="reservation-row {{ $index < 3 ? 'unread' : '' }}" onclick="toggleReservationDetails({{ $reservation->id }})">
                    <div class="reservation-details">
                        <div>
                            <div class="guest-info">{{ $reservation->user->name }}</div>
                            <div class="hotel-info">
                                {{ $reservation->room->roomType->hotel->name }} -
                                Habitación {{ $reservation->room->room_number }}
                                ({{ $reservation->room->roomType->name }})
                            </div>
                        </div>

                        <div class="dates-info">
                            <strong>Check-in:</strong><br>
                            {{ \Carbon\Carbon::parse($reservation->check_in)->format('d/m/Y') }}
                        </div>

                        <div class="dates-info">
                            <strong>Check-out:</strong><br>
                            {{ \Carbon\Carbon::parse($reservation->check_out)->format('d/m/Y') }}
                        </div>

                        <div>
                            <span class="status-badge status-{{ $reservation->status }}">
                                {{ ucfirst($reservation->status) }}
                            </span><br>
                            <span class="payment-badge payment-{{ $reservation->payment_status }}">
                                {{ ucfirst($reservation->payment_status) }}
                            </span>
                        </div>

                        <div class="price-info">
                            S/. {{ number_format($reservation->total_price, 2) }}
                            <div style="font-size: 12px; color: #6c757d;">
                                {{ $reservation->guest }} {{ $reservation->guest == 1 ? 'huésped' : 'huéspedes' }}
                            </div>
                        </div>

                        <div class="actions">
                            <a href="{{ route('admin.reservations.show', $reservation->id) }}" class="btn-small btn-view">Ver</a>
                            <button onclick="event.stopPropagation(); editReservation({{ $reservation->id }})" class="btn-small btn-edit">Editar</button>
                        </div>
                    </div>

                    <!-- Detalles expandibles -->
                    <div id="details-{{ $reservation->id }}" style="display: none; margin-top: 15px; padding-top: 15px; border-top: 1px solid #e9ecef;">
                        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px;">
                            <div>
                                <strong>Información de Contacto:</strong><br>
                                Email: {{ $reservation->user->email }}<br>
                                Teléfono: {{ $reservation->user->phone ?? 'No especificado' }}
                            </div>
                            <div>
                                <strong>Fechas de Reserva:</strong><br>
                                Creada: {{ $reservation->created_at->format('d/m/Y H:i') }}<br>
                                Actualizada: {{ $reservation->updated_at->format('d/m/Y H:i') }}
                            </div>
                            <div>
                                <strong>Detalles de Estadía:</strong><br>
                                Noches: {{ \Carbon\Carbon::parse($reservation->check_in)->diffInDays(\Carbon\Carbon::parse($reservation->check_out)) }}<br>
                                Hotel: {{ $reservation->room->roomType->hotel->city }}
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div style="padding: 40px; text-align: center; color: #6c757d;">
                <h3>No hay reservas registradas</h3>
                <p>Las nuevas reservas aparecerán aquí</p>
            </div>
        @endif
    </div>

    <!-- Paginación -->
    @if($reservations->hasPages())
        <div class="pagination">
            {{ $reservations->links() }}
        </div>
    @endif
</div>

<script>
let roomTypesData = {};

function toggleReservationDetails(reservationId) {
    const details = document.getElementById('details-' + reservationId);
    if (details.style.display === 'none') {
        details.style.display = 'block';
    } else {
        details.style.display = 'none';
    }
}

function editReservation(reservationId) {
    // Aquí puedes abrir un modal o redirigir a una página de edición
    alert('Función de edición para reserva ID: ' + reservationId);
}

async function loadRoomTypes() {
    const hotelId = document.getElementById('hotel').value;
    const roomTypeSelect = document.getElementById('roomType');
    const roomSelect = document.getElementById('room');

    roomTypeSelect.innerHTML = '<option value="">Seleccione tipo de habitación</option>';
    roomSelect.innerHTML = '<option value="">Seleccione una habitación</option>';

    if (hotelId) {
        try {
            const response = await fetch(`/admin/reservations/room-types/${hotelId}`);
            const roomTypes = await response.json();

            roomTypes.forEach(type => {
                const option = document.createElement('option');
                option.value = type.id;
                option.textContent = `${type.name} - S/. ${type.base_price}/noche (Max: ${type.capacity} personas)`;
                option.dataset.price = type.base_price;
                option.dataset.capacity = type.capacity;
                roomTypeSelect.appendChild(option);

                roomTypesData[type.id] = type;
            });
        } catch (error) {
            console.error('Error cargando tipos de habitación:', error);
        }
    }

    calculateTotal();
}

async function loadRooms() {
    const roomTypeId = document.getElementById('roomType').value;
    const roomSelect = document.getElementById('room');

    roomSelect.innerHTML = '<option value="">Seleccione una habitación</option>';

    if (roomTypeId) {
        const checkIn = document.getElementById('checkIn').value;
        const checkOut = document.getElementById('checkOut').value;

        if (checkIn && checkOut) {
            loadAvailableRooms();
        } else {
            try {
                const response = await fetch(`/admin/reservations/rooms/${roomTypeId}`);
                const rooms = await response.json();

                rooms.forEach(room => {
                    const option = document.createElement('option');
                    option.value = room.id;
                    option.textContent = `Habitación ${room.room_number}${room.floor ? ' - Piso ' + room.floor : ''}`;
                    roomSelect.appendChild(option);
                });
            } catch (error) {
                console.error('Error cargando habitaciones:', error);
            }
        }
    }

    calculateTotal();
}

async function loadAvailableRooms() {
    const roomTypeId = document.getElementById('roomType').value;
    const checkIn = document.getElementById('checkIn').value;
    const checkOut = document.getElementById('checkOut').value;
    const roomSelect = document.getElementById('room');

    roomSelect.innerHTML = '<option value="">Cargando habitaciones...</option>';

    if (roomTypeId && checkIn && checkOut) {
        try {
            const response = await fetch('/admin/reservations/available-rooms', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    room_type_id: roomTypeId,
                    check_in: checkIn,
                    check_out: checkOut
                })
            });

            const rooms = await response.json();
            roomSelect.innerHTML = '<option value="">Seleccione una habitación</option>';

            if (rooms.length === 0) {
                const option = document.createElement('option');
                option.value = "";
                option.textContent = "No hay habitaciones disponibles en estas fechas";
                option.disabled = true;
                roomSelect.appendChild(option);
            } else {
                rooms.forEach(room => {
                    const option = document.createElement('option');
                    option.value = room.id;
                    option.textContent = `Habitación ${room.room_number}${room.floor ? ' - Piso ' + room.floor : ''} - Disponible`;
                    roomSelect.appendChild(option);
                });
            }
        } catch (error) {
            console.error('Error cargando habitaciones disponibles:', error);
            roomSelect.innerHTML = '<option value="">Error cargando habitaciones</option>';
        }
    }

    calculateTotal();
}

function calculateTotal() {
    const checkIn = document.getElementById('checkIn').value;
    const checkOut = document.getElementById('checkOut').value;
    const roomTypeId = document.getElementById('roomType').value;

    if (checkIn && checkOut && roomTypeId && roomTypesData[roomTypeId]) {
        const checkInDate = new Date(checkIn);
        const checkOutDate = new Date(checkOut);
        const nights = Math.ceil((checkOutDate - checkInDate) / (1000 * 60 * 60 * 24));

        if (nights > 0) {
            const pricePerNight = parseFloat(roomTypesData[roomTypeId].base_price);
            const total = nights * pricePerNight;

            document.getElementById('nights').value = nights;
            document.getElementById('totalPriceDisplay').value = `S/. ${total.toFixed(2)}`;
            document.getElementById('totalPrice').value = total.toFixed(2);
        } else {
            document.getElementById('nights').value = '';
            document.getElementById('totalPriceDisplay').value = '';
            document.getElementById('totalPrice').value = '';
        }
    } else {
        document.getElementById('nights').value = '';
        document.getElementById('totalPriceDisplay').value = '';
        document.getElementById('totalPrice').value = '';
    }
}

function validateCapacity() {
    const guests = parseInt(document.getElementById('guests').value);
    const roomTypeId = document.getElementById('roomType').value;

    if (guests && roomTypeId && roomTypesData[roomTypeId]) {
        const capacity = parseInt(roomTypesData[roomTypeId].capacity);

        if (guests > capacity) {
            alert(`Esta habitación tiene capacidad máxima para ${capacity} personas. Por favor seleccione otro tipo de habitación.`);
            document.getElementById('guests').value = '';
            return false;
        }
    }

    return true;
}

// Establecer fecha mínima como hoy
document.addEventListener('DOMContentLoaded', function() {
    const today = new Date().toISOString().split('T')[0];
    document.getElementById('checkIn').min = today;
    document.getElementById('checkOut').min = today;

    document.getElementById('checkIn').addEventListener('change', function() {
        const selectedDate = this.value;
        document.getElementById('checkOut').min = selectedDate;
        loadAvailableRooms();
    });
});
</script>

@endsection
