<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Hotel;

class RoomFactory extends Factory
{
    public function definition(): array
    {
        $types = ['Standard','Deluxe','Suite'];

        return [
            'hotel_id'        => Hotel::inRandomOrder()->value('id') ?? Hotel::factory(),
            'name'            => 'Kamar '.strtoupper(fake()->randomLetter()).fake()->randomNumber(2),
            'type'            => fake()->randomElement($types),
            'capacity'        => fake()->numberBetween(1, 4),
            'price_per_night' => fake()->numberBetween(250000, 1800000),
            'status'          => 'available',
            'photo_url'       => 'https://picsum.photos/seed/'.fake()->uuid().'/800/500',
        ];
    }
}
