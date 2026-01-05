<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Emoka Konveksi</title>
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <!-- Favicons -->
    <link href="{{ asset("/img/logo2.png") }}" rel="icon" />
    <link href="{{ asset("/img/logo2.png") }}" rel="apple-touch-icon" />

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect" />
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Nunito:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
      rel="stylesheet"
    />

    <!-- Vendor CSS Files -->
    <link href="{{ asset("vendor/bootstrap/css/bootstrap.min.css") }}" rel="stylesheet" />
    <link href="{{ asset("vendor/bootstrap-icons/bootstrap-icons.css") }}" rel="stylesheet" />
    <link href="{{ asset("vendor/aos/aos.css") }}" rel="stylesheet" />
    <link href="{{ asset("vendor/glightbox/css/glightbox.min.css") }}" rel="stylesheet" />
    <link href="{{ asset("vendor/swiper/swiper-bundle.min.css") }}" rel="stylesheet" />

    <!-- Main CSS File -->
    <link href="{{ asset("css/main.css") }}" rel="stylesheet" />
  </head>
  <body class="index-page">
    <header id="header" class="header d-flex align-items-center fixed-top">
      <div class="container-fluid container-xl position-relative d-flex align-items-center">
        <a href="index.html" class="logo d-flex align-items-center me-auto">
          <!-- Uncomment the line below if you also wish to use an image logo -->
          <img src="{{ asset("img/logo.png") }}" alt="" />
          <h1 class="sitename d-block">Emoka</h1>
        </a>

        <nav id="navmenu" class="navmenu">
          <ul>
            <li>
              <a href="/#hero">
                Beranda
                <br />
              </a>
            </li>
            <li><a href="/#about">Tentang Kami</a></li>
            <li><a href="/#services">Layanan</a></li>
            <li><a href="/#portfolio">Produk</a></li>

            <li><a href="/#contact">Kontak</a></li>

            @auth
              <!-- Jika User Sudah Login, Tampilkan Username -->
              <li class="dropdown">
                <a href="#">
                  <span>{{ Auth::user()->username }}</span>
                  <i class="bi bi-chevron-down toggle-dropdown"></i>
                </a>
                <ul>
                  <li><a href="/profile">Profil</a></li>
                  <li><a href="/tracking-pesanan" class="active">Pesanan</a></li>
                  <li><a href="{{ route("logout") }}">Logout</a></li>
                </ul>
              </li>
            @else
              <!-- Jika Belum Login, Tampilkan Tombol Login -->
              <a class="btn-getstarted ms-3" href="{{ route("login") }}">Login</a>
            @endauth
          </ul>
          <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
        </nav>
      </div>
    </header>

    <main class="container pt-5 mb-5" style="margin-top: 100px">
      <h2 class="text-center mb-4" style="font-weight: 700">Pesanan Anda</h2>
      <div class="row justify-content-center">
        <div class="col-lg-10">
          <div id="result">
            @if ($orders->count())
              <div class="alert alert-info">
                Ditemukan {{ $orders->count() }} pesanan untuk
                <strong>{{ Auth::user()->username }}</strong>
              </div>
              <ul class="list-group">
                @foreach ($orders as $index => $order)
                  <li class="list-group-item">
                    <div class="d-flex justify-content-between align-items-center">
                      <span>
                        <strong>Pesanan #{{ $index + 1 }}</strong>
                        <br />
                        {{ $order->deskripsi }}
                      </span>
                      <span
                        class="badge @if ($order->status == "Menunggu")
                            bg-secondary
                        @elseif ($order->status == "Belum Bayar")
                            bg-warning
                            text-dark
                        @elseif ($order->status == "Sudah Bayar")
                            bg-info
                            text-dark
                        @elseif ($order->status == "Produksi")
                            bg-primary
                        @elseif ($order->status == "Pengiriman")
                            bg-success
                        @elseif ($order->status == "Selesai")
                            bg-dark
                        @else
                            bg-light
                            text-dark
                        @endif"
                      >
                        {{ $order->status }}
                      </span>
                    </div>
                    <div class="text-end mt-2">
                      @if ($order->status == "Belum Bayar")
                        <!-- Tombol Bayar -->
                        <button class="btn btn-success btn-pay py-1" data-id="{{ $order->id }}">Bayar</button>
                      @endif

                      @if ($order->status != "Menunggu")
                        <!-- Tombol Cetak Invoice -->
                        <a
                          href="/pelanggan/invoice/{{ $order->id }}"
                          class="btn btn-sm btn-outline-primary"
                          target="_blank"
                        >
                          Cetak Invoice
                        </a>
                      @endif

                      <button
                        class="btn btn-sm btn-outline-primary"
                        data-bs-toggle="collapse"
                        data-bs-target="#detail{{ $index + 1 }}"
                      >
                        Lihat Detail
                      </button>
                      @if (in_array($order->status, ["Menunggu", "Belum Bayar"]))
                        @php
                          $totalHarga = optional($order->detail)->sum("harga_total") ?? 0;
                        @endphp

                        <p class="mt-2 mb-0" style="font-weight: 500">
                          Harga Total : Rp.{{ number_format($totalHarga, 0, ",", ".") }}
                        </p>

                        <!-- Tombol Batalkan Pesanan -->
                        <form action="{{ route("pelanggan.batalkanPesanan", $order->id) }}" method="POST">
                          @csrf
                          @method("PUT")
                          <button type="submit" class="btn btn-sm btn-outline-danger mt-2 btn-batal-konfirmasi">
                            Batalkan Pesanan
                          </button>
                        </form>
                      @endif
                    </div>
                    <div class="collapse mt-3" id="detail{{ $index + 1 }}">
                      <ul class="list-group">
                        <li class="list-group-item">
                          <strong>Nama:</strong>
                          {{ $order->nama }}
                        </li>
                        <li class="list-group-item">
                          <strong>Email:</strong>
                          {{ $order->email }}
                        </li>
                        <li class="list-group-item">
                          <strong>Nomor WA:</strong>
                          {{ $order->nomor }}
                        </li>
                        <li class="list-group-item">
                          <strong>Alamat:</strong>
                          {{ $order->alamat }}
                        </li>
                        <li class="list-group-item">
                          <strong>Deskripsi:</strong>
                          {{ $order->deskripsi }}
                        </li>
                        <li class="list-group-item">
                          <strong>Tanggal:</strong>
                          {{ \Carbon\Carbon::parse($order->tanggal)->format("Y-m-d H:i") }}
                        </li>
                        <li class="list-group-item">
                          <strong>File Ukuran:</strong>

                          @if ($order->fileUkuran)
                            <a href="{{ asset($order->fileUkuran) }}" download class="btn btn-sm btn-success">
                              Download
                            </a>
                          @else
                            <em>Tidak ada</em>
                          @endif
                        </li>

                        @if ($order->desain)
                          @php
                            $desains = json_decode($order->desain, true);
                          @endphp

                          @foreach ($desains as $desain)
                            <li class="list-group-item">
                              <strong>{{ $desain["nama"] }}:</strong>
                              <br />

                              <img
                                src="{{ asset($desain["file"]) }}"
                                alt="Tampak Depan"
                                class="img-fluid rounded my-2"
                                style="max-height: 300px"
                              />
                              <br />
                              <a href="{{ asset($desain["file"]) }}" download class="btn btn-sm btn-success">
                                Download
                              </a>
                            </li>
                          @endforeach
                        @endif
                      </ul>
                    </div>
                  </li>
                @endforeach
              </ul>
            @else
              <div class="alert alert-warning">Belum ada pesanan atas nama {{ Auth::user()->username }}.</div>
            @endif
          </div>
        </div>
      </div>
    </main>

    <footer id="footer" class="footer mt-3">
      <div class="footer-newsletter"></div>

      <div class="container footer-top">
        <div class="row gy-4">
          <div class="col-lg-4 col-md-6 footer-about">
            <a href="index.html" class="d-flex align-items-center">
              <span class="sitename">Emoka Konveksi</span>
            </a>
            <div class="footer-contact pt-3">
              <p>Taman, Sungkur, Semangkak, Kec. Klaten Tengah</p>
              <p>Kabupaten Klaten, Jawa Tengah 57415</p>
              <p class="mt-3">
                <strong>Whatsapp:</strong>
                <span>+62 882-0034-41009</span>
              </p>
              <p>
                <strong>Email:</strong>
                <span>emoka.konveksi@gmail.com</span>
              </p>
            </div>
          </div>

          <div class="col-lg-2 col-md-3 footer-links">
            <!-- <h4>Useful Links</h4>
              <ul>
                <li><i class="bi bi-chevron-right"></i> <a href="#">Home</a></li>
                <li><i class="bi bi-chevron-right"></i> <a href="#">About us</a></li>
                <li><i class="bi bi-chevron-right"></i> <a href="#">Services</a></li>
                <li><i class="bi bi-chevron-right"></i> <a href="#">Terms of service</a></li>
              </ul> -->
          </div>

          <div class="col-lg-2 col-md-3 footer-links">
            <!-- <h4>Our Services</h4>
              <ul>
                <li><i class="bi bi-chevron-right"></i> <a href="#">Web Design</a></li>
                <li><i class="bi bi-chevron-right"></i> <a href="#">Web Development</a></li>
                <li><i class="bi bi-chevron-right"></i> <a href="#">Product Management</a></li>
                <li><i class="bi bi-chevron-right"></i> <a href="#">Marketing</a></li>
              </ul> -->
          </div>

          <div class="col-lg-4 col-md-12">
            <h4>Ikuti Kami</h4>
            <p>Tetap terhubung dengan kami untuk informasi dan penawaran terbaru.</p>
            <div class="social-links d-flex">
              <a href="https://www.tiktok.com/@emoka.konveksi"><i class="bi bi-tiktok"></i></a>
              <a href="https://www.instagram.com/emoka.konveksi/"><i class="bi bi-instagram"></i></a>
            </div>
          </div>
        </div>
      </div>
    </footer>

    <!-- Vendor JS Files -->
    <script src="{{ asset("vendor/php-email-form/validate.js") }}"></script>
    <script src="{{ asset("vendor/aos/aos.js") }}"></script>
    <script src="{{ asset("vendor/glightbox/js/glightbox.min.js") }}"></script>
    <script src="{{ asset("vendor/purecounter/purecounter_vanilla.js") }}"></script>
    <script src="{{ asset("vendor/imagesloaded/imagesloaded.pkgd.min.js") }}"></script>
    <script src="{{ asset("vendor/isotope-layout/isotope.pkgd.min.js") }}"></script>
    <script src="{{ asset("vendor/swiper/swiper-bundle.min.js") }}"></script>
    <script src="{{ asset("vendor/bootstrap/js/bootstrap.bundle.min.js") }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Main JS File -->
    <script src="{{ asset("js/main.js") }}"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script
      src="https://app.sandbox.midtrans.com/snap/snap.js"
      data-client-key="{{ config("services.midtrans.client_key") }}"
    ></script>

    <script>
      $('.btn-pay').on('click', function () {
        const id = $(this).data('id')

        Swal.fire({
          title: 'Memuat pembayaran...',
          allowOutsideClick: false,
          didOpen: () => {
            Swal.showLoading()
          },
        })

        $.get(`/midtrans/token/${id}`, function (response) {
          Swal.close()
          window.snap.pay(response.token, {
            onSuccess: function (result) {
              Swal.fire({
                icon: 'success',
                title: 'Pembayaran Berhasil!',
                text: 'Transaksi Anda telah selesai.',
              }).then(() => {
                location.reload() // atau redirect ke halaman sukses
              })
            },
            onPending: function (result) {},
            onError: function (result) {
              Swal.fire({
                icon: 'error',
                title: 'Pembayaran Gagal!',
                text: 'Terjadi kesalahan saat memproses transaksi.',
              })
            },
            onClose: function () {
              Swal.fire({
                icon: 'warning',
                title: 'Keluar',
                text: 'Anda menutup jendela pembayaran tanpa menyelesaikannya.',
              })
            },
          })
        })
      })
    </script>
    <script>
      $(document).ready(function () {
        $('.btn-batal-konfirmasi').on('click', function (e) {
          e.preventDefault()
          const form = $(this).closest('form')

          Swal.fire({
            title: 'Batalkan Pesanan?',
            text: 'Pesanan akan dibatalkan dan tidak dapat dikembalikan!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, batalkan!',
            cancelButtonText: 'Tidak',
          }).then((result) => {
            if (result.isConfirmed) {
              form.submit()
            }
          })
        })
      })
    </script>
  </body>
</html>
