<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use App\Models\Pemesanan;
use App\Models\DetailPesanan;
use Midtrans\Snap;
use Midtrans\Transaction;
use Illuminate\Support\Facades\Log;
use App\Models\Midtrans;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;


class PemesananController extends Controller
{
    public function showForm()
    {
        return view('form-pemesanan');
    }

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

    public function buatPesanan(Request $request)
    {
        $request->validate([
            'nama' => 'required|string',
            'email' => 'required|email',
            'nomor' => 'required|numeric',
            'alamat' => 'required|string',
            'deskripsi' => 'required|string',
            'fileUkuran' => 'required|file|mimes:pdf,xlsx,xls,csv',
        ]);

        $username = Auth::user()->username; // atau dari session jika belum pakai Auth

        $data = $request->only(['nama', 'email', 'nomor', 'alamat', 'deskripsi', 'jenis_pakaian', 'lengan']);
        $data['status'] = 'Menunggu';
        $data['tanggal'] = now();
        $data['username'] = $username;

        // Upload file
        $nama = strtolower(trim($request->nama)); // kecilkan dan trim spasi
        $nama = preg_replace('/\s+/', '_', $nama); // spasi → underscore
        $nama = preg_replace('/[^a-z0-9_]/', '', $nama); // hapus karakter aneh

        if ($request->hasFile('fileUkuran')) {
            $extension = $request->file('fileUkuran')->getClientOriginalExtension();
            $counter = 0;

            do {
                $suffix = $counter > 0 ? $counter : '';
                $filename = "{$nama}{$suffix}_fileUkuran.{$extension}";
                $path = public_path("desain/{$filename}");
                $counter++;
            } while (File::exists($path));

            $request->file('fileUkuran')->move(public_path('desain'), $filename);
            $data['fileUkuran'] = 'desain/' . $filename;
        }

        $daftarDesain = [];

        if ($request->has('designs')) {
            foreach ($request->designs as $design) {
                if (isset($design['file']) && $design['file'] instanceof \Illuminate\Http\UploadedFile) {
                    $originalName = $design['file']->getClientOriginalName();
                    $extension = $design['file']->getClientOriginalExtension();
                    $counter = 0;

                    do {
                        $suffix = $counter > 0 ? $counter : '';
                        $filename = "{$nama}{$suffix}_" . preg_replace('/\s+/', '_', $design['name']) . ".{$extension}";
                        $path = public_path("desain/{$filename}");
                        $counter++;
                    } while (File::exists($path));

                    $design['file']->move(public_path('desain'), $filename);

                    $daftarDesain[] = [
                        'nama' => $design['name'],
                        'file' => 'desain/' . $filename,
                    ];
                }
            }
        }

        // Simpan daftar desain sebagai JSON
        $data['desain'] = json_encode($daftarDesain);

        //Unik Random ID 
        $data['id'] = 'ORD-' . strtoupper(Str::random(7)). '-' . now()->format('Ymd') ;

        $pemesanan = Pemesanan::create($data);

        $ukuranList = json_decode($request->input('ukuran_json'), true);

        if (!empty($ukuranList)) {
            foreach ($ukuranList as $item) {
                DetailPesanan::create([
                    'pesanan_id' => $pemesanan->id,
                    'ukuran' => $item['ukuran'],
                    'lengan' => $item['lengan'],
                    'jumlah' => $item['jumlah'],
                    'harga_satuan' => 0, // sembarang harga dulu
                    'harga_total' => 0, // sembarang harga dulu
                ]);
            }
        }else {
            DetailPesanan::create([
                    'pesanan_id' => $pemesanan->id,
                    'ukuran' => "-",
                    'lengan' => "-",
                    'jumlah' => $request->jumlah_pakaian,
                    'harga_satuan' => 0, // sembarang harga dulu
                    'harga_total' => 0, // sembarang harga dulu
                ]);
        }
        
        $pemesanan->workOrder()->create([
            'order_date' => now(),
            'expected_start_date' => null,
            'expected_end_date' => null,
            'jenis_kain' => null,
            'warna_kain' => null,
            'furing' => null,
        ]);

        $nomor = str_replace([' ', '+', '-'], '', $request->nomor);
        $nomor = preg_replace('/^0/', '62', $nomor); // ubah 08xxx jadi 62xxx
        $pesan = "Halo $request->nama,\n"
            . "Pesanan Anda telah diterima ✅\n\n"
            . "📦 Deskripsi: $request->deskripsi\n"
            . "📍 Alamat: $request->alamat\n"
            . "📆 " . now()->format('d-m-Y H:i') . "\n\n"
            . "Kami akan segera memprosesnya. Terima kasih 🙏";

        $this->kirimWhatsapp($nomor, $pesan);

        return response()->json(['success' => true, 'message' => 'Pesanan berhasil disimpan!']);
    }

