<?php

namespace App\Http\Controllers\Admin\Laporan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Models\TransaksiDetail;
use App\Models\MasterBus;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use DataTables;
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

}
