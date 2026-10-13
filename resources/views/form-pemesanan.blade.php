<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Form Pemesanan - Emoka Konveksi</title>
    <meta name="description" content="Form Pemesanan Pakaian Kustom Emoka Konveksi Klaten" />
    <meta name="keywords" content="konveksi, pemesanan pakaian, kaos, kemeja, pdh, pdl, jaket, emoka konveksi" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <!-- Favicons -->
    <link href="{{ asset('img/logo2.png') }}" rel="icon" />
    <link href="{{ asset('img/logo2.png') }}" rel="apple-touch-icon" />

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

    <link href="{{ asset('css/form-pemesanan.css') }}" rel="stylesheet" />
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
            <li><a href="/form-pemesanan" class="active">Pesan</a></li>

            @auth
              <!-- User Dropdown -->
              <li class="dropdown">
                <a href="#">
                  <span>{{ Auth::user()->username }}</span>
                  <i class="bi bi-chevron-down toggle-dropdown"></i>
                </a>
                <ul>
                  <li><a href="/profile">Profil</a></li>
                  <li><a href="/tracking-pesanan">Pesanan</a></li>
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
          <i class="bi bi-bag-check-fill"></i>
          Layanan Pemesanan Kustom
        </span>
        <h1 class="order-hero-title">Form Pemesanan Pakaian</h1>
        <p class="order-hero-subtitle">
          Isi formulir di bawah ini dengan lengkap untuk memulai pesanan pakaian kustom Anda. Tim profesional Emoka
          Konveksi siap mewujudkan pakaian berkualitas terbaik.
        </p>
        <div class="breadcrumb-custom">
          <a href="/">
            <i class="bi bi-house-door me-1"></i>
            Beranda
          </a>
          <i class="bi bi-chevron-right small"></i>
          <span>Form Pemesanan</span>
        </div>
      </div>
    </div>

    <!-- Main Form Section -->
    <main class="container my-5">
      <form id="formPemesanan" action="/buat-pesanan" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row g-4">
          <!-- Kolom Kiri: Data Pemesan & Spesifikasi Pakaian -->
          <div class="col-lg-7">
            <!-- Card 1: Data Pemesan -->
            <div class="form-section-card" data-aos="fade-up" data-aos-delay="100">
              <div class="card-header-styled">
                <div class="card-icon-box">
                  <i class="bi bi-person-lines-fill"></i>
                </div>
                <div>
                  <h4 class="card-title-text">Informasi Pemesan</h4>
                  <p class="card-subtitle-text">Data kontak dan alamat untuk keperluan pengiriman pesanan</p>
                </div>
              </div>

              <div class="row g-3">
                <div class="col-md-6">
                  <label for="nama" class="form-label form-label-custom">
                    <i class="bi bi-person text-primary"></i>
                    Nama Lengkap
                    <span class="text-danger">*</span>
                  </label>
                  <div class="input-group input-group-custom">
                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                    <input
                      type="text"
                      class="form-control form-control-custom validasi"
                      id="nama"
                      name="nama"
                      placeholder="Masukkan nama lengkap"
                      value="{{ Auth::user()->profile->nama ?? Auth::user()->username }}"
                    />
                  </div>
                  <small class="text-danger error-msg"></small>
                </div>

                <div class="col-md-6">
                  <label for="email" class="form-label form-label-custom">
                    <i class="bi bi-envelope text-primary"></i>
                    Alamat Email
                    <span class="text-danger">*</span>
                  </label>
                  <div class="input-group input-group-custom">
                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                    <input
                      type="email"
                      class="form-control form-control-custom validasi"
                      id="email"
                      name="email"
                      placeholder="contoh@domain.com"
                      value="{{ Auth::user()->email ?? '' }}"
                    />
                  </div>
                  <small class="text-danger error-msg"></small>
                </div>

                <div class="col-12">
                  <label for="nomor" class="form-label form-label-custom">
                    <i class="bi bi-whatsapp text-success"></i>
                    No. Telepon / WhatsApp
                    <span class="text-danger">*</span>
                  </label>
                  <div class="input-group input-group-custom">
                    <span class="input-group-text"><i class="bi bi-telephone"></i></span>
                    <input
                      type="text"
                      class="form-control form-control-custom validasi"
                      id="nomor"
                      name="nomor"
                      placeholder="Contoh: 081234567890"
                      value="{{ Auth::user()->profile->nomor ?? '' }}"
                    />
                  </div>
                  <small class="text-danger error-msg"></small>
                </div>

                <div class="col-12">
                  <label for="alamat" class="form-label form-label-custom">
                    <i class="bi bi-geo-alt text-primary"></i>
                    Alamat Pengiriman Lengkap
                    <span class="text-danger">*</span>
                  </label>
                  <div class="input-group input-group-custom">
                    <span class="input-group-text"><i class="bi bi-geo-alt"></i></span>
                    <textarea
                      class="form-control form-control-custom validasi"
                      id="alamat"
                      name="alamat"
                      rows="3"
                      placeholder="Tuliskan jalan, nomor rumah, RT/RW, kecamatan, kota/kabupaten, dan kode pos"
                    >
{{ Auth::user()->profile->alamat ?? '' }}</textarea
                    >
                  </div>
                  <small class="text-danger error-msg"></small>
                </div>
              </div>
            </div>

            <!-- Card 2: Spesifikasi Pakaian & Detail Ukuran -->
            <div class="form-section-card" data-aos="fade-up" data-aos-delay="150">
              <div class="card-header-styled">
                <div class="card-icon-box">
                  <i class="bi bi-scissors"></i>
                </div>
                <div>
                  <h4 class="card-title-text">Detail & Spesifikasi Pakaian</h4>
                  <p class="card-subtitle-text">Tentukan kategori pakaian, jumlah pesanan, dan rincian ukuran</p>
                </div>
              </div>

              <div class="mb-3">
                <label for="jenis_pakaian" class="form-label form-label-custom">
                  <i class="bi bi-tag text-primary"></i>
                  Jenis Pakaian
                  <span class="text-danger">*</span>
                </label>
                <div class="input-group input-group-custom">
                  <span class="input-group-text"><i class="bi bi-tag"></i></span>
                  <select class="form-select form-select-custom validasi" id="jenis_pakaian" name="jenis_pakaian">
                    <option value="" disabled selected>Pilih jenis pakaian yang ingin diproduksi</option>
                    <option value="Kaos">Kaos (T-Shirt / Raglan)</option>
                    <option value="Kemeja">Kemeja Formal / Kasual</option>
                    <option value="PDH">PDH (Pakaian Dinas Harian)</option>
                    <option value="PDL">PDL (Pakaian Dinas Lapangan)</option>
                    <option value="Jaket">Jaket (Bomber, Parka, Windbreaker)</option>
                    <option value="Hoodie">Hoodie / Zipper</option>
                    <option value="Rompi">Rompi Komunitas / Proyek</option>
                    <option value="Celana">Celana</option>
                    <option value="Topi">Topi</option>
                    <option value="Seragam">Seragam Sekolah / Kantor</option>
                    <option value="Lainnya">Lainnya</option>
                  </select>
                </div>
                <small class="text-danger error-msg"></small>
              </div>

              <div class="mb-3">
                <label for="deskripsi" class="form-label form-label-custom">
                  <i class="bi bi-card-text text-primary"></i>
                  Deskripsi & Spesifikasi Pesanan
                  <span class="text-danger">*</span>
                </label>
                <textarea
                  class="form-control form-control-custom validasi"
                  id="deskripsi"
                  name="deskripsi"
                  rows="3"
                  placeholder="Contoh: Warna kain navy, bahan combed 24s, sablon DTF ukuran A3 di bagian punggung, bordir nama di dada kanan, kerah model polo bergaris putih."
                ></textarea>
                <small class="text-danger error-msg"></small>
              </div>

              <!-- Pilihan Jumlah / Mode Rincian Ukuran -->
              <div class="p-3 rounded-3 bg-light border mb-3">
                <div class="d-flex align-items-center justify-content-between mb-2">
                  <label class="form-label-custom mb-0">
                    <i class="bi bi-calculator text-primary"></i>
                    Penentuan Jumlah & Ukuran
                  </label>
                  <button type="button" id="toggle-detail" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                    <i class="bi bi-plus-circle me-1"></i>
                    + Tambah Rincian Ukuran (S, M, L, dll)
                  </button>
                </div>

                <!-- Input Jumlah Total Saja -->
                <div id="jumlah-total-wrapper" class="mt-2">
                  <div class="row align-items-center">
                    <div class="col-sm-6">
                      <div class="input-group input-group-custom">
                        <span class="input-group-text"><i class="bi bi-hash"></i></span>
                        <input
                          type="number"
                          id="jumlah-pakaian"
                          name="jumlah_pakaian"
                          class="form-control form-control-custom"
                          placeholder="Masukkan total pcs"
                          min="1"
                        />
                        <span class="input-group-text bg-white">Pcs</span>
                      </div>
                      <small class="text-danger error-msg"></small>
                    </div>
                    <div class="col-sm-6 mt-2 mt-sm-0">
                      <small class="text-muted d-block">
                        <i class="bi bi-info-circle me-1"></i>
                        Masukkan total jumlah pakaian, atau klik tombol di atas jika ingin membagi per ukuran spesifik.
                      </small>
                    </div>
                  </div>
                </div>

                <!-- Wrapper Rincian Ukuran & Jumlah Per Potong -->
                <div id="detail-ukuran-wrapper" class="d-none mt-3 pt-3 border-top">
                  <div class="row g-2">
                    <div class="col-md-3 col-6">
                      <label class="form-label-custom small mb-1">Ukuran</label>
                      <select id="input-ukuran" name="ukuran" class="form-select form-select-custom">
                        <option value="" disabled selected>Pilih Ukuran</option>
                        <option value="SK">SK</option>
                        <option value="S">S</option>
                        <option value="M">M</option>
                        <option value="L">L</option>
                        <option value="XL">XL</option>
                        <option value="XXL">XXL (+Rp 5.000)</option>
                        <option value="XXXL">XXXL (+Rp 5.000)</option>
                        <option value="XXXXL">XXXXL (+Rp 5.000)</option>
                      </select>
                    </div>

                    <div class="col-md-3 col-6">
                      <label class="form-label-custom small mb-1">Lengan</label>
                      <select id="input-lengan" name="lengan" class="form-select form-select-custom">
                        <option value="" disabled selected>Pilih Lengan</option>
                        <option value="Pendek">Pendek</option>
                        <option value="Panjang">Panjang</option>
                      </select>
                    </div>

                    <div class="col-md-3 col-6">
                      <label class="form-label-custom small mb-1">Jumlah (Pcs)</label>
                      <input
                        type="number"
                        id="input-jumlah"
                        class="form-control form-control-custom"
                        placeholder="Qty"
                        min="1"
                      />
                    </div>

                    <div class="col-md-3 col-6 d-flex align-items-end">
                      <button type="button" class="btn btn-primary w-100 py-2 rounded-3" id="btn-tambah-ukuran">
                        <i class="bi bi-plus-lg me-1"></i>
                        Tambah
                      </button>
                    </div>
                  </div>

                  <div class="mt-3">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                      <span class="form-label-custom small mb-0">Rincian Ukuran Ditambahkan:</span>
                      <span id="total-pcs-detail" class="badge bg-primary rounded-pill px-2 py-1">0 pcs</span>
                    </div>
                    <div id="list-ukuran">
                      <!-- Chip ukuran akan di-render di sini -->
                    </div>
                  </div>
                  <!-- Field hidden untuk dikirim ke backend -->
                  <input type="hidden" name="ukuran_json" id="ukuran_json" />
                </div>
              </div>

              <!-- Box Estimasi Harga -->
              <div class="price-estimate-card">
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                  <div class="d-flex align-items-center gap-3">
                    <div class="estimate-icon-circle">
                      <i class="bi bi-cash-stack"></i>
                    </div>
                    <div>
                      <span class="text-uppercase tracking-wider fw-bold small text-muted d-block">
                        Estimasi Biaya Dasar
                      </span>
                      <div class="d-flex align-items-baseline gap-2">
                        <span id="estimasi-harga" class="price-estimate-amount">Rp -</span>
                        <span class="badge bg-primary-subtle text-primary rounded-pill small">Estimasi</span>
                      </div>
                    </div>
                  </div>
                  <div class="text-end">
                    <span
                      class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-3 py-2"
                    >
                      <i class="bi bi-check-circle-fill me-1"></i>
                      Konsultasi Gratis
                    </span>
                  </div>
                </div>
                <div class="mt-2 pt-2 border-top border-light-subtle">
                  <small class="text-muted d-flex align-items-center gap-1">
                    <i class="bi bi-info-circle-fill text-primary"></i>
                    <em>
                      Estimasi harga otomatis. Biaya final akan dikonfirmasi oleh admin setelah peninjauan detail bahan
                      dan desain.
                    </em>
                  </small>
                </div>
                <input type="hidden" id="input_estimasi_harga" name="estimasi_harga" />
              </div>
            </div>
          </div>

          <!-- Kolom Kanan: Panduan Ukuran, File Berkas & Desain -->
          <div class="col-lg-5">
            <!-- Card 3: Panduan Ukuran & Berkas Nama -->
            <div class="form-section-card" data-aos="fade-up" data-aos-delay="200">
              <div class="card-header-styled">
                <div class="card-icon-box">
                  <i class="bi bi-rulers"></i>
                </div>
                <div>
                  <h4 class="card-title-text">Panduan Ukuran & Berkas</h4>
                  <p class="card-subtitle-text">Lihat standar size chart dan unggah data nama/ukuran anggota</p>
                </div>
              </div>

              <!-- Size Chart Showcase -->
              <label class="form-label-custom mb-2">
                <i class="bi bi-zoom-in text-primary"></i>
                Size Chart Emoka (Klik untuk perbesar)
              </label>
              <div class="row g-2 mb-3">
                <div class="col-4">
                  <div class="sizechart-item-card">
                    <div class="sizechart-img-container">
                      <img src="{{ asset('/img/sizechart/kaos.jpg') }}" alt="Size Chart Kaos" />
                      <a
                        href="{{ asset('/img/sizechart/kaos.jpg') }}"
                        class="glightbox sizechart-zoom-overlay"
                        data-gallery="sizechart-gallery"
                        data-title="Panduan Ukuran Kaos"
                      >
                        <i class="bi bi-arrows-fullscreen"></i>
                      </a>
                    </div>
                    <div class="sizechart-footer-label">Kaos</div>
                  </div>
                </div>

                <div class="col-4">
                  <div class="sizechart-item-card">
                    <div class="sizechart-img-container">
                      <img src="{{ asset('/img/sizechart/kemeja.jpg') }}" alt="Size Chart Kemeja" />
                      <a
                        href="{{ asset('/img/sizechart/kemeja.jpg') }}"
                        class="glightbox sizechart-zoom-overlay"
                        data-gallery="sizechart-gallery"
                        data-title="Panduan Ukuran Kemeja & PDH"
                      >
                        <i class="bi bi-arrows-fullscreen"></i>
                      </a>
                    </div>
                    <div class="sizechart-footer-label">Kemeja / PDH</div>
                  </div>
                </div>

                <div class="col-4">
                  <div class="sizechart-item-card">
                    <div class="sizechart-img-container">
                      <img src="{{ asset('/img/sizechart/jaket.jpg') }}" alt="Size Chart Jaket" />
                      <a
                        href="{{ asset('/img/sizechart/jaket.jpg') }}"
                        class="glightbox sizechart-zoom-overlay"
                        data-gallery="sizechart-gallery"
                        data-title="Panduan Ukuran Jaket & Hoodie"
                      >
                        <i class="bi bi-arrows-fullscreen"></i>
                      </a>
                    </div>
                    <div class="sizechart-footer-label">Jaket</div>
                  </div>
                </div>
              </div>

              <!-- Upload File Data Ukuran / Nama Anggota -->
              <div class="mb-2">
                <label for="fileUkuran" class="form-label form-label-custom">
                  <i class="bi bi-file-earmark-spreadsheet text-primary"></i>
                  Upload Data Nama / Ukuran Pakaian
                  <span class="text-danger">*</span>
                </label>
                <div class="dropzone-box" id="dropzone-fileUkuran">
                  <input
                    type="file"
                    class="file-input-overlay validasi"
                    id="fileUkuran"
                    name="fileUkuran"
                    accept=".pdf, .xlsx, .xls, .csv"
                  />
                  <div id="fileUkuran-placeholder">
                    <div class="dropzone-icon">
                      <i class="bi bi-cloud-arrow-up-fill"></i>
                    </div>
                    <p class="dropzone-title mb-1">Pilih berkas atau seret ke sini</p>
                    <p class="dropzone-subtitle text-muted mb-2">Format: PDF, XLSX, XLS, CSV (Maks 10MB)</p>
                    <span class="btn btn-sm btn-outline-primary rounded-pill px-3">
                      <i class="bi bi-folder2-open me-1"></i>
                      Telusuri File
                    </span>
                  </div>

                  <div id="fileUkuran-preview" class="file-preview-card d-none">
                    <div class="d-flex align-items-center justify-content-between p-3">
                      <div class="d-flex align-items-center gap-3 text-start">
                        <i class="bi bi-file-earmark-check-fill text-success fs-2"></i>
                        <div>
                          <div
                            id="fileUkuran-preview-name"
                            class="fw-bold text-dark text-truncate"
                            style="max-width: 200px"
                          ></div>
                          <div id="fileUkuran-preview-size" class="text-muted small"></div>
                        </div>
                      </div>
                      <button
                        type="button"
                        id="fileUkuran-remove"
                        class="btn btn-sm btn-outline-danger rounded-circle p-1"
                        title="Hapus file"
                      >
                        <i class="bi bi-x fs-5"></i>
                      </button>
                    </div>
                  </div>
                </div>
                <small class="text-danger error-msg"></small>
              </div>
            </div>

            <!-- Card 4: Upload Desain & Logo Mockup -->
            <div class="form-section-card" data-aos="fade-up" data-aos-delay="250">
              <div class="card-header-styled">
                <div class="card-icon-box">
                  <i class="bi bi-palette-fill"></i>
                </div>
                <div>
                  <h4 class="card-title-text">Desain & Mockup</h4>
                  <p class="card-subtitle-text">Lampirkan file logo, gambar referensi, atau mockup pakaian</p>
                </div>
              </div>

              <div id="design-form" class="p-3 rounded-3 bg-light border mb-3">
                <div class="mb-2">
                  <label for="design-name" class="form-label-custom small mb-1">
                    <i class="bi bi-fonts text-primary"></i>
                    Nama / Posisi Desain
                  </label>
                  <input
                    type="text"
                    id="design-name"
                    class="form-control form-control-custom"
                    placeholder="Contoh: Logo Dada Kiri, Sablon Punggung"
                  />
                </div>
                <div class="mb-2">
                  <label for="design-file" class="form-label-custom small mb-1">
                    <i class="bi bi-image text-primary"></i>
                    File Desain / Logo
                  </label>
                  <input
                    type="file"
                    id="design-file"
                    class="form-control form-control-custom"
                    accept="image/*,.pdf,.ai,.psd,.cdr"
                  />
                </div>
                <div class="d-flex flex-column mt-2">
                  <button type="button" id="add-design" class="btn btn-primary rounded-3 py-2">
                    <i class="bi bi-plus-lg me-1"></i>
                    + Tambah ke Daftar Desain
                  </button>
                  <small id="design-error" class="text-danger mt-1 d-none"></small>
                </div>
              </div>

              <!-- Daftar Desain yang Ditambahkan -->
              <div class="d-flex align-items-center justify-content-between mb-2">
                <h6 class="fw-bold text-dark mb-0">Daftar Desain Terlampir:</h6>
                <span id="design-count-badge" class="badge bg-secondary-subtle text-secondary rounded-pill">
                  0 Desain
                </span>
              </div>
              <div id="design-list" class="mb-2">
                <!-- Daftar desain akan muncul di sini -->
              </div>

              <!-- Hidden input untuk server -->
              <div id="design-hidden-inputs"></div>
            </div>
          </div>
        </div>

        <!-- Card 5: Konfirmasi & Kirim Pesanan -->
        <div class="form-section-card mt-3 text-center py-4 px-3 px-md-5" data-aos="fade-up" data-aos-delay="300">
          <h4 class="fw-bold text-dark mb-2">Siap Mewujudkan Pakaian Impian Anda?</h4>
          <p class="text-muted mb-4 max-w-600 mx-auto">
            Pastikan data dan berkas yang Anda masukkan telah sesuai. Tim Emoka Konveksi akan segera memeriksa pesanan
            Anda dan menghubungi via WhatsApp untuk konfirmasi detail produksi.
          </p>

          <div class="d-flex justify-content-center flex-wrap gap-2 gap-md-3 mb-4">
            <div class="feature-trust-badge">
              <i class="bi bi-shield-check text-primary fs-5"></i>
              <span>Bahan Berkualitas Tinggi</span>
            </div>
            <div class="feature-trust-badge">
              <i class="bi bi-clock-history text-primary fs-5"></i>
              <span>Pengerjaan Tepat Waktu</span>
            </div>
            <div class="feature-trust-badge">
              <i class="bi bi-patch-check-fill text-primary fs-5"></i>
              <span>Jahitan & Sablon Rapi</span>
            </div>
          </div>

          <div>
            <button type="submit" id="btnSubmitOrder" class="btn btn-submit-order btn-pilihDesain">
              <i class="bi bi-send-fill me-2"></i>
              Kirim Pesanan Sekarang
            </button>
          </div>
          <p class="text-muted small mt-3 mb-0">
            <i class="bi bi-lock-fill text-secondary me-1"></i>
            Data Anda tersimpan aman dan terenkripsi.
          </p>
        </div>
      </form>
    </main>

    <!-- Footer -->
    <footer id="footer" class="footer">
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

    <script>
      $(function () {
        let designs = [] // Global untuk desain
        let daftarUkuran = [] // Global untuk ukuran

        // Harga dasar per jenis pakaian
        const hargaDasarMap = {
          Kaos: 60000,
          Kemeja: 60000,
          PDH: 120000,
          PDL: 120000,
          Jaket: 120000,
          Hoodie: 120000,
          Rompi: 110000,
          Celana: 60000,
          Topi: 60000,
          Seragam: 60000,
          Lainnya: 10000,
        }

        const ukuranMahal = ['XXL', 'XXXL', 'XXXXL']

        // Hapus pesan error visual
        function clearError(input) {
          const $input = $(input)
          $input.removeClass('is-invalid')
          $input
            .closest('.mb-3, .col-md-6, .col-12, .mb-2, .dropzone-box, .input-group-custom')
            .find('.error-msg')
            .text('')
        }

        // Tampilkan pesan error visual
        function showError(input, message) {
          const $input = $(input)
          $input.addClass('is-invalid')

          let $container = $input.closest('.mb-3, .col-md-6, .col-12, .mb-2')
          let $error = $container.find('.error-msg').first()

          if ($error.length > 0) {
            $error.html('<i class="bi bi-exclamation-circle me-1"></i>' + message)
          } else {
            $input.after(
              `<small class="text-danger error-msg"><i class="bi bi-exclamation-circle me-1"></i>${message}</small>`,
            )
          }
        }

        function formatDesignName(name) {
          return name.trim().replace(/\w\S*/g, function (txt) {
            return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase()
          })
        }

        function showDesignError(message) {
          $('#design-error')
            .removeClass('d-none')
            .html('<i class="bi bi-exclamation-circle me-1"></i>' + message)
        }

        function hideDesignError() {
          $('#design-error').addClass('d-none').text('')
        }

        function resetDesignInputs() {
          $('#design-name').val('')
          $('#design-file').val('')
        }

        // Render daftar desain
        function renderDesignList() {
          const $designList = $('#design-list')
          $designList.empty()
          $('#design-count-badge').text(designs.length + ' Desain')

          if (designs.length === 0) {
            $designList.html(`
              <div class="text-center py-3 border border-dashed rounded-3 bg-light text-muted small">
                <i class="bi bi-image fs-4 d-block mb-1 text-secondary"></i>
                Belum ada file desain yang ditambahkan.
              </div>
            `)
            return
          }

          designs.forEach((design, index) => {
            const fileExt = design.file.name.split('.').pop().toUpperCase()
            $designList.append(`
              <div class="design-item-card d-flex align-items-center justify-content-between mb-2 shadow-sm" data-index="${index}">
                <div class="d-flex align-items-center gap-3">
                  <span class="design-file-badge">${fileExt}</span>
                  <div>
                    <div class="fw-bold text-dark" style="font-size: 14px;">${design.name}</div>
                    <small class="text-muted"><i class="bi bi-paperclip me-1"></i>${design.file.name}</small>
                  </div>
                </div>
                <button type="button" class="btn btn-sm btn-outline-danger btn-hapus-desain rounded-pill px-3" title="Hapus Desain">
                  <i class="bi bi-trash3 me-1"></i> Hapus
                </button>
              </div>
            `)
          })
        }

        // Loading SweetAlert
        function showLoading(message) {
          Swal.fire({
            title: message,
            text: 'Mohon tunggu, berkas dan data pesanan Anda sedang dikirim.',
            allowOutsideClick: false,
            didOpen: () => {
              Swal.showLoading()
            },
          })
        }

        // Validasi real-time per field
        function handleFieldValidation() {
          const id = $(this).attr('id')
          const value = ($(this).val() || '').trim()

          if (id === 'email') {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/
            if (emailRegex.test(value)) {
              clearError(this)
            }
          } else if (id === 'nama' && /^[a-zA-Z\s]+$/.test(value)) {
            clearError(this)
          } else if (id === 'nomor' && /^\d+$/.test(value)) {
            clearError(this)
          } else if ($(this).attr('type') === 'file' && this.files.length > 0) {
            clearError(this)
          } else if (value !== '') {
            clearError(this)
          }
        }

        // Tambah Desain
        function handleAddDesign() {
          const name = formatDesignName($('#design-name').val() || '')
          const fileInput = $('#design-file')[0]
          const file = fileInput.files ? fileInput.files[0] : null

          if (!name || !file) {
            showDesignError('Silakan isi nama desain dan pilih file pendukung.')
            return
          }

          hideDesignError()
          designs.push({ name: name, file: file })
          renderDesignList()
          resetDesignInputs()
        }

        // Hapus Desain
        function handleRemoveDesign() {
          const index = $(this).closest('[data-index]').data('index')
          designs.splice(index, 1)
          renderDesignList()
        }

        // Render Rincian Ukuran
        function renderUkuran() {
          let html = ''

          if (daftarUkuran.length === 0) {
            html = `
              <div class="text-center py-3 border border-dashed rounded-3 bg-white text-muted small">
                <i class="bi bi-rulers me-1"></i> Belum ada ukuran yang ditambahkan ke rincian
              </div>
            `
            $('#total-pcs-detail').text('0 pcs')
          } else {
            let totalPcs = 0
            html = '<div class="d-flex flex-wrap gap-2">'
            $.each(daftarUkuran, function (i, item) {
              const jml = parseInt(item.jumlah) || 0
              totalPcs += jml
              html += `
                <div class="ukuran-chip shadow-sm">
                  <span class="badge bg-primary rounded-pill px-2 py-1">${item.ukuran}</span>
                  <span class="text-dark small fw-medium">${item.lengan}</span>
                  <span class="badge bg-secondary-subtle text-secondary rounded-pill">${item.jumlah} pcs</span>
                  <button type="button" class="btn btn-sm btn-link text-danger p-0 ms-1 btn-hapus-ukuran" data-index="${i}" title="Hapus">
                    <i class="bi bi-x-circle-fill"></i>
                  </button>
                </div>
              `
            })
            html += '</div>'
            $('#total-pcs-detail').text(totalPcs + ' pcs')
          }

          $('#list-ukuran').html(html)
          $('#ukuran_json').val(JSON.stringify(daftarUkuran))

          hitungEstimasiHarga()
        }

        // Tambah Ukuran
        function handleAddUkuran() {
          const ukuran = ($('#input-ukuran').val() || '').trim()
          const jumlah = ($('#input-jumlah').val() || '').trim()
          const lengan = ($('#input-lengan').val() || '').trim()

          if (ukuran === '' || jumlah === '' || parseInt(jumlah) < 1 || lengan === '') {
            Swal.fire({
              icon: 'warning',
              title: 'Input Tidak Lengkap',
              text: 'Silakan pilih ukuran, jenis lengan, dan jumlah pakaian yang valid!',
              confirmButtonColor: '#4154f1',
            })
            return
          }

          const exist = daftarUkuran.find((item) => item.ukuran === ukuran && item.lengan === lengan)
          if (exist) {
            Swal.fire({
              icon: 'error',
              title: 'Sudah Ditambahkan',
              text: `Ukuran ${ukuran} dengan lengan ${lengan} sudah ada di daftar.`,
              confirmButtonColor: '#4154f1',
            })
            return
          }

          daftarUkuran.push({ ukuran: ukuran, jumlah: jumlah, lengan: lengan })
          $('#input-ukuran').val('')
          $('#input-jumlah').val('')
          $('#input-lengan').val('')
          renderUkuran()
        }

        // Hapus Ukuran
        function handleRemoveUkuran() {
          const index = $(this).closest('[data-index]').data('index')
          daftarUkuran.splice(index, 1)
          renderUkuran()
        }

        // Kalkulasi Estimasi Harga Otomatis
        function hitungEstimasiHarga() {
          const jenis = $('#jenis_pakaian').val()
          if (!jenis || !hargaDasarMap[jenis] || jenis === 'Lainnya') {
            $('#estimasi-harga').text('Rp -')
            return
          }

          const hargaDasar = hargaDasarMap[jenis]
          let total = 0

          if (!$('#detail-ukuran-wrapper').hasClass('d-none') && daftarUkuran.length > 0) {
            daftarUkuran.forEach((item) => {
              const jml = parseInt(item.jumlah) || 0
              const tambahan = ukuranMahal.includes(item.ukuran) ? 5000 : 0
              const hargaSatuan = hargaDasar + tambahan
              total += hargaSatuan * jml
            })
          } else {
            const jml = parseInt($('#jumlah-pakaian').val()) || 0
            total = hargaDasar * jml
          }

          $('#estimasi-harga').text(total > 0 ? 'Rp ' + total.toLocaleString('id-ID') : 'Rp -')
          $('#input_estimasi_harga').val(total)
        }

        // Toggle Rincian Ukuran
        function toggleDetailUkuran() {
          const $detail = $('#detail-ukuran-wrapper')
          const $jumlah = $('#jumlah-pakaian')
          const isHidden = $detail.hasClass('d-none')

          if (isHidden) {
            $detail.removeClass('d-none')
            $jumlah.val('').prop('disabled', true)
            $('#jumlah-total-wrapper').addClass('opacity-50')
            $('#toggle-detail')
              .html('<i class="bi bi-dash-circle me-1"></i> Gunakan Jumlah Total Saja')
              .removeClass('btn-outline-primary')
              .addClass('btn-outline-secondary')
          } else {
            $detail.addClass('d-none')
            $jumlah.prop('disabled', false)
            $('#jumlah-total-wrapper').removeClass('opacity-50')
            $('#toggle-detail')
              .html('<i class="bi bi-plus-circle me-1"></i> + Tambah Rincian Ukuran (S, M, L, dll)')
              .removeClass('btn-outline-secondary')
              .addClass('btn-outline-primary')
          }
          hitungEstimasiHarga()
        }

        // Event listener berkas ukuran preview
        $('#fileUkuran').on('change', function () {
          const file = this.files ? this.files[0] : null
          if (file) {
            clearError(this)
            const sizeKB = (file.size / 1024).toFixed(1)
            const sizeStr = sizeKB > 1024 ? (sizeKB / 1024).toFixed(2) + ' MB' : sizeKB + ' KB'
            $('#fileUkuran-preview-name').text(file.name)
            $('#fileUkuran-preview-size').text(sizeStr)
            $('#fileUkuran-placeholder').addClass('d-none')
            $('#fileUkuran-preview').removeClass('d-none')
          } else {
            $('#fileUkuran-placeholder').removeClass('d-none')
            $('#fileUkuran-preview').addClass('d-none')
          }
        })

        $('#fileUkuran-remove').on('click', function (e) {
          e.stopPropagation()
          $('#fileUkuran').val('')
          $('#fileUkuran-placeholder').removeClass('d-none')
          $('#fileUkuran-preview').addClass('d-none')
        })

        // Inisialisasi awal
        renderDesignList()
        renderUkuran()

        // Event listeners
        $('#toggle-detail').on('click', toggleDetailUkuran)
        $('#add-design').on('click', handleAddDesign)
        $('#design-list').on('click', '.btn-hapus-desain', handleRemoveDesign)
        $('#btn-tambah-ukuran').on('click', handleAddUkuran)
        $('#list-ukuran').on('click', '.btn-hapus-ukuran', handleRemoveUkuran)
        $('#jenis_pakaian').on('change', hitungEstimasiHarga)
        $('#jumlah-pakaian').on('input change', hitungEstimasiHarga)
        $(document).on('input change', 'input, textarea, select', handleFieldValidation)

        // Submit Form Pemesanan
        $('#formPemesanan').on('submit', function (e) {
          e.preventDefault()
          let isValid = true

          // Validasi form fields required
          $('.validasi, #formPemesanan textarea').each(function () {
            const value = ($(this).val() || '').trim()
            if (value === '') {
              isValid = false
              showError(this, 'Kolom ini wajib diisi.')
            } else {
              clearError(this)
            }
          })

          // Validasi Nama (hanya huruf dan spasi)
          const nama = ($('#nama').val() || '').trim()
          if (nama !== '' && !/^[a-zA-Z\s]+$/.test(nama)) {
            isValid = false
            showError('#nama', 'Nama hanya boleh berisi huruf dan spasi.')
          }

          // Validasi Nomor Telepon (hanya angka)
          const nomor = ($('#nomor').val() || '').trim()
          if (nomor !== '' && !/^\d+$/.test(nomor)) {
            isValid = false
            showError('#nomor', 'Nomor telepon hanya boleh berisi angka.')
          }

          // Validasi Email
          const email = ($('#email').val() || '').trim()
          const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/
          if (email === '') {
            isValid = false
            showError('#email', 'Alamat email wajib diisi.')
          } else if (!emailRegex.test(email)) {
            isValid = false
            showError('#email', 'Format alamat email tidak valid.')
          } else {
            clearError('#email')
          }

          // Validasi Jenis Pakaian
          const jenisPakaian = $('#jenis_pakaian').val()
          if (!jenisPakaian) {
            isValid = false
            showError('#jenis_pakaian', 'Silakan pilih jenis pakaian.')
          } else {
            clearError('#jenis_pakaian')
          }

          // Validasi Jumlah / Detail Ukuran
          const isDetailActive = !$('#detail-ukuran-wrapper').hasClass('d-none')
          if (isDetailActive) {
            if (daftarUkuran.length === 0) {
              isValid = false
              Swal.fire({
                icon: 'warning',
                title: 'Rincian Ukuran Masih Kosong',
                text: 'Silakan tambahkan minimal satu ukuran pakaian atau matikan opsi rincian ukuran.',
                confirmButtonColor: '#4154f1',
              })
            }
          } else {
            const jml = parseInt($('#jumlah-pakaian').val()) || 0
            if (jml <= 0) {
              isValid = false
              showError('#jumlah-pakaian', 'Masukkan jumlah pakaian minimal 1 pcs.')
            } else {
              clearError('#jumlah-pakaian')
            }
          }

          // Validasi File Ukuran
          const fileUkuranInput = $('#fileUkuran')[0]
          const fileUkuran = fileUkuranInput.files ? fileUkuranInput.files[0] : null
          if (!fileUkuran) {
            isValid = false
            showError('#fileUkuran', 'Berkas ukuran / nama pakaian wajib diunggah.')
          }

          if (!isValid) {
            const $firstError = $('.is-invalid:first')
            if ($firstError.length > 0) {
              $('html, body').animate(
                {
                  scrollTop: $firstError.offset().top - 140,
                },
                400,
              )
            }
            return
          }

          // Siapkan FormData
          const form = document.getElementById('formPemesanan')
          const formData = new FormData(form)

          // Masukkan daftar desain
          designs.forEach((design, index) => {
            formData.append(`designs[${index}][name]`, design.name)
            formData.append(`designs[${index}][file]`, design.file)
          })

          showLoading('Mengirim Formulir Pesanan...')

          $.ajaxSetup({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
          })

          $.ajax({
            url: '/buat-pesanan',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
              Swal.close()
              if (response.success) {
                Swal.fire({
                  icon: 'success',
                  title: 'Pesanan Berhasil Dibuat!',
                  text: response.message || 'Pesanan Anda telah diterima. Kami akan segera menghubungi WhatsApp Anda.',
                  confirmButtonColor: '#4154f1',
                  confirmButtonText: 'Lihat Status Pesanan',
                  showCancelButton: true,
                  cancelButtonText: 'Tutup',
                  cancelButtonColor: '#6c757d',
                }).then((result) => {
                  if (result.isConfirmed) {
                    window.location.href = '/tracking-pesanan'
                  } else {
                    form.reset()
                    $('.error-msg').text('')
                    $('.is-invalid').removeClass('is-invalid')
                    designs = []
                    daftarUkuran = []
                    hideDesignError()
                    renderDesignList()
                    renderUkuran()
                    $('#fileUkuran-placeholder').removeClass('d-none')
                    $('#fileUkuran-preview').addClass('d-none')
                    $('#estimasi-harga').text('Rp -')
                  }
                })
              } else {
                Swal.fire({
                  icon: 'error',
                  title: 'Pemesanan Gagal',
                  text: response.message || 'Terjadi kesalahan saat memproses pesanan.',
                  confirmButtonColor: '#4154f1',
                })
              }
            },
            error: function (xhr) {
              Swal.close()
              let msg = 'Terjadi kesalahan pada server saat mengirim data!'
              if (xhr.responseJSON && xhr.responseJSON.message) {
                msg = xhr.responseJSON.message
              }
              Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: msg,
                confirmButtonColor: '#4154f1',
              })
            },
          })
        })
      })
    </script>
  </body>
</html>
