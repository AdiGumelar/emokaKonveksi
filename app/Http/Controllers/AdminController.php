<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use App\Models\Pemesanan;
use App\Models\Produk;
use App\Models\DetailPesanan;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\Http;


class AdminController extends Controller
{
    public function dashboard()
    {
    $jumlah_user = DB::table('users')->count();
    $jumlah_menunggu = DB::table('pemesanan')->where('status', 'Menunggu')->count();
    $jumlah_produksi = DB::table('pemesanan')->where('status', 'Produksi')->count();
    $jumlah_selesai = DB::table('pemesanan')->where('status', 'Selesai')->count();

    $pesan_list = DB::table('pesan')->orderBy('tanggal', 'desc')->get();

    return view('admin.dashboard', compact('jumlah_user', 'jumlah_menunggu', 'jumlah_produksi', 'jumlah_selesai', 'pesan_list'));
    }

        public function dataPemesanan()
    {
        $orders = Pemesanan::orderBy('tanggal')->get();
        return view('admin.data-pemesanan', compact('orders'));
    }

    public function orderDetails($id)
    {
        $order = Pemesanan::findOrFail($id);
        return response()->json(['order' => $order]);
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

    public function updateOrderStatus(Request $request, $id)
    {
        $order = Pemesanan::find($id);
        if ($order) {
            $order->status = $request->status;
            $order->save();
            // Siapkan nomor dan pesan WA
            $nomor = str_replace([' ', '+', '-'], '', $order->nomor);
            $nomor = preg_replace('/^0/', '62', $nomor); // ubah 08xxx jadi 62xxx
            $pesan = "Halo Kak {$order->nama},\n\n".
                        "Pesanan Anda dengan nomor invoice *{$order->id}* telah diperbarui menjadi:\n\n".
                        "📌 *".ucfirst($order->status)."*\n\n".
                        "Terima kasih telah mempercayakan pesanan Anda kepada kami.\n\n".
                        "Salam hangat,\nTim Emoka Konveksi";


            // Kirim WA
            $response = $this->kirimWhatsapp($nomor, $pesan);
            \Log::info('WA response:', $response); // Log ke storage/logs
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false]);
    }

