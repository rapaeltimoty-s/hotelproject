<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hotel_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->enum('type',['Standard','Deluxe','Suite'])->default('Standard');
            $table->unsignedTinyInteger('capacity')->default(2);
            $table->unsignedInteger('price_per_night')->default(200000);
            $table->enum('status',['available','unavailable'])->default('available');
            $table->string('photo_url')->nullable();
            $table->string('photo_path')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('rooms'); }
};
