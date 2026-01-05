<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Lupa Password | Emoka Konveksi</title>

    <link href="{{ asset('/img/logo2.png') }}" rel="icon" />
    <link href="{{ asset('/img/logo2.png') }}" rel="apple-touch-icon" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('/css/loginPage.css') }}" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" />

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  </head>
  <body>
    <section class="h-100 gradient-form" style="background-color: #eee">
      <div class="container h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
          <div class="col-xl-10">
            <div class="card rounded-3 text-black">
              <div class="row g-0">
                <div class="col-lg-6 order-2">
                  <div class="card-body p-md-5 mx-md-4">
                    <div class="text-center">
                      <img src="{{ asset('/img/logo.png') }}" alt="Logo" style="width: 250px" />
                      <h3 class="mt-1 mb-5 pb-1" style="font-weight: 700">
                        <span style="color: #4154f1">Emoka</span>
                        Konveksi
                      </h3>
                    </div>

                    <form id="forgotPasswordForm">
                      <p style="font-weight: 500">Masukkan email untuk reset password</p>

                      <div class="form-floating mb-3">
                        <input type="email" class="form-control" id="email" placeholder="name@example.com" required />
                        <label for="email">Email</label>
                        <small id="emailError" class="text-danger"></small>
                      </div>

                      <div id="tokenSection" style="display: none">
                        <div class="form-floating mb-3">
                          <input type="text" class="form-control" id="token" placeholder="Token verifikasi" />
                          <label for="token">Masukkan Token</label>
                        </div>
                        <div class="form-floating mb-3">
                          <input type="password" class="form-control" id="newPassword" placeholder="Password Baru" />
                          <label for="newPassword">Password Baru</label>
                          <i
                            class="bi bi-eye-slash position-absolute eye-icon"
                            id="togglePassword"
                            style="top: 50%; right: 10px; transform: translateY(-50%); cursor: pointer"
                          ></i>
                        </div>
                      </div>

                      <div class="text-center d-flex flex-column pt-1 pb-1">
                        <button class="btn-login btn-block mb-3" type="submit">Kirim Permintaan</button>
                        <a href="/login" class="text-muted" style="text-decoration: none">Kembali ke Login</a>
                      </div>
                    </form>
                  </div>
                </div>

                <div class="col-lg-6 d-flex align-items-center order-1" style="background-color: #4154f1">
                  <div class="text-white px-3 py-4 p-md-5 mx-md-4">
                    <h4 class="mb-4">Reset Password dengan Mudah</h4>
                    <p class="small mb-0">
                      Masukkan email yang terdaftar untuk menerima token dan reset password Anda.
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <script>
      $(document).ready(function () {
        $('#forgotPasswordForm').submit(function (e) {
          e.preventDefault()
          const email = $('#email').val().trim()
          const token = $('#token').val().trim()
          const newPassword = $('#newPassword').val().trim()

          if (!email) {
            $('#emailError').text('Email wajib diisi')
            return
          }
          $('#emailError').text('')

          let payload = { email: email }
          if (token && newPassword) {
            payload.token = token
            payload.new_password = newPassword
          }

          Swal.fire({
            title: 'Memproses...',
            text: 'Mohon tunggu...',
            allowOutsideClick: false,
            didOpen: () => Swal.showLoading(),
          })

          // CSRF setup
          $.ajaxSetup({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
          })

          $.ajax({
            url: '/lupa-password',
            method: 'POST',
            data: payload,
            success: function (res) {
              Swal.close()
              if (res.token_sent) {
                $('#tokenSection').show()
                Swal.fire('Token Dikirim', res.message, 'success')
              } else if (res.success) {
                Swal.fire('Berhasil', res.message, 'success').then(() => (window.location.href = '/login'))
              } else {
                Swal.fire('Gagal', res.message, 'error')
              }
            },
            error: function () {
              Swal.close()
              Swal.fire('Error', 'Terjadi kesalahan pada server.', 'error')
            },
          })
        })
      })
    </script>
    <script>
      $(document).ready(function () {
        $('#togglePassword').click(function () {
          let passwordField = $('#newPassword')
          let type = passwordField.attr('type') === 'password' ? 'text' : 'password'
          passwordField.attr('type', type)

          // Ubah ikon mata
          $(this).toggleClass('bi-eye bi-eye-slash')
        })
      })
    </script>
  </body>
</html>
