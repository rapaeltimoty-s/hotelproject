<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('bookings', function (Blueprint $t) {
            $t->id();
            $t->foreignId('user_id')->constrained()->cascadeOnDelete();
            $t->foreignId('room_id')->constrained()->cascadeOnDelete();
            $t->date('check_in');
            $t->date('check_out');
            $t->unsignedInteger('nights');
            $t->decimal('total_price', 10, 2);
            $t->enum('status', ['pending','confirmed','cancelled'])->default('pending');
            $t->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('bookings'); }
};
