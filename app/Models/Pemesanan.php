<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemesanan extends Model
{
    use HasFactory;
    protected $table = 'pemesanan'; // ✅ WAJIB agar tidak pakai default pluralisasi
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'id','nama', 'email', 'nomor', 'alamat', 'deskripsi',
        'status', 'tanggal', 'username',
        'fileUkuran', 'desain', 'jenis_pakaian','jumlah_pakaian'
    ];

    public function detail()
    {
        return $this->hasMany(DetailPesanan::class, 'pesanan_id');
    }

    public function midtrans()
    {
        return $this->hasOne(Midtrans::class);
    }

    public function workOrder()
    {
        return $this->hasOne(WorkOrder::class);
    }
}
