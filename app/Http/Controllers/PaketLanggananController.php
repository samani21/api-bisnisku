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
        $data = PaketLangganan::get();
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
}
