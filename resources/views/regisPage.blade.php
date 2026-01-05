<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Emoka Konveksi</title>

    <!-- Favicons -->
    <link href="{{ asset('/img/logo2.png') }}" rel="icon" />
    <link href="{{ asset('/img/logo2.png') }}" rel="apple-touch-icon" />

    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
      crossorigin="anonymous"
    />
    <link rel="stylesheet" href="{{ asset('/css/regisPage.css') }}" />
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" />

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
      function regis() {
        let username = $('#username').val().trim()
        let email = $('#email').val().trim()
        let password = $('#password').val().trim()
        let confirmPassword = $('#confirmPassword').val().trim()

        // Reset error messages
        $('#usernameError').text('')
        $('#emailError').text('')
        $('#passwordError').text('')
        $('#confirmPasswordError').text('')

        // Validasi username minimal 4 karakter
        if (username.length < 4) {
          $('#usernameError').text('Username minimal 4 karakter!')
          return
        }

        // Validasi email format
        let emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/
        if (!emailPattern.test(email)) {
          $('#emailError').text('Format email tidak valid!')
          return
        }

        // Validasi panjang password
        if (password.length < 6) {
          $('#passwordError').text('Password minimal 6 karakter!')
          return
        }

        // Validasi konfirmasi password
        if (password !== confirmPassword) {
          $('#confirmPasswordError').text('Password tidak cocok!')
          return
        }

        // Tampilkan SweetAlert Loading
        Swal.fire({
          title: 'Memproses...',
          text: 'Mohon tunggu, sedang mendaftarkan akun.',
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
          type: 'POST',
          url: '/regisUser',
          data: { username_give: username, email_give: email, pw_give: password },
          success: function (response) {
            if (response.result === 'success') {
              Swal.fire({
                title: 'Registrasi Berhasil',
                text: 'Silakan login!',
                icon: 'success',
                confirmButtonText: 'OK',
                confirmButtonColor: '#137DCB',
              }).then(() => {
                window.location.replace('/login')
              })
            } else {
              Swal.fire({
                title: 'Registrasi Gagal',
                text: response.msg,
                icon: 'error',
                confirmButtonText: 'OK',
                confirmButtonColor: '#137DCB',
              })
            }
          },
          error: function () {
            Swal.fire({
              title: 'Error',
              text: 'Terjadi kesalahan, coba lagi nanti.',
              icon: 'error',
              confirmButtonText: 'OK',
            })
          },
        })
      }
    </script>
    <script>
      $(document).ready(function () {
        $('#togglePassword').click(function () {
          let passwordField = $('#password')
          let type = passwordField.attr('type') === 'password' ? 'text' : 'password'
          passwordField.attr('type', type)

          // Ubah ikon mata
          $(this).toggleClass('bi-eye bi-eye-slash')
        })

        $('#toggleConfirmPassword').click(function () {
          let passwordField = $('#confirmPassword')
          let type = passwordField.attr('type') === 'password' ? 'text' : 'password'
          passwordField.attr('type', type)

          // Ubah ikon mata
          $(this).toggleClass('bi-eye bi-eye-slash')
        })
      })
    </script>
  </head>
  <body>
    <section class="h-100 gradient-form" style="background-color: #eeee">
      <div class="container h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
          <div class="col-xl-10">
            <div class="card rounded-3 text-black">
              <div class="row g-0">
                <div class="col-lg-6 order-2">
                  <div class="card-body py-md-3 px-md-5 mx-md-4">
                    <div class="text-center">
                      <img src="{{ asset('/img/logo.png') }}" alt="" style="width: 250px" />
                      <h3 class="mt-1 mb-5 pb-1" style="font-weight: 700">
                        <span style="color: #4154f1">Emoka</span>
                        Konveksi
                      </h3>
                    </div>

                    <form id="registerForm">
                      <p style="font-weight: 500">Registrasi Sekarang</p>

                      <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="username" placeholder="Username" required />
                        <label for="username">Username</label>
                        <small id="usernameError" class="text-danger"></small>
                      </div>

                      <div class="form-floating mb-3">
                        <input type="email" class="form-control" id="email" placeholder="name@example.com" required />
                        <label for="email">Email</label>
                        <small id="emailError" class="text-danger"></small>
                      </div>

                      <!-- Password dengan tombol mata -->
                      <div class="form-floating mb-3 position-relative">
                        <input type="password" class="form-control" id="password" placeholder="Password" required />
                        <label for="password">Password</label>
                        <small id="passwordError" class="text-danger"></small>
                        <i
                          class="bi bi-eye-slash position-absolute eye-icon"
                          id="togglePassword"
                          style="top: 50%; right: 10px; transform: translateY(-50%); cursor: pointer"
                        ></i>
                      </div>

                      <div class="form-floating mb-3 position-relative">
                        <input
                          type="password"
                          class="form-control"
                          id="confirmPassword"
                          placeholder="Konfirmasi Password"
                          required
                        />
                        <label for="confirmPassword">Konfirmasi Password</label>
                        <small id="confirmPasswordError" class="text-danger"></small>
                        <i
                          class="bi bi-eye-slash position-absolute eye-icon"
                          id="toggleConfirmPassword"
                          style="top: 50%; right: 10px; transform: translateY(-50%); cursor: pointer"
                        ></i>
                      </div>

                      <div class="text-center d-flex flex-column pt-1 pb-1">
                        <button class="btn-registrasi btn-block mb-3" type="button" onclick="regis()">
                          Registrasi
                        </button>
                      </div>

                      <div class="d-flex justify-content-center" style="font-weight: 500">
                        <p class="">Sudah Punya Akun?</p>
                        <a href="/login" style="color: #4154f1; text-decoration: none" class="ms-2">Login Sekarang</a>
                      </div>
                    </form>
                  </div>
                </div>
                <div class="col-lg-6 d-flex align-items-center order-1" style="background-color: #4154f1">
                  <div class="text-white px-3 py-4 p-md-5 mx-md-4">
                    <h4 class="mb-4">Kreativitas dalam Setiap Jahitan.</h4>
                    <p class="small mb-0">
                      Selamat datang di Emoka Konveksi, tempat di mana setiap desain menjadi sebuah karya yang istimewa.
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </body>
</html>
