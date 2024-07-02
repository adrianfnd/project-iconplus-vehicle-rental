<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('penyewaan', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('id_kendaraan');
            $table->foreign('id_kendaraan')->references('id')->on('kendaraan')->onDelete('cascade');
            $table->uuid('id_vendor');
            $table->foreign('id_vendor')->references('id')->on('vendor')->onDelete('cascade');
            $table->uuid('id_driver');
            $table->foreign('id_driver')->references('id')->on('vendor')->onDelete('cascade');
            $table->string('nama_penyewa');
            $table->string('kontak_penyewa');
            $table->integer('jumlah_hari_sewa');
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->integer('kilometer_awal');
            $table->integer('kilometer_akhir');
            $table->decimal('nilai_sewa', 10, 2);
            $table->decimal('biaya_bbm_tol_parkir', 10, 2);
            $table->decimal('biaya_driver', 10, 2);
            $table->decimal('total_biaya', 10, 2);
            $table->string('nomor_io');
            $table->text('keterangan');
            $table->date('tanggal_pembayaran');
            $table->string('status');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('penyewaan');
    }
};