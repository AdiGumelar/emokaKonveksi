<!DOCTYPE html>
<html>
  <head>
    <title>Cetak Work Order</title>
    <link href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="{{ asset('/img/logo2.png') }}" rel="icon" />
    <link href="{{ asset('/img/apple-touch-icon.png') }}" rel="apple-touch-icon" />
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
      rel="stylesheet"
    />
    <style>
      body {
        font-family: 'Poppins', sans-serif;
        margin: 0;
        padding: 0;
      }
      .invoice-box {
        width: 800px;
        margin: auto;
        padding: 30px;
        border: 1px solid #ccc;
      }

      h3 {
        text-align: center;
        margin: 0;
      }
      .text-right {
        text-align: right;
      }
      table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
      }
      th,
      td {
        border: 1px solid #ccc;
        padding: 5px;
        text-align: center;
      }
      .no-border {
        border: none;
      }
      .mt-2 {
        margin-top: 8px;
      }
      .mt-4 {
        margin-top: 20px;
      }
    </style>
  </head>
  <body onload="">
    <div class="invoice-box">
      <div class="row justify-content-between align-items-start">
        <div class="col kiri mt-4">
          <p style="font-weight: 600" class="p-0 m-0">EMOKA KONVEKSI</p>
          <p style="font-size: 12px">
            Jl. Sungkur, Klaten Tengah, Klaten, Jawa Tengah 57415
            <br />
            0882-0034-41009
            <br />
            emoka.konveksi@gmail.com
            <br />
            <a href="http://emokakonveksi.unaux.com/">http://emokakonveksi.unaux.com/</a>
          </p>
        </div>
        <div class="col-auto">
          <img src="{{ asset('img/logo.png') }}" alt="Logo" style="height: 150px" />
        </div>
      </div>

      <table>
        <tr>
          <td class="bg-secondary text-white" style="white-space: nowrap">Client Name</td>
          <td colspan="2">{{ $pemesanan->nama }}</td>
          <td class="bg-secondary text-white" style="white-space: nowrap">Order Number</td>
          <td colspan="2">100</td>
        </tr>
        <tr>
          <td class="bg-secondary text-white" style="white-space: nowrap">Client Phone</td>
          <td colspan="2">{{ $pemesanan->nomor }}</td>
          <td class="bg-secondary text-white" style="white-space: nowrap">Order Received By</td>
          <td colspan="2">ADIL</td>
        </tr>
        <tr>
          <td class="bg-secondary text-white" style="white-space: nowrap">Order Date</td>
          <td>{{ $workOrder->order_date }}</td>
          <td class="bg-secondary text-white" style="white-space: nowrap">Expected Start</td>
          <td>{{ $workOrder->expected_start_date }}</td>
          <td class="bg-secondary text-white" style="white-space: nowrap">Expected End</td>
          <td>{{ $workOrder->expected_end_date }}</td>
        </tr>
      </table>

      <table>
        <tr>
          <td class="bg-secondary text-white" style="white-space: nowrap">WORK ORDER COMPILED BY</td>
          <td>Admin Emoka</td>
        </tr>
      </table>

      <table>
        <tr>
          <td class="bg-secondary text-white" style="white-space: nowrap">WORK</td>
          <td colspan="5">{{ $pemesanan->jenis_pakaian }}</td>
        </tr>
        <tr>
          <th rowspan="3" class="align-middle bg-secondary text-white">DESCRIPTION</th>
          <td><strong>JENIS KAIN</strong></td>
          <td colspan="4">{{ $workOrder->jenis_kain ?? '-' }}</td>
        </tr>
        <tr>
          <td><strong>FURING</strong></td>
          <td colspan="4">{{ $workOrder->furing ?? '-' }}</td>
        </tr>

        <tr>
          <td><strong>WARNA KAIN</strong></td>
          <td colspan="4">{{ $workOrder->warna_kain ?? '-' }}</td>
        </tr>
        @php
          $desain = json_decode($pemesanan->desain, true);
          $tampak_depan = collect($desain)
            ->filter(function ($item) {
              return $item['nama'] === 'Tampak Depan' || $item['nama'] === 'Depan';
            })
            ->first();
          $logo = collect($desain)->firstWhere('nama', 'Logo');
          $tampak_belakang = collect($desain)
            ->filter(function ($item) {
              return $item['nama'] === 'Tampak Belakang' || $item['nama'] === 'Belakang';
            })
            ->first();
        @endphp

        <tr>
          <td rowspan="4" class="bg-secondary text-white" style="white-space: nowrap">DESIGN</td>
          <td>DEPAN</td>
          <td colspan="4">SIZE</td>
        </tr>
        <tr>
          <td>
            @if ($tampak_depan)
              <img src="{{ asset($tampak_depan['file']) }}" alt="Logo" style="max-width: 350px" />
            @else
              <p>Desain tampak depan belum tersedia.</p>
            @endif
          </td>
          <td style="border-right: none">PENDEK</td>
          <td style="padding: 0; border: none">
            <table style="margin: 0">
              <tr><td>SK</td></tr>
              <tr><td>S</td></tr>
              <tr><td>M</td></tr>
              <tr><td>L</td></tr>
              <tr><td>XL</td></tr>
              <tr><td>XXL</td></tr>
              <tr><td>XXXL</td></tr>
              <tr><td>XXXXL</td></tr>
            </table>
          </td>
          <td style="padding: 0; border: none">
            <table style="margin: 0; border-left: none">
              <tr>
                <td>{{ $detail->where('ukuran', 'SK')->where('lengan', 'Pendek')->first()?->jumlah ?? '-' }}</td>
              </tr>
              <tr>
                <td>
                  {{ $detail->where('ukuran', 'S')->where('lengan', 'Pendek')->first()?->jumlah ?? '-' }}
                </td>
              </tr>
              <tr>
                <td>
                  {{ $detail->where('ukuran', 'M')->where('lengan', 'Pendek')->first()?->jumlah ?? '-' }}
                </td>
              </tr>
              <tr><td>{{ $detail->where('ukuran', 'L')->where('lengan', 'Pendek')->first()?->jumlah ?? '-' }}</td></tr>
              <tr>
                <td>{{ $detail->where('ukuran', 'XL')->where('lengan', 'Pendek')->first()?->jumlah ?? '-' }}</td>
              </tr>
              <tr>
                <td>{{ $detail->where('ukuran', 'XXL')->where('lengan', 'Pendek')->first()?->jumlah ?? '-' }}</td>
              </tr>
              <tr>
                <td>{{ $detail->where('ukuran', 'XXXL')->where('lengan', 'Pendek')->first()?->jumlah ?? '-' }}</td>
              </tr>
              <tr>
                <td>{{ $detail->where('ukuran', 'XXXXL')->where('lengan', 'Pendek')->first()?->jumlah ?? '-' }}</td>
              </tr>
            </table>
          </td>
        </tr>
        <tr>
          <td>BELAKANG</td>

          <td colspan="4">SIZE</td>
        </tr>
        <tr>
          <td>
            @if ($tampak_belakang)
              <img src="{{ asset($tampak_belakang['file']) }}" alt="Logo" style="max-width: 200px" />
            @else
              <p>Desain tampak belakang belum tersedia.</p>
            @endif
          </td>
          <td style="border-right: none">PANJANG</td>
          <td style="padding: 0; border: none">
            <table style="margin: 0">
              <tr><td>SK</td></tr>
              <tr><td>S</td></tr>
              <tr><td>M</td></tr>
              <tr><td>L</td></tr>
              <tr><td>XL</td></tr>
              <tr><td>XXL</td></tr>
              <tr><td>XXXL</td></tr>
              <tr><td>XXXXL</td></tr>
            </table>
          </td>
          <td style="padding: 0; border: none">
            <table style="margin: 0; border-left: none">
              <tr>
                <td>{{ $detail->where('ukuran', 'SK')->where('lengan', 'Panjang')->first()?->jumlah ?? '-' }}</td>
              </tr>
              <tr>
                <td>{{ $detail->where('ukuran', 'S')->where('lengan', 'Panjang')->first()?->jumlah ?? '-' }}</td>
              </tr>
              <tr>
                <td>{{ $detail->where('ukuran', 'M')->where('lengan', 'Panjang')->first()?->jumlah ?? '-' }}</td>
              </tr>
              <tr>
                <td>{{ $detail->where('ukuran', 'L')->where('lengan', 'Panjang')->first()?->jumlah ?? '-' }}</td>
              </tr>
              <tr>
                <td>{{ $detail->where('ukuran', 'XL')->where('lengan', 'Panjang')->first()?->jumlah ?? '-' }}</td>
              </tr>
              <tr>
                <td>{{ $detail->where('ukuran', 'XXL')->where('lengan', 'Panjang')->first()?->jumlah ?? '-' }}</td>
              </tr>
              <tr>
                <td>{{ $detail->where('ukuran', 'XXXL')->where('lengan', 'Panjang')->first()?->jumlah ?? '-' }}</td>
              </tr>
              <tr>
                <td>{{ $detail->where('ukuran', 'XXXXL')->where('lengan', 'Panjang')->first()?->jumlah ?? '-' }}</td>
              </tr>
            </table>
          </td>
        </tr>

        <tr>
          <td colspan="3">Total</td>
          <td colspan="2">{{ $detail->sum('jumlah') }}</td>
        </tr>
      </table>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.10.111/pdf.min.js"></script>
  </body>
</html>
