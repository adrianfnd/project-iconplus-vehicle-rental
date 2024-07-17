<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('riwayat_surat_jalan', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('id_vendor')->nullable();
            $table->foreign('id_vendor')->references('id')->on('vendor')->onDelete('cascade');
            $table->uuid('id_surat_jalan');
            $table->foreign('id_surat_jalan')->references('id')->on('surat_jalan')->onDelete('cascade');
            $table->boolean('sudah_dicetak')->default(false);
            $table->date('start_period')->nullable();
            $table->date('end_period')->nullable(); 
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('riwayat_surat_jalan');
    }
};
