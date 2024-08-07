<?php

namespace App\Http\Controllers\Admin\Laporan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Models\TransaksiDetail;
use App\Models\MasterBus;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use DataTables;
use Carbon\Carbon;
use Validator;

class LaporanController extends Controller
{
    /**
     * Return sap barang settings view
     */
    public function index()
    {
        $data["bus"] = MasterBus::get();
        return view('admin.transaksi.report', $data);
    }

    public function getDataLaporan(Request $req){
        try{
            $dataRet = TransaksiDetail::orderBy('created_at', 'asc');
           
            if ($req->tgl_awal && $req->tgl_akhir) {
                $dataRet->whereBetween('created_at', [Carbon::parse($req->tgl_awal)->startOfDay(), Carbon::parse($req->tgl_akhir)->endOfDay()]);
            } elseif ($req->tgl_awal) {
                $dataRet->where('created_at', '>=', Carbon::parse($req->tgl_awal)->startOfDay());
            } elseif ($req->tgl_akhir) {
                $dataRet->where('created_at', '<=', Carbon::parse($req->tgl_akhir)->endOfDay());
            }

            $data = $dataRet->with('bus')->with('parent')->get();
            return $this->sendResponse($data, "Berhasil mengambil data.");
        }catch(\Throwable $err){
            return $this->sendError("Data tidak dapat ditemukan.");
        }
    }

}
