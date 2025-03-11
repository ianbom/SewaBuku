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
        Schema::table('payment', function (Blueprint $table) {
            $table->string('fraud_status')->nullable();
            $table->dateTime('payment_date')->nullable();
            $table->string('snap_token')->nullable();
            $table->string('id_payment_gateway')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payment', function (Blueprint $table) {
            $table->dropColumn(['fraud_status', 'payment_date', 'snap_token', 'id_payment_gateway']);
        });
    }
};
