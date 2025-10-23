<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Room;
use Illuminate\Support\Carbon;

class BookingFactory extends Factory
{
    public function definition(): array
    {
        $user = User::inRandomOrder()->first() ?? User::factory()->create();
        $room = Room::inRandomOrder()->first() ?? Room::factory()->create();

        $checkIn  = Carbon::now()->addDays(fake()->numberBetween(1, 20));
        $nights   = fake()->numberBetween(1, 5);
        $checkOut = (clone $checkIn)->addDays($nights);
        $ppn      = $room->price_per_night;
        $total    = $ppn * $nights;

        return [
            'user_id'         => $user->id,
            'room_id'         => $room->id,
            'check_in'        => $checkIn,
            'check_out'       => $checkOut,
            'nights'          => $nights,
            'price_per_night' => $ppn,
            'total_price'     => $total,
            'status'          => fake()->randomElement(['pending','confirmed']),
        ];
    }
}
