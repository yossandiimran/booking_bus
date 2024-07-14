<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MasterBus;
use App\Models\MasterSopir;
use App\Models\MasterTempat;
use App\Models\User;
use Validator;

class HelperController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function getSelectsopir(Request $req){
        $validator = Validator::make($req->input(), [
            'search' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return $this->sendError("Error validation", $validator->errors());
        }

        try {
            $query = MasterSopir::whereNotNull("id");
            if(!empty($req->search)){
                $search = $req->search;
                $query->where(function($q)use($search){
                    $q->where('nama','LIKE',"%$search%")->orWhere('kontak','LIKE',"%$search%");
                });
            }
            $data = $query->orderBy("nama")->limit(250)->get();
            return $this->sendResponse($data, "Berhasil mendapatkan data.");
        } catch (\Throwable $err) {
            return $this->sendError("Kesalahan sistem saat proses pengambilan data, silahkan hubungi admin");
        }
    }

}
