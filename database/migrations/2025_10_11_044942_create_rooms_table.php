<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('rooms', function (Blueprint $t) {
            $t->id();
            $t->foreignId('hotel_id')->constrained()->cascadeOnDelete();
            $t->string('name');
            $t->enum('type', ['Standard','Deluxe','Suite']);
            $t->unsignedInteger('capacity')->default(1);
            $t->decimal('price_per_night', 10, 2);
            $t->string('status')->default('available');
            $t->string('photo')->nullable();
            $t->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('rooms'); }
};
