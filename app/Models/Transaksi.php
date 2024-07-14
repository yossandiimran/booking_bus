<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $table = 'transaksi';

    protected $guarded = [];

    public function customer()
    {
        return $this->hasOne(User::class, 'id', 'customer_id');
    }

    public function detail()
    {
        return $this->hasMany(TransaksiDetail::class, 'kode_booking', 'kode_booking');
    }
}
