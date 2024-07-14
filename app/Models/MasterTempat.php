<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterTempat extends Model
{
    protected $table = 'master_tempat';

    protected $guarded = [];

    public function destinasi()
    {
        return $this->hasMany(Transaksi::class, 'id', 'id_tempat');
    }
}
