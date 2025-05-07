<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PaketLangganan;
use App\Services\UtilityService;

class PaketLanggananController extends Controller
{
    protected $utilityService;

    public function __construct(UtilityService $utilityService)
    {
        $this->utilityService = $utilityService;
    }

    public function index(Request $request)
    {
        $data = PaketLangganan::select('*', 'aktif as status')->get();
        if ($data) {
            return $this->utilityService->is200ResponseWithData("Berhasil simpan data", $data);
        } else {
            return $this->utilityService->is500InternalServerError("Data tidak ditemukan");
        }
    }

    public function create(Request $request)
    {
        $data = [
            'nama_paket' => $request->nama_paket,
            'harga' => $request->harga,
            'durasi_hari' => $request->durasi_hari,
            'deskripsi' => $request->deskripsi,
        ];

        $insert = PaketLangganan::create($data);
        if ($insert) {
            return $this->utilityService->is201ResponseCreated("Berhasil simpan data", $insert);
        } else {
            return $this->utilityService->is500InternalServerError("Gagal simpan data");
        }
    }
    public function update(Request $request, $id)
    {
        $data = PaketLangganan::find($id);
        $data->nama_paket = $request->nama_paket;
        $data->harga = $request->harga;
        $data->durasi_hari = $request->durasi_hari;
        $data->deskripsi = $request->deskripsi;
        if ($data->save()) {
            return $this->utilityService->is201ResponseUpdated("Update data berhasil");
        } else {
            return $this->utilityService->is500InternalServerError("Gagal update data");
        }
    }
    public function distroy($id)
    {
        $data = PaketLangganan::find($id);
        if ($data->delete()) {
            return $this->utilityService->is200ResponseWith("Data berhasil dihapus");
        } else {
            return $this->utilityService->is500InternalServerError("Gagal hapus data");
        }
    }
}
