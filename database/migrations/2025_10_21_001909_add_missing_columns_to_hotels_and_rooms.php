<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // ==== HOTELS ====
        Schema::table('hotels', function (Blueprint $table) {
            // kolom dasar lokasi/rating (kalau belum ada)
            if (!Schema::hasColumn('hotels', 'city'))  {
                $table->string('city')->nullable()->index();
            }
            if (!Schema::hasColumn('hotels', 'stars')) {
                $table->unsignedTinyInteger('stars')->default(3);
            }
            if (!Schema::hasColumn('hotels', 'address')) {
                $table->string('address')->nullable();
            }
            if (!Schema::hasColumn('hotels', 'description')) {
                $table->text('description')->nullable();
            }

            // kolom gambar
            if (!Schema::hasColumn('hotels', 'cover_url')) {
                $table->string('cover_url')->nullable();
            }
            if (!Schema::hasColumn('hotels', 'cover_path')) {
                $table->string('cover_path')->nullable();
            }

            // harga dasar
            if (!Schema::hasColumn('hotels', 'base_price')) {
                $table->unsignedInteger('base_price')->default(200000);
            }

            // fitur & galeri (pakai JSON; jika MySQL/MariaDB kamu tua dan tak support JSON,
            // ubah ke: $table->text('features')->nullable(); dan $table->text('gallery')->nullable();)
            if (!Schema::hasColumn('hotels', 'features')) {
                $table->json('features')->nullable();
            }
            if (!Schema::hasColumn('hotels', 'gallery')) {
                $table->json('gallery')->nullable();
            }
        });

        // ==== ROOMS ==== (jaga-jaga kalau skema awal belum lengkap)
        Schema::table('rooms', function (Blueprint $table) {
            if (!Schema::hasColumn('rooms', 'type')) {
                $table->enum('type',['Standard','Deluxe','Suite'])->default('Standard');
            }
            if (!Schema::hasColumn('rooms', 'capacity')) {
                $table->unsignedTinyInteger('capacity')->default(2);
            }
            if (!Schema::hasColumn('rooms', 'price_per_night')) {
                $table->unsignedInteger('price_per_night')->default(200000);
            }
            if (!Schema::hasColumn('rooms', 'status')) {
                $table->enum('status',['available','unavailable'])->default('available');
            }
            if (!Schema::hasColumn('rooms', 'photo_url')) {
                $table->string('photo_url')->nullable();
            }
            if (!Schema::hasColumn('rooms', 'photo_path')) {
                $table->string('photo_path')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('hotels', function (Blueprint $table) {
            // Hapus kolom-kolom yang kita tambahkan saja (cek dulu agar aman)
            foreach (['gallery','features','base_price','cover_path','cover_url','description','address','stars','city'] as $col) {
                if (Schema::hasColumn('hotels', $col)) $table->dropColumn($col);
            }
        });

        Schema::table('rooms', function (Blueprint $table) {
            foreach (['photo_path','photo_url','status','price_per_night','capacity','type'] as $col) {
                if (Schema::hasColumn('rooms', $col)) $table->dropColumn($col);
            }
        });
    }
};
