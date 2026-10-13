<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Lupa Password - Emoka Konveksi</title>
    <meta name="description" content="Reset dan pulihkan password akun Emoka Konveksi Anda dengan mudah." />

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

    <link rel="stylesheet" href="{{ asset('css/lupaPassword.css') }}" />
  </head>
  <body>
    <div class="bg-blob-1"></div>
    <div class="bg-blob-2"></div>

    <div class="auth-card-container">
      <div class="auth-card">
        <div class="row g-0">
          <!-- Kolom Kiri: Form Lupa Password -->
          <div class="col-lg-6 form-side order-2 order-lg-1">
            <a href="/login" class="back-home-btn">
              <i class="bi bi-arrow-left"></i> Kembali ke Halaman Login
            </a>

            <div class="brand-header">
              <img src="{{ asset('/img/logo.png') }}" alt="Emoka Logo" />
              <h2 class="brand-title"><span>Emoka</span> Konveksi</h2>
            </div>

            <h1 class="form-headline">Lupa Password? 🔐</h1>
            <p class="form-subheadline">
              Masukkan alamat email Anda untuk menerima token verifikasi dan mengatur ulang password akun Anda.
            </p>

            <form id="forgotPasswordForm">
              <!-- Field Email -->
              <div class="form-group-modern">
                <label for="email" class="form-label-modern">Alamat Email Terdaftar</label>
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

              <!-- Section Token & Password Baru (Muncul setelah token dikirim) -->
              <div id="tokenSection" style="display: none">
                <div class="token-alert-box">
                  <i class="bi bi-info-circle-fill fs-5 flex-shrink-0 text-primary"></i>
                  <div>
                    <strong>Token Terkirim!</strong> Periksa kotak masuk email Anda (termasuk folder spam) untuk kode token verifikasi 6 karakter.
                  </div>
                </div>

                <div class="form-group-modern">
                  <label for="token" class="form-label-modern">Kode Token Verifikasi</label>
                  <div class="input-wrapper">
                    <i class="bi bi-key input-icon-lead"></i>
                    <input
                      type="text"
                      class="form-control-modern"
                      id="token"
                      placeholder="Masukkan 6 karakter token"
                      style="text-transform: uppercase; letter-spacing: 2px; font-weight: 700;"
                    />
                  </div>
                </div>

                <div class="form-group-modern">
                  <label for="newPassword" class="form-label-modern">Password Baru</label>
                  <div class="input-wrapper">
                    <i class="bi bi-shield-lock input-icon-lead"></i>
                    <input
                      type="password"
                      class="form-control-modern"
                      id="newPassword"
                      placeholder="Minimal 6 karakter"
                      autocomplete="new-password"
                    />
                    <button type="button" class="password-toggle-btn" id="togglePassword" title="Lihat password">
                      <i class="bi bi-eye-slash"></i>
                    </button>
                  </div>
                </div>
              </div>

              <!-- Submit Button -->
              <button class="btn-submit-modern mt-3" type="submit" id="btnSubmitReset">
                <i class="bi bi-send"></i> Kirim Token Verifikasi
              </button>

              <p class="auth-footer-text">
                Ingat password Anda? <a href="/login">Masuk Kembali</a>
              </p>
            </form>
          </div>

          <!-- Kolom Kanan: Visual Hero Side -->
          <div class="col-lg-6 visual-side order-1 order-lg-2">
            <div>
              <span class="visual-badge">
                <i class="bi bi-shield-lock-fill"></i> Pemulihan Akun Aman
              </span>
              <h2 class="visual-headline">Reset Password dengan Cepat & Aman.</h2>
              <p class="visual-description">
                Kami menjaga keamanan akun Anda dengan verifikasi token email terenkripsi untuk memastikan akun Anda tetap terlindungi.
              </p>

              <div class="feature-card-list">
                <div class="feature-mini-card">
                  <div class="feature-icon-circle">
                    <i class="bi bi-envelope-check"></i>
                  </div>
                  <div class="feature-text">Token Verifikasi Otomatis ke Email</div>
                </div>

                <div class="feature-mini-card">
                  <div class="feature-icon-circle">
                    <i class="bi bi-lightning-charge"></i>
                  </div>
                  <div class="feature-text">Proses Reset Langsung Tanpa Menunggu Lama</div>
                </div>

                <div class="feature-mini-card">
                  <div class="feature-icon-circle">
                    <i class="bi bi-shield-shaded"></i>
                  </div>
                  <div class="feature-text">Keamanan Kata Sandi Terenkripsi</div>
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
      $(document).ready(function () {
        // Toggle password visibility
        $('#togglePassword').click(function () {
          let passwordField = $('#newPassword');
          let type = passwordField.attr('type') === 'password' ? 'text' : 'password';
          passwordField.attr('type', type);
          $(this).find('i').toggleClass('bi-eye bi-eye-slash');
        });

        $('#email').on('input', function () {
          $('#emailError').text('');
        });

        $('#forgotPasswordForm').submit(function (e) {
          e.preventDefault();
          const email = $('#email').val().trim();
          const token = $('#token').val().trim();
          const newPassword = $('#newPassword').val().trim();

          if (!email) {
            $('#emailError').html('<i class="bi bi-exclamation-circle me-1"></i>Email wajib diisi');
            $('#email').focus();
            return;
          }
          $('#emailError').text('');

          let payload = { email: email };
          if (token && newPassword) {
            payload.token = token;
            payload.new_password = newPassword;
          }

          Swal.fire({
            title: 'Memproses Permintaan...',
            text: 'Mohon tunggu sebentar.',
            allowOutsideClick: false,
            didOpen: () => Swal.showLoading(),
          });

          // CSRF setup
          $.ajaxSetup({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
          });

          $.ajax({
            url: '/lupa-password',
            method: 'POST',
            data: payload,
            success: function (res) {
              Swal.close();
              if (res.token_sent) {
                $('#tokenSection').slideDown();
                $('#btnSubmitReset').html('<i class="bi bi-key-fill me-1"></i> Simpan Password Baru');
                Swal.fire({
                  icon: 'success',
                  title: 'Token Terkirim! 📧',
                  text: res.message,
                  confirmButtonColor: '#4154f1',
                });
                $('#token').focus();
              } else if (res.success) {
                Swal.fire({
                  icon: 'success',
                  title: 'Berhasil! 🎉',
                  text: res.message,
                  confirmButtonColor: '#4154f1',
                }).then(() => {
                  window.location.href = '/login';
                });
              } else {
                Swal.fire({
                  icon: 'error',
                  title: 'Gagal',
                  text: res.message,
                  confirmButtonColor: '#4154f1',
                });
              }
            },
            error: function () {
              Swal.close();
              Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Terjadi kesalahan pada server. Coba lagi nanti.',
                confirmButtonColor: '#4154f1',
              });
            },
          });
        });
      });
    </script>
  </body>
</html>
