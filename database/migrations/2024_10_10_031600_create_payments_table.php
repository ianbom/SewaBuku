<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payment', function (Blueprint $table) {
            $table->id('id_payment');
            $table->foreignId('id_order')->constrained('order', 'id_order')->cascadeOnUpdate();
            $table->decimal('total_bayar', 15, 2);
            $table->string('metode_pembayaran')->nullable();
            $table->string('id_transaksi')->nullable(); //buat payment gateway
            $table->enum('status_pembayaran', ['Dibayar', 'Proses', 'Dibatalkan', 'Gagal']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment');
    }
};
