@foreach ($hotel->HotelType as $typeRoom)
    <div>
        <h4>{{ $typeRoom->name }}</h4>
        <p>{{ $typeRoom->price }} USD</p>
        <a href="{{ route('reservation.create', ['hotel' => $hotel->id, 'idtype' => $typeRoom->id]) }}">
            Ver detalles y reservar
        </a>
    </div>
@endforeach
