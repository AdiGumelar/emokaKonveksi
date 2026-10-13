<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Midtrans;
use App\Models\Pemesanan;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MidtransWebhookController extends Controller
{
    public function kirimWhatsapp($nomor, $pesan)
    {
        try {
            $response = Http::timeout(10)->withOptions([
                'verify' => false
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
        } catch (\Exception $e) {
            Log::warning("Gagal mengirim WhatsApp notifikasi: " . $e->getMessage());
            return null;
        }
    }

    public function handle(Request $request)
    {
        $payload = $request->all();

        $orderId = $payload['order_id'] ?? null;
        $statusCode = $payload['status_code'] ?? null;
        $grossAmount = $payload['gross_amount'] ?? null;
        $signatureKey = $payload['signature_key'] ?? null;
        $status = $payload['transaction_status'] ?? null;
        $fraudStatus = $payload['fraud_status'] ?? 'accept';

        // 1. Verifikasi Signature Key Midtrans (Keamanan)
        $serverKey = config('services.midtrans.server_key');
        if ($orderId && $statusCode && $grossAmount && $signatureKey && $serverKey) {
            $calculatedSignature = hash('sha512', $orderId . $statusCode . $grossAmount . $serverKey);
            if ($calculatedSignature !== $signatureKey) {
                Log::warning("Midtrans Webhook: Signature Key tidak valid untuk order_id {$orderId}");
                return response()->json(['message' => 'Invalid signature key'], 403);
            }
        }

        // 2. Temukan data Midtrans berdasarkan midtrans_order_id
        $midtrans = Midtrans::where('midtrans_order_id', $orderId)->first();

        if ($midtrans) {
            // Update status transaksi di tabel midtrans
            $midtrans->midtrans_status = $status;
            $midtrans->save();

            // Pengecekan apakah pembayaran berhasil
            $isPaid = false;
            if ($status === 'settlement') {
                $isPaid = true;
            } elseif ($status === 'capture' && $fraudStatus === 'accept') {
                $isPaid = true;
            }

            if ($isPaid) {
                $pemesanan = Pemesanan::find($midtrans->pemesanan_id);
                if ($pemesanan && $pemesanan->status !== 'Sudah Bayar') {
                    $pemesanan->status = 'Sudah Bayar';
                    $pemesanan->save();

                    // Format nomor HP (pastikan diawali 62)
                    $nomor = str_replace([' ', '+', '-'], '', $pemesanan->nomor);
                    $nomor = preg_replace('/^0/', '62', $nomor);

                    // Siapkan pesan WhatsApp konfirmasi pembayaran
                    $pesan = "Halo Kak {$pemesanan->nama},\n\n".
                        "Pembayaran untuk pesanan dengan nomor invoice *{$pemesanan->id}* telah *BERHASIL DIVERIFIKASI*.\n\n".
                        "📌 Status Pesanan: *Sudah Bayar (Siap Produksi)*\n".
                        "💰 Total Tagihan: Rp " . number_format((float)$grossAmount, 0, ',', '.') . "\n\n".
                        "Pesanan Anda akan segera diteruskan ke bagian produksi Emoka Konveksi.\n".
                        "Terima kasih telah bertransaksi bersama kami.\n\n".
                        "Salam hangat,\nTim Emoka Konveksi";

                    // Kirim notifikasi WA (aman dalam try-catch)
                    $this->kirimWhatsapp($nomor, $pesan);
                }
            }
        }

        return response()->json(['message' => 'OK'], 200);
    }
}
