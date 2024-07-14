<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class SettingServer extends Model
{
    protected $table = 'setting_sap';

    protected $fillable = ['app','urlsap','ashost','sysnr','client','usap','psap'];

    /**
     * Mutator for hidden password
     */
    public function getHdpwAttribute($value)
    {
        return generatePassword($value);
    }

    /**
     * Mutator for name text
     */
    public function getNameTextAttribute($value)
    {
        return $this->app." - ".$this->usap." ( ".$this->urlsap." )";
    }
}