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
          <td colspan="2" style="">{{ $pemesanan->nama }}</td>
          <td class="bg-secondary text-white" style="white-space: nowrap">Order Number</td>
          <td colspan="2">100</td>
        </tr>
        <tr>
          <td class="bg-secondary text-white" style="white-space: nowrap">Client Phone</td>
          <td style="" colspan="2">{{ $pemesanan->nomor }}</td>
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
          <td class="bg-secondary text-white" style="white-space: nowrap; width:">WORK ORDER COMPILED BY</td>
          <td>Admin Emoka</td>
        </tr>
      </table>

      <table>
        <tr>
          <td class="bg-secondary text-white" style="white-space: nowrap; width:">WORK</td>
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

      <div class="mb-3">
        @if ($excelData)
          <div class="mt-3">
            <h5>Data Ukuran</h5>
            <table border="1" cellspacing="0" cellpadding="5" style="width: 100%; border-collapse: collapse">
              @foreach ($excelData as $rowIdx => $row)
                <tr>
                  @php
                    $skipCols = [];
                  @endphp

                  @foreach ($row as $colIdx => $cell)
                    @if (in_array($colIdx, $skipCols))
                      @continue
                    @endif

                    @php
                      $colspan = 1;
                      // Cek apakah cell termasuk merge
                      foreach ($mergeCells as $range) {
                        [$start, $end] = explode(':', $range);
                        if ($start === $colIdx . $rowIdx) {
                          // Hitung lebar merge
                          preg_match('/([A-Z]+)(\d+)/', $start, $startMatch);
                          preg_match('/([A-Z]+)(\d+)/', $end, $endMatch);
                          $startCol = $startMatch[1];
                          $endCol = $endMatch[1];
                          $startColIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($startCol);
                          $endColIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($endCol);
                          $colspan = $endColIndex - $startColIndex + 1;

                          // Tandai kolom yang harus diskip
                          for ($i = $startColIndex + 1; $i <= $endColIndex; $i++) {
                            $skipCols[] = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($i);
                          }
                          break;
                        }
                      }
                    @endphp

                    <td @if($colspan > 1) colspan="{{ $colspan }}" @endif>
                      {{ $cell }}
                    </td>
                  @endforeach
                </tr>
              @endforeach
            </table>
          </div>
        @else
          <h5 class="mt-3">Data Ukuran:</h5>
          <div id="pdf-container"></div>
        @endif
      </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.10.111/pdf.min.js"></script>

    <script>
      const url = '{{ asset($pemesanan->fileUkuran) }}'

      pdfjsLib.GlobalWorkerOptions.workerSrc =
        'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.10.111/pdf.worker.min.js'

      const loadingTask = pdfjsLib.getDocument(url)
      loadingTask.promise.then(
        function (pdf) {
          console.log('PDF loaded')

          for (let pageNumber = 1; pageNumber <= pdf.numPages; pageNumber++) {
            pdf.getPage(pageNumber).then(function (page) {
              const scale = 1.5
              const viewport = page.getViewport({ scale: scale })

              const canvas = document.createElement('canvas')
              const context = canvas.getContext('2d')

              // Tetap set ukuran asli
              canvas.height = viewport.height
              canvas.width = viewport.width

              // Tambahkan canvas ke container
              document.getElementById('pdf-container').appendChild(canvas)

              // Render PDF ke canvas
              const renderContext = {
                canvasContext: context,
                viewport: viewport,
              }
              page.render(renderContext).promise.then(() => {
                // Setelah render, atur CSS agar responsif
                canvas.style.width = '100%'
                canvas.style.height = 'auto'
                canvas.style.display = 'block'
              })
            })
          }
        },
        function (reason) {
          console.error('Error loading PDF:', reason)
        },
      )
    </script>
  </body>
</html>
