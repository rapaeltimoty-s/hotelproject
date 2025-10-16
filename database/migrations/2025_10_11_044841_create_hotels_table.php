<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('hotels', function (Blueprint $t) {
            $t->id();
            $t->string('name');
            $t->string('city')->index();
            $t->string('address');
            $t->text('description')->nullable();
            $t->tinyInteger('stars')->nullable();   // 1..5
            $t->text('amenities')->nullable();      // "WiFi, Sarapan, Parkir"
            $t->string('photo')->nullable();        // path foto cover
            $t->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('hotels'); }
};
