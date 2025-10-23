<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // ====== BOOKINGS ======
        Schema::table('bookings', function (Blueprint $table) {
            // relasi
            if (!Schema::hasColumn('bookings', 'user_id')) {
                $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            }
            if (!Schema::hasColumn('bookings', 'room_id')) {
                $table->foreignId('room_id')->constrained()->cascadeOnDelete();
            }

            // tanggal
            if (!Schema::hasColumn('bookings', 'check_in')) {
                $table->date('check_in');
            }
            if (!Schema::hasColumn('bookings', 'check_out')) {
                $table->date('check_out');
            }

            // harga & total
            if (!Schema::hasColumn('bookings', 'nights')) {
                $table->unsignedInteger('nights')->default(1);
            }
            if (!Schema::hasColumn('bookings', 'price_per_night')) {
                $table->unsignedInteger('price_per_night')->default(0);
            }
            if (!Schema::hasColumn('bookings', 'total_price')) {
                $table->unsignedInteger('total_price')->default(0);
            }

            // status
            if (!Schema::hasColumn('bookings', 'status')) {
                $table->enum('status', ['pending','confirmed','cancelled'])->default('pending');
            }

            // timestamps kalau belum ada
            if (!Schema::hasColumn('bookings', 'created_at')) {
                $table->timestamps();
            }
        });

        // ====== ROOMS (jaga-jaga) ======
        Schema::table('rooms', function (Blueprint $table) {
            if (!Schema::hasColumn('rooms', 'price_per_night')) {
                $table->unsignedInteger('price_per_night')->default(200000);
            }
            if (!Schema::hasColumn('rooms', 'type')) {
                $table->enum('type',['Standard','Deluxe','Suite'])->default('Standard');
            }
            if (!Schema::hasColumn('rooms', 'capacity')) {
                $table->unsignedTinyInteger('capacity')->default(2);
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
        // Rollback hati-hati: hanya kolom yang kita tambah yang di-drop
        Schema::table('bookings', function (Blueprint $table) {
            foreach (['status','total_price','price_per_night','nights','check_out','check_in'] as $col) {
                if (Schema::hasColumn('bookings', $col)) $table->dropColumn($col);
            }
            // Jangan drop foreign keys/IDs di down() kalau tabel sudah terisi—amanin saja
        });

        Schema::table('rooms', function (Blueprint $table) {
            foreach (['photo_path','photo_url','status','price_per_night','capacity','type'] as $col) {
                if (Schema::hasColumn('rooms', $col)) $table->dropColumn($col);
            }
        });
    }
};
