<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HangHoaController;
use App\Http\Controllers\LoaiHangController;
use App\Http\Controllers\NhaCungCapController;
use App\Http\Controllers\NhapKhoController;
use App\Http\Controllers\XuatKhoController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ThongKeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\DashboardController;

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

Route::middleware(['auth'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::prefix('hang-hoa')->group(function () {
        Route::get('/', [HangHoaController::class, 'index'])->name('hang-hoa.index');
        Route::get('/xem/{code}', [HangHoaController::class, 'show'])->name('hang-hoa.show');
        Route::get('/in-barcode/{code}', [HangHoaController::class, 'exportBarcode'])->name('hang-hoa.in-barcode');
        Route::get('/xem/{code}?{ma_ncc}', [HangHoaController::class, 'show'])->name('hang-hoa.showInfo');
        Route::get('/them', [HangHoaController::class, 'create'])->name('hang-hoa.create')->middleware('can:user');
        Route::post('/them', [HangHoaController::class, 'store'])->name('hang-hoa.store')->middleware('can:user');
        Route::get('/sua/{code}', [HangHoaController::class, 'edit'])->name('hang-hoa.edit')->middleware('can:user');
        Route::put('/sua/{code}', [HangHoaController::class, 'update'])->name('hang-hoa.update')->middleware('can:user');
        Route::get('/sua-chi-tiet/{code}?{id}', [HangHoaController::class, 'editItem'])->name('hang-hoa.editItem')->middleware('can:user');
        Route::put('/sua-chi-tiet/{code}?{id}', [HangHoaController::class, 'storeItem'])->name('hang-hoa.storeItem')->middleware('can:user');
        Route::delete('/xoa/{id}', [HangHoaController::class, 'destroy'])->name('hang-hoa.delete')->middleware('can:user');
    });

    Route::prefix('loai-hang')->group(function () {
        Route::get('/', [LoaiHangController::class, 'index'])->name('loai-hang.index');
        Route::get('/them', [LoaiHangController::class, 'create'])->name('loai-hang.create')->middleware('can:user');
        Route::post('/them', [LoaiHangController::class, 'store'])->name('loai-hang.store')->middleware('can:user');
        Route::get('/sua/{id}', [LoaiHangController::class, 'edit'])->name('loai-hang.edit')->middleware('can:user');
        Route::put('/sua/{id}', [LoaiHangController::class, 'update'])->name('loai-hang.update')->middleware('can:user');
        Route::get('/xem/{id}', [LoaiHangController::class, 'show'])->name('loai-hang.show');
        Route::delete('/xoa/{id}', [LoaiHangController::class, 'destroy'])->name('loai-hang.delete')->middleware('can:user');
    });

    Route::prefix('nhap-kho')->group(function () {
        Route::get('/', [NhapKhoController::class, 'index'])->name('nhap-kho.index');
        Route::get('/tao-phieu', [NhapKhoController::class, 'create'])->name('nhap-kho.create');
        Route::post('/tao-phieu-n', [NhapKhoController::class, 'store'])->name('nhap-kho.store');
        Route::post('/tao-phieu', [NhapKhoController::class, 'import'])->name('nhap-kho.import');
        Route::get('/xem/{code}', [NhapKhoController::class, 'show'])->name('nhap-kho.show');
    });

    Route::prefix('xuat-kho')->group(function () {
        Route::get('/', [XuatKhoController::class, 'index'])->name('xuat-kho.index');
        Route::get('/tao-phieu', [XuatKhoController::class, 'create'])->name('xuat-kho.create');
        Route::post('/tao-phieu-excel', [XuatKhoController::class, 'export'])->name('xuat-kho.export');
        Route::get('/download-excel', [XuatKhoController::class, 'download'])->name('xuat-kho.download');
        Route::get('/xem/{code}', [XuatKhoController::class, 'show'])->name('xuat-kho.show');
    });

    Route::prefix('nha-cung-cap')->group(function () {
        Route::get('/', [NhaCungCapController::class, 'index'])->name('nha-cung-cap.index');
        Route::get('/them', [NhaCungCapController::class, 'create'])->name('nha-cung-cap.create')->middleware('can:user');
        Route::post('/them', [NhaCungCapController::class, 'store'])->name('nha-cung-cap.store')->middleware('can:user');
        Route::get('/xem/{code}', [NhaCungCapController::class, 'show'])->name('nha-cung-cap.show');
        Route::get('/sua/{code}', [NhaCungCapController::class, 'edit'])->name('nha-cung-cap.edit')->middleware('can:user');
        Route::put('/sua/{code}', [NhaCungCapController::class, 'update'])->name('nha-cung-cap.update')->middleware('can:user');
    });

    Route::prefix('profile')->group(function () {
        Route::get('/', [UserController::class, 'show'])->name('user.show');
        Route::post('/doi-mat-khau', [UserController::class, 'updatePassword'])->name('user.updatePassword');
        Route::put('/doi-thong-tin', [UserController::class, 'updateProfile'])->name('user.updateProfile');
    });

    Route::prefix('thong-ke')->group(function () {
        Route::get('/', [ThongKeController::class, 'index'])->name('thong-ke.index');
        Route::get('/export', [ThongKeController::class, 'export'])->name('thong-ke.export');
    });

    Route::prefix('tai-khoan')->middleware('can:user')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('tai-khoan.index');
        Route::get('/them-tai-khoan', [RegisterController::class, 'showRegistrationForm'])->name('register');
        Route::post('/them-tai-khoan', [RegisterController::class, 'register']);
        Route::put('/{id}', [UserController::class, 'changeRole'])->name('user.changeRole');
        Route::get('/xem/{id}', [UserController::class, 'showUser'])->name('tai-khoan.showUser');
        Route::delete('/xoa/{id}', [UserController::class, 'delete'])->name('tai-khoan.delete');
    });
});

Route::get('/dang-nhap', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/dang-nhap', [LoginController::class, 'login']);
Route::post('/dang-xuat', [LoginController::class, 'logout'])->name('logout');
