<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class RiwayatSuratJalan extends Model
{
    use HasFactory, HasUuids;

    protected $keyType = 'uuid';
    public $incrementing = false;

    protected $fillable = [
        'id_surat_jalan',
        'tanggal',
        'keterangan',
        'sudah_dicetak',
    ];

    public function suratJalan()
    {
        return $this->belongsTo(SuratJalan::class, 'id_surat_jalan');
    }
}
