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
        Schema::create('pemesanan', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('nama');
            $table->string('email');
            $table->string('nomor');
            $table->text('alamat');
            $table->text('deskripsi');
            $table->string('fileUkuran');
            $table->string('jenis_pakaian');
            $table->json('desain')->nullable(); // ← ini tambahan penting
            $table->string('status')->default('Menunggu');
            $table->string('username');
            $table->timestamp('tanggal')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemesanan');
    }
};
