<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // kalau sudah ada user admin dengan email yang sama, jangan duplikasi
        $email = 'admin123@gmail.com';

        $exists = DB::table('users')->where('email', $email)->exists();
        if (!$exists) {
            DB::table('users')->insert([
                'name'       => 'Admin',
                'email'      => $email,
                'password'   => Hash::make('admin123'), // ganti di production
                'role'       => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
