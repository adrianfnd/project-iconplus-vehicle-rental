<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Penyewaan extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'penyewaan';

    protected $keyType = 'uuid';
    public $incrementing = false;

    protected $fillable = [
        'id_kendaraan',
        'id_jabatan',
        'id_vendor',
        'id_driver',
        'include_driver',
        'nama_penyewa',
        'kontak_penyewa',
        'sewa_untuk',
        'jumlah_hari_sewa',
        'tanggal_mulai',
        'tanggal_selesai',
        'is_outside_bandung',
        'kilometer_awal',
        'kilometer_akhir',
        'nilai_sewa',
        'biaya_bbm',
        'biaya_tol',
        'biaya_parkir',
        'biaya_driver',
        'total_biaya',
        'nomor_io',
        'keterangan',
        'tanggal_pembayaran',
        'status',
        'reject_notes',
    ];

    public function kendaraan()
    {
        return $this->belongsTo(Kendaraan::class, 'id_kendaraan');
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'id_vendor');
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class, 'id_driver');
    }

    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class, 'id_jabatan');
    }
}
