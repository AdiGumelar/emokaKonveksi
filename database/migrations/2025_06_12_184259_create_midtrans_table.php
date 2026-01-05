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
        Schema::create('midtrans', function (Blueprint $table) {
            $table->id();
            $table->string('pemesanan_id')->unique(); // One-to-One
            $table->string('midtrans_order_id');
            $table->string('midtrans_token');
            $table->string('midtrans_status')->nullable(); // pending / settlement / etc
            $table->timestamps();
            $table->foreign('pemesanan_id')
                  ->references('id')->on('pemesanan')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('midtrans');
    }
};
