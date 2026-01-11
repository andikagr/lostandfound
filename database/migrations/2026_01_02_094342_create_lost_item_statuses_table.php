<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('lost_item_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('nama_status');
            $table->timestamps();
        });

        // Insert data default agar ID 1 tersedia
        DB::table('lost_item_statuses')->insert([
            ['id' => 1, 'nama_status' => 'Dilaporkan', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'nama_status' => 'Ditemukan', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'nama_status' => 'Selesai', 'created_at' => now(), 'updated_at' => now()],
        ]);

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lost_item_statuses');
    }
};
