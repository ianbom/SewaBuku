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
        Schema::create('jawaban', function (Blueprint $table) {
            $table->id('id_jawaban');
            $table->foreignId('id_quiz')->constrained('quiz', 'id_quiz')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('id_soal')->constrained('soal', 'id_soal')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('id_opsi')->constrained('opsi', 'id_opsi')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('id')->constrained('users', 'id')->cascadeOnDelete()->cascadeOnUpdate();
            $table->boolean('is_correct')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jawaban');
    }
};
