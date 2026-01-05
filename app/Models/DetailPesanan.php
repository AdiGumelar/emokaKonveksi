<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPesanan extends Model
{
    use HasFactory;
    protected $table = 'detail_pesanan'; // ✅ WAJIB agar tidak pakai default pluralisasi
    protected $fillable = ['pesanan_id', 'ukuran', 'lengan','jumlah', 'harga_satuan', 'harga_total'];


    public function pesanan()
    {
        return $this->belongsTo(Pemesanan::class, 'pesanan_id');
    }

}
