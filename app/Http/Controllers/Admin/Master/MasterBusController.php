<?php

namespace App\Http\Controllers\Admin\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\MasterBus;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use DataTables;
use Validator;

class MasterBusController extends Controller
{
    /**
     * Return sap bus settings view
     */
    public function index()
    {
        return view('admin.master.bus.index');
    }

    /**
     * Return sap bus data for datatables
     */
    public function scopeData(Request $req)
    {
        $data = MasterBus::select('*')->with('sopir');
        return DataTables::of($data)
                ->addIndexColumn()
                ->removeColumn('id')
                ->addColumn('foto', function($val) {
                    $url = asset('storage/' . $val->foto);
                    return '<img src="'.$url.'" width="100">';
                })
                ->addColumn('sopir', function($val) {
                    return $val->sopir->nama;
                })
                ->addColumn('status', function($val) {
                    if($val->status == null){
                        return '<button class="btn btn-success btn-sm " title="Tersedia"><i class="fas fa-check"></i> Tersedia</button>';
                    }else{
                        return '<button class="btn btn-warning btn-sm " title="Disewa"><i class="fas fa-bus"></i> Disewa</button>';
                    }
                })
                ->addColumn('action', function($val) {
                    $key = encrypt("bus".$val->id);
                    return '<div class="btn-group">'.
                                '<button class="btn btn-warning btn-sm btn-edit" data-key="'.$key.'" title="Ubah Data"><i class="fas fa-pen"></i></button>'.
                                '<button class="btn btn-danger btn-sm btn-delete" data-key="'.$key.'" title="Hapus Data"><i class="fas fa-trash-alt"></i></button>'.
                            '</div>';
                })
                ->rawColumns(['action', 'foto', 'status'])
                ->make(true);
    }

    /**
     * Return sap bus settings detail
     */
    public function detail(Request $req)
    {
        try {
            $key = str_replace("bus", "", decrypt($req->key));
            $data = MasterBus::select('*')->whereId($key)->with('sopir')->firstOrFail();
            return $this->sendResponse($data, "Berhasil mengambil data.");
        } catch (ModelNotFoundException $e) {
            return $this->sendError("Data tidak dapat ditemukan.");
        } catch (\Throwable $err) {
            return $this->sendError("Kesalahan sistem saat proses pengambilan data, silahkan hubungi admin.");
        }
    }


    /**
     * Store create or update sap bus settings
     */
    public function store(Request $req)
    {
        $pwRules = 'nullable';
      
        $validator = Validator::make($req->input(), [
            'key' => 'nullable|string',
            'bus' => 'required|string',
            'nopol' => 'required|string',
            'jumlah_kursi' => 'required|integer',
            'tarif' => 'required|integer',
            'type_bus' => 'required|string',
            'keterangan' => 'required|string',
            'id_sopir' => 'required|string',
        ]);

        if($req->file('foto')){
            $foto = $req->file('foto')->store('uploads', 'public');
        }

        if ($validator->fails()) {
            return $this->sendError("Error validation", $validator->errors());
        }

        try {
            if(empty($req->key)){
                // Create Data
                $data = MasterBus::create([
                    'bus' => $req->bus,
                    'nopol' => $req->nopol,
                    'jumlah_kursi' => $req->jumlah_kursi,
                    'tarif' => $req->tarif,
                    'type_bus' => $req->type_bus,
                    'keterangan' => $req->keterangan,
                    'id_sopir' => $req->id_sopir,
                    'foto' => $foto,
                ]);
                // Save Log
            } else {
                // Validation
                $key = str_replace("bus", "", decrypt($req->key));
                $data = MasterBus::findOrFail($key);

                if(!$req->file('foto')){
                    $foto = $data->foto;
                }
                // Update Data
                $data->update([
                    'bus' => $req->bus,
                    'nopol' => $req->nopol,
                    'jumlah_kursi' => $req->jumlah_kursi,
                    'tarif' => $req->tarif,
                    'type_bus' => $req->type_bus,
                    'keterangan' => $req->keterangan,
                    'id_sopir' => $req->id_sopir,
                    'foto' => $foto,
                ]);
            }
            return $this->sendResponse(null, "Berhasil memproses data.");
        } catch (ModelNotFoundException $e) {
            return $this->sendError("Data tidak dapat ditemukan.");
        } catch (\Throwable $err) {
            return $this->sendError("Kesalahan sistem saat proses penyimpanan data, silahkan hubungi admin");
        }
    }

    public function destroy(Request $req)
    {
        try {
            // Validation
            $key = str_replace("bus", "", decrypt($req->key));
            $data = MasterBus::findOrFail($key);
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
