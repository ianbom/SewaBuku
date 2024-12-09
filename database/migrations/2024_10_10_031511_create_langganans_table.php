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
        Schema::create('langganan', function (Blueprint $table) {
            $table->id('id_langganan');
            $table->foreignId('id')->constrained('users', 'id')->cascadeOnUpdate();
            $table->foreignId('id_buku')->constrained('buku', 'id_buku')->cascadeOnUpdate();
            $table->boolean('status_langganan')->default(false);
            $table->date('mulai_langganan');
            $table->date('akhir_langganan');
            $table->timestamps();
        });
    } 

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('langganans');
    }
};
