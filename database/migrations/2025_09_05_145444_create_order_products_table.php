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
        Schema::create('order_products', function (Blueprint $table) {
            $table->id();
            $table->string('nama_produk');
            $table->string('nama_customer')->nullable();
            $table->string('ukuran');
            $table->date('waktu_mulai');
            $table->date('waktu_tenggat');
            $table->date('waktu_selesai')->nullable();
            $table->string('deskripsi')->nullable();
            $table->integer('progress')->default(0);
            $table->integer('biaya_pembuatan')->default(0);
            $table->string('desain')->nullable();
            $table->string('gambar_proses')->nullable();
            $table->boolean('selesai')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_products');
    }
};
