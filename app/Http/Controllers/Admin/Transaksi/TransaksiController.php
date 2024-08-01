<?php

namespace App\Http\Controllers\Admin\Transaksi;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Models\TransaksiDetail;
use App\Models\MasterBus;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use DataTables;
use Validator;

class TransaksiController extends Controller
{
    /**
     * Return sap barang settings view
     */
    public function index()
    {
        $data["bus"] = MasterBus::get();
        return view('admin.transaksi.index', $data);
    }

    /**
     * Return sap barang data for datatables
     */
    public function scopeData(Request $req)
    {
        $data = Transaksi::select('*');
        return DataTables::of($data)
                ->addIndexColumn()
                ->removeColumn('id')
                ->addColumn('status_booking', function($val) {
                    if($val->status_booking == "1"){
                        return 'New';
                    }else if($val->status == "2"){
                        return 'Proses';
                    }else if($val->status =="3"){
                        return 'Batal';
                    }else if($val->status =="4"){
                        return 'Selesai';
                    }
                })
                ->addColumn('action', function($val) {
                    $key = encrypt("transaksi".$val->id);
                    return '<div class="btn-group">'.
                                '<button class="btn btn-success btn-sm btn-acc" data-key="'.$key.'" title="Terima"><i class="fas fa-check"></i></button>'.
                                '<button class="btn btn-warning btn-sm btn-cancel" data-key="'.$key.'" title="Batalkan"><i class="fas fa-ban"></i></button>'.
                                '<button class="btn btn-primary btn-sm btn-info" data-key="'.$key.'" title="Detail"><i class="fas fa-info"></i></button>'.
                                '<button class="btn btn-danger btn-sm btn-delete" data-key="'.$key.'" title="Hapus"><i class="fas fa-trash-alt"></i></button>'.
                            '</div>';
                })
                ->rawColumns(['action', 'status_booking'])
                ->make(true);
    }


    public function scopeList(Request $req){
        
        $data = Masterbarang::select('*');
        return DataTables::of($data)
            ->addIndexColumn()
            ->removeColumn('id')
            ->addColumn('gudang', function($val) {
                return $val->gudang->nama_gudang;
            })
            ->addColumn('supplier', function($val) {
                return $val->supplier->nama_supplier;
            })
            ->addColumn('action', function($val) {
                $key = encrypt("barang".$val->id);
                return '<div class="d-flex justify-content-center">
                                    <input class="form-check-input mt-0" type="checkbox" data-key="'.$key.'" value="'.$key.'" aria-label="Checkbox for following text input">
                                </div>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    /**
     * Return sap barang settings detail
     */
    public function detail(Request $req)
    {
        try {
            $key = str_replace("barang", "", decrypt($req->key));
            $data = Masterbarang::select('*')->whereId($key)->with('supplier')->with('gudang')->firstOrFail();
            return $this->sendResponse($data, "Berhasil mengambil data.");
        } catch (ModelNotFoundException $e) {
            return $this->sendError("Data tidak dapat ditemukan.");
        } catch (\Throwable $err) {
            return $this->sendError("Kesalahan sistem saat proses pengambilan data, silahkan hubungi admin.");
        }
    }


    /**
     * Store create or update sap barang settings
     */
    public function store(Request $req)
    {
        $pwRules = 'nullable';
      
        $validator = Validator::make($req->input(), [
            'key' => 'nullable|string',
            'nama_barang' => 'required|string',
            'kode_barang' => 'required|string',
            'id_supplier' => 'required|string',
            'id_gudang' => 'required|string',
            'stok' => 'required|string',
            'harga' => 'required|string',
            'satuan' => 'required|string',
            'keterangan' => 'required|string',
        ]);

        if ($validator->fails()) {
            return $this->sendError("Error validation", $validator->errors());
        }

        // try {
            if(empty($req->key)){
                // Create Data
                $data = Masterbarang::create([
                    'nama_barang' => $req->nama_barang,
                    'kode_barang' => $req->kode_barang,
                    'id_supplier' => $req->id_supplier,
                    'id_gudang' => $req->id_gudang,
                    'stok' => $req->stok,
                    'harga' => $req->harga,
                    'satuan' => $req->satuan,
                    'keterangan' => $req->keterangan,
                ]);
                // Save Log
            } else {
                // Validation
                $key = str_replace("barang", "", decrypt($req->key));
                $data = Masterbarang::findOrFail($key);
                // Update Data
                $data->update([
                    'nama_barang' => $req->nama_barang,
                    'kode_barang' => $req->kode_barang,
                    'id_supplier' => $req->id_supplier,
                    'id_gudang' => $req->id_gudang,
                    'stok' => $req->stok,
                    'harga' => $req->harga,
                    'satuan' => $req->satuan,
                    'keterangan' => $req->keterangan,
                ]);
            }
            return $this->sendResponse(null, "Berhasil memproses data.");
        // } catch (ModelNotFoundException $e) {
        //     return $this->sendError("Data tidak dapat ditemukan.");
        // } catch (\Throwable $err) {
        //     return $this->sendError("Kesalahan sistem saat proses penyimpanan data, silahkan hubungi admin");
        // }
    }

    /**
     * Delete sap barang data from db
     */
    public function destroy(Request $req)
    {
        try {
            // Validation
            $key = str_replace("barang", "", decrypt($req->key));
            $data = Masterbarang::findOrFail($key);
            // Delete Process
            $data->delete();
            return $this->sendResponse(null, "Berhasil menghapus data.");
        } catch (ModelNotFoundException $e) {
            return $this->sendError("Data tidak dapat ditemukan.");
        } catch (\Throwable $err) {
            return $this->sendError("Kesalahan sistem saat proses penghapusan data, silahkan hubungi admin");
        }
    }

}
