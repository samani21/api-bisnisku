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
        $query = PaketLangganan::query();

        // Search (misalnya by nama_paket)
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('nama_paket', 'like', '%' . $search . '%');
        }

        // Filter (misalnya filter berdasarkan status aktif)
        if ($request->has('status')) {
            $query->where('aktif', $request->input('status'));
        }

        // Pagination (default: 10 per page)
        $perPage = $request->input('per_page', 10);
        $data = $query->select('*', 'aktif as status')->paginate($perPage);

        if ($data->isNotEmpty()) {
            return $this->utilityService->is200ResponseWithData("Berhasil ambil data", [
                'items' => $data->items(),
                'current_page' => $data->currentPage(),
                'total_pages' => $data->lastPage(),
                'total_items' => $data->total(),
                'per_page' => $data->perPage()
            ]);
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
