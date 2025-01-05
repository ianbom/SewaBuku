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
        Schema::create('buku_tags', function (Blueprint $table) {
            $table->id('id_buku_tags');
            $table->foreignId('id_buku')->constrained('buku', 'id_buku')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('id_tags')->constrained('tags', 'id_tags')->cascadeOnUpdate()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('buku_tags');
    }
};
