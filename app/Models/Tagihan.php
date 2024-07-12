<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Tagihan extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'tagihan';

    protected $keyType = 'uuid';
    public $incrementing = false;

    protected $fillable = [
        'id_vendor',
        'id_penyewaan',
        'link_pdf',
        'tanggal_terbit',
        'tanggal_jatuh_tempo',
        'total_tagihan',
        'link_pembayaran',
        'status',
        'reject_notes',
    ];

    public function penyewaan()
    {
        return $this->belongsTo(Penyewaan::class, 'id_penyewaan');
    }
}
