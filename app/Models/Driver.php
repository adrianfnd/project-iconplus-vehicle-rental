<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Driver extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'driver';

    protected $keyType = 'uuid';
    public $incrementing = false;

    protected $fillable = [
        'nama',
        'alamat',
        'kontak',
    ];
}
