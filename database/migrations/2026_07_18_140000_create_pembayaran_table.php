<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->id('id_pembayaran');
            $table->unsignedBigInteger('id_reservasi');
            $table->decimal('jumlah_bayar', 10, 2);
            $table->string('metode_bayar', 50)->nullable();
            $table->string('bukti_transfer')->nullable();
            $table->enum('status_bayar', ['menunggu', 'valid', 'ditolak'])->default('menunggu');
            $table->timestamp('tanggal_bayar')->useCurrent();

            $table->foreign('id_reservasi')->references('id_reservasi')->on('reservasi')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pembayaran');
    }
};