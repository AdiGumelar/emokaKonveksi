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

        // Jika sudah ada token dan masih pending, gunakan ulang
        $midtrans = $pemesanan->midtrans;
        if ($midtrans && $midtrans->midtrans_status === 'pending') {
            return response()->json(['token' => $midtrans->midtrans_token]);
        }

        $total = DetailPesanan::where('pesanan_id', $id)->sum(\DB::raw('jumlah * harga_satuan'));


        $orderId =  $id. '-' . now()->format('His');

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

        \Midtrans\Config::$curlOptions[CURLOPT_SSL_VERIFYPEER] = false;
        
        \Midtrans\Config::$serverKey = config('services.midtrans.server_key');
        \Midtrans\Config::$clientKey = config('services.midtrans.client_key');
        \Midtrans\Config::$isProduction = config('services.midtrans.is_production', false);
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;
        
        
       $snapToken = \Midtrans\Snap::getSnapToken($params);

        Midtrans::updateOrCreate(
            ['pemesanan_id' => $pemesanan->id],
            [
                'midtrans_order_id' => $orderId,
                'midtrans_token' => $snapToken,
                'midtrans_status' => 'pending',
            ]
        );

        return response()->json(['token' => $snapToken]);
    }
}
   

