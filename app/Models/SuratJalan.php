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
        'id_vendor',
        'id_penyewaan',
        'link_pdf',
        'tanggal_terbit',
        'is_lebih_hari',
        'lebih_hari',
        'jumlah_denda',
        'bukti_biaya_bbm_tol_parkir',
        'bukti_lainnya',
        'status'
    ];

    public function penyewaan()
    {
        return $this->belongsTo(Penyewaan::class, 'id_penyewaan');
    }
}
