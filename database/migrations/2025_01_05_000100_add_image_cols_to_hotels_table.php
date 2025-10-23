<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('hotels', function (Blueprint $table) {
            // Tambahkan kolom jika belum ada. Jangan “after cover_url” karena bisa belum ada
            if (!Schema::hasColumn('hotels', 'cover_url')) {
                $table->string('cover_url')->nullable();
            }
            if (!Schema::hasColumn('hotels', 'cover_path')) {
                $table->string('cover_path')->nullable();
            }
            if (!Schema::hasColumn('hotels', 'gallery')) {
                $table->json('gallery')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('hotels', function (Blueprint $table) {
            if (Schema::hasColumn('hotels', 'gallery')) {
                $table->dropColumn('gallery');
            }
            if (Schema::hasColumn('hotels', 'cover_path')) {
                $table->dropColumn('cover_path');
            }
            if (Schema::hasColumn('hotels', 'cover_url')) {
                $table->dropColumn('cover_url');
            }
        });
    }
};