    public function deleteOrder($id)
    {
        $order = Pemesanan::find($id);
        if ($order) {
            // Hapus file desain jika ada
            if (!empty($order->desain)) {
                $desainArray = json_decode($order->desain, true);
                if (is_array($desainArray)) {
                    foreach ($desainArray as $item) {
                        if (isset($item['file'])) {
                            $filePath = public_path($item['file']);
                            if (File::exists($filePath)) {
                                File::delete($filePath);
                            }
                        }
                    }
                }
            }

            if (!empty($order->fileUkuran)) {
                $filePath = public_path($order->fileUkuran);
                if (File::exists($filePath)) {
                    File::delete($filePath);
                }
            }

            $order->delete();
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false]);
    }

      public function getUkuran($id)
    {
        $ukuran = DetailPesanan::where('pesanan_id', $id)->get();
        $pemesanan = Pemesanan::findOrFail($id);

        // Tambahkan jenis_pakaian ke setiap item ukuran
        $ukuran->map(function ($item) use ($pemesanan) {
            $item->jenis_pakaian = $pemesanan->jenis_pakaian;
            return $item;
        });

        return response()->json(['ukuran' => $ukuran]);
    }

    public function simpanInvoice(Request $request)
    {
        $pesananId = $request->input('pesanan_id');
        $ukurans = $request->input('ukuran');
        $jumlahs = $request->input('jumlah');
        $hargas = $request->input('harga_satuan');


        foreach ($ukurans as $i => $ukuran) {
            // Cari data berdasarkan pesanan_id + ukuran
            $detail = DetailPesanan::where('pesanan_id', $pesananId)
                        ->where('ukuran', $ukuran);

            if ($detail) {
                // Update jika sudah ada
                $detail->update([
                    'jumlah' => $jumlahs[$i],
                    'harga_satuan'  => $hargas[$i] ?? 0,
                    'harga_total' => $jumlahs[$i] * $hargas[$i],
                ]);
            } 
        }

        return response()->json([
            'success' => true,
            'message' => 'Invoice berhasil disimpan.',
        ]);
    }

        public function produk()
    {
        $produk_list = Produk::orderBy('created_at', 'desc')->get();
        return view('admin.produk', compact('produk_list'));
    }

    public function tambahProduk(Request $request)
    {
        try {
            $request->validate([
                'nama' => 'required',
                'keterangan' => 'required',
                'foto' => 'required|image',
                'fotoCrop' => 'required|image',
            ]);

            $nama = Str::slug($request->nama); // untuk nama file yang aman

            // Tentukan folder tujuan
            $folder = public_path('produkEmoka');
            if (!File::exists($folder)) {
                File::makeDirectory($folder, 0755, true);
            }
        
            // Simpan foto asli
            $foto = $request->file('foto');
            $fotoName = $nama . '.' . $foto->getClientOriginalExtension();
            $foto->move($folder, $fotoName);
        
            // Simpan foto crop
            $fotoCrop = $request->file('fotoCrop');
            $fotoCropName = $nama . '-Crop.' . $fotoCrop->getClientOriginalExtension();
            $fotoCrop->move($folder, $fotoCropName);

            Produk::create([
                'nama' => $request->nama,
                'keterangan' => $request->keterangan,
                'foto' => $fotoName,
                'fotoCrop' => $fotoCropName,
            ]);

            return response()->json(['success' => true, 'message' => 'Produk berhasil ditambahkan.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function hapusProduk($id)
    {
        $produk = Produk::find($id);
        if (!$produk) {
            return response()->json(['success' => false, 'message' => 'Produk tidak ditemukan.']);
        }

        // Tentukan path folder
        $folder = public_path('produkEmoka');

        // Hapus file foto asli
        if ($produk->foto) {
            $fotoPath = $folder . '/' . $produk->foto;
            if (File::exists($fotoPath)) {
                File::delete($fotoPath);
            }
        }

        // Hapus file foto crop
        if ($produk->fotoCrop) {
            $fotoCropPath = $folder . '/' . $produk->fotoCrop;
            if (File::exists($fotoCropPath)) {
                File::delete($fotoCropPath);
            }
        }

        $produk->delete();

        return response()->json(['success' => true, 'message' => 'Produk berhasil dihapus.']);
    }

    public function WorkOrderUpdate(Request $request, Pemesanan $pemesanan)
    {
        $validated = $request->validate([
            'order_date' => 'required|date',
            'expected_start_date' => 'nullable|date',
            'expected_end_date' => 'nullable|date',
            'jenis_kain' => 'nullable|string',
            'warna_kain' => 'nullable|string',
            'furing' => 'nullable|string',
        ]);

        // Ubah string kosong menjadi null
        foreach (['order_date', 'expected_start_date', 'expected_end_date', 'jenis_kain', 'warna_kain', 'furing'] as $field) {
            if (empty($validated[$field])) {
                $validated[$field] = null;
            }
        }

        // Update  work order
        $pemesanan->workOrder->update($validated);

        return response()->json(['message' => 'Work order berhasil diperbarui.']);

    }

    public function cetakWorkOrder($id)
    {
        $pemesanan = Pemesanan::with(['workOrder', 'detail'])->findOrFail($id);

        $excelData = null;
        $mergeCells = [];

        $extension = pathinfo($pemesanan->fileUkuran, PATHINFO_EXTENSION);

        if (in_array(strtolower($extension), ['xls', 'xlsx'])) {
            $path = public_path($pemesanan->fileUkuran);

            if (file_exists($path)) {
                $spreadsheet = IOFactory::load($path);
                $worksheet = $spreadsheet->getActiveSheet();

                // Ambil semua data
                $excelDataRaw = $worksheet->toArray(null, true, true, true);

                // Cari baris pertama yang ada data
                $firstRowWithData = null;
                foreach ($excelDataRaw as $rowIdx => $row) {
                    if (array_filter($row)) {
                        $firstRowWithData = $rowIdx;
                        break;
                    }
                }

                // Potong array mulai baris pertama isi
                if ($firstRowWithData !== null) {
                    $excelData = array_slice(
                        $excelDataRaw,
                        array_search($firstRowWithData, array_keys($excelDataRaw)),
                        null,
                        true
                    );
                } else {
                    $excelData = [];
                }

                // Tetap ambil merge cells
                $mergeCells = $worksheet->getMergeCells();
            }

        }
        return view('admin.cetak_work_order', [
            'pemesanan' => $pemesanan,
            'workOrder' => $pemesanan->workOrder,
            'detail' => $pemesanan->detail,
            'excelData' => $excelData,
            'mergeCells' => $mergeCells,
        ]);
    }
}
