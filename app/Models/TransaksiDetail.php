<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiDetail extends Model
{
    protected $table = 'transaksi_detail';

    protected $guarded = [];

    public function parent()
    {
        return $this->hasOne(Transaksi::class, 'kode_booking', 'kode_booking');
    }
}
