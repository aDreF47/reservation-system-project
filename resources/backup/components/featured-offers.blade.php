<div class="grid grid-cols-1 md:grid-cols-3 gap-8">
    @php
        // En un caso real, estos datos vendrían del controlador
        $featuredOffers = [
            [
                'type' => 'hotel',
                'name' => 'Hotel Paradise',
                'image' => 'images/hotels/hotel1.jpg',
                'price' => 120,
                'discount' => 20,
                'rating' => 4.5,
                'location' => 'Lima Centro',
                'description' => 'Habitación doble con desayuno incluido'
            ],
            [
                'type' => 'restaurant',
                'name' => 'La Terraza Gourmet',
                'image' => 'images/restaurants/restaurant1.jpg',
                'price' => 50,
                'discount' => 15,
                'rating' => 4.8,
                'location' => 'Miraflores',
                'description' => 'Menú degustación para 2 personas'
            ],
            [
                'type' => 'venue',
                'name' => 'Salón Dorado',
                'image' => 'images/venues/venue1.jpg',
                'price' => 500,
                'discount' => 10,
                'rating' => 4.7,
                'location' => 'San Isidro',
                'description' => 'Salón para 100 personas por 4 horas'
            ]
        ];
    @endphp

    @foreach($featuredOffers as $offer)
    <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition duration-300">
        <div class="relative">
            <img src="{{ asset($offer['image']) }}" alt="{{ $offer['name'] }}" class="w-full h-48 object-cover">
            <div class="absolute top-4 right-4 bg-red-500 text-white px-3 py-1 rounded-full text-sm font-semibold">
                -{{ $offer['discount'] }}%
            </div>
        </div>
        <div class="p-6">
            <div class="flex justify-between items-start mb-2">
                <h3 class="text-xl font-semibold">{{ $offer['name'] }}</h3>
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                    </svg>
                    <span class="ml-1 text-gray-600">{{ $offer['rating'] }}</span>
                </div>
            </div>
            <p class="text-gray-600 mb-2">
                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                {{ $offer['location'] }}
            </p>
            <p class="text-gray-600 mb-4">{{ $offer['description'] }}</p>
            <div class="flex justify-between items-center">
                <div>
                    <span class="text-gray-400 line-through text-sm">S/ {{ $offer['price'] }}</span>
                    <span class="text-2xl font-bold text-green-600 ml-2">
                        S/ {{ $offer['price'] - ($offer['price'] * $offer['discount'] / 100) }}
                    </span>
                </div>
                <a href="#" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition duration-300">
                    Reservar
                </a>
            </div>
        </div>
    </div>
    @endforeach
</div>
