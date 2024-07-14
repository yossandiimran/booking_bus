<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterSopir extends Model
{
    protected $table = 'master_sopir';

    protected $guarded = [];

    public function bus()
    {
        return $this->hasMany(MasterBus::class, 'id', 'id_sopir');
    }
    
}
