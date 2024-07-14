<?php

namespace App\Http\Controllers\Admin\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\MasterTempat;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use DataTables;
use Validator;
use Illuminate\Support\Facades\Storage;

class MasterTempatController extends Controller
{
    /**
     * Return sap tempat settings view
     */
    public function index()
    {
        return view('admin.master.tempat.index');
    }

    /**
     * Return sap tempat data for datatables
     */
    public function scopeData(Request $req)
    {
        $data = MasterTempat::select('*');
        return DataTables::of($data)
                ->addIndexColumn()
                ->removeColumn('id')
                ->addColumn('foto', function($val) {
                    $url = asset('storage/' . $val->foto);
                    return '<img src="'.$url.'" width="100">';
                })
                ->addColumn('action', function($val) {
                    $key = encrypt("tempat".$val->id);
                    return '<div class="btn-group">'.
                                '<button class="btn btn-warning btn-sm btn-edit" data-key="'.$key.'" title="Ubah Data"><i class="fas fa-pen"></i></button>'.
                                '<button class="btn btn-danger btn-sm btn-delete" data-key="'.$key.'" title="Hapus Data"><i class="fas fa-trash-alt"></i></button>'.
                            '</div>';
                })
                ->rawColumns(['action', 'foto'])
                ->make(true);
    }

    /**
     * Return sap tempat settings detail
     */
    public function detail(Request $req)
    {
        try {
            $key = str_replace("tempat", "", decrypt($req->key));
            $data = MasterTempat::select('*')->whereId($key)->firstOrFail();
            return $this->sendResponse($data, "Berhasil mengambil data.");
        } catch (ModelNotFoundException $e) {
            return $this->sendError("Data tidak dapat ditemukan.");
        } catch (\Throwable $err) {
            return $this->sendError("Kesalahan sistem saat proses pengambilan data, silahkan hubungi admin.");
        }
    }


    /**
     * Store create or update sap tempat settings
     */
    public function store(Request $req)
    {
        $pwRules = 'nullable';

      
        $validator = Validator::make($req->input(), [
            'key' => 'nullable|string',
            'nama_tempat' => 'required|string',
            'keterangan' => 'required|string',
            // 'foto' => 'required|file',
        ]);

        if ($validator->fails()) {
            return $this->sendError("Error validation", $validator->errors());
        }

        if($req->file('foto')){
            $foto = $req->file('foto')->store('uploads', 'public');
        }

        try {
            if(empty($req->key)){
                // Create Data
                $data = MasterTempat::create([
                    'nama_tempat' => $req->nama_tempat,
                    'keterangan' => $req->keterangan,
                    'foto' => $foto
                ]);
                // Save Log
            } else {
                // Validation
                $key = str_replace("tempat", "", decrypt($req->key));
                $data = MasterTempat::findOrFail($key);

                // Cek Foto
                if(!$req->file('foto')){
                    $foto = $data->foto;
                }
                // Update Data
                $data->update([
                    'nama_tempat' => $req->nama_tempat,
                    'keterangan' => $req->keterangan,
                    'foto' => $foto
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
            $key = str_replace("tempat", "", decrypt($req->key));
            $data = MasterTempat::findOrFail($key);
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
