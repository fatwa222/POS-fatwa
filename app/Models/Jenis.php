<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Jenis extends Model
{
    use HasFactory;

    protected $table = 'jenis';

    protected $fillable = [
        'nama',
        'user_id',
    ];

    public function produk()
    {
        return $this->hasMany(Produk::class, 'jenis_id');
    }
}