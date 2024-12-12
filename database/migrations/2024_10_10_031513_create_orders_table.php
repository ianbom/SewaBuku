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
        Schema::create('order', function (Blueprint $table) {
            $table->id('id_order');
            $table->foreignId('id')->constrained('users', 'id')->cascadeOnUpdate();
            $table->foreignId('id_paket_langganan')->constrained('paket_langganan', 'id_paket_langganan')->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('nama_paket');
            $table->decimal('total_bayar', 15, 2);
            $table->integer('masa_waktu');
            $table->enum('status_order', ['Dibayar', 'Proses', 'Dibatalkan', 'Gagal']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
