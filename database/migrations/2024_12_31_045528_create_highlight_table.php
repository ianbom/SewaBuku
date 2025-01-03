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
        Schema::create('highlight', function (Blueprint $table) {
            $table->id('id_highlight');
            $table->foreignId('id')->constrained('users', 'id')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('id_buku')->nullable()->constrained('buku', 'id_buku')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('id_detail_buku')->nullable()->constrained('detail_buku', 'id_detail_buku')->cascadeOnUpdate()->cascadeOnDelete();
            $table->text('highlight');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('highlight');
    }
};
