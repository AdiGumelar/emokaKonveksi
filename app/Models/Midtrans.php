<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Midtrans extends Model
{
    use HasFactory;

    protected $fillable = [
        'pemesanan_id',
        'midtrans_order_id',
        'midtrans_token',
        'midtrans_status',
    ];

    public function pemesanan()
    {
        return $this->belongsTo(Pemesanan::class);
    }
}
