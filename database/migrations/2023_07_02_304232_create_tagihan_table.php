<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tagihan', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('id_penyewaan');
            $table->foreign('id_penyewaan')->references('id')->on('penyewaan');
            $table->date('tanggal_terbit');
            $table->date('tanggal_jatuh_tempo');
            $table->decimal('total_tagihan', 10, 2);
            $table->string('status');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tagihan');
    }
};