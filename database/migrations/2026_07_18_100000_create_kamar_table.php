<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kamar', function (Blueprint $table) {
            $table->id('id_kamar');
            $table->string('nomor_kamar', 10)->unique();
            $table->string('tipe_kamar', 50);
            $table->decimal('harga_per_malam', 10, 2);
            $table->text('fasilitas')->nullable();
            $table->string('foto')->nullable();
            $table->enum('status', ['tersedia', 'perbaikan', 'nonaktif'])->default('tersedia');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kamar');
    }
};