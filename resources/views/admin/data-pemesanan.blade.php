<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <!-- Favicons -->
    <link href="{{ asset('/img/logo2.png') }}" rel="icon" />
    <link href="{{ asset('/img/apple-touch-icon.png') }}" rel="apple-touch-icon" />

    <title>Emoka Admin</title>

    <!-- Custom fonts for this template -->
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css" />
    <link
      href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
      rel="stylesheet"
    />

    <link href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" />

    <!-- Bootstrap Icon -->
    <link href="{{ asset('vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet" />

    <!-- Custom styles for this template -->
    <link href="{{ asset('css/sb-admin-2.css') }}" rel="stylesheet" />

    <!-- Custom styles for this page -->
    <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
  </head>

  <body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
      <!-- Sidebar -->
      <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
        <!-- Sidebar - Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
          <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
          </div>
          <div class="sidebar-brand-text mx-3">Emoka Admin</div>
        </a>

        <!-- Divider -->
        <hr class="sidebar-divider my-0" />

        <!-- Nav Item - Dashboard -->
        <li class="nav-item">
          <a class="nav-link" href="/admin/dashboard">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
          </a>
        </li>
        <li class="nav-item active">
          <a class="nav-link" href="/admin/data-pemesanan">
            <i class="fas fa-file-invoice"></i>
            <span>Data Pemesanan</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/admin/produk">
            <i class="fas fa-tshirt"></i>
            <span>Manajemen Produk</span>
          </a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider d-none d-md-block" />

        <!-- Sidebar Toggler (Sidebar) -->
        <div class="text-center d-none d-md-inline">
          <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>
      </ul>
      <!-- End of Sidebar -->

      <!-- Content Wrapper -->
      <div id="content-wrapper" class="d-flex flex-column">
        <!-- Main Content -->
        <div id="content">
          <!-- Topbar -->
          <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
            <!-- Sidebar Toggle (Topbar) -->
            <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
              <i class="fa fa-bars"></i>
            </button>

            <!-- Topbar Navbar -->
            <ul class="navbar-nav ml-auto">
              <!-- Nav Item - User Information -->
              <li class="nav-item dropdown no-arrow">
                <a
                  class="nav-link dropdown-toggle"
                  href="#"
                  id="userDropdown"
                  role="button"
                  data-bs-toggle="dropdown"
                  aria-haspopup="true"
                  aria-expanded="false"
                >
                  <span class="mr-2 d-none d-lg-inline text-gray-600 small">Admin</span>
                  <i class="bi bi-chevron-down"></i>
                </a>
                <!-- Dropdown - User Information -->
                <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                  <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#logoutModal">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Logout
                  </a>
                </div>
              </li>
            </ul>
          </nav>
          <!-- End of Topbar -->

          <!-- Begin Page Content -->
          <div class="container-fluid">
            <!-- Page Heading -->
            <h1 class="h3 mb-2 text-gray-800">Pesanan</h1>
            <p class="mb-4">Tabel ini menampilkan data pesanan dari pelanggan Emoka Konveksi</p>

            <!-- DataTales Example -->
            <div class="card shadow mb-4">
              <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Tabel Pesanan</h6>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                      <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>No. Wa</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tfoot>
                      <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>No. Wa</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                      </tr>
                    </tfoot>
                    <tbody>
                      @foreach ($orders as $order)
                        <tr>
                          <td>{{ $order->nama }}</td>
                          <td>{{ $order->email }}</td>
                          <td>{{ $order->nomor }}</td>
                          <td data-order="{{ $order->status }}">
                            <select
                              class="form-select pe-4"
                              aria-label="Status"
                              id="status{{ $order->id }}"
                              data-status="{{ $order->status }}"
                            >
                              <option value="Menunggu">Menunggu</option>
                              <option value="Belum Bayar">Belum Bayar</option>
                              <option value="Sudah Bayar">Sudah Bayar</option>
                              <option value="Produksi">Produksi</option>
                              <option value="Pengiriman">Pengiriman</option>
                              <option value="Selesai">Selesai</option>
                              <option value="Dibatalkan">Dibatalkan</option>
                            </select>
                          </td>
                          <td>{{ \Carbon\Carbon::parse($order->tanggal)->format('Y-m-d H:i') }}</td>
                          <td>
                            <button class="btn btn-sm btn-primary" onclick="showDetails('{{ $order->id }}')">
                              <i class="bi bi-eye"></i>
                              Detail
                            </button>
                            <button class="btn btn-sm btn-warning" onclick="updateStatus('{{ $order->id }}')">
                              <i class="bi bi-pencil-square"></i>
                              Update
                            </button>
                            <button class="btn btn-sm btn-danger" onclick="hapusPesanan('{{ $order->id }}')">
                              <i class="bi bi-trash"></i>
                              Hapus
                            </button>
                            <button
                              class="btn btn-sm btn-success btn-invoice"
                              onclick=""
                              data-id="{{ $order->id }}"
                              data-bs-toggle="modal"
                              data-bs-target="#invoiceModal"
                            >
                              <i class="bi bi-receipt"></i>
                              Invoice
                            </button>
                            <button
                              type="button"
                              class="btn btn-primary btn-sm mt-1"
                              data-bs-toggle="modal"
                              data-bs-target="#modalWorkOrder{{ $order->id }}"
                            >
                              <i class="bi bi-file-earmark-text"></i>
                              Work Order
                            </button>
                          </td>
                        </tr>

                        <!-- Modal Detail Pemesanan -->
                        <div
                          class="modal fade"
                          id="orderDetailsModal"
                          tabindex="-1"
                          aria-labelledby="orderDetailsModalLabel"
                          aria-hidden="true"
                        >
                          <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="orderDetailsModalLabel">Detail Pemesanan</h5>
                                <button
                                  type="button"
                                  class="btn-close"
                                  data-bs-dismiss="modal"
                                  aria-label="Close"
                                ></button>
                              </div>
                              <div class="modal-body">
                                <!-- Detail Pesanan akan muncul di sini -->
                                <div id="orderDetailsContent"></div>
                              </div>
                              <div class="modal-footer">
                                <div id="orderDetailsFooter"></div>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                              </div>
                            </div>
                          </div>
                        </div>

                        <!-- Modal Work Order -->
                        <div
                          class="modal fade"
                          id="modalWorkOrder{{ $order->id }}"
                          tabindex="-1"
                          aria-labelledby="modalWorkOrderLabel{{ $order->id }}"
                          aria-hidden="true"
                        >
                          <div class="modal-dialog">
                            <form
                              class="form-work-order"
                              action="{{ route('work-order.update', $order->id) }}"
                              method="POST"
                            >
                              @csrf
                              @method('PUT')
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="modalWorkOrderLabel{{ $order->id }}">
                                    Work Order untuk {{ $order->nama }}
                                  </h5>
                                  <button
                                    type="button"
                                    class="btn-close"
                                    data-bs-dismiss="modal"
                                    aria-label="Tutup"
                                  ></button>
                                </div>
                                <div class="modal-body">
                                  <div class="mb-2">
                                    <label>Order Date</label>
                                    <input
                                      type="date"
                                      name="order_date"
                                      class="form-control"
                                      value="{{ optional($order->workOrder)->order_date }}"
                                      required
                                    />
                                  </div>
                                  <div class="mb-2">
                                    <label>Expected Start Date</label>
                                    <input
                                      type="date"
                                      name="expected_start_date"
                                      class="form-control"
                                      value="{{ optional($order->workOrder)->expected_start_date }}"
                                    />
                                  </div>
                                  <div class="mb-2">
                                    <label>Expected End Date</label>
                                    <input
                                      type="date"
                                      name="expected_end_date"
                                      class="form-control"
                                      value="{{ optional($order->workOrder)->expected_end_date }}"
                                    />
                                  </div>
                                  <div class="mb-2">
                                    <label>Jenis Kain</label>
                                    <input
                                      type="text"
                                      name="jenis_kain"
                                      class="form-control"
                                      value="{{ optional($order->workOrder)->jenis_kain }}"
                                    />
                                  </div>
                                  <div class="mb-2">
                                    <label>Warna Kain</label>
                                    <input
                                      type="text"
                                      name="warna_kain"
                                      class="form-control"
                                      value="{{ optional($order->workOrder)->warna_kain }}"
                                    />
                                  </div>
                                  <div class="mb-2">
                                    <label>Furing</label>
                                    <input
                                      type="text"
                                      name="furing"
                                      class="form-control"
                                      value="{{ optional($order->workOrder)->furing }}"
                                    />
                                  </div>
                                </div>
                                <div class="modal-footer">
                                  <a
                                    href="{{ route('admin.work-order.print', $order->id) }}"
                                    target="_blank"
                                    class="btn btn-outline-secondary"
                                  >
                                    Cetak Work Order
                                  </a>

                                  <!-- Tombol Update -->
                                  <button type="submit" class="btn btn-primary">Update Work Order</button>
                                </div>
                              </div>
                            </form>
                          </div>
                        </div>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <!-- /.container-fluid -->
        </div>
        <!-- End of Main Content -->

        <!-- Footer -->
        <footer class="sticky-footer bg-white">
          <div class="container my-auto">
            <div class="copyright text-center my-auto">
              <span>Emoka &copy; Emoka Konveksi</span>
            </div>
          </div>
        </footer>
        <!-- End of Footer -->
      </div>
      <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div
      class="modal fade"
      id="logoutModal"
      tabindex="-1"
      role="dialog"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Ingin Keluar?</h5>
            <button class="close" type="button" data-bs-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">Pilih "Logout" dibawah jika kamu ingin keluar.</div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Batal</button>
            <a class="btn btn-primary" href="/admin/logout">Logout</a>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal Invoice -->
    <div class="modal fade" id="invoiceModal" tabindex="-1" aria-labelledby="invoiceModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
          <form id="invoiceForm">
            <div class="modal-header">
              <h5 class="modal-title">Input Harga Satuan per Ukuran</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <input type="hidden" name="pesanan_id" id="invoice-pesanan-id" />
              <div class="table-responsive">
                <table class="table table-bordered" id="invoice-ukuran-table">
                  <thead>
                    <tr>
                      <th>Jenis Pakaian</th>
                      <th>Ukuran</th>
                      <th>Jumlah</th>
                      <th>Harga Satuan (Rp)</th>
                    </tr>
                  </thead>
                  <tbody>
                    <!-- Baris akan diisi dinamis -->
                  </tbody>
                </table>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-success" id="print-invoice-btn">Cetak Invoice</button>
              <button type="submit" class="btn btn-primary">Simpan</button>
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Bootstrap core JavaScript -->
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript -->
    <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Page level plugins -->
    <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

    <!-- Page level custom scripts -->
    <script src="{{ asset('js/demo/datatables-demo.js') }}"></script>

    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Custom scripts for all pages -->
    <script src="{{ asset('js/sb-admin-2.min.js') }}"></script>

    <script>
      function showDetails(orderId) {
        // CSRF setup
        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
          },
        })

        $.ajax({
          url: '/admin/order-details/' + orderId,
          type: 'GET',
          success: function (response) {
            const order = response.order

            let desainContent = ''
            if (order.desain) {
              try {
                const desainArray = JSON.parse(order.desain)
                if (Array.isArray(desainArray) && desainArray.length) {
                  desainArray.forEach((desain) => {
                    desainContent += `
                    <p><strong>${desain.nama}:</strong>  <a href="/${desain.file}" class="btn btn-sm btn-info" download> <i class="bi bi-download"></i> Download ${desain.nama} </a></p>
                `
                  })
                }
              } catch (e) {
                console.error('Gagal decode JSON desain:', e)
              }
            }

            let content = `
          <p><strong>Nama:</strong> ${order.nama}</p>
          <p><strong>Email:</strong> ${order.email}</p>
          <p><strong>Nomor Telepon:</strong> ${order.nomor}</p>
          <p><strong>Alamat:</strong> ${order.alamat}</p>
          <p><strong>Status:</strong> ${order.status}</p>
          <p><strong>Deskripsi:</strong> ${order.deskripsi}</p>
          <p><strong>File Ukuran:</strong>  <a href="/${order.fileUkuran}" class="btn btn-sm btn-info" download> <i class="bi bi-download"></i> Download Ukuran </a></p>
          ${desainContent}
        `
            let footer = ``

            $('#orderDetailsContent').html(content)
            $('#orderDetailsModal').modal('show')
          },
          error: function () {
            Swal.fire('Error', 'Gagal mengambil data pesanan.', 'error')
          },
        })
      }

      function updateStatus(orderId) {
        const status = $('#status' + orderId).val()

        Swal.fire({
          title: 'Memproses...',
          text: 'Mohon tunggu, status sedang diperbarui.',
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
          url: '/admin/update-order-status/' + orderId,
          type: 'POST',
          data: { status: status },
          success: function (response) {
            if (response.success) {
              Swal.fire('Berhasil', 'Status berhasil diupdate.', 'success')
            } else {
              Swal.fire('Gagal', 'Gagal mengupdate status.', 'error')
            }
          },
          error: function () {
            Swal.fire('Error', 'Gagal mengupdate status.', 'error')
          },
        })
      }

      function hapusPesanan(orderId) {
        Swal.fire({
          title: 'Hapus pesanan?',
          text: 'Pesanan ini akan dihapus permanen!',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonText: 'Hapus',
          cancelButtonText: 'Batal',
        }).then((result) => {
          if (result.isConfirmed) {
            // CSRF setup
            $.ajaxSetup({
              headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
              },
            })
            $.ajax({
              url: '/admin/delete-order/' + orderId,
              type: 'POST',
              success: function (response) {
                if (response.success) {
                  Swal.fire('Dihapus!', 'Pesanan berhasil dihapus.', 'success')
                  location.reload()
                } else {
                  Swal.fire('Gagal', 'Gagal menghapus pesanan.', 'error')
                }
              },
              error: function () {
                Swal.fire('Error', 'Terjadi kesalahan dalam menghapus pesanan.', 'error')
              },
            })
          }
        })
      }
    </script>

    <script>
      $(document).ready(function () {
        // 🔁 Custom sorting untuk kolom Status
        $.fn.dataTable.ext.type.order['status-custom-pre'] = function (data) {
          const order = ['Menunggu', 'Belum Bayar', 'Sudah Bayar', 'Produksi', 'Pengiriman', 'Selesai', 'Dibatalkan']
          return order.indexOf(data.trim())
        }

        // 🧠 Inisialisasi DataTable
        $('#dataTable').DataTable({
          destroy: true,
          columnDefs: [
            {
              targets: 3, // Kolom ke-4: Status
              type: 'status-custom',
            },
            {
              targets: [1, 2, 5], // Email, No WA, Aksi (non-sortable)
              orderable: false,
            },
          ],
          order: [[4, 'asc']], // Urut default berdasarkan kolom ke-5 (Tanggal)
        })

        // 🎯 Set value <select> status sesuai atribut data-status
        $('select.form-select').each(function () {
          var currentStatus = $(this).data('status')
          $(this).val(currentStatus)
        })
      })
    </script>

    <script>
      $('.btn-invoice').on('click', function () {
        const pesananId = $(this).data('id')
        $('#invoice-pesanan-id').val(pesananId)
        $('#invoice-ukuran-table tbody').empty()

        // Ambil data ukuran dari server
        $.get(`/admin/ukuran/${pesananId}`, function (data) {
          data.ukuran.forEach((item, i) => {
            $('#invoice-ukuran-table tbody').append(`
          <tr>
            <td><input type="text" class="form-control" name="jenis_pakaian[${i}]" value="${item.jenis_pakaian}" readonly></td>
            <td><input type="text" class="form-control" name="ukuran[${i}]" value="${item.ukuran}" readonly></td>
            <td><input type="number" class="form-control" name="jumlah[${i}]" value="${item.jumlah}" readonly></td>
            <td><input type="number" class="form-control" name="harga_satuan[${i}]" value="${item.harga_satuan}" required></td>
          </tr>
        `)
          })
        })
      })

      $('#invoiceForm').submit(function (e) {
        e.preventDefault()

        // CSRF setup
        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
          },
        })

        const formData = $(this).serialize()
        console.log(formData)

        $.post('/admin/simpan-invoice', formData, function (res) {
          Swal.fire('Berhasil!', res.message, 'success')
          $('#invoiceModal').modal('hide')
        }).fail(function () {
          Swal.fire('Gagal!', 'Terjadi kesalahan saat menyimpan invoice.', 'error')
        })
      })
    </script>
    <script>
      $('.form-work-order').on('submit', function (e) {
        e.preventDefault() // jangan biarkan form reload halaman

        const form = $(this)
        const url = form.attr('action')
        const data = form.serialize() // kumpulkan semua input

        $.ajax({
          url: url,
          method: 'POST', // meskipun pakai PUT spoofing
          data: data,
          success: function (response) {
            Swal.fire({
              icon: 'success',
              title: 'Berhasil',
              text: response.message,
              timer: 2000,
            })
          },
          error: function (xhr) {
            Swal.fire({
              icon: 'error',
              title: 'Gagal',
              text: xhr.responseJSON?.message || 'Terjadi kesalahan',
            })
          },
        })
      })
    </script>
    <script>
      $(document).ready(function () {
        $('#print-invoice-btn').on('click', function () {
          const pesananId = $('#invoice-pesanan-id').val()
          if (pesananId) {
            const url = `/pelanggan/invoice/${pesananId}`
            window.open(url, '_blank')
          } else {
            alert('ID pesanan tidak tersedia.')
          }
        })
      })
    </script>
  </body>
</html>
