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
            $table->uuid('id_vendor')->nullable();
            $table->foreign('id_vendor')->references('id')->on('vendor')->onDelete('cascade');
            $table->uuid('id_penyewaan');
            $table->foreign('id_penyewaan')->references('id')->on('penyewaan');
            $table->string('link_pdf')->nullable();
            $table->date('tanggal_terbit')->nullable();
            $table->boolean('is_lebih_hari')->default(false);
            $table->integer('lebih_hari')->nullable();
            $table->decimal('jumlah_denda', 10, 2)->nullable();
            $table->text('bukti_biaya_bbm_tol_parkir')->nullable();
            $table->text('bukti_lainnya')->nullable();
            $table->string('status');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('surat_jalan');
    }
};