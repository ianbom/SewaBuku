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
            Schema::create('soal', function (Blueprint $table) {
                $table->id('id_soal');
                $table->foreignId('id_quiz')->constrained('quiz', 'id_quiz')->cascadeOnDelete()->cascadeOnUpdate();
                $table->string('soal');
                $table->string('image')->nullable();
                $table->timestamps();
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('soal');
    }
};
