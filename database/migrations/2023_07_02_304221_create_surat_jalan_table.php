<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('surat_jalan', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('id_penyewaan');
            $table->foreign('id_penyewaan')->references('id')->on('penyewaan');
            $table->string('link_pdf')->nullable();
            $table->date('tanggal_terbit')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('surat_jalan');
    }
};