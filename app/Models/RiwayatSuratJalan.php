<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class RiwayatSuratJalan extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'riwayat_surat_jalan';

    protected $keyType = 'uuid';
    public $incrementing = false;

    protected $fillable = [
        'id_vendor',
        'id_surat_jalan',
        'sudah_dicetak',
        'start_period',
        'end_period',
    ];

    public function suratJalan()
    {
        return $this->belongsTo(SuratJalan::class, 'id_surat_jalan');
    }
}
