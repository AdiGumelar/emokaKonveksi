<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Tracking Pesanan - Emoka Konveksi</title>
    <meta name="description" content="Lacak status pesanan konveksi Anda di Emoka Konveksi Klaten" />
    <meta name="keywords" content="tracking pesanan, status pesanan, emoka konveksi, pakaian kustom" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <!-- Favicons -->
    <link href="{{ asset('/img/logo2.png') }}" rel="icon" />
    <link href="{{ asset('/img/logo2.png') }}" rel="apple-touch-icon" />

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect" />
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;500;600;700;800&family=Poppins:wght@300;400;500;600;700&family=Roboto:wght@300;400;500;700&display=swap"
      rel="stylesheet"
    />

    <!-- Vendor CSS Files -->
    <link href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet" />
    <link href="{{ asset('vendor/aos/aos.css') }}" rel="stylesheet" />
    <link href="{{ asset('vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet" />

    <!-- Main CSS File -->
    <link href="{{ asset('css/main.css') }}" rel="stylesheet" />

    <link href="{{ asset('css/trackingPesanan.css') }}" rel="stylesheet" />
  </head>
  <body class="index-page">
    <!-- Header / Navbar -->
    <header id="header" class="header d-flex align-items-center fixed-top">
      <div class="container-fluid container-xl position-relative d-flex align-items-center">
        <a href="/" class="logo d-flex align-items-center me-auto">
          <img src="{{ asset('img/logo.png') }}" alt="Emoka Logo" />
          <h1 class="sitename d-block">Emoka</h1>
        </a>

        <nav id="navmenu" class="navmenu">
          <ul>
            <li><a href="/#hero">Beranda</a></li>
            <li><a href="/#about">Tentang Kami</a></li>
            <li><a href="/#services">Layanan</a></li>
            <li><a href="/#portfolio">Produk</a></li>
            <li><a href="/#contact">Kontak</a></li>
            <li><a href="/form-pemesanan">Pesan</a></li>

            @auth
              <!-- User Dropdown -->
              <li class="dropdown">
                <a href="#">
                  <span>{{ Auth::user()->username }}</span>
                  <i class="bi bi-chevron-down toggle-dropdown"></i>
                </a>
                <ul>
                  <li><a href="/profile">Profil</a></li>
                  <li><a href="/tracking-pesanan" class="active">Pesanan</a></li>
                  <li><a href="{{ route('logout') }}">Logout</a></li>
                </ul>
              </li>
            @else
              <a class="btn-getstarted ms-3" href="{{ route('login') }}">Login</a>
            @endauth
          </ul>
          <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
        </nav>
      </div>
    </header>

    <!-- Hero Banner -->
    <div class="order-hero-banner">
      <div class="container text-center" data-aos="fade-up">
        <span class="order-badge-pill">
          <i class="bi bi-clock-history"></i>
          Tracking Status Produksi
        </span>
        <h1 class="order-hero-title">Pesanan & Pelacakan</h1>
        <p class="order-hero-subtitle">
          Pantau status pengerjaan pakaian pesanan Anda secara transparan dan terkini dari mulai konfirmasi hingga
          pengiriman.
        </p>
        <div class="breadcrumb-custom">
          <a href="/">
            <i class="bi bi-house-door me-1"></i>
            Beranda
          </a>
          <i class="bi bi-chevron-right small"></i>
          <span>Tracking Pesanan</span>
        </div>
      </div>
    </div>

    <!-- Main Content -->
    <main class="container my-5">
      <div class="row justify-content-center">
        <div class="col-lg-10">
          @if (session('success'))
            <div
              class="alert alert-success alert-dismissible fade show rounded-3 mb-4 d-flex align-items-center gap-2"
              role="alert"
            >
              <i class="bi bi-check-circle-fill fs-5"></i>
              <div>{{ session('success') }}</div>
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          @endif

          @if (session('error'))
            <div
              class="alert alert-danger alert-dismissible fade show rounded-3 mb-4 d-flex align-items-center gap-2"
              role="alert"
            >
              <i class="bi bi-exclamation-triangle-fill fs-5"></i>
              <div>{{ session('error') }}</div>
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          @endif

          <div id="result">
            @if ($orders->count())
              <!-- Summary Bar -->
              <div
                class="order-summary-bar d-flex align-items-center justify-content-between flex-wrap gap-3"
                data-aos="fade-up"
              >
                <div class="d-flex align-items-center gap-3">
                  <div class="user-avatar-circle">
                    <i class="bi bi-person-fill"></i>
                  </div>
                  <div>
                    <div class="fw-bold text-dark" style="font-size: 15px">Akun: {{ Auth::user()->username }}</div>
                    <small class="text-muted">
                      Menampilkan
                      <strong class="text-primary">{{ $orders->count() }}</strong>
                      pesanan aktif yang sedang berlangsung
                    </small>
                  </div>
                </div>
                <a href="/form-pemesanan" class="btn btn-sm btn-outline-primary rounded-pill px-3 py-2 fw-semibold">
                  <i class="bi bi-plus-lg me-1"></i>
                  Pesan Pakaian Baru
                </a>
              </div>

              <!-- List of Orders -->
              @foreach ($orders as $index => $order)
                @php
                  // Hitung total harga & total item
                  $totalHarga = optional($order->detail)->sum('harga_total') ?? 0;
                  $totalPcs = optional($order->detail)->sum('jumlah') ?? ($order->jumlah_pakaian ?? 0);

                  // Progress Step Index:
                  // 1 = Menunggu, 2 = Belum Bayar, 3 = Sudah Bayar, 4 = Produksi, 5 = Pengiriman, 6 = Selesai
                  $statusMap = [
                    'Menunggu' => 1,
                    'Belum Bayar' => 2,
                    'Sudah Bayar' => 3,
                    'Produksi' => 4,
                    'Pengiriman' => 5,
                    'Selesai' => 6,
                  ];
                  $currentStep = $statusMap[$order->status] ?? 1;
                @endphp

                <div class="order-card" data-aos="fade-up" data-aos-delay="{{ 100 + $index * 50 }}">
                  <!-- Card Header -->
                  <div class="order-card-header">
                    <div class="d-flex align-items-center gap-2 flex-wrap">
                      <span
                        class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill px-3 py-1"
                      >
                        Pesanan #{{ $index + 1 }}
                      </span>
                      <span class="order-code-badge">{{ $order->id }}</span>
                      <span class="text-muted small">
                        <i class="bi bi-calendar3 me-1"></i>
                        {{ \Carbon\Carbon::parse($order->tanggal)->translatedFormat('d M Y, H:i') }}
                      </span>
                    </div>

                    <!-- Status Badge -->
                    <div>
                      @if ($order->status == 'Menunggu')
                        <span
                          class="badge bg-secondary-subtle text-secondary border border-secondary-subtle rounded-pill px-3 py-2"
                        >
                          <i class="bi bi-hourglass-split me-1"></i>
                          Menunggu Konfirmasi
                        </span>
                      @elseif ($order->status == 'Belum Bayar')
                        <span
                          class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle rounded-pill px-3 py-2"
                        >
                          <i class="bi bi-wallet2 me-1"></i>
                          Menunggu Pembayaran
                        </span>
                      @elseif ($order->status == 'Sudah Bayar')
                        <span
                          class="badge bg-info-subtle text-info-emphasis border border-info-subtle rounded-pill px-3 py-2"
                        >
                          <i class="bi bi-check2-circle me-1"></i>
                          Pembayaran Terverifikasi
                        </span>
                      @elseif ($order->status == 'Produksi')
                        <span
                          class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill px-3 py-2"
                        >
                          <i class="bi bi-scissors me-1"></i>
                          Dalam Proses Produksi
                        </span>
                      @elseif ($order->status == 'Pengiriman')
                        <span
                          class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-3 py-2"
                        >
                          <i class="bi bi-truck me-1"></i>
                          Sedang Dikirim
                        </span>
                      @elseif ($order->status == 'Selesai')
                        <span class="badge bg-dark-subtle text-dark border border-dark-subtle rounded-pill px-3 py-2">
                          <i class="bi bi-check-all me-1"></i>
                          Selesai
                        </span>
                      @else
                        <span class="badge bg-light text-dark border rounded-pill px-3 py-2">
                          {{ $order->status }}
                        </span>
                      @endif
                    </div>
                  </div>

                  <!-- Card Body -->
                  <div class="order-card-body">
                    <!-- Tracking Pipeline Stepper -->
                    <div class="tracking-stepper">
                      <!-- Step 1: Menunggu -->
                      <div
                        class="stepper-step {{ $currentStep > 1 ? 'completed' : ($currentStep == 1 ? 'active' : '') }}"
                      >
                        <div class="stepper-circle">
                          @if ($currentStep > 1)
                            <i class="bi bi-check-lg"></i>
                          @else
                            <i class="bi bi-hourglass-split"></i>
                          @endif
                        </div>
                        <span class="stepper-label">1. Konfirmasi</span>
                      </div>

                      <!-- Step 2: Belum Bayar -->
                      <div
                        class="stepper-step {{ $currentStep > 2 ? 'completed' : ($currentStep == 2 ? 'active' : '') }}"
                      >
                        <div class="stepper-circle">
                          @if ($currentStep > 2)
                            <i class="bi bi-check-lg"></i>
                          @else
                            <i class="bi bi-credit-card"></i>
                          @endif
                        </div>
                        <span class="stepper-label">2. Pembayaran</span>
                      </div>

                      <!-- Step 3: Sudah Bayar -->
                      <div
                        class="stepper-step {{ $currentStep > 3 ? 'completed' : ($currentStep == 3 ? 'active' : '') }}"
                      >
                        <div class="stepper-circle">
                          @if ($currentStep > 3)
                            <i class="bi bi-check-lg"></i>
                          @else
                            <i class="bi bi-shield-check"></i>
                          @endif
                        </div>
                        <span class="stepper-label">3. Terverifikasi</span>
                      </div>

                      <!-- Step 4: Produksi -->
                      <div
                        class="stepper-step {{ $currentStep > 4 ? 'completed' : ($currentStep == 4 ? 'active' : '') }}"
                      >
                        <div class="stepper-circle">
                          @if ($currentStep > 4)
                            <i class="bi bi-check-lg"></i>
                          @else
                            <i class="bi bi-scissors"></i>
                          @endif
                        </div>
                        <span class="stepper-label">4. Produksi</span>
                      </div>

                      <!-- Step 5: Pengiriman -->
                      <div
                        class="stepper-step {{ $currentStep >= 5 ? ($currentStep > 5 ? 'completed' : 'active') : '' }}"
                      >
                        <div class="stepper-circle">
                          @if ($currentStep > 5)
                            <i class="bi bi-check-lg"></i>
                          @else
                            <i class="bi bi-truck"></i>
                          @endif
                        </div>
                        <span class="stepper-label">5. Pengiriman</span>
                      </div>
                    </div>

                    <!-- Meta Information Box -->
                    <div class="order-meta-grid">
                      <div>
                        <span class="meta-item-label">Jenis Pakaian</span>
                        <span class="meta-item-value text-primary">
                          <i class="bi bi-tag me-1"></i>
                          {{ $order->jenis_pakaian ?? 'Pakaian Kustom' }}
                        </span>
                      </div>
                      <div>
                        <span class="meta-item-label">Jumlah Produksi</span>
                        <span class="meta-item-value">{{ $totalPcs }} Pcs</span>
                      </div>
                      <div>
                        <span class="meta-item-label">Total Tagihan</span>
                        <span class="meta-item-value {{ $totalHarga > 0 ? 'text-success' : 'text-muted' }}">
                          @if ($totalHarga > 0)
                            Rp {{ number_format($totalHarga, 0, ',', '.') }}
                          @else
                            <em>Menunggu Penawaran Admin</em>
                          @endif
                        </span>
                      </div>
                      <div>
                        <span class="meta-item-label">Penerima</span>
                        <span class="meta-item-value text-truncate d-block" style="max-width: 180px">
                          {{ $order->nama }}
                        </span>
                      </div>
                    </div>

                    <!-- Ringkasan Catatan / Deskripsi -->
                    <div class="mb-3">
                      <small class="text-muted fw-bold text-uppercase d-block mb-1" style="font-size: 11px">
                        Catatan Pesanan:
                      </small>
                      <p class="text-secondary small mb-0 p-2 rounded bg-light border-start border-3 border-primary">
                        {{ $order->deskripsi }}
                      </p>
                    </div>

                    <!-- Action Bar Buttons -->
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 pt-2 border-top">
                      <!-- Tombol Aksi Kiri (Collapse & CS) -->
                      <div class="d-flex align-items-center gap-2 flex-wrap">
                        <button
                          class="btn btn-sm btn-outline-primary rounded-pill px-3 btn-detail-toggle"
                          data-bs-toggle="collapse"
                          data-bs-target="#detail-{{ $order->id }}"
                          aria-expanded="false"
                        >
                          <i class="bi bi-info-circle me-1"></i>
                          Rincian Pesanan
                          <i class="bi bi-chevron-down ms-1 toggle-icon"></i>
                        </button>

                        <a
                          href="https://wa.me/62882003441009?text={{ urlencode('Halo Admin Emoka Konveksi, saya ingin konfirmasi pesanan #' . $order->id) }}"
                          target="_blank"
                          class="btn btn-sm btn-outline-success rounded-pill px-3"
                          title="Tanyakan ke CS WhatsApp"
                        >
                          <i class="bi bi-whatsapp me-1"></i>
                          Tanya CS
                        </a>
                      </div>

                      <!-- Tombol Aksi Kanan (Bayar, Invoice, Batalkan) -->
                      <div class="d-flex align-items-center gap-2 flex-wrap">
                        @if ($order->status == 'Belum Bayar')
                          <!-- Tombol Bayar Midtrans -->
                          <button
                            class="btn btn-sm btn-success btn-pay rounded-pill px-3 fw-bold shadow-sm"
                            data-id="{{ $order->id }}"
                          >
                            <i class="bi bi-credit-card-2-front me-1"></i>
                            Bayar Sekarang
                          </button>
                        @endif

                        @if ($order->status != 'Menunggu')
                          <!-- Tombol Cetak Invoice -->
                          <a
                            href="/pelanggan/invoice/{{ $order->id }}"
                            class="btn btn-sm btn-outline-secondary rounded-pill px-3"
                            target="_blank"
                          >
                            <i class="bi bi-printer me-1"></i>
                            Cetak Invoice
                          </a>
                        @endif

                        @if (in_array($order->status, ['Menunggu', 'Belum Bayar']))
                          <!-- Tombol Batalkan Pesanan -->
                          <form
                            action="{{ route('pelanggan.batalkanPesanan', $order->id) }}"
                            method="POST"
                            class="d-inline"
                          >
                            @csrf
                            @method('PUT')
                            <button
                              type="submit"
                              class="btn btn-sm btn-outline-danger btn-batal-konfirmasi rounded-pill px-3"
                            >
                              <i class="bi bi-x-circle me-1"></i>
                              Batalkan
                            </button>
                          </form>
                        @endif
                      </div>
                    </div>

                    <!-- Collapsible Detail Section -->
                    <div class="collapse" id="detail-{{ $order->id }}">
                      <div class="order-detail-container mt-3">
                        <div class="row g-4">
                          <!-- Kolom Kiri: Informasi Pemesan & Pengiriman -->
                          <div class="col-md-6">
                            <div class="section-subheading">
                              <i class="bi bi-person-lines-fill text-primary"></i>
                              Data Pemesan & Pengiriman
                            </div>
                            <ul class="list-group list-group-flush rounded-3 border bg-white small mb-3">
                              <li class="list-group-item d-flex justify-content-between py-2">
                                <span class="text-muted">Nama:</span>
                                <span class="fw-semibold text-dark">{{ $order->nama }}</span>
                              </li>
                              <li class="list-group-item d-flex justify-content-between py-2">
                                <span class="text-muted">Email:</span>
                                <span class="fw-semibold text-dark">{{ $order->email }}</span>
                              </li>
                              <li class="list-group-item d-flex justify-content-between py-2">
                                <span class="text-muted">WhatsApp:</span>
                                <span class="fw-semibold text-success">{{ $order->nomor }}</span>
                              </li>
                              <li class="list-group-item d-flex justify-content-between py-2">
                                <span class="text-muted">Tanggal:</span>
                                <span class="fw-semibold text-dark">
                                  {{ \Carbon\Carbon::parse($order->tanggal)->translatedFormat('d M Y, H:i') }}
                                </span>
                              </li>
                              <li class="list-group-item py-2">
                                <span class="text-muted d-block mb-1">Alamat Pengiriman:</span>
                                <span class="fw-semibold text-dark">{{ $order->alamat }}</span>
                              </li>
                            </ul>

                            <!-- Berkas Ukuran Anggota -->
                            <div class="section-subheading mt-3">
                              <i class="bi bi-file-earmark-spreadsheet text-primary"></i>
                              Berkas Nama / Ukuran
                            </div>
                            <div
                              class="p-3 bg-white border rounded-3 d-flex align-items-center justify-content-between"
                            >
                              @if ($order->fileUkuran)
                                <div class="d-flex align-items-center gap-2 text-truncate me-2">
                                  <i class="bi bi-file-earmark-check text-success fs-4"></i>
                                  <span class="small fw-semibold text-dark text-truncate">
                                    {{ basename($order->fileUkuran) }}
                                  </span>
                                </div>
                                <a
                                  href="{{ asset($order->fileUkuran) }}"
                                  download
                                  class="btn btn-sm btn-outline-success rounded-pill px-3"
                                >
                                  <i class="bi bi-download me-1"></i>
                                  Unduh
                                </a>
                              @else
                                <span class="text-muted small"><em>Tidak ada berkas diunggah</em></span>
                              @endif
                            </div>
                          </div>

                          <!-- Kolom Kanan: Rincian Ukuran & Desain -->
                          <div class="col-md-6">
                            <!-- Tabel Rincian Ukuran -->
                            <div class="section-subheading">
                              <i class="bi bi-rulers text-primary"></i>
                              Rincian Ukuran Pakaian
                            </div>

                            @if ($order->detail && $order->detail->count() > 0)
                              <div class="table-responsive rounded-3 border bg-white mb-3">
                                <table class="table table-sm table-striped align-middle mb-0 small text-center">
                                  <thead class="table-light">
                                    <tr>
                                      <th>Ukuran</th>
                                      <th>Lengan</th>
                                      <th>Qty</th>
                                      <th>Harga Satuan</th>
                                      <th>Subtotal</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    @foreach ($order->detail as $item)
                                      <tr>
                                        <td>
                                          <span class="badge bg-primary-subtle text-primary">{{ $item->ukuran }}</span>
                                        </td>
                                        <td>{{ $item->lengan }}</td>
                                        <td class="fw-bold">{{ $item->jumlah }}</td>
                                        <td>
                                          {{ $item->harga_satuan > 0 ? 'Rp ' . number_format($item->harga_satuan, 0, ',', '.') : '-' }}
                                        </td>
                                        <td class="fw-bold text-success">
                                          {{ $item->harga_total > 0 ? 'Rp ' . number_format($item->harga_total, 0, ',', '.') : '-' }}
                                        </td>
                                      </tr>
                                    @endforeach
                                  </tbody>
                                  <tfoot class="table-light fw-bold">
                                    <tr>
                                      <td colspan="2" class="text-start ps-3">Total:</td>
                                      <td>{{ $totalPcs }} pcs</td>
                                      <td>-</td>
                                      <td class="text-success">
                                        {{ $totalHarga > 0 ? 'Rp ' . number_format($totalHarga, 0, ',', '.') : 'TBD' }}
                                      </td>
                                    </tr>
                                  </tfoot>
                                </table>
                              </div>
                            @else
                              <div class="p-3 bg-white border rounded-3 mb-3 small">
                                <div class="d-flex justify-content-between mb-1">
                                  <span class="text-muted">Total Jumlah:</span>
                                  <span class="fw-bold">{{ $order->jumlah_pakaian ?? 0 }} pcs</span>
                                </div>
                                <div class="d-flex justify-content-between">
                                  <span class="text-muted">Total Harga:</span>
                                  <span class="fw-bold text-success">
                                    {{ $totalHarga > 0 ? 'Rp ' . number_format($totalHarga, 0, ',', '.') : 'Menunggu Konfirmasi Admin' }}
                                  </span>
                                </div>
                              </div>
                            @endif

                            <!-- Lampiran Desain & Logo -->
                            <div class="section-subheading mt-3">
                              <i class="bi bi-images text-primary"></i>
                              Desain & Mockup Terlampir
                            </div>

                            @if ($order->desain)
                              @php
                                $desains = json_decode($order->desain, true);
                              @endphp

                              @if (is_array($desains) && count($desains) > 0)
                                <div class="row g-2">
                                  @foreach ($desains as $desain)
                                    @php
                                      $extension = strtolower(pathinfo($desain['file'], PATHINFO_EXTENSION));
                                      $isImage = in_array($extension, ['jpg', 'jpeg', 'png', 'webp', 'gif']);
                                    @endphp

                                    <div class="col-6">
                                      <div class="design-thumb-card p-2 bg-white">
                                        @if ($isImage)
                                          <div class="design-img-wrap rounded mb-2">
                                            <img src="{{ asset($desain['file']) }}" alt="{{ $desain['nama'] }}" />
                                            <a
                                              href="{{ asset($desain['file']) }}"
                                              class="glightbox design-zoom-btn"
                                              data-gallery="order-design-{{ $order->id }}"
                                              data-title="{{ $desain['nama'] }}"
                                            >
                                              <i class="bi bi-zoom-in"></i>
                                            </a>
                                          </div>
                                        @else
                                          <div class="design-img-wrap rounded mb-2 bg-light text-primary">
                                            <i class="bi bi-file-earmark-code fs-1"></i>
                                          </div>
                                        @endif
                                        <div class="d-flex align-items-center justify-content-between">
                                          <div
                                            class="small fw-bold text-dark text-truncate me-1"
                                            style="font-size: 12px"
                                          >
                                            {{ $desain['nama'] }}
                                          </div>
                                          <a
                                            href="{{ asset($desain['file']) }}"
                                            download
                                            class="btn btn-sm btn-link text-primary p-0"
                                            title="Unduh"
                                          >
                                            <i class="bi bi-download"></i>
                                          </a>
                                        </div>
                                      </div>
                                    </div>
                                  @endforeach
                                </div>
                              @else
                                <div class="p-3 bg-white border rounded-3 text-muted small">
                                  <em>Tidak ada lampiran desain</em>
                                </div>
                              @endif
                            @else
                              <div class="p-3 bg-white border rounded-3 text-muted small">
                                <em>Tidak ada lampiran desain</em>
                              </div>
                            @endif
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              @endforeach
            @else
              <!-- Empty State -->
              <div class="empty-state-card text-center" data-aos="fade-up">
                <div class="empty-state-icon">
                  <i class="bi bi-box2"></i>
                </div>
                <h4 class="fw-bold text-dark mb-2">Belum Ada Pesanan Berjalan</h4>
                <p class="text-muted mb-4 max-w-500 mx-auto" style="max-width: 500px">
                  Saat ini tidak ada pesanan aktif atas nama akun
                  <strong>{{ Auth::user()->username }}</strong>
                  . Wujudkan pakaian impian Anda bersama Emoka Konveksi sekarang juga!
                </p>
                <a href="/form-pemesanan" class="btn btn-primary rounded-pill px-4 py-2 fw-semibold">
                  <i class="bi bi-plus-circle me-2"></i>
                  Buat Pesanan Baru
                </a>
              </div>
            @endif
          </div>
        </div>
      </div>
    </main>

    <!-- Footer -->
    <footer id="footer" class="footer mt-5">
      <div class="footer-newsletter"></div>

      <div class="container footer-top">
        <div class="row gy-4">
          <div class="col-lg-4 col-md-6 footer-about">
            <a href="/" class="d-flex align-items-center">
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

          <div class="col-lg-2 col-md-3 footer-links"></div>
          <div class="col-lg-2 col-md-3 footer-links"></div>

          <div class="col-lg-4 col-md-12">
            <h4>Ikuti Kami</h4>
            <p>Tetap terhubung dengan kami untuk informasi dan penawaran terbaru.</p>
            <div class="social-links d-flex">
              <a href="https://www.tiktok.com/@emoka.konveksi" target="_blank"><i class="bi bi-tiktok"></i></a>
              <a href="https://www.instagram.com/emoka.konveksi/" target="_blank"><i class="bi bi-instagram"></i></a>
            </div>
          </div>
        </div>
      </div>
    </footer>

    <!-- Scroll Top Button -->
    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center">
      <i class="bi bi-arrow-up-short"></i>
    </a>

    <!-- Vendor JS Files -->
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('vendor/aos/aos.js') }}"></script>
    <script src="{{ asset('vendor/glightbox/js/glightbox.min.js') }}"></script>
    <script src="{{ asset('vendor/purecounter/purecounter_vanilla.js') }}"></script>
    <script src="{{ asset('vendor/imagesloaded/imagesloaded.pkgd.min.js') }}"></script>
    <script src="{{ asset('vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>
    <script src="{{ asset('vendor/swiper/swiper-bundle.min.js') }}"></script>

    <!-- Main JS File -->
    <script src="{{ asset('js/main.js') }}"></script>

    <!-- jQuery & SweetAlert2 -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Midtrans Snap -->
    <script
      src="{{ config('services.midtrans.is_production') ? 'https://app.midtrans.com/snap/snap.js' : 'https://app.sandbox.midtrans.com/snap/snap.js' }}"
      data-client-key="{{ config('services.midtrans.client_key') }}"
    ></script>

    <script>
      $(function () {
        function showLoadingPayment(message) {
          Swal.fire({
            title: message || 'Memuat Pembayaran...',
            text: 'Menghubungkan ke gerbang pembayaran Midtrans.',
            allowOutsideClick: false,
            didOpen: () => {
              Swal.showLoading()
            },
          })
        }

        function showPaymentError(msg) {
          Swal.fire({
            icon: 'error',
            title: 'Pembayaran Gagal!',
            text: msg || 'Terjadi kendala saat memproses transaksi pembayaran.',
            confirmButtonColor: '#4154f1',
          })
        }

        function showPaymentClosedWarning() {
          Swal.fire({
            icon: 'info',
            title: 'Jendela Pembayaran Ditutup',
            text: 'Anda menutup jendela transaksi sebelum menyelesaikannya. Anda dapat membayarnya kembali kapan saja.',
            confirmButtonColor: '#4154f1',
          })
        }

        function openMidtransPayment(token, orderId) {
          window.snap.pay(token, {
            onSuccess: function (result) {
              showLoadingPayment('Memverifikasi status pembayaran...')
              $.ajax({
                url: `/midtrans/sync/${orderId}`,
                type: 'POST',
                headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                complete: function () {
                  Swal.fire({
                    icon: 'success',
                    title: 'Pembayaran Berhasil!',
                    text: 'Transaksi Anda telah diverifikasi. Pesanan akan segera masuk ke tahap produksi.',
                    confirmButtonColor: '#4154f1',
                  }).then(() => {
                    location.reload()
                  })
                },
              })
            },
            onPending: function (result) {
              $.ajax({
                url: `/midtrans/sync/${orderId}`,
                type: 'POST',
                headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
              })
              Swal.fire({
                icon: 'info',
                title: 'Menunggu Pembayaran',
                text: 'Silakan selesaikan pembayaran sesuai instruksi Virtual Account / E-Wallet yang Anda pilih.',
                confirmButtonColor: '#4154f1',
              }).then(() => {
                location.reload()
              })
            },
            onError: function (result) {
              showPaymentError(
                result && result.status_message ? result.status_message : 'Terjadi kendala saat memproses transaksi.',
              )
            },
            onClose: function () {
              showPaymentClosedWarning()
            },
          })
        }

        function handlePayButtonClick() {
          const id = $(this).data('id')
          showLoadingPayment('Memuat token pembayaran...')

          $.get(`/midtrans/token/${id}`, function (response) {
            Swal.close()
            if (response.token) {
              openMidtransPayment(response.token, id)
            } else if (response.error) {
              Swal.fire({
                icon: 'warning',
                title: 'Tidak Dapat Memproses',
                text: response.error,
                confirmButtonColor: '#4154f1',
              })
            }
          }).fail(function (xhr) {
            Swal.close()
            let msg = 'Gagal memuat token pembayaran.'
            if (xhr.responseJSON && xhr.responseJSON.error) {
              msg = xhr.responseJSON.error
            }
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: msg,
              confirmButtonColor: '#4154f1',
            })
          })
        }

        function handleCancelOrderClick(e) {
          e.preventDefault()
          const form = $(this).closest('form')

          Swal.fire({
            title: 'Batalkan Pesanan Ini?',
            text: 'Pesanan yang dibatalkan tidak dapat dikembalikan lagi.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Batalkan!',
            cancelButtonText: 'Kembali',
          }).then((result) => {
            if (result.isConfirmed) {
              form.submit()
            }
          })
        }

        $('.btn-pay').on('click', handlePayButtonClick)
        $('.btn-batal-konfirmasi').on('click', handleCancelOrderClick)
      })
    </script>
  </body>
</html>
