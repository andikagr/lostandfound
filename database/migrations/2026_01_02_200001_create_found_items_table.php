<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('found_items', function (Blueprint $table) {
            $table->id();
            $table->string('nama_barang');
            $table->string('kategori');
            $table->string('lokasi');
            $table->date('tanggal_ditemukan');
            $table->time('waktu_ditemukan');
            $table->string('lokasi_penemuan');
            $table->text('kronologi')->nullable();
            $table->string('nama_penemu');
            $table->string('kontak_penemu');
            $table->string('alamat_penemu');
            $table->string('kontak');
            $table->text('deskripsi');
            $table->string('image')->nullable();
            $table->timestamps();
        });


    }

    public function down(): void
    {
        Schema::dropIfExists('found_items');
    }
};