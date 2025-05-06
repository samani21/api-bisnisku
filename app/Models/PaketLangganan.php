<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaketLangganan extends Model
{
    protected $table = 'paket_langganan';

    protected $fillable = [
        'nama_paket',
        'harga',
        'durasi_hari',
        'deskripsi',
        'aktif'
    ];
}
