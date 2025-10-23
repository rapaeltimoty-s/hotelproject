<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained()->cascadeOnDelete();
            $table->string('order_id')->unique();                 // unik per transaksi
            $table->string('gateway')->default('midtrans');       // midtrans/xendit/stripe/mock
            $table->string('method')->nullable();                 // qris/va/cc/e-wallet
            $table->unsignedInteger('amount');                    // grand_total
            $table->string('currency',10)->default('IDR');
            $table->enum('status',['pending','success','failed','expired','refunded'])->default('pending');
            $table->string('provider_transaction_id')->nullable();// transaction_id dari provider
            $table->string('signature')->nullable();              // signature verifikasi
            $table->json('raw_payload')->nullable();              // simpan payload callback
            $table->dateTime('expires_at')->nullable();
            $table->dateTime('paid_at')->nullable();
            $table->unsignedInteger('refunded_amount')->default(0);
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('payments');
    }
};
