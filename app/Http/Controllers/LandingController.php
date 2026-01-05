<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Pesan;
use App\Models\Pemesanan;
use App\Models\User;
use Illuminate\Support\Facades\Session;

class LandingController extends Controller
{
    public function home()
    {
        $produk_list = Produk::orderBy('created_at', 'asc')->get();

        // Hitung pesanan selesai
        $totalPesananSelesai = Pemesanan::where('status', 'selesai')->count();

        // Hitung total pelanggan
        $totalPelanggan = User::count();

        return view('landingPage', [
            'produk_list' => $produk_list,
            'totalPesananSelesai' => $totalPesananSelesai,
            'totalPelanggan' => $totalPelanggan,
        ]);
    }


    public function kirimPesan(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'subject' => 'required',
            'message' => 'required',
        ]);

        Pesan::create([
            'nama' => $request->name,
            'email' => $request->email,
            'subjek' => $request->subject,
            'pesan' => $request->message,
            'tanggal' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Pesan berhasil dikirim.'
        ]);
    }
}

