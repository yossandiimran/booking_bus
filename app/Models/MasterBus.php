<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterBus extends Model
{
    protected $table = 'master_bus';

    protected $guarded = [];

    public function sopir()
    {
        return $this->hasOne(MasterSopir::class, 'id', 'id_sopir');
    }

    public function transaksi()
    {
        return $this->hasMany(Transaksi::class, 'id_bus', 'id');
    }
    
}
