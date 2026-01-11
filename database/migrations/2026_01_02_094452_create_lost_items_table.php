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
    Schema::create('lost_items', function (Blueprint $table) {
        $table->id();
        // GUNAKAN INI agar tipe datanya otomatis Unsigned Big Integer (sama dengan id user)
        $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); 
        
        $table->string('nama_barang');
        $table->string('kategori');
        $table->string('lokasi_terakhir');
        
        // Pastikan status_id juga foreignId jika terhubung ke tabel status
        $table->foreignId('status_id')->constrained('lost_item_statuses'); // Sesuaikan nama tabel status kamu
        
        $table->date('tanggal_hilang');
        $table->text('deskripsi');
        $table->string('kontak');
        $table->string('image')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lost_items');
    }
};
