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
    <link href="{{ asset('img/logo2.png') }}" rel="icon" />
    <link href="{{ asset('img/logo2.png') }}" rel="apple-touch-icon" />

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
          <img src="{{ asset('img/logo.png') }}" alt="" />
          <h1 class="sitename d-block">Emoka</h1>
        </a>

        <nav id="navmenu" class="navmenu">
          <ul>
            <li>
              <a href="/#hero" class="active">
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

    <form id="formPemesanan" action="/buat-pesanan" method="POST" enctype="multipart/form-data">
      <div class="container" style="margin-top: 150px">
        <h2 class="mb-4 formPemesanan">Form Pemesanan</h2>
        <div style="height: 2px; background-color: #444444"></div>

        <div class="row my-4">
          <div class="col-12 col-lg">
            <div class="mb-3">
              <label for="nama" class="form-label">Nama</label>
              <input type="text" class="form-control validasi" id="nama" name="nama" />
              <small class="text-danger error-msg"></small>
            </div>

            <div class="mb-3">
              <label for="email" class="form-label">Email</label>
              <input type="text" class="form-control" id="email" name="email" />
              <small class="text-danger error-msg"></small>
            </div>

            <div class="mb-3">
              <label for="nomor" class="form-label">No. Telepon / WA</label>
              <input type="text" class="form-control validasi" id="nomor" name="nomor" />
              <small class="text-danger error-msg"></small>
            </div>

            <div class="mb-3">
              <label for="jenisPakaian" class="form-label">Jenis Pakaian</label>
              <select class="form-select" id="jenis_pakaian" name="jenis_pakaian">
                <option value="" disabled selected>Pilih jenis pakaian</option>
                <option value="Kaos">Kaos</option>
                <option value="Kemeja">Kemeja</option>
                <option value="PDH">PDH</option>
                <option value="PDL">PDL</option>
                <option value="Jaket">Jaket</option>
                <option value="Hoodie">Hoodie</option>
                <option value="Rompi">Rompi</option>
                <option value="Celana">Celana</option>
                <option value="Topi">Topi</option>
                <option value="Seragam">Seragam</option>
                <option value="Lainnya">Lainnya</option>
              </select>
              <small class="text-danger error-msg"></small>
            </div>

            <div id="jumlah-total-wrapper" class="mb-2">
              <label for="jenisPakaian" class="form-label">Jumlah</label>
              <input type="number" id="jumlah-pakaian" name="jumlah_pakaian" class="form-control" />
              <small class="text-danger error-msg"></small>
              <small class="form-text text-muted mt-2">Klik tombol dibawah jika memerlukan ukuran</small>
            </div>

            <div class="mb-2">
              <button type="button" id="toggle-detail" class="btn btn-outline-secondary">+ Tambah Detail Ukuran</button>
            </div>

            <div id="detail-ukuran-wrapper" class="d-none">
              <label class="form-label">Ukuran & Jumlah</label>
              <div class="row g-2">
                <div class="col-5">
                  <select id="input-ukuran" name="ukuran" class="form-select">
                    <option value="" disabled selected>Pilih Ukuran</option>
                    <option value="SK">SK</option>
                    <option value="S">S</option>
                    <option value="M">M</option>
                    <option value="L">L</option>
                    <option value="XL">XL</option>
                    <option value="XXL">XXL</option>
                    <option value="XXXL">XXXL</option>
                    <option value="XXXXL">XXXXL</option>
                  </select>
                </div>

                <div class="col-5">
                  <input type="number" id="input-jumlah" class="form-control" placeholder="Jumlah" min="1" />
                </div>
                <div class="col-3">
                  <select id="input-lengan" name="lengan" class="form-select">
                    <option value="" disabled selected>Pilih Lengan</option>
                    <option value="Pendek">Pendek</option>
                    <option value="Panjang">Panjang</option>
                  </select>
                </div>
                <div class="col-2">
                  <button type="button" class="btn btn-pilihDesain w-100" id="btn-tambah-ukuran">+</button>
                </div>
              </div>
              <div class="mt-3">
                <label class="form-label">Ukuran Terpilih:</label>
                <div id="list-ukuran">
                  <!-- Chip/badge/list ukuran-jumlah akan muncul di sini -->
                </div>
              </div>
              <!-- Field hidden untuk dikirim ke backend -->
              <input type="hidden" name="ukuran_json" id="ukuran_json" />
            </div>

            <div class="mt-3">
              <label class="form-label">Estimasi Harga:</label>
              <p id="estimasi-harga" class="fw-bold text-success">
                Rp -
                <span></span>
              </p>
              <small class="form-text text-muted mt-2"><em>Bukan Harga Final</em></small>
            </div>
          </div>

          <div class="col-12 col-lg">
            <div class="mb-3">
              <label for="alamat" class="form-label">Alamat Pengiriman</label>
              <textarea class="form-control" id="alamat" name="alamat" rows="3"></textarea>
              <small class="text-danger error-msg"></small>
            </div>

            <div class="mb-3">
              <label for="deskripsi" class="form-label">Deskripsi Pesanan</label>
              <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3"></textarea>
              <small class="text-danger error-msg"></small>
            </div>

            <div class="mb-3">
              <label for="fileUkuran" class="form-label">Upload Data Nama Pakaian (pdf, xlsx)</label>
              <input
                type="file"
                class="form-control validasi"
                id="fileUkuran"
                name="fileUkuran"
                accept=".pdf, .xlsx, .xls, .csv"
              />
              <small class="text-danger error-msg"></small>
            </div>

            <div class="d-none d-lg-block mt-2">
              <div class="row gx-2 mb-2">
                <div class="col-6">
                  <img
                    src="{{ asset('/img/sizechart/jaket.jpg') }}"
                    alt="Sizechart 1"
                    class="img-fluid w-100 rounded"
                  />
                </div>
                <div class="col-6">
                  <img
                    src="{{ asset('/img/sizechart/kemeja.jpg') }}"
                    alt="Sizechart 2"
                    class="img-fluid w-100 rounded"
                  />
                </div>
              </div>
              <div class="row gx-2">
                <div class="col-6 offset-3">
                  {{-- Tengah --}}
                  <img
                    src="{{ asset('/img/sizechart/kaos.jpg') }}"
                    alt="Sizechart 3"
                    class="img-fluid w-100 rounded"
                  />
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Form Upload Desain -->
        <div class="row">
          <p class="text-center" style="font-size: 30px; font-weight: 700">Desain</p>
        </div>

        <!-- Form Upload Logo -->
        <div class="mb-3 mt-3 row">
          <div class="col">
            <!-- Input desain -->
            <div id="design-form" class="mb-3">
              <div class="row g-2">
                <div class="col-md-6">
                  <input type="text" id="design-name" class="form-control" placeholder="Nama Desain" />
                </div>
                <div class="col-md-6">
                  <input type="file" id="design-file" class="form-control" />
                </div>
              </div>
              <div class="d-flex flex-column">
                <small class="form-text text-muted mt-2">
                  Nama desain harus sesuai dengan file, misalnya "logo" untuk file logo.
                </small>

                <button type="button" id="add-design" class="btn btn-outline-secondary mt-2">+ Tambah Desain</button>
                <small id="design-error" class="form-text text-danger mt-2 d-none"></small>
              </div>
            </div>

            <!-- Daftar desain yang sudah ditambahkan -->
            <h5>Desain yang Ditambahkan:</h5>
            <ul id="design-list" class="list-group mb-3"></ul>

            <!-- Input tersembunyi yang akan dikirim ke server -->
            <div id="design-hidden-inputs"></div>
          </div>
        </div>

        <div class="my-5 d-flex justify-content-center">
          <button type="submit" class="btn-pilihDesain">Buat Pesanan</button>
        </div>
      </div>
    </form>

    <!-- /Form Pemesanan -->

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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
      $(document).ready(function () {
        let designs = [] // ✅ Global untuk desain
        let daftarUkuran = [] // ✅ Global untuk ukuran

        // Fungsi hapus error
        function clearError(input) {
          const $input = $(input)
          $input.removeClass('is-invalid')
          $input.next('.error-msg').remove()
        }

        // Fungsi tampilkan error
        function showError(input, message) {
          const $input = $(input)
          $input.addClass('is-invalid')

          let $error = $input.next('.error-msg')
          if ($error.length === 0) {
            $input.after(`<small class="text-danger error-msg">${message}</small>`)
          } else {
            $error.text(message)
          }
        }

        // Hilangkan error saat user mengetik/ubah
        $(document).on('input change', 'input, textarea', function () {
          const id = $(this).attr('id')
          const value = $(this).val().trim()

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
        })

        // === ✅ Tambah Desain ===
        $('#add-design').on('click', function () {
          const nameInput = document.getElementById('design-name')
          const fileInput = document.getElementById('design-file')

          const name = nameInput.value.trim().replace(/\w\S*/g, function (txt) {
            return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase()
          })
          const file = fileInput.files[0]

          const errorText = document.getElementById('design-error')

          if (!name || !file) {
            errorText.classList.remove('d-none')
            errorText.textContent = '*Silakan isi nama desain dan pilih file.'
            return
          } else {
            errorText.classList.add('d-none')
          }

          const fileExt = file.name.split('.').pop()
          const index = designs.length
          designs.push({ name: name, file: file })

          const listItem = document.createElement('li')
          listItem.classList.add('list-group-item', 'd-flex', 'justify-content-between', 'align-items-center')
          listItem.setAttribute('data-index', index)
          listItem.innerHTML = `
      <span>${name}.${fileExt}</span>
      <button type="button" class="btn btn-sm btn-danger btn-hapus-desain">Hapus</button>
    `

          document.getElementById('design-list').appendChild(listItem)

          // Hapus desain saat tombol diklik
          listItem.querySelector('.btn-hapus-desain').addEventListener('click', function () {
            const idx = parseInt(listItem.getAttribute('data-index'))
            designs.splice(idx, 1)
            listItem.remove()

            // Perbarui ulang index setelah hapus
            $('#design-list li').each(function (i) {
              $(this).attr('data-index', i)
              designs[i] = designs[i] // tetap urut
            })
          })

          nameInput.value = ''
          fileInput.value = ''
        })

        // === ✅ Tambah Ukuran ===
        const hargaDasarMap = {
          Kaos: 60000,
          Kemeja: 60000,
          PDH: 120000,
          PDL: 120000,
          Jaket: 120000,
          Hoodie: 120000,
          Rompi: 11000,
          Celana: 60000,
          Topi: 60000,
          Seragam: 6000,
          Lainnya: 10000,
        }

        const ukuranMahal = ['XXL', 'XXXL', 'XXXXL']

        function renderUkuran() {
          let html = ''

          if (daftarUkuran.length === 0) {
            html = '<span class="text-muted">Belum ada ukuran ditambah</span>'
          } else {
            $.each(daftarUkuran, function (i, item) {
              html += `
        <span class="badge bg-secondary me-2 mb-2 p-2 d-inline-flex align-items-center">
          <b>${item.ukuran}</b> (${item.lengan}) : ${item.jumlah} pcs
          <button type="button" class="btn btn-sm btn-danger btn-hapus-ukuran ms-2" data-index="${i}" title="Hapus" style="padding: 0 7px; font-size:13px;">&times;</button>
        </span>
        `
            })
          }

          $('#list-ukuran').html(html)
          $('#ukuran_json').val(JSON.stringify(daftarUkuran))

          hitungEstimasiHarga() // 🔁 panggil saat render ukuran
        }

        $('#btn-tambah-ukuran').click(function () {
          var ukuran = ($('#input-ukuran').val() || '').trim()
          var jumlah = ($('#input-jumlah').val() || '').trim()
          var lengan = ($('#input-lengan').val() || '').trim()

          if (ukuran === '' || jumlah === '' || parseInt(jumlah) < 1 || lengan === '') {
            Swal.fire({
              icon: 'warning',
              title: 'Input Tidak Valid',
              text: 'Masukkan ukuran, jumlah dan lengan yang benar!',
              confirmButtonColor: '#3085d6',
            })
            return
          }

          const exist = daftarUkuran.find((e) => e.ukuran === ukuran && e.lengan === lengan)
          if (exist) {
            Swal.fire({
              icon: 'error',
              title: 'Ukuran & Lengan Sudah Ditambahkan',
              text: `Ukuran ${ukuran} dengan lengan ${lengan} sudah ada.`,
            })
            return
          }

          daftarUkuran.push({ ukuran: ukuran, jumlah: jumlah, lengan: lengan })
          $('#input-ukuran').val('')
          $('#input-jumlah').val('')
          $('#input-lengan').val('')
          renderUkuran()
        })

        $('#list-ukuran').on('click', '.btn-hapus-ukuran', function () {
          var idx = $(this).data('index')
          daftarUkuran.splice(idx, 1)
          renderUkuran()
        })

        function hitungEstimasiHarga() {
          const jenis = $('#jenis_pakaian').val()
          if (!jenis || !hargaDasarMap[jenis] || jenis === 'Lainnya') {
            $('#estimasi-harga').text('Rp -')
            return
          }

          const hargaDasar = hargaDasarMap[jenis]
          let total = 0

          daftarUkuran.forEach((item) => {
            const jml = parseInt(item.jumlah) || 0 // ⬅️ parse jumlah saat dihitung
            const tambahan = ukuranMahal.includes(item.ukuran) ? 5000 : 0
            const hargaSatuan = hargaDasar + tambahan
            total += hargaSatuan * jml
          })

          $('#estimasi-harga').text(total > 0 ? 'Rp ' + total.toLocaleString('id-ID') : 'Rp -')

          $('#input_estimasi_harga').val(total) // jika disimpan juga
        }

        renderUkuran()

        // === ✅ Submit Form ===
        $('#formPemesanan').submit(function (e) {
          e.preventDefault()
          let isValid = true

          $('.validasi, #formPemesanan textarea').each(function () {
            const value = $(this).val().trim()
            if (value === '') {
              isValid = false
              showError(this, '*Kolom ini tidak boleh kosong.')
            } else {
              clearError(this)
            }
          })

          const nama = $('#nama').val().trim()
          if (nama !== '' && !/^[a-zA-Z\s]+$/.test(nama)) {
            isValid = false
            showError('#nama', '*Nama hanya boleh berisi huruf dan spasi.')
          }

          const nomor = $('#nomor').val().trim()
          if (nomor !== '' && !/^\d+$/.test(nomor)) {
            isValid = false
            showError('#nomor', '*Nomor telepon hanya boleh berisi angka.')
          }

          const email = $('#email').val().trim()
          const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/
          if (email === '') {
            isValid = false
            showError('#email', '*Kolom tidak boleh kosong.')
          } else if (!emailRegex.test(email)) {
            isValid = false
            showError('#email', '*Format email tidak valid.')
          } else {
            clearError('#email')
          }

          const fileUkuran = $('#fileUkuran')[0].files[0]
          if (!fileUkuran) {
            isValid = false
            showError('#fileUkuran', '*File ukuran wajib diunggah.')
          }

          if (isValid) {
            const form = document.getElementById('formPemesanan')
            const formData = new FormData(form)

            designs.forEach((design, index) => {
              formData.append(`designs[${index}][name]`, design.name)
              formData.append(`designs[${index}][file]`, design.file)
            })

            Swal.fire({
              title: 'Mengirim data...',
              allowOutsideClick: false,
              didOpen: () => {
                Swal.showLoading()
              },
            })

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
                    title: 'Berhasil!',
                    text: response.message,
                  }).then(() => {
                    form.reset()
                    $('#design-list').empty()
                    $('.error-msg').remove()
                    designs = []
                    daftarUkuran = []
                    renderUkuran()
                  })
                } else {
                  Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: response.message,
                  })
                }
              },
              error: function () {
                Swal.close()
                Swal.fire({
                  icon: 'error',
                  title: 'Oops...',
                  text: 'Terjadi kesalahan saat mengirim data!',
                })
              },
            })
          }
        })
      })
    </script>
    <script>
      $(document).ready(function () {
        $('#toggle-detail').click(function () {
          const $detail = $('#detail-ukuran-wrapper')
          const $jumlah = $('#jumlah-pakaian')

          if ($detail.hasClass('d-none')) {
            // Tampilkan detail ukuran
            $detail.removeClass('d-none')
            $jumlah.val('')
            $jumlah.prop('disabled', true)
            $(this).text('- Sembunyikan Detail Ukuran')
          } else {
            // Sembunyikan detail ukuran
            $detail.addClass('d-none')
            $jumlah.prop('disabled', false)
            $(this).text('+ Tambah Detail Ukuran')
          }
        })
      })
    </script>
  </body>
</html>
