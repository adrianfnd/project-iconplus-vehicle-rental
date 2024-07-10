<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class SuratJalan extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'surat_jalan';

    protected $keyType = 'uuid';
    public $incrementing = false;

    protected $fillable = [
        'id_penyewaan',
        'tanggal_terbit',
        'link_pdf',
        'status'
    ];

    public function penyewaan()
    {
        return $this->belongsTo(Penyewaan::class, 'id_penyewaan');
    }
}
