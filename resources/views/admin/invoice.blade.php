<!DOCTYPE html>
<html>
  <head>
    <title>INVOICE EMOKA KONVEKSI</title>
    <link href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet" />

    <!-- Favicons -->
    <link href="{{ asset('/img/logo2.png') }}" rel="icon" />
    <link href="{{ asset('/img/apple-touch-icon.png') }}" rel="apple-touch-icon" />

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
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
  <body>
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

      <table class="table align-middle">
        <tr>
          <td class="bg-secondary text-white" style="white-space: nowrap; width: 1%">Client Name</td>
          <td style="">{{ $order->nama }}</td>
          <td class="bg-secondary text-white" style="white-space: nowrap; width: 1%">Order Number</td>
          <td>100</td>
        </tr>
        <tr>
          <td class="bg-secondary text-white" style="white-space: nowrap; width: 1%">Client Phone</td>
          <td style="">{{ $order->nomor }}</td>
          <td class="bg-secondary text-white" style="white-space: nowrap; width: 1%">Order Received By</td>
          <td>ADIL</td>
        </tr>
      </table>

      <table class="table align-middle">
        <tr>
          <td class="bg-secondary text-white">INVOICE COMPILED BY</td>
          <td style="">Shahwa</td>
        </tr>
      </table>

      <table class="mt-2">
        <thead>
          <tr>
            <th class="bg-secondary text-white">Invoice</th>
            <th class="bg-secondary text-white">Size</th>
            <th class="bg-secondary text-white">Quantity</th>
            <th class="bg-secondary text-white">Price per Unit</th>
            <th class="bg-secondary text-white">Amount</th>
          </tr>
        </thead>
        <tbody>
          @php
            $total = 0;
            $jmlUkuranTotal = 0;
          @endphp

          @foreach ($details as $item)
            <tr>
              <td>{{ $order->jenis_pakaian }}</td>
              <td>{{ $item->ukuran }}</td>
              <td>{{ $item->jumlah }}</td>
              <td>Rp.{{ number_format($item->harga_satuan, 0, ',', '.') }}</td>
              <td>Rp.{{ number_format($item->jumlah * $item->harga_satuan, 0, ',', '.') }}</td>
            </tr>
            @php
              $total += $item->jumlah * $item->harga_satuan;
              $jmlUkuranTotal += $item->jumlah;
            @endphp
          @endforeach

          <tr>
            <td colspan="2">Total</td>
            <td>{{ number_format($jmlUkuranTotal, 0, ',', '.') }}</td>
            <td>Subtotal</td>
            <td>Rp.{{ number_format($total, 0, ',', '.') }}</td>
          </tr>
        </tbody>
      </table>

      <table class="table align-middle">
        <tr>
          <td class="bg-secondary text-white" style="white-space: nowrap; width: 1%">INVOICE AUTHORIZED BY</td>
          <td style="">Adil</td>
          <td class="bg-secondary text-white" style="white-space: nowrap; width: 1%">PAID</td>
          <td>
            @if ($midtrans && $midtrans->midtrans_status === 'settlement')
              Rp.{{ number_format($total, 0, ',', '.') }}
            @else
              Rp.0
            @endif
          </td>
        </tr>
        <tr>
          <td class="bg-secondary text-white" style="white-space: nowrap; width: 1%">DATE APRROVAL</td>
          <td style="">Budi</td>
          <td class="bg-secondary text-white" style="white-space: nowrap; width: 1%">INVOICE</td>
          <td>Rp.{{ number_format($total, 0, ',', '.') }}</td>
        </tr>
      </table>

      <p style="text-align: center; margin-top: 30px">Terima kasih telah mempercayakan pemesanan Anda kepada kami.</p>
    </div>

    <script>
      window.onload = function () {
        window.print()
      }
    </script>
  </body>
</html>
