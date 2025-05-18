<div class="flex rounded-lg shadow-xl overflow-hidden bg-white border border-gray-200">
    <!-- Imagen del hotel -->
    <img src="{{ $hotel->main_image }}" alt="Imagen del hotel" class="w-1/3 h-48 object-cover">

    <!-- Contenido del hotel -->
    <div class="p-4 flex flex-col justify-between w-2/3">
        <h3 class="text-xl font-semibold mb-2">{{ $hotel->name }}</h3>
        <p class="text-sm text-gray-500 mb-4">{{ $hotel->description }}</p>

        <div class="flex justify-between items-center">
            <!-- Estrellas -->
            <span class="text-yellow-500">
                @for ($i = 0; $i < $hotel->stars; $i++)
                    ★
                @endfor
            </span>

            <a href="{{ url('/hotels/' . $hotel->id) }}" class="text-blue-600 hover:text-blue-800 text-sm">Ver más</a>
        </div>
    </div>
</div>
