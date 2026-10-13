<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login - Emoka Konveksi</title>
    <meta name="description" content="Masuk ke akun Emoka Konveksi Anda untuk memesan dan melacak pesanan pakaian." />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <!-- Favicons -->
    <link href="{{ asset('/img/logo2.png') }}" rel="icon" />
    <link href="{{ asset('/img/logo2.png') }}" rel="apple-touch-icon" />

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect" />
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&family=Poppins:wght@400;500;600;700&family=Roboto:wght@300;400;500;700&display=swap"
      rel="stylesheet"
    />

    <!-- Vendor CSS -->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
      crossorigin="anonymous"
    />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" />

    <link rel="stylesheet" href="{{ asset('css/loginPage.css') }}" />
  </head>
  <body>
    <div class="bg-blob-1"></div>
    <div class="bg-blob-2"></div>

    <div class="auth-card-container">
      <div class="auth-card">
        <div class="row g-0">
          <!-- Kolom Kiri: Form Login -->
          <div class="col-lg-6 form-side order-2 order-lg-1">
            <a href="/" class="back-home-btn">
              <i class="bi bi-arrow-left"></i> Kembali ke Beranda
            </a>

            <div class="brand-header">
              <img src="{{ asset('/img/logo.png') }}" alt="Emoka Logo" />
              <h2 class="brand-title"><span>Emoka</span> Konveksi</h2>
            </div>

            <h1 class="form-headline">Selamat Datang Kembali 👋</h1>
            <p class="form-subheadline">Masukkan email dan password untuk masuk ke akun Anda.</p>

            <form onsubmit="event.preventDefault(); login();" id="loginForm">
              <!-- Field Email -->
              <div class="form-group-modern">
                <label for="email" class="form-label-modern">Alamat Email</label>
                <div class="input-wrapper">
                  <i class="bi bi-envelope input-icon-lead"></i>
                  <input
                    type="email"
                    class="form-control-modern"
                    id="email"
                    placeholder="nama@email.com"
                    autocomplete="email"
                    required
                  />
                </div>
                <small id="emailError" class="error-feedback"></small>
              </div>

              <!-- Field Password -->
              <div class="form-group-modern">
                <div class="form-label-modern">
                  <span>Password</span>
                  <a href="/lupa-password" class="text-decoration-none small text-primary fw-semibold">
                    Lupa Password?
                  </a>
                </div>
                <div class="input-wrapper">
                  <i class="bi bi-shield-lock input-icon-lead"></i>
                  <input
                    type="password"
                    class="form-control-modern"
                    id="password"
                    placeholder="Masukkan password Anda"
                    autocomplete="current-password"
                    required
                  />
                  <button type="button" class="password-toggle-btn" id="togglePassword" title="Lihat password">
                    <i class="bi bi-eye-slash"></i>
                  </button>
                </div>
                <small id="passwordError" class="error-feedback"></small>
              </div>

              <!-- Submit Button -->
              <button class="btn-submit-modern mt-3" type="submit" id="btnLogin">
                <i class="bi bi-box-arrow-in-right"></i> Masuk Sekarang
              </button>

              <p class="auth-footer-text">
                Belum punya akun? <a href="/registrasi">Daftar Akun Baru</a>
              </p>
            </form>
          </div>

          <!-- Kolom Kanan: Visual Branding Side -->
          <div class="col-lg-6 visual-side order-1 order-lg-2">
            <div>
              <span class="visual-badge">
                <i class="bi bi-patch-check-fill"></i> Portal Resmi Emoka
              </span>
              <h2 class="visual-headline">Menjahit Setiap Kreativitas Pakaian Impian Anda.</h2>
              <p class="visual-description">
                Solusi konveksi pakaian terlengkap di Klaten untuk instansi, perusahaan, komunitas, dan brand fashion dengan standar kualitas tinggi.
              </p>

              <div class="feature-card-list">
                <div class="feature-mini-card">
                  <div class="feature-icon-circle">
                    <i class="bi bi-gem"></i>
                  </div>
                  <div class="feature-text">Kualitas Bahan & Sablon Standar Distro</div>
                </div>

                <div class="feature-mini-card">
                  <div class="feature-icon-circle">
                    <i class="bi bi-stopwatch"></i>
                  </div>
                  <div class="feature-text">Pengerjaan Tepat Waktu & Bergaransi</div>
                </div>

                <div class="feature-mini-card">
                  <div class="feature-icon-circle">
                    <i class="bi bi-shield-check"></i>
                  </div>
                  <div class="feature-text">Kemudahan Tracking & Pembayaran Online</div>
                </div>
              </div>
            </div>

            <div class="visual-footer d-flex align-items-center justify-content-between">
              <span>&copy; {{ date('Y') }} Emoka Konveksi.</span>
              <span>Klaten, Jawa Tengah</span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Scripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
      function login() {
        let email = $('#email').val().trim();
        let password = $('#password').val().trim();

        // Reset error messages
        $('#emailError').text('');
        $('#passwordError').text('');

        // Validasi email
        if (email === '') {
          $('#emailError').html('<i class="bi bi-exclamation-circle me-1"></i>Email wajib diisi!');
          $('#email').focus();
          return;
        }

        // Validasi password
        if (password === '') {
          $('#passwordError').html('<i class="bi bi-exclamation-circle me-1"></i>Password wajib diisi!');
          $('#password').focus();
          return;
        }

        // SweetAlert Loading
        Swal.fire({
          title: 'Memproses Masuk...',
          text: 'Mohon tunggu, sedang memverifikasi akun Anda.',
          allowOutsideClick: false,
          didOpen: () => {
            Swal.showLoading();
          },
        });

        // CSRF setup
        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
          },
        });

        $.ajax({
          type: 'POST',
          url: '/loginUser',
          data: { email_give: email, pw_give: password },
          success: function (response) {
            if (response.result === 'success') {
              Swal.fire({
                title: 'Login Berhasil!',
                text: 'Selamat datang kembali di Emoka Konveksi.',
                icon: 'success',
                confirmButtonText: 'Lanjutkan',
                confirmButtonColor: '#4154f1',
              }).then((result) => {
                if (result.isConfirmed) {
                  window.location.replace('/');
                }
              });
            } else if (response.result === 'dashboard') {
              window.location.replace('/admin/dashboard');
            } else {
              Swal.fire({
                title: 'Gagal Masuk',
                text: response.msg || 'Email atau password yang Anda masukkan salah.',
                icon: 'error',
                confirmButtonText: 'Coba Lagi',
                confirmButtonColor: '#4154f1',
              });
            }
          },
          error: function () {
            Swal.fire({
              title: 'Terjadi Kesalahan',
              text: 'Tidak dapat menghubungi server. Coba beberapa saat lagi.',
              icon: 'error',
              confirmButtonText: 'OK',
              confirmButtonColor: '#4154f1',
            });
          },
        });
      }

      $(document).ready(function () {
        // Toggle password visibility
        $('#togglePassword').click(function () {
          let passwordField = $('#password');
          let type = passwordField.attr('type') === 'password' ? 'text' : 'password';
          passwordField.attr('type', type);
          $(this).find('i').toggleClass('bi-eye bi-eye-slash');
        });

        // Clear error saat user mengetik
        $('#email').on('input', function () {
          $('#emailError').text('');
        });
        $('#password').on('input', function () {
          $('#passwordError').text('');
        });
      });
    </script>
  </body>
</html>
