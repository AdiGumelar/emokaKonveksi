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
    <link href="{{ asset('/img/logo2.png') }}" rel="icon" />
    <link href="{{ asset('/img/logo2.png') }}" rel="apple-touch-icon" />

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect" />
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Nunito:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
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
  </head>

  <body class="index-page">
    <header id="header" class="header d-flex align-items-center fixed-top">
      <div class="container-fluid container-xl position-relative d-flex align-items-center">
        <a href="index.html" class="logo d-flex align-items-center me-auto">
          <!-- Uncomment the line below if you also wish to use an image logo -->
          <img src="{{ asset('/img/logo.png') }}" alt="" />
          <h1 class="sitename d-block">Emoka</h1>
        </a>

        <nav id="navmenu" class="navmenu">
          <ul>
            <li>
              <a href="#hero" class="active">
                Beranda
                <br />
              </a>
            </li>
            <li><a href="#about">Tentang Kami</a></li>
            <li><a href="#services">Layanan</a></li>
            <li><a href="#portfolio">Produk</a></li>

            <li><a href="#contact">Kontak</a></li>

            @auth
              <!-- Jika User Sudah Login, Tampilkan Username -->
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
              <!-- Jika Belum Login, Tampilkan Tombol Login -->
              <a class="btn-getstarted ms-3" href="{{ route('login') }}">Login</a>
            @endauth
          </ul>
          <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
        </nav>
      </div>
    </header>

    <main class="main">
      <!-- Hero Section -->
      <section id="hero" class="hero section">
        <div class="container">
          <div class="row gy-4">
            <div class="col-lg-6 order-2 order-lg-1 d-flex flex-column justify-content-center">
              <h1 data-aos="fade-up">Kami Menawarkan Jasa Konveksi Berkualitas Tinggi</h1>
              <p data-aos="fade-up" data-aos-delay="100">
                Kami konveksi yang siap membantu mewujudkan desain pakaian impian Anda.
              </p>
              <div class="d-flex flex-column flex-md-row" data-aos="fade-up" data-aos-delay="200">
                <a href="/form-pemesanan" class="btn-get-started">
                  Pesan Sekarang
                  <i class="bi bi-arrow-right"></i>
                </a>
                <a
                  href="https://wa.me/62882003441009"
                  target="_blank"
                  class="btn-whatsapp d-flex align-items-center justify-content-center ms-0 ms-md-4 mt-4 mt-md-0"
                >
                  <i class="bi bi-whatsapp"></i>
                  <span>Konstultasi Gratis</span>
                </a>
              </div>
            </div>
            <div class="col-lg-6 order-1 order-lg-2 hero-img mt-5 mt-md-0" data-aos="zoom-out">
              <img src="{{ asset('/img/hero-img.jpg') }}" class="img-fluid animated" alt="" />
            </div>
          </div>
        </div>
      </section>

      <!-- /Hero Section -->

      <!-- About Section -->
      <section id="about" class="about section">
        <div class="container" data-aos="fade-up">
          <div class="row gx-0">
            <div
              class="col-lg-6 d-flex flex-column justify-content-center order-2"
              data-aos="fade-up"
              data-aos-delay="200"
            >
              <div class="content">
                <h3>Tentang Kami</h3>
                <h2>Konveksi Handal, Gaya Total!</h2>
                <p>
                  Kami adalah mitra produksi terpercaya yang siap membantu Anda memenuhi kebutuhan seragam untuk
                  berbagai keperluan, mulai dari instansi pemerintah, perusahaan, brand, hingga komunitas. Dengan
                  pengalaman dan keahlian yang kami miliki, kami memastikan setiap produk yang kami hasilkan memenuhi
                  standar kualitas tertinggi dan dapat memperkuat identitas serta citra merek Anda.
                </p>
              </div>
            </div>

            <div class="col-lg-6 d-flex align-items-center order-1" data-aos="zoom-out" data-aos-delay="200">
              <img src="{{ asset('/img/about.jpg') }}" class="img-fluid" alt="" />
            </div>
          </div>
        </div>
      </section>
      <!-- /About Section -->

      <!-- Values Section -->
      <section id="values" class="values section">
        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
          <h2>Keunggulan Kami</h2>
          <p>
            Komitmen Kami untuk Anda
            <br />
          </p>
        </div>
        <!-- End Section Title -->

        <div class="container">
          <div class="row gy-4">
            <div class="col-lg-3" data-aos="fade-up" data-aos-delay="100">
              <div class="card">
                <i class="bi bi-tools" style="font-size: 120px"></i>
                <h3>Kustomisasi Pesanan</h3>
                <p>
                  Pelanggan dapat menyesuaikan desain, bahan, dan ukuran sesuai kebutuhan untuk hasil yang lebih
                  personal.
                </p>
              </div>
            </div>
            <!-- End Card Item -->

            <div class="col-lg-3" data-aos="fade-up" data-aos-delay="200">
              <div class="card">
                <i class="bi bi-palette" style="font-size: 120px"></i>
                <h3>Gratis Desain</h3>
                <p>
                  Layanan desain gratis untuk membantu menciptakan pakaian sesuai keinginan pelanggan tanpa biaya
                  tambahan.
                </p>
              </div>
            </div>
            <!-- End Card Item -->

            <div class="col-lg-3" data-aos="fade-up" data-aos-delay="300">
              <div class="card">
                <i class="bi bi-person-check" style="font-size: 120px"></i>
                <h3>Pelayanan Konsultasi</h3>
                <p>
                  Kami siap memberikan konsultasi gratis untuk membantu pelanggan dalam memilih bahan dan desain
                  terbaik.
                </p>
              </div>
            </div>

            <div class="col-lg-3" data-aos="fade-up" data-aos-delay="300">
              <div class="card">
                <i class="bi bi-box-seam" style="font-size: 120px"></i>
                <h3>Gratis Ongkir</h3>
                <p>
                  Pengiriman gratis ke seluruh Indonesia untuk memastikan pelanggan menerima pesanan tanpa biaya
                  tambahan.
                </p>
              </div>
            </div>
            <!-- End Card Item -->
          </div>
        </div>
      </section>
      <!-- /Values Section -->

      <!-- Stats Section -->
      <section id="stats" class="stats section">
        <div class="container" data-aos="fade-up" data-aos-delay="100">
          <div class="row gy-4">
            <div class="col-lg-3 col-md-6">
              <div class="stats-item d-flex align-items-center w-100 h-100">
                <i class="bi bi-person-workspace color-blue flex-shrink-0"></i>
                <div>
                  <span
                    data-purecounter-start="0"
                    data-purecounter-end="232"
                    data-purecounter-duration="1"
                    class="purecounter"
                  ></span>
                  <p>Tim Produksi Aktif</p>
                </div>
              </div>
            </div>
            <!-- End Stats Item -->

            <div class="col-lg-3 col-md-6">
              <div class="stats-item d-flex align-items-center w-100 h-100">
                <i class="bi bi-person-hearts color-orange flex-shrink-0" style="color: #ee6c20"></i>
                <div>
                  <span
                    data-purecounter-start="0"
                    data-purecounter-end="{{ 121 + $totalPelanggan }}"
                    data-purecounter-duration="1"
                    class="purecounter"
                  ></span>
                  <p>Pelanggan Puas</p>
                </div>
              </div>
            </div>
            <!-- End Stats Item -->

            <div class="col-lg-3 col-md-6">
              <div class="stats-item d-flex align-items-center w-100 h-100">
                <i class="bi bi-tags color-green flex-shrink-0" style="color: #15be56"></i>
                <div>
                  <span
                    data-purecounter-start="0"
                    data-purecounter-end="{{ 300 + $totalPesananSelesai }}"
                    data-purecounter-duration="1"
                    class="purecounter"
                  ></span>
                  <p>Produk Terjual</p>
                </div>
              </div>
            </div>
            <!-- End Stats Item -->

            <div class="col-lg-3 col-md-6">
              <div class="stats-item d-flex align-items-center w-100 h-100">
                <i class="bi bi-stopwatch color-pink flex-shrink-0" style="color: #bb0852"></i>
                <div>
                  <span
                    data-purecounter-start="0"
                    data-purecounter-end="15"
                    data-purecounter-duration="1"
                    class="purecounter"
                  ></span>
                  <p>Waktu Produksi</p>
                </div>
              </div>
            </div>
            <!-- End Stats Item -->
          </div>
        </div>
      </section>
      <!-- /Stats Section -->

      <!-- Features Section -->
      <section id="features" class="features section">
        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
          <h2>Pemesanan</h2>
          <p>
            Langkah Pemesanan
            <br />
          </p>
        </div>
        <!-- End Section Title -->

        <div class="container">
          <div class="row gy-5">
            <div class="col-xl-5" data-aos="zoom-out" data-aos-delay="100">
              <img src="{{ asset('/img/features.png') }}" class="img-fluid" alt="" />
            </div>

            <div class="col-xl-7 d-flex">
              <div class="row align-self-center gy-4">
                <div class="col-md-6" data-aos="fade-up" data-aos-delay="200">
                  <div class="feature-box d-flex align-items-center">
                    <i class="bi bi-1-square"></i>
                    <h3>Konsultasi & Diskusi</h3>
                  </div>
                </div>
                <!-- End Feature Item -->

                <div class="col-md-6" data-aos="fade-up" data-aos-delay="300">
                  <div class="feature-box d-flex align-items-center">
                    <i class="bi bi-2-square"></i>
                    <h3>Pengisian Form</h3>
                  </div>
                </div>
                <!-- End Feature Item -->

                <div class="col-md-6" data-aos="fade-up" data-aos-delay="400">
                  <div class="feature-box d-flex align-items-center">
                    <i class="bi bi-3-square"></i>
                    <h3>Pembayaran DP dan Persetujuan Surat Perjanjian Kerja</h3>
                  </div>
                </div>
                <!-- End Feature Item -->

                <div class="col-md-6" data-aos="fade-up" data-aos-delay="500">
                  <div class="feature-box d-flex align-items-center">
                    <i class="bi bi-4-square"></i>
                    <h3>Proses Produksi</h3>
                  </div>
                </div>
                <!-- End Feature Item -->

                <div class="col-md-6" data-aos="fade-up" data-aos-delay="600">
                  <div class="feature-box d-flex align-items-center">
                    <i class="bi bi-5-square"></i>
                    <h3>Pemeriksaan & Finishing</h3>
                  </div>
                </div>
                <!-- End Feature Item -->

                <div class="col-md-6" data-aos="fade-up" data-aos-delay="700">
                  <div class="feature-box d-flex align-items-center">
                    <i class="bi bi-6-square"></i>
                    <h3>Pengiriman</h3>
                  </div>
                </div>
                <!-- End Feature Item -->
              </div>
            </div>
          </div>
        </div>
      </section>
      <!-- /Features Section -->

      <!-- Sizechart Section -->
      <section>
        <div class="container section-title" data-aos="fade-up">
          <h2>Sizechart</h2>
        </div>

        <div class="container">
          <div class="row">
            <div class="col-12 col-md-6 col-lg">
              <img
                src="{{ asset('/img/sizechart/jaket.jpg') }}"
                alt=""
                class="img-fluid"
                data-aos="zoom-in"
                data-aos-delay="100"
              />
            </div>
            <div class="col-12 col-md-6 col-lg">
              <img
                src="{{ asset('/img/sizechart/kaos.jpg') }}"
                alt=""
                class="img-fluid"
                data-aos="zoom-in"
                data-aos-delay="200"
              />
            </div>
            <div class="col-12 col-md-6 offset-md-3 col-lg offset-lg-0">
              <img
                src="{{ asset('/img/sizechart/kemeja.jpg') }}"
                alt=""
                class="img-fluid"
                data-aos="zoom-in"
                data-aos-delay="300"
              />
            </div>
          </div>
        </div>
      </section>

      <!-- Services Section -->
      <section id="services" class="services section">
        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
          <h2>Layanan</h2>
          <p>
            Lihat berbagai produk yang dapat kami buat untuk Anda.
            <br />
          </p>
        </div>
        <!-- End Section Title -->

        <div class="container">
          <div class="row gy-4">
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
              <div class="service-item item-cyan position-relative">
                <img src="{{ asset('/img/layanan/kaos.png') }}" alt="" style="width: 60%" />
                <h3>Kaos</h3>
                <p>
                  XS-3XL | Min.Order 12 pcs
                  <br />
                  Harga Mulai Rp60.000
                </p>
              </div>
            </div>
            <!-- End Service Item -->

            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
              <div class="service-item item-orange position-relative">
                <img src="{{ asset('/img/layanan/kemeja.png') }}" alt="" style="width: 60%" />
                <h3>Kemeja</h3>
                <p>
                  XS-3XL | Min.Order 12 pcs
                  <br />
                  Harga Mulai Rp120.000
                </p>
              </div>
            </div>
            <!-- End Service Item -->

            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
              <div class="service-item item-teal position-relative">
                <img src="{{ asset('/img/layanan/jersey.png') }}" alt="" style="width: 60%" />
                <h3>Jersey</h3>
                <p>
                  XS-3XL | Min.Order 12 pcs
                  <br />
                  Harga Mulai Rp60.000
                </p>
              </div>
            </div>
            <!-- End Service Item -->

            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="400">
              <div class="service-item item-red position-relative">
                <img src="{{ asset('/img/layanan/hoodie.png') }}" alt="" style="width: 60%" />
                <h3>Hoodie</h3>
                <p>
                  XS-3XL | Min.Order 12 pcs
                  <br />
                  Harga Mulai Rp120.000
                </p>
              </div>
            </div>
            <!-- End Service Item -->

            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="500">
              <div class="service-item item-indigo position-relative">
                <img src="{{ asset('/img/layanan/sticker.png') }}" alt="" style="width: 80%" />
                <h3>Sticker</h3>
                <p>
                  Requested Size | Min.Order 12 pcs
                  <br />
                  Harga Mulai Rp120.000
                </p>
              </div>
            </div>
            <!-- End Service Item -->

            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="600">
              <div class="service-item item-pink position-relative">
                <img src="{{ asset('/img/layanan/almamater.png') }}" alt="" style="width: 60%" />
                <h3>Almamater</h3>
                <p>
                  XS-3XL | Min.Order 12 pcs
                  <br />
                  Harga Mulai Rp120.000
                </p>
              </div>
            </div>
            <!-- End Service Item -->
          </div>
        </div>
      </section>

      <!-- Faq Section -->
      <section id="faq" class="faq section">
        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
          <h2>F.A.Q</h2>
          <p>Paling Sering Ditanyakan</p>
        </div>
        <!-- End Section Title -->

        <div class="container">
          <div class="row">
            <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
              <div class="faq-container">
                <div class="faq-item faq-active">
                  <h3>Apa jenis layanan yang ditawarkan oleh Emoka Konveksi?</h3>
                  <div class="faq-content">
                    <p>
                      Emoka Konveksi menyediakan layanan pembuatan berbagai jenis pakaian, seperti kaos, jaket, seragam,
                      dan lainnya sesuai kebutuhan pelanggan. Anda dapat melihatnya pada laman web bagian produk atau
                      Anda dapat mengunduh katalog dari Emoka Konveksi.
                    </p>
                  </div>
                  <i class="faq-toggle bi bi-chevron-right"></i>
                </div>
                <!-- End Faq item-->

                <div class="faq-item">
                  <h3>Berapa lama waktu produksi untuk pesanan pakaian?</h3>
                  <div class="faq-content">
                    <p>
                      Waktu produksi bervariasi tergantung pada jenis dan jumlah pesanan. Kami akan memberikan perkiraan
                      waktu produksi saat konfirmasi pemesanan.
                    </p>
                  </div>
                  <i class="faq-toggle bi bi-chevron-right"></i>
                </div>
                <!-- End Faq item-->

                <div class="faq-item">
                  <h3>Apakah Emoka Konveksi menyediakan layanan desain custom?</h3>
                  <div class="faq-content">
                    <p>
                      Ya, kami menyediakan layanan desain custom. Pelanggan dapat memberikan desain mereka atau bekerja
                      sama dengan tim desain kami untuk menciptakan produk yang diinginkan.
                    </p>
                  </div>
                  <i class="faq-toggle bi bi-chevron-right"></i>
                </div>
                <!-- End Faq item-->
              </div>
            </div>
            <!-- End Faq Column-->

            <div class="col-lg-6" data-aos="fade-up" data-aos-delay="200">
              <div class="faq-container">
                <div class="faq-item">
                  <h3>Bagaimana dengan biaya pengiriman dan pengemasan?</h3>
                  <div class="faq-content">
                    <p>
                      Biaya pengiriman dan pengemasan akan disesuaikan dengan lokasi pengiriman dan jumlah pesanan. Kami
                      berusaha memberikan tarif yang kompetitif dan efisien. Konsultasikan kepada admin kami untuk
                      mendapatkan fasilitas biaya pengiriman.
                    </p>
                  </div>
                  <i class="faq-toggle bi bi-chevron-right"></i>
                </div>
                <!-- End Faq item-->

                <div class="faq-item">
                  <h3>Apakah mungkin untuk melihat sampel produk sebelum memesan?</h3>
                  <div class="faq-content">
                    <p>
                      Ya, kami dapat menyediakan sampel produk sebelum produksi massal. Kami dapat membantu setelah
                      pelanggan mengonfirmasi pesanan untuk menilai kualitas dan desain produk.
                    </p>
                  </div>
                  <i class="faq-toggle bi bi-chevron-right"></i>
                </div>
                <!-- End Faq item-->

                <!-- End Faq item-->
              </div>
            </div>
            <!-- End Faq Column-->
          </div>
        </div>
      </section>
      <!-- /Faq Section -->

      <!-- Portfolio Section -->
      <section id="portfolio" class="portfolio section">
        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
          <h2>Produk Emoka</h2>
          <p>Lihat Produk Buatan Kami</p>
        </div>
        <!-- End Section Title -->

        <div class="container">
          <div class="isotope-layout" data-default-filter="*" data-layout="masonry" data-sort="original-order">
            <ul class="portfolio-filters isotope-filters" data-aos="fade-up" data-aos-delay="100">
              <!-- <li data-filter="*" class="filter-active">All</li>
              <li data-filter=".filter-app">App</li>
              <li data-filter=".filter-product">Product</li>
              <li data-filter=".filter-branding">Branding</li>
              <li data-filter=".filter-books">Books</li> -->
            </ul>
            <!-- End Portfolio Filters -->

            <div class="row gy-4 isotope-container" data-aos="fade-up" data-aos-delay="200">
              @foreach ($produk_list as $produk)
                <div class="col-lg-4 col-md-6 portfolio-item isotope-item filter-app">
                  <div class="portfolio-content h-100">
                    <img src="{{ asset('produkEmoka/' . $produk->fotoCrop) }}" class="img-fluid" alt="" />
                    <div class="portfolio-info">
                      <h4>{{ $produk->nama }}</h4>
                      <p>{{ $produk->keterangan }}</p>
                      <a
                        href="{{ asset('produkEmoka/' . $produk->foto) }}"
                        title="{{ $produk->nama }}"
                        data-gallery="portfolio-gallery"
                        class="glightbox preview-link"
                      >
                        <i class="bi bi-zoom-in"></i>
                      </a>
                    </div>
                  </div>
                </div>
              @endforeach

              <!-- End Portfolio Item -->
            </div>
            <!-- End Portfolio Container -->
          </div>
        </div>
      </section>
      <!-- /Portfolio Section -->

      <!-- Clients Section -->
      <section id="clients" class="clients section">
        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
          <h2>Klien</h2>
          <p>
            Kami bekerja dengan klien terbaik
            <br />
          </p>
        </div>
        <!-- End Section Title -->

        <div class="container" data-aos="fade-up" data-aos-delay="100">
          <div class="swiper init-swiper">
            <script type="application/json" class="swiper-config">
              {
                "loop": true,
                "speed": 600,
                "autoplay": {
                  "delay": 5000
                },
                "slidesPerView": "auto",
                "pagination": {
                  "el": ".swiper-pagination",
                  "type": "bullets",
                  "clickable": true
                },
                "breakpoints": {
                  "320": {
                    "slidesPerView": 2,
                    "spaceBetween": 40
                  },
                  "480": {
                    "slidesPerView": 3,
                    "spaceBetween": 60
                  },
                  "640": {
                    "slidesPerView": 4,
                    "spaceBetween": 80
                  },
                  "992": {
                    "slidesPerView": 6,
                    "spaceBetween": 120
                  }
                }
              }
            </script>
            <div class="swiper-wrapper align-items-center">
              <div class="swiper-slide">
                <img src="{{ asset('/img/clients/logoITB.png') }}" class="img-fluid" alt="" />
              </div>
              <div class="swiper-slide">
                <img src="{{ asset('/img/clients/logoUPNJ.png') }}" class="img-fluid" alt="" />
              </div>
              <div class="swiper-slide">
                <img src="{{ asset('/img/clients/logoUPNY.png') }}" class="img-fluid" alt="" />
              </div>
              <div class="swiper-slide">
                <img src="{{ asset('/img/clients/logoITS.png') }}" class="img-fluid" alt="" />
              </div>
              <div class="swiper-slide">
                <img src="{{ asset('/img/clients/logoUNS.png') }}" class="img-fluid" alt="" />
              </div>
              <div class="swiper-slide">
                <img src="{{ asset('/img/clients/logoUGM.png') }}" class="img-fluid" alt="" />
              </div>
              <div class="swiper-slide">
                <img src="{{ asset('/img/clients/logoUNDIP.png') }}" class="img-fluid" alt="" />
              </div>
              <div class="swiper-slide">
                <img src="{{ asset('/img/clients/logoPoltekkes.png') }}" class="img-fluid" alt="" />
              </div>
            </div>
            <div class="swiper-pagination"></div>
          </div>
        </div>
      </section>
      <!-- /Clients Section -->

      <!-- Contact Section -->
      <section id="contact" class="contact section">
        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
          <h2>Kontak</h2>
          <p>Kontak Kami</p>
        </div>
        <!-- End Section Title -->

        <div class="container mb-3" data-aos="fade-up" data-aos-delay="100">
          <div class="row">
            <div class="col-12" style="height: 350px">
              <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3953.880585445067!2d110.6024658598166!3d-7.695962581150814!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7a43b2346763e9%3A0x6807c1eb844464c9!2sTaman!5e0!3m2!1sid!2sid!4v1741439098897!5m2!1sid!2sid"
                class="w-100 h-100 border-0"
                allowfullscreen=""
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"
              ></iframe>
            </div>
          </div>
        </div>

        <div class="container" data-aos="fade-up" data-aos-delay="200">
          <div class="row gy-4">
            <div class="col-lg-6">
              <div class="row gy-4">
                <div class="col-md-6">
                  <div class="info-item" data-aos="fade" data-aos-delay="300">
                    <i class="bi bi-geo-alt"></i>
                    <h3>Alamat</h3>
                    <p>Taman, Sungkur, Semangkak, Kec. Klaten Tengah Kabupaten Klaten, Jawa Tengah 57415</p>
                  </div>
                </div>
                <!-- End Info Item -->

                <div class="col-md-6">
                  <div class="info-item" data-aos="fade" data-aos-delay="400">
                    <i class="bi bi-telephone"></i>
                    <h3>Whatsapp</h3>
                    <p>+62 882-0034-41009</p>
                  </div>
                </div>
                <!-- End Info Item -->

                <div class="col-md-6">
                  <div class="info-item" data-aos="fade" data-aos-delay="500">
                    <i class="bi bi-envelope"></i>
                    <h3>Email</h3>
                    <p>emoka.konveksi@gmail.com</p>
                  </div>
                </div>
                <!-- End Info Item -->

                <div class="col-md-6">
                  <div class="info-item" data-aos="fade" data-aos-delay="600">
                    <i class="bi bi-clock"></i>
                    <h3>Jam Operasional</h3>
                    <p>Senin - Sabtu</p>
                    <p>08.00 - 16.00</p>
                  </div>
                </div>
                <!-- End Info Item -->
              </div>
            </div>

            <div class="col-lg-6">
              <form id="contactForm" class="php-email-form" data-aos="fade-up" data-aos-delay="200">
                <div class="row gy-4">
                  <div class="col-md-6">
                    <input type="text" name="name" id="name" class="form-control" placeholder="Nama" required />
                  </div>
                  <div class="col-md-6">
                    <input type="email" name="email" id="email" class="form-control" placeholder="Email" required />
                  </div>
                  <div class="col-12">
                    <input type="text" name="subject" id="subject" class="form-control" placeholder="Subjek" required />
                  </div>
                  <div class="col-12">
                    <textarea
                      name="message"
                      id="message"
                      class="form-control"
                      rows="6"
                      placeholder="Pesan"
                      required
                    ></textarea>
                  </div>
                  <div class="col-12 text-center">
                    <button type="submit">Kirim Pesan</button>
                  </div>
                </div>
              </form>
            </div>
            <!-- End Contact Form -->
          </div>
        </div>
      </section>
      <!-- /Contact Section -->
    </main>

    <footer id="footer" class="footer">
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

    <!-- Scroll Top -->
    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center">
      <i class="bi bi-arrow-up-short"></i>
    </a>

    <!-- Vendor JS Files -->
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('vendor/aos/aos.js') }}"></script>
    <script src="{{ asset('vendor/glightbox/js/glightbox.min.js') }}"></script>
    <script src="{{ asset('vendor/purecounter/purecounter_vanilla.js') }}"></script>
    <script src="{{ asset('vendor/imagesloaded/imagesloaded.pkgd.min.js') }}"></script>
    <script src="{{ asset('vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>
    <script src="{{ asset('vendor/swiper/swiper-bundle.min.js') }}"></script>

    <!-- Main JS File -->
    <script src="{{ asset('js/main.js') }}"></script>

    <script>
      $(document).ready(function () {
        // CSRF setup
        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
          },
        })

        $('#contactForm').submit(function (e) {
          e.preventDefault()
          const data = {
            name: $('#name').val(),
            email: $('#email').val(),
            subject: $('#subject').val(),
            message: $('#message').val(),
          }

          // SweetAlert loading
          Swal.fire({
            title: 'Mengirim pesan...',
            text: 'Mohon tunggu sebentar.',
            allowOutsideClick: false,
            didOpen: () => {
              Swal.showLoading()
            },
          })

          $.ajax({
            url: '/kirim-pesan',
            method: 'POST',
            data: data,
            success: function (res) {
              Swal.close()
              if (res.success) {
                Swal.fire('Terkirim!', res.message, 'success')
                $('#contactForm')[0].reset()
              } else {
                Swal.fire('Gagal', res.message, 'error')
              }
            },
            error: function () {
              Swal.fire('Gagal', 'Terjadi kesalahan saat mengirim pesan.', 'error')
            },
          })
        })
      })
    </script>
  </body>
</html>
