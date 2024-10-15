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
            Schema::create('buku', function (Blueprint $table) {
                $table->id('id_buku');
                $table->string('judul_buku');
                $table->string('penulis');
                $table->string('penerbit');
                $table->string('jumlah_halaman');
                $table->string('isbn');
                $table->string('tahun_terbit');
                $table->decimal('harga', 15, 2);
                $table->string('teaser_audio'); //mp3
                $table->text('sinopsis');
                $table->text('ringkasan_audio');
                $table->timestamps();
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bukus');
    }
};
