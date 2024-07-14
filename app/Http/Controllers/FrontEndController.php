<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\MasterBus;
use App\Models\MasterTempat;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use DataTables;
use Validator;

class FrontEndController extends Controller
{
    /**
     * Return sap bus settings view
     */
    public function index()
    {
        $data['bus'] = MasterBus::get();
        $data['type_bus'] = MasterBus::distinct()->pluck('type_bus');
        $data['tempat'] = MasterTempat::get();
        return view('frontend.index', $data);
    }

    public function prosesFormFe(Request $req){
        $data['type_bus'] = MasterBus::distinct()->pluck('type_bus');
        $data['bus'] = MasterBus::where('type_bus', $req->bus)
        ->where('jumlah_kursi', '>=', $req->jumlahSeat)
        ->where(function ($query) use ($req) {
            $query->whereDate('status', '<', $req->tgl_berangkat)
                  ->orWhereNull('status');
        })
        ->get();
        $data['tempat'] = MasterTempat::get();
        $data['formData'] = $req->all();
        return view('frontend.cekbus', $data);

    }

}
