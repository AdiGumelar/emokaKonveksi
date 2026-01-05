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
    <style>
      .toggle-password {
        position: absolute;
        top: 70%;
        right: 1rem;
        transform: translateY(-50%);
        cursor: pointer;
        font-size: 1.2rem;

        z-index: 2;
      }

      .position-relative .form-control {
        padding-right: 2.75rem; /* untuk memberi ruang ke icon */
      }
    </style>
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
                  <li><a href="/profile" class="active">Profil</a></li>
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

    <div class="container mb-5" style="margin-top: 120px">
      <h2 class="mb-4 text-center" style="font-weight: 700">Profil Pengguna</h2>
      <div class="row justify-content-center">
        <div class="col-md-8">
          <div class="card profile-card shadow-lg p-4 rounded">
            <div class="row">
              <!-- Kolom Kiri: Foto Profil -->
              <div class="col-md-4 text-center d-flex flex-column align-items-center">
                <img
                  id="profilePicture"
                  src="{{ Auth::user()->profile->foto ? asset('foto-profile/' . Auth::user()->profile->foto) . '?t=' . time() : asset('img/user-placeholder.png') }}"
                  class="rounded-circle img-fluid profile-img mb-3"
                  width="120"
                  alt="Profile Picture"
                />

                <button
                  type="button"
                  class="btn btn-outline-primary btn-sm"
                  onclick="document.getElementById('fileInput').click();"
                >
                  Ubah Foto
                </button>
              </div>

              <!-- Kolom Kanan: Form Profil -->
              <div class="col-md-8">
                <form id="formProfile" enctype="multipart/form-data">
                  <input type="file" id="fileInput" name="fotoProfil" class="form-control d-none" accept="image/*" />

                  <div class="mb-3">
                    <label class="form-label">Nama</label>
                    <input
                      type="text"
                      name="nama"
                      class="form-control"
                      value="{{ Auth::user()->profile->nama ?? '' }}"
                      placeholder="Masukkan nama anda"
                    />
                  </div>

                  <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input
                      type="email"
                      name="email"
                      class="form-control"
                      value="{{ Auth::user()->email ?? '' }}"
                      placeholder="Masukkan email anda"
                    />
                  </div>

                  <div class="mb-3">
                    <label class="form-label">No. Telepon / WA</label>
                    <input
                      type="text"
                      name="nomor"
                      class="form-control"
                      value="{{ Auth::user()->profile->nomor ?? '' }}"
                      placeholder="Masukkan nomor telepon anda"
                    />
                  </div>

                  <div class="mb-3">
                    <label class="form-label">Alamat</label>
                    <textarea name="alamat" class="form-control" rows="3" placeholder="Masukkan alamat">
{{ Auth::user()->profile->alamat ?? '' }}</textarea
                    >
                  </div>

                  <hr class="my-4" />
                  <h5 class="text-center">Ubah Password</h5>

                  <div class="mb-3">
                    <label class="form-label">Password Lama</label>
                    <div class="input-group">
                      <input
                        type="password"
                        name="password_lama"
                        id="passwordLama"
                        class="form-control"
                        placeholder="Masukkan password lama"
                      />
                      <span class="input-group-text bg-white" id="togglePasswordLama" style="cursor: pointer">
                        <i class="bi bi-eye-slash"></i>
                      </span>
                    </div>
                    <small id="errorPasswordLama" class="text-danger d-none"></small>
                  </div>

                  <div class="mb-3">
                    <label class="form-label">Password Baru</label>
                    <div class="input-group">
                      <input
                        type="password"
                        name="password_baru"
                        id="passwordBaru"
                        class="form-control"
                        placeholder="Masukkan password baru"
                      />
                      <span class="input-group-text bg-white" id="togglePasswordBaru" style="cursor: pointer">
                        <i class="bi bi-eye-slash"></i>
                      </span>
                    </div>
                    <small id="errorPasswordBaru" class="text-danger d-none"></small>
                  </div>

                  <div class="mb-3">
                    <label class="form-label">Konfirmasi Password Baru</label>
                    <div class="input-group">
                      <input
                        type="password"
                        name="konfirmasi_password"
                        id="konfirmasiPassword"
                        class="form-control"
                        placeholder="Ulangi password baru"
                      />
                      <span class="input-group-text bg-white" id="toggleKonfirmasiPassword" style="cursor: pointer">
                        <i class="bi bi-eye-slash"></i>
                      </span>
                    </div>
                    <small id="errorKonfirmasiPassword" class="text-danger d-none"></small>
                  </div>

                  <button type="submit" class="btn btn-primary w-100">Simpan Perubahan</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

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

    <!-- Vendor JS Files -->
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('vendor/php-email-form/validate.js') }}"></script>
    <script src="{{ asset('vendor/aos/aos.js') }}"></script>
    <script src="{{ asset('vendor/glightbox/js/glightbox.min.js') }}"></script>
    <script src="{{ asset('vendor/purecounter/purecounter_vanilla.js') }}"></script>
    <script src="{{ asset('vendor/imagesloaded/imagesloaded.pkgd.min.js') }}"></script>
    <script src="{{ asset('vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>
    <script src="{{ asset('vendor/swiper/swiper-bundle.min.js') }}"></script>

    <!-- Main JS File -->
    <script src="{{ asset('js/main.js') }}"></script>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
      // Preview foto profil saat dipilih
      $('#fileInput').on('change', function () {
        const file = this.files[0]
        if (file) {
          const reader = new FileReader()
          reader.onload = function (e) {
            $('#profilePicture').attr('src', e.target.result)
          }
          reader.readAsDataURL(file)
        }
      })

      // Simpan data profil dengan AJAX (tanpa reload)
      $(document).ready(function () {
        $('#formProfile').on('submit', function (e) {
          e.preventDefault() // Cegah submit biasa

          const formData = new FormData(this)

          Swal.fire({
            title: 'Menyimpan...',
            text: 'Mohon tunggu, data Anda sedang diproses.',
            allowOutsideClick: false,
            didOpen: () => {
              Swal.showLoading()
            },
          })

          // CSRF setup
          $.ajaxSetup({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
          })

          $.ajax({
            url: '/profile',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
              Swal.close()

              // Reset semua error
              $('#errorPasswordLama, #errorPasswordBaru, #errorKonfirmasiPassword').addClass('d-none').text('')

              if (response.success) {
                Swal.fire('Berhasil!', response.message, 'success')
              } else {
                if (response.field === 'password_lama') {
                  $('#errorPasswordLama').removeClass('d-none').text(response.message)
                } else if (response.field === 'konfirmasi_password') {
                  $('#errorKonfirmasiPassword').removeClass('d-none').text(response.message)
                } else {
                  Swal.fire('Gagal!', response.message, 'error')
                }
              }
            },
          })
        })
      })
    </script>
    <script>
      function togglePasswordIcon(groupId, inputId) {
        $(`#${groupId}`).click(function () {
          const input = $(`#${inputId}`)
          const icon = $(this).find('i')
          const type = input.attr('type') === 'password' ? 'text' : 'password'
          input.attr('type', type)
          icon.toggleClass('bi-eye bi-eye-slash')
        })
      }

      togglePasswordIcon('togglePasswordLama', 'passwordLama')
      togglePasswordIcon('togglePasswordBaru', 'passwordBaru')
      togglePasswordIcon('toggleKonfirmasiPassword', 'konfirmasiPassword')
    </script>
  </body>
</html>
