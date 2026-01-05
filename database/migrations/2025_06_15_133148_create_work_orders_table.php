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
        Schema::create('work_order', function (Blueprint $table) {
            $table->id();
            $table->string('pemesanan_id');
            $table->foreign('pemesanan_id')->references('id')->on('pemesanan')->onDelete('cascade');
            $table->date('order_date');
            $table->date('expected_start_date')->nullable();
            $table->date('expected_end_date')->nullable();
            $table->string('jenis_kain')->nullable();
            $table->string('warna_kain')->nullable();
            $table->string('furing')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_order');
    }
};