    public function trackingPesanan()
    {
        $username = Auth::user()->username;
        $orders = Pemesanan::with('detail')
                ->where('username', $username)
                ->whereNotIn('status', ['Selesai', 'Dibatalkan'])
                ->orderBy('created_at', 'asc')
                ->get();

        return view('trackingPesanan', compact('orders'));
    }

    public function batalkanPesanan($id)
    {
        $pemesanan = Pemesanan::where('id', $id)
            ->where('username', Auth::user()->username)
            ->where('status', 'Belum Bayar')
            ->firstOrFail();

        $pemesanan->status = 'Dibatalkan';
        $pemesanan->save();

        return redirect()->back()->with('success', 'Pesanan berhasil dibatalkan.');
    }


      public function invoice($id)
    {
        $order = Pemesanan::findOrFail($id);
        $details = DetailPesanan::where('pesanan_id', $id)->get();
        $midtrans = Midtrans::where('pemesanan_id', $id)->first();       
        return view('admin.invoice', compact('order', 'details', 'midtrans'));
    }

    
        public function getPaymentToken($id)
    {
        $pemesanan = Pemesanan::findOrFail($id);

        // 1. Otorisasi: Pastikan user yang login adalah pemilik pesanan atau admin
        $username = Auth::user() ? Auth::user()->username : null;
        if ($pemesanan->username !== $username && !session('admin')) {
            return response()->json(['error' => 'Anda tidak memiliki akses ke pesanan ini.'], 403);
        }

        // 2. Validasi status pesanan: hanya 'Belum Bayar' yang dapat dibayar
        if ($pemesanan->status !== 'Belum Bayar') {
            return response()->json(['error' => 'Status pesanan saat ini tidak memerlukan pembayaran: ' . $pemesanan->status], 400);
        }

        // 3. Hitung total tagihan dari rincian detail pesanan
        $total = (int) DetailPesanan::where('pesanan_id', $id)->sum(DB::raw('jumlah * harga_satuan'));

        if ($total <= 0) {
            return response()->json(['error' => 'Total tagihan belum ditentukan oleh admin atau bernilai 0.'], 400);
        }

        // 4. Cek apakah sudah ada token yang masih berstatus pending untuk pesanan ini
        $midtrans = $pemesanan->midtrans;
        if ($midtrans && $midtrans->midtrans_status === 'pending' && !empty($midtrans->midtrans_token)) {
            return response()->json(['token' => $midtrans->midtrans_token]);
        }

        $orderId = $id . '-' . now()->format('His');

        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => $total,
            ],
            'customer_details' => [
                'first_name' => $pemesanan->nama,
                'email' => $pemesanan->email,
                'phone' => $pemesanan->nomor,
            ]
        ];

        try {
            \Midtrans\Config::$curlOptions[CURLOPT_SSL_VERIFYPEER] = false;
            \Midtrans\Config::$serverKey = config('services.midtrans.server_key');
            \Midtrans\Config::$clientKey = config('services.midtrans.client_key');
            \Midtrans\Config::$isProduction = config('services.midtrans.is_production', false);
            \Midtrans\Config::$isSanitized = true;
            \Midtrans\Config::$is3ds = true;

            $snapToken = Snap::getSnapToken($params);

            Midtrans::updateOrCreate(
                ['pemesanan_id' => $pemesanan->id],
                [
                    'midtrans_order_id' => $orderId,
                    'midtrans_token' => $snapToken,
                    'midtrans_status' => 'pending',
                ]
            );

            return response()->json(['token' => $snapToken]);
        } catch (\Exception $e) {
            Log::error("Midtrans Snap Error untuk {$id}: " . $e->getMessage());
            return response()->json(['error' => 'Gagal memproses pembayaran ke Midtrans: ' . $e->getMessage()], 500);
        }
    }

    public function syncPaymentStatus($id)
    {
        $pemesanan = Pemesanan::findOrFail($id);

        // Otorisasi
        $username = Auth::user() ? Auth::user()->username : null;
        if ($pemesanan->username !== $username && !session('admin')) {
            return response()->json(['error' => 'Akses ditolak.'], 403);
        }

        $midtrans = $pemesanan->midtrans;
        if (!$midtrans || empty($midtrans->midtrans_order_id)) {
            return response()->json(['status' => $pemesanan->status]);
        }

        try {
            \Midtrans\Config::$curlOptions[CURLOPT_SSL_VERIFYPEER] = false;
            \Midtrans\Config::$serverKey = config('services.midtrans.server_key');
            \Midtrans\Config::$isProduction = config('services.midtrans.is_production', false);

            $statusResponse = Transaction::status($midtrans->midtrans_order_id);
            $transactionStatus = is_object($statusResponse) ? $statusResponse->transaction_status : ($statusResponse['transaction_status'] ?? null);
            $fraudStatus = is_object($statusResponse) ? ($statusResponse->fraud_status ?? 'accept') : ($statusResponse['fraud_status'] ?? 'accept');

            $midtrans->midtrans_status = $transactionStatus;
            $midtrans->save();

            $isPaid = false;
            if ($transactionStatus === 'settlement') {
                $isPaid = true;
            } elseif ($transactionStatus === 'capture' && $fraudStatus === 'accept') {
                $isPaid = true;
            }

            if ($isPaid && $pemesanan->status !== 'Sudah Bayar') {
                $pemesanan->status = 'Sudah Bayar';
                $pemesanan->save();

                // Format nomor HP dan kirim WA
                $nomor = str_replace([' ', '+', '-'], '', $pemesanan->nomor);
                $nomor = preg_replace('/^0/', '62', $nomor);

                $pesan = "Halo Kak {$pemesanan->nama},\n\n".
                    "Pembayaran untuk pesanan dengan nomor invoice *{$pemesanan->id}* telah *BERHASIL DIVERIFIKASI*.\n\n".
                    "📌 Status Pesanan: *Sudah Bayar (Siap Produksi)*\n\n".
                    "Pesanan Anda akan segera diteruskan ke bagian produksi Emoka Konveksi.\n".
                    "Terima kasih telah bertransaksi bersama kami.\n\n".
                    "Salam hangat,\nTim Emoka Konveksi";

                try {
                    $this->kirimWhatsapp($nomor, $pesan);
                } catch (\Exception $e) {
                    Log::warning("Gagal kirim WA sync: " . $e->getMessage());
                }
            }

            return response()->json([
                'success' => true,
                'status' => $pemesanan->status,
                'midtrans_status' => $transactionStatus,
                'is_paid' => $isPaid,
            ]);
        } catch (\Exception $e) {
            Log::warning("Midtrans Sync Error untuk {$id}: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'status' => $pemesanan->status,
                'message' => $e->getMessage(),
            ]);
        }
    }
}
   

