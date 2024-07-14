<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'alamat',
        'kode_pos',
        'no_hp',
        'provinsi',
        'kelurahan',
        'kecamatan',
        'kota',
        'username',
        'nrp',
        'p_site',
        'plant',
        'group_user',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Mutator for group user text
     */
    public function getGroupTextAttribute($value)
    {
        $group = [1 => "Admin", 2 => "Kepala Pabrik", 3 => "Management", 4 => "Public User", 5 => "Function"];
        return $group[$value] ?? "Belum memiliki hak akses";
    }

    /**
     * Mutator for name text
     */
    public function getNameTextAttribute($value)
    {
        return $this->name." - ".$this->username;
    }
}
