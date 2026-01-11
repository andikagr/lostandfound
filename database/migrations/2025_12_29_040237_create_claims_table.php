<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('claims', function (Blueprint $table) {
            $table->id();
            $table->foreignId('found_item_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('lost_item_id')->nullable()->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('user_id')->index();
            $table->string('nama_pemilik');
            $table->string('kontak_pemilik');
            $table->string('lokasi_terakhir');
            $table->string('bukti');
            $table->string('status')->default('pending');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('claims');
    }
};
