<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tanda_tangan_vendor', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('id_vendor')->nullable();
            $table->foreign('id_vendor')->references('id')->on('vendor')->onDelete('cascade');
            $table->string('ttd_name');
            $table->string('image_url');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tanda_tangan_vendor');
    }
};