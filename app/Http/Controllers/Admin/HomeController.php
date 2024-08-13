<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MasterBus;
use App\Models\MasterSopir;
use App\Models\MasterTempat;
use App\Models\Transaksi;
use App\Models\TransaksiDetail;

class HomeController extends Controller
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
    public function index()
    {
        $data["trx"] = Transaksi::get();
        $data["laba"] = TransaksiDetail::sum('tarif');
        $data["bus_ready"] = count(MasterBus::where('status', null)->get());
        $data["bus_disewa"] = count(MasterBus::whereNotNull('status')->get());
        $data["trx_count"] = count(Transaksi::get());
        $data["sopir_count"] = count(MasterSopir::get());
        
        $busNames = [];
        $busCounts = [];
        $dataBusFavorite = TransaksiDetail::selectRaw('COUNT(id_bus) as cnt, id_bus')->groupBy('id_bus')->with('bus')->get();

        foreach ($dataBusFavorite as $favorite) {
            $busNames[] = $favorite->bus->bus; 
            $busCounts[] = $favorite->cnt;
        }
        
        $data['busNames'] = $busNames;
        $data['busCounts'] = $busCounts;


        return view('home', $data);
    }
}
