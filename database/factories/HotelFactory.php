<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class HotelFactory extends Factory
{
    public function definition(): array
    {
        $cities   = ['Jakarta','Bandung','Yogyakarta','Bali','Surabaya','Medan'];
        $features = ['WiFi','Sarapan','Kolam','Parkir','Gym','AC','Spa','Bar'];
        shuffle($features);

        return [
            'name'        => fake()->company().' Hotel',
            'city'        => fake()->randomElement($cities),
            'stars'       => fake()->numberBetween(3,5),
            'address'     => fake()->address(),
            'description' => fake()->paragraph(),
            'cover_url'   => 'https://picsum.photos/seed/'.fake()->uuid().'/1200/700',
            'base_price'  => fake()->numberBetween(250000, 1200000),
            'features'    => array_slice($features, 0, 4),
            'gallery'     => [],
        ];
    }
}
