<?php

namespace Database\Factories;

use App\Models\Hotel;
use Illuminate\Database\Eloquent\Factories\Factory;

class HotelFactory extends Factory
{
    /**
     * El nombre del modelo que la fábrica representa.
     *
     * @var string
     */
    protected $model = Hotel::class;

    /**
     * Definir el estado de la fábrica.
     *
     * @return array
     */
    public function definition()
    {
        // Lista de capitales de los departamentos de Perú
        $cities = [
            'Lima', 'Arequipa', 'Cusco', 'Trujillo', 'Piura', 'Chiclayo', 'Iquitos', 'Chimbote', 'Tacna', 'Puno',
            'Huancayo', 'Ayacucho', 'Cajamarca', 'Loreto', 'Moquegua', 'Huánuco', 'Junín', 'Tumbes', 'Apurímac',
            'San Martín', 'Ancash', 'Callao', 'La Libertad', 'Madre de Dios', 'Ucayali', 'La Oroya', 'Lambayeque'
        ];

        return [
            'name' => $this->faker->company . ' ' . $this->faker->randomElement($cities), // Nombre del hotel
            'address' => $this->faker->streetAddress . ', ' . $this->faker->randomElement($cities), // Dirección con ciudad
            'city' => $this->faker->randomElement($cities), // Ciudad aleatoria de las capitales
            'phone' => '01-' . $this->faker->numberBetween(1000000, 9999999), // Teléfono en formato peruano
            'email' => $this->faker->safeEmail, // Email seguro
            'stars' => $this->faker->numberBetween(3, 5),  // Estrellas entre 3 y 5
            'description' => $this->faker->paragraph, // Descripción aleatoria
            'main_image' => json_encode([$this->faker->imageUrl(640, 480, 'business')]), // Imagen aleatoria
            'active' => true, // Activo
        ];
    }
}
