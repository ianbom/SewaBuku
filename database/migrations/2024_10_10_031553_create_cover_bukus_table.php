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
        Schema::create('cover_buku', function (Blueprint $table) {
            $table->id('id_cover_buku');
            $table->foreignId('id_buku')->constrained('buku', 'id_buku')->cascadeOnUpdate();
            $table->string('file_image');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cover_bukus');
    }
};
