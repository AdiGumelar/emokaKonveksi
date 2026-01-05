<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkOrder extends Model
{
    use HasFactory;
    protected $table = 'work_order';
    protected $fillable = [
        'pemesanan_id',
        'order_date',
        'expected_start_date',
        'expected_end_date',
        'jenis_kain',
        'warna_kain',
        'furing',
    ];

    public function pemesanan()
    {
        return $this->belongsTo(Pemesanan::class);
    }
}
