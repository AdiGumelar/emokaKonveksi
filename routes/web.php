<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\PemesananController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\MidtransWebhookController;
use Illuminate\Support\Facades\Response;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Login
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/loginUser', [AuthController::class, 'login']);

// Register
Route::get('/registrasi', [AuthController::class, 'showRegister']);
Route::post('/regisUser', [AuthController::class, 'register']);

// Logout
Route::get('/logout', function () {
    Auth::logout();
    session()->forget('admin_emoka');
    return redirect('/');
})->name('logout');

Route::get('/admin/logout', function () {
    session()->forget('admin');
    return redirect('/');
})->name('admin.logout');


//Lupa Password
Route::get('/lupa-password', [ForgotPasswordController::class, 'showForm']);
Route::post('/lupa-password', [ForgotPasswordController::class, 'handleRequest']);

// LandingPage
Route::get('/', [LandingController::class, 'home']);
Route::post('/kirim-pesan', [LandingController::class, 'kirimPesan']);

//Pemesanan
Route::middleware(['auth'])->group(function () {
    Route::get('/form-pemesanan', [PemesananController::class, 'showForm'])->name('form.pemesanan');
    Route::post('/buat-pesanan', [PemesananController::class, 'buatPesanan'])->name('buat.pesanan');
});

//Tracking Pesanan
Route::middleware(['auth'])->get('/tracking-pesanan', [PemesananController::class, 'trackingPesanan'])->name('tracking.pesanan');
Route::get('/pelanggan/invoice/{id}', [PemesananController::class, 'invoice'])->name('admin.invoice');
Route::get('/midtrans/token/{id}', [PemesananController::class, 'getPaymentToken']);
Route::put('/pelanggan/pesanan/{id}/batal', [PemesananController::class, 'batalkanPesanan'])->name('pelanggan.batalkanPesanan');

//Profile
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

//Dashboard
Route::middleware('admin.session')->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
});

//Data Pemesanan
Route::middleware(['admin.session'])->group(function () {
    Route::get('/admin/data-pemesanan', [AdminController::class, 'dataPemesanan'])->name('admin.dataPemesanan');
    Route::get('/admin/order-details/{id}', [AdminController::class, 'orderDetails']);
    Route::post('/admin/update-order-status/{id}', [AdminController::class, 'updateOrderStatus']);
    Route::post('/admin/delete-order/{id}', [AdminController::class, 'deleteOrder']);
    Route::get('/admin/ukuran/{pesanan_id}', [AdminController::class, 'getUkuran']);
    Route::post('/admin/simpan-invoice', [AdminController::class, 'simpanInvoice']);
    Route::put('/admin/work-order/{pemesanan}', [AdminController::class, 'WorkOrderUpdate'])->name('work-order.update');
    Route::get('/admin/work-order/cetak/{id}', [AdminController::class, 'cetakWorkOrder'])->name('admin.work-order.print');
});



//Manajemen Produk
Route::middleware('admin.session')->prefix('admin')->group(function () {
    Route::get('/produk', [AdminController::class, 'produk'])->name('admin.produk');
    Route::post('/produk/tambah', [AdminController::class, 'tambahProduk'])->name('admin.produk.tambah');
    Route::post('/produk/hapus/{id}', [AdminController::class, 'hapusProduk'])->name('admin.produk.hapus');
});







