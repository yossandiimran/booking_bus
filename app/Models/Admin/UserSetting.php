<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class UserSetting extends Model
{
    protected $table = 'user_setting';

    protected $fillable = ['server_id','user_id','app_id','permission_id','device_token','delete_token'];

    protected $hidden = ['id','created_at','updated_at'];

    protected $casts = [
        'device_token' => 'json',
    ];

    /**
     * Get the user that owns the setting
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the app that owns the setting
     */
    public function app()
    {
        return $this->belongsTo(MasterApp::class, 'app_id');
    }

    /**
     * Get the permission that owns the setting
     */
    public function permission()
    {
        return $this->belongsTo(MasterAppPermission::class, 'permission_id');
    }

    /**
     * Get the server that owns the setting
     */
    public function server()
    {
        return $this->belongsTo(SettingServer::class, 'server_id');
    }

    /**
     * Mutator for update device tokens
     */
    public function setDeviceTokenAttribute($value){
        $list = json_decode($this->attributes['device_token']);
        if($list){
            if(!in_array($value,$list)){
                if(count($list) >= 3){
                    $list = array_slice($list, -2);
                }
                array_push($list, $value);
                $this->attributes['device_token'] = json_encode($list);
            }
        } else {
            $list = [$value];
            $this->attributes['device_token'] = json_encode($list);
        }
    }
    public function setDeleteTokenAttribute($value){
        $list = json_decode($this->attributes['device_token']);
        if($list){
            if (($key = array_search($value, $list)) !== false) {
                array_splice($list, $key, 1);
                $this->attributes['device_token'] = json_encode($list);
            }
        }
    }
}