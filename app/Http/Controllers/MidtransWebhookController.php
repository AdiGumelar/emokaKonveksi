<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Midtrans;
use App\Models\Pemesanan;
use Illuminate\Support\Facades\Http;


class MidtransWebhookController extends Controller
{
    
    public function kirimWhatsapp($nomor, $pesan)
    {
        

        $response = Http::withOptions([
            'verify' => false // DISINI tempat yang benar
        ])->withHeaders([
            'Authorization' => 'NG1W0JdD3GQdwk0lqJ1mG2izqQbelMuLWM4SXBW0HnX0v7vV3c5ZU8b.r9B3gLtv'
        ])->post('https://bdg.wablas.com/api/v2/send-message', [
            'data' => [
            [
                'phone' => $nomor,
                'message' => $pesan,
                'secret' => false,
                'priority' => true
            ]
        ]
        ]);
        return $response->json();
    }

    public function handle(Request $request)
    {
        $payload = $request->all();

        $orderId = $payload['order_id'] ?? null;
        $status = $payload['transaction_status'] ?? null;

        // Temukan data midtrans berdasarkan order_id
        $midtrans = Midtrans::where('midtrans_order_id', $orderId)->first();

         if ($midtrans) {
            if ($status === 'expired') {
                // Hapus data midtrans
                $midtrans->delete();
            } else {
                // Update status midtrans
                $midtrans->midtrans_status = $status;
                $midtrans->save();

                // Jika status settlement, update tabel pemesanans
                if ($status === 'settlement') {
                    $pemesanan = Pemesanan::find($midtrans->pemesanan_id);
                    if ($pemesanan) {
                        $pemesanan->status = 'Sudah Bayar';
                        $pemesanan->save();

                         // Format nomor HP (pastikan 62)
                    $nomor = str_replace([' ', '+', '-'], '', $pemesanan->nomor);
                    $nomor = preg_replace('/^0/', '62', $nomor);

                    // Siapkan pesan WhatsApp
                    $pesan = "Halo Kak {$pemesanan->nama},\n\n".
                        "Pesanan Anda dengan nomor invoice *{$pemesanan->id}* telah diperbarui menjadi:\n\n".
                        "📌 *".ucfirst($pemesanan->status)."*\n\n".
                        "Terima kasih telah mempercayakan pesanan Anda kepada kami.\n\n".
                        "Salam hangat,\nTim Emoka Konveksi";


                    // Kirim WA
                    $this->kirimWhatsapp($nomor, $pesan);
                    }
                }
            }
        }

        return response()->json(['message' => 'OK'], 200);
    }
}
