<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{User,Hotel,Room,Booking};

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(AdminUserSeeder::class);
        User::factory()->count(5)->create();

        Hotel::factory()
            ->count(6)
            ->create()
            ->each(function($h){
                Room::factory()->count(rand(4,6))->create(['hotel_id'=>$h->id]);
            });

        Booking::factory()->count(8)->create();
    }
}
