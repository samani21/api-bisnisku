<?php

namespace App\Http\Controllers;

use App\Models\Fitur;
use App\Models\PaketFitur;
use App\Models\PaketLangganan;
use Illuminate\Http\Request;
use App\Services\UtilityService;

class PaketFiturController extends Controller
{
    protected $utilityService;

    public function __construct(UtilityService $utilityService)
    {
        $this->utilityService = $utilityService;
    }
    public function index(Request $request)
    {
        $query = PaketFitur::join('fiturs', 'fiturs.id', '=', 'paket_fiturs.fitur_id')
            ->join('paket_langganan', 'paket_langganan.id', '=', 'paket_fiturs.paket_id');
        // Search (misalnya by nama_paket)
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('nama_fitur', 'like', '%' . $search . '%');
        }

        // Filter (misalnya filter berdasarkan status aktif)
        if ($request->has('status')) {
            $query->where('fiturs.aktif', $request->input('status'));
        }

        // Pagination (default: 10 per page)
        $perPage = $request->input('per_page', 10);
        $data = $query->select(
            'paket_fiturs.*',
            'fiturs.aktif as status',
            'fiturs.nama_fitur',
            'fiturs.harga_satuan',
            'fiturs.aktif as status',
            'paket_langganan.nama_paket',
            'paket_langganan.harga as harga_paket',
            'paket_langganan.deskripsi',
        )->paginate($perPage);

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

    public function showSelect(Request $request)
    {
        $data = [];
        $langganan = PaketLangganan::select(
            'id as value',
            'nama_paket as label',
        )->get();
        if ($langganan) {
            $data['paket_langganan'] = $langganan;
        }
        $fitur = Fitur::select(
            'id as value',
            'nama_fitur as label',
        )->get();
        if ($fitur) {
            $data['fitur'] = $fitur;
        }
        return $this->utilityService->is200ResponseWithData("Data berhasil dihapus", $data);
    }


    public function create(Request $request)
    {
        $data = [
            'paket_id' => $request->paket_id,
            'fitur_id' => $request->fitur_id,
        ];

        $insert = PaketFitur::create($data);
        if ($insert) {
            return $this->utilityService->is201ResponseCreated("Berhasil simpan data", $insert);
        } else {
            return $this->utilityService->is500InternalServerError("Gagal simpan data");
        }
    }
    public function update(Request $request, $id)
    {
        $data = PaketFitur::find($id);
        $data->paket_id = $request->paket_id;
        $data->fitur_id = $request->fitur_id;
        if ($data->save()) {
            return $this->utilityService->is201ResponseUpdated("Update data berhasil");
        } else {
            return $this->utilityService->is500InternalServerError("Gagal update data");
        }
    }
    public function distroy($id)
    {
        $data = PaketFitur::find($id);
        if ($data->delete()) {
            return $this->utilityService->is200ResponseWith("Data berhasil dihapus");
        } else {
            return $this->utilityService->is500InternalServerError("Gagal hapus data");
        }
    }
}
