<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Penjualan extends Model
{

    use HasFactory;

    protected $table = 'penjualan';

    protected $fillable = [
        'user_id',
        'total_pembayaran',
        'metode_pembayaran',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


    public function itemPenjualan()
    {
        return $this->hasMany(ItemPenjualan::class);
    }

    public function produk()
{
    return $this->belongsTo(Produk::class);
}

public function penjualan()
{
    return $this->belongsTo(Penjualan::class);
}

}
