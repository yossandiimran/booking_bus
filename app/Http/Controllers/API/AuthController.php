<?php

namespace App\Http\Controllers\API;

use Auth;
use Validator;
use Exception;
use Http;
use App\Models\User;
use App\Models\Admin\SettingServer;
use App\Models\Admin\UserSetting;
use App\Models\Admin\PermissionAccess;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    /**
     * Login user.
     */
    public function login(Request $req)
    {
        $validator = Validator::make($req->input(), [
            'username' => 'required|string',
            'password' => 'required|string',
            'aplikasi' => 'required|string',
        ]);

        if ($validator->fails()) {
            return $this->sendError("Error validation", $validator->errors());
        }

        try {
            $app = DB::table('master_app')->where('code', $req->aplikasi)->first();
            if(!$app) return $this->sendError('Aplikasi tidak ditemukan.');

            if (!Auth::attempt($req->only('username', 'password')))
            {
                return $this->sendError('Unauthorized.', ['error'=>'Username atau Password salah.'], 401);
            }
    
            $user = Auth::user();
            $setting = UserSetting::where('user_id', $user->id)->where('app_id', $app->id)->first();
            if(!$setting) return $this->sendError('Anda tidak memiliki akses pada aplikasi ini.');
            // Delete Tokens > 3
            $jenisToken = $app->code."-token";
            $last2Tokens = $user->tokens()->where('name', $jenisToken)->limit(env("MAX_USER",3))->latest()->pluck('id')->toArray();
            $user->tokens()->where('name', $jenisToken)->whereNotIn('id',$last2Tokens)->delete();
            // Create New Token
            $res['access_token'] =  $user->createToken($jenisToken, [$setting->permission->code.'-access'])->plainTextToken;
            if($req->device_token){
                $setting->update(["device_token" => $req->device_token]);
            }
            // Set response
            $_user = User::selectRaw("id, name, email, username, COALESCE(nrp,'') as nrp, COALESCE(p_site,'') as p_site, COALESCE(plant,'') as plant")->find($user->id);
            $_user["hak_akses"] = $setting->permission->code;
            $_user["permission"] = PermissionAccess::join('master_app_menu as am','permission_access.menu_id','am.id')->where('permission_id', $setting->permission->id)->pluck('am.menu')->toArray();
            $_user["setting"] = SettingServer::select("urlsap","ashost","sysnr","client","usap","psap")->find($setting->server_id);
            $res['user'] = $_user;
    
            return $this->sendResponse($res, 'User berhasil login.');
        } catch (\Throwable $err) {
            $this->errLog("API login user", $err->getMessage());
            return $this->sendError('Kesalahan sistem saat proses login, silahkan hubungi admin.');
        }
    }

    /**
     * Logout user.
     */
    public function logout(Request $req)
    {
        try {
            $user = Auth::user()->currentAccessToken();
            if($req->device_token){
                $app = DB::table('master_app')->where('code', str_replace("-token", "", $user->name))->first();
                if($app){
                    $setting = UserSetting::where('user_id', $user->tokenable_id)->where('app_id', $app->id)->first();
                    if($setting)
                        $setting->update(["delete_token" => $req->device_token]);
                }
            }
            $user->delete();
            return $this->sendResponse([], 'User berhasil logout.');
        } catch (\Throwable $err) {
            $this->errLog("API logout user", $err->getMessage());
            return $this->sendError('Kesalahan sistem saat proses logout, silahkan hubungi admin.');
        }
    }

    /**
     * Logout bapi sap without auth user.
     */
    public function logoutBapi(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'user_id' => 'required|integer|min:1',
            'app_name' => 'required|string',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Invalid parameter.', $validator->messages());
        }

        try {
            // Get app access
            $user = User::find($req->user_id);
            if(!$user) throw new Exception("User tidak ditemukan.", 200);
            $appName = $req->app_name;
            $setting = UserSetting::select('user_setting.*')->join('master_app as map','user_setting.app_id','map.id')->where('user_setting.user_id', $user->id)->where('map.code', $appName)->first();
            if(!$setting) throw new Exception("Anda tidak memiliki akses pada aplikasi ini.", 200);
            
            $url = $setting->server->urlsap."unregdes";
            $url = str_replace("202.138.230.51","192.168.1.118", $url);
            $param = [
                "USERID"    => $user->id,
            ];
            
            $response = Http::acceptJson();
            if($req->type == 'get'){
                $response = Http::get($url, $param);
            } else {
                $response = Http::get($url, $param);
            }
            $response->throw();
    
            return json_decode($response->body());
        } catch (\Throwable $err) {
            if($err->getCode() == 200){
                return $this->sendError($err->getMessage());
            } else {
                $this->errLog("API Logout BAPI", $err->getMessage());
                return $this->sendError('Error koneksi SAP.');
            }
        }
    }
}
