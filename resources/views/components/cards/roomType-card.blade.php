<div class="flex rounded-lg shadow-xl overflow-hidden bg-white border border-gray-200">
    <!-- Imagen del hotel -->
    <img src="{{ $roomType->main_image }}" alt="Imagen del hotel" class="w-1/3 h-48 object-cover">

    <!-- Contenido del hotel -->
    <div class="p-4 flex flex-col justify-between w-2/3">
        <h3 class="text-xl font-semibold mb-2">{{ $roomType->name }}</h3>
        <p class="text-sm text-gray-500 mb-4">{{ $roomType->description }}</p>
        <p class="text-sm text-gray-500 mb-4">{{ $roomType->capacity }} huéspedes máximo</p>

        <div class="mb-3">
            @foreach ($roomType->characteristics->take(4) as $characteristic)
                <span class="badge bg-light text-dark me-1 mb-1">
                    {{ $characteristic->name }}
                </span>
            @endforeach

            @if ($roomType->characteristics->count() > 4)
                <span class="badge bg-light text-dark">
                    +{{ $roomType->characteristics->count() - 4 }} más
                </span>
            @endif
        </div>

        <div class="d-flex justify-content-between align-items-center">
            <div>
                <span class="fs-4 fw-bold text-primary">S/ {{ number_format($roomType->base_price, 2) }}</span>
                <span class="text-muted">/noche</span>
            </div>

            <div>
                @if ($roomType->available_rooms_count > 0)
                    <a href="{{ route('room_types.show', $roomType) }}" class="btn btn-primary">
                        Ver detalles
                    </a>
                @else
                    <button class="btn btn-secondary" disabled>No disponible</button>
                @endif
            </div>
        </div>

        <div class="card-footer bg-white border-top-0">
                        <small class="text-muted">
                            {{ $roomType->available_rooms_count }} habitaciones disponibles
                        </small>
                    </div>
    </div>
</div>
