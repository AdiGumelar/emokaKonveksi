<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Daftar Akun - Emoka Konveksi</title>
    <meta name="description" content="Daftar akun baru di Emoka Konveksi untuk memesan pakaian kustom dan memantau status pesanan." />
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

    <link rel="stylesheet" href="{{ asset('css/regisPage.css') }}" />
  </head>
  <body>
    <div class="bg-blob-1"></div>
    <div class="bg-blob-2"></div>

    <div class="auth-card-container">
      <div class="auth-card">
        <div class="row g-0">
          <!-- Kolom Kiri: Form Registrasi -->
          <div class="col-lg-6 form-side order-2 order-lg-1">
            <a href="/" class="back-home-btn">
              <i class="bi bi-arrow-left"></i> Kembali ke Beranda
            </a>

            <div class="brand-header">
              <img src="{{ asset('/img/logo.png') }}" alt="Emoka Logo" />
              <h2 class="brand-title"><span>Emoka</span> Konveksi</h2>
            </div>

            <h1 class="form-headline">Buat Akun Baru 🚀</h1>
            <p class="form-subheadline">Daftar sekarang untuk kemudahan pemesanan pakaian dan tracking pesanan.</p>

            <form onsubmit="event.preventDefault(); regis();" id="registerForm">
              <!-- Field Username -->
              <div class="form-group-modern">
                <label for="username" class="form-label-modern">Username</label>
                <div class="input-wrapper">
                  <i class="bi bi-person input-icon-lead"></i>
                  <input
                    type="text"
                    class="form-control-modern"
                    id="username"
                    placeholder="Minimal 4 karakter"
                    autocomplete="username"
                    required
                  />
                </div>
                <small id="usernameError" class="error-feedback"></small>
              </div>

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
                <label for="password" class="form-label-modern">Password</label>
                <div class="input-wrapper">
                  <i class="bi bi-shield-lock input-icon-lead"></i>
                  <input
                    type="password"
                    class="form-control-modern"
                    id="password"
                    placeholder="Minimal 6 karakter"
                    autocomplete="new-password"
                    required
                  />
                  <button type="button" class="password-toggle-btn" id="togglePassword" title="Lihat password">
                    <i class="bi bi-eye-slash"></i>
                  </button>
                </div>
                <small id="passwordError" class="error-feedback"></small>
              </div>

              <!-- Field Konfirmasi Password -->
              <div class="form-group-modern">
                <label for="confirmPassword" class="form-label-modern">Konfirmasi Password</label>
                <div class="input-wrapper">
                  <i class="bi bi-shield-check input-icon-lead"></i>
                  <input
                    type="password"
                    class="form-control-modern"
                    id="confirmPassword"
                    placeholder="Ketik ulang password"
                    autocomplete="new-password"
                    required
                  />
                  <button type="button" class="password-toggle-btn" id="toggleConfirmPassword" title="Lihat password">
                    <i class="bi bi-eye-slash"></i>
                  </button>
                </div>
                <small id="confirmPasswordError" class="error-feedback"></small>
              </div>

              <!-- Submit Button -->
              <button class="btn-submit-modern mt-3" type="submit" id="btnRegister">
                <i class="bi bi-person-plus"></i> Daftar Akun Sekarang
              </button>

              <p class="auth-footer-text">
                Sudah punya akun? <a href="/login">Masuk Sekarang</a>
              </p>
            </form>
          </div>

          <!-- Kolom Kanan: Visual Side -->
          <div class="col-lg-6 visual-side order-1 order-lg-2">
            <div>
              <span class="visual-badge">
                <i class="bi bi-stars"></i> Bergabung Bersama Kami
              </span>
              <h2 class="visual-headline">Kreativitas Tanpa Batas dalam Setiap Jahitan.</h2>
              <p class="visual-description">
                Jadikan kebutuhan seragam organisasi, pakaian kelas, kemeja kantor, atau merchandise brand Anda semakin profesional bersama tim ahli Emoka Konveksi.
              </p>

              <div class="feature-card-list">
                <div class="feature-mini-card">
                  <div class="feature-icon-circle">
                    <i class="bi bi-palette"></i>
                  </div>
                  <div class="feature-text">Kustomisasi Desain & Konsultasi Gratis</div>
                </div>

                <div class="feature-mini-card">
                  <div class="feature-icon-circle">
                    <i class="bi bi-clock-history"></i>
                  </div>
                  <div class="feature-text">Pelacakan Status Produksi Real-Time</div>
                </div>

                <div class="feature-mini-card">
                  <div class="feature-icon-circle">
                    <i class="bi bi-credit-card-2-front"></i>
                  </div>
                  <div class="feature-text">Pembayaran Online Aman & Terintegrasi</div>
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
      function regis() {
        let username = $('#username').val().trim();
        let email = $('#email').val().trim();
        let password = $('#password').val().trim();
        let confirmPassword = $('#confirmPassword').val().trim();

        // Reset error messages
        $('#usernameError').text('');
        $('#emailError').text('');
        $('#passwordError').text('');
        $('#confirmPasswordError').text('');

        // Validasi username minimal 4 karakter
        if (username.length < 4) {
          $('#usernameError').html('<i class="bi bi-exclamation-circle me-1"></i>Username minimal 4 karakter!');
          $('#username').focus();
          return;
        }

        // Validasi email format
        let emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailPattern.test(email)) {
          $('#emailError').html('<i class="bi bi-exclamation-circle me-1"></i>Format email tidak valid!');
          $('#email').focus();
          return;
        }

        // Validasi panjang password
        if (password.length < 6) {
          $('#passwordError').html('<i class="bi bi-exclamation-circle me-1"></i>Password minimal 6 karakter!');
          $('#password').focus();
          return;
        }

        // Validasi konfirmasi password
        if (password !== confirmPassword) {
          $('#confirmPasswordError').html('<i class="bi bi-exclamation-circle me-1"></i>Password konfirmasi tidak cocok!');
          $('#confirmPassword').focus();
          return;
        }

        // Tampilkan SweetAlert Loading
        Swal.fire({
          title: 'Memproses Pendaftaran...',
          text: 'Mohon tunggu sebentar, sedang membuat akun Anda.',
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
          url: '/regisUser',
          data: { username_give: username, email_give: email, pw_give: password },
          success: function (response) {
            if (response.result === 'success') {
              Swal.fire({
                title: 'Registrasi Berhasil! 🎉',
                text: 'Akun Anda berhasil dibuat. Silakan masuk untuk memulai pemesanan.',
                icon: 'success',
                confirmButtonText: 'Login Sekarang',
                confirmButtonColor: '#4154f1',
              }).then(() => {
                window.location.replace('/login');
              });
            } else {
              Swal.fire({
                title: 'Registrasi Gagal',
                text: response.msg || 'Terjadi kesalahan saat mendaftar.',
                icon: 'error',
                confirmButtonText: 'Periksa Kembali',
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
        // Toggle password
        $('#togglePassword').click(function () {
          let passwordField = $('#password');
          let type = passwordField.attr('type') === 'password' ? 'text' : 'password';
          passwordField.attr('type', type);
          $(this).find('i').toggleClass('bi-eye bi-eye-slash');
        });

        $('#toggleConfirmPassword').click(function () {
          let passwordField = $('#confirmPassword');
          let type = passwordField.attr('type') === 'password' ? 'text' : 'password';
          passwordField.attr('type', type);
          $(this).find('i').toggleClass('bi-eye bi-eye-slash');
        });

        // Clear error saat mengetik
        $('#username').on('input', function () { $('#usernameError').text(''); });
        $('#email').on('input', function () { $('#emailError').text(''); });
        $('#password').on('input', function () { $('#passwordError').text(''); });
        $('#confirmPassword').on('input', function () { $('#confirmPasswordError').text(''); });
      });
    </script>
  </body>
</html>
