<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('hotels', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('city')->index();
            $table->unsignedTinyInteger('stars')->default(3);
            $table->string('address')->nullable();
            $table->text('description')->nullable();
            $table->string('cover_url')->nullable();   // URL manual
            $table->string('cover_path')->nullable();  // file upload (public)
            $table->json('gallery')->nullable();       // array paths
            $table->unsignedInteger('base_price')->default(200000);
            $table->json('features')->nullable();      // ["WiFi","Kolam","Sarapan"]
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('hotels'); }
};
