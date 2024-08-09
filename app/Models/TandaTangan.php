<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class TandaTangan extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'tanda_tangan';

    protected $keyType = 'uuid';
    public $incrementing = false;

    protected $fillable = [
        'ttd_name',
        'image_url',
    ];

    public function penyewaan()
    {
        return $this->hasMany(Penyewaan::class);
    }
}