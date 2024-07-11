<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('id_vendor')->nullable();
            $table->foreign('id_vendor')->references('id')->on('vendor')->onDelete('cascade');
            $table->uuid('id_tagihan');
            $table->foreign('id_tagihan')->references('id')->on('tagihan');
            $table->decimal('jumlah', 10, 2);
            $table->date('tanggal_pembayaran');
            $table->string('metode_pembayaran');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pembayaran');
    }
};