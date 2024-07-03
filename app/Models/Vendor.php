<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Vendor extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'vendor';

    protected $keyType = 'uuid';
    public $incrementing = false;

    protected $fillable = [
        'nama',
        'alamat',
        'kontak',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
