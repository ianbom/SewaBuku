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
        Schema::create('opsi', function (Blueprint $table) {
            $table->id('id_opsi');
            $table->foreignId('id_soal')->constrained('soal', 'id_soal')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('opsi');
            $table->string('image')->nullable();
            $table->boolean('is_correct')->default(false);;
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('opsi');
    }
};
