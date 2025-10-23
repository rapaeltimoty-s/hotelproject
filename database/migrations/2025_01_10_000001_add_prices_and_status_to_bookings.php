<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('bookings', function (Blueprint $table) {
            if (!Schema::hasColumn('bookings','subtotal'))      $table->unsignedInteger('subtotal')->default(0);
            if (!Schema::hasColumn('bookings','tax'))           $table->unsignedInteger('tax')->default(0);
            if (!Schema::hasColumn('bookings','discount'))      $table->unsignedInteger('discount')->default(0);
            if (!Schema::hasColumn('bookings','grand_total'))   $table->unsignedInteger('grand_total')->default(0);
            if (!Schema::hasColumn('bookings','payment_status'))$table->enum('payment_status',['pending','paid','failed','expired','refunded'])->default('pending');
            if (!Schema::hasColumn('bookings','payment_deadline')) $table->dateTime('payment_deadline')->nullable();
            if (!Schema::hasColumn('bookings','paid_at'))       $table->dateTime('paid_at')->nullable();
            // booking.status kamu sudah ada (pending/confirmed/cancelled); ini diselaraskan via webhook
        });
    }
    public function down(): void {
        Schema::table('bookings', function (Blueprint $table) {
            foreach (['subtotal','tax','discount','grand_total','payment_status','payment_deadline','paid_at'] as $c) {
                if (Schema::hasColumn('bookings',$c)) $table->dropColumn($c);
            }
        });
    }
};
