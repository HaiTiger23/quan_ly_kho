<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\NhapKhoController;
use App\Http\Controllers\Api\XuatKhoController;
use App\Http\Controllers\Api\HangHoaController;
use App\Http\Controllers\DashboardController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/nhap-kho/tao-phieu/store', [NhapKhoController::class, 'store'])->name('api.nhap-kho.store');
Route::post('/nhap-kho/tao-phieu/them-hang', [NhapKhoController::class, 'add'])->name('api.them-hang.add');

Route::post('/xuat-kho/tao-phieu/store', [XuatKhoController::class, 'store'])->name('api.xuat-kho.store');
Route::post('/xuat-kho/tao-phieu/export', [XuatKhoController::class, 'export'])->name('api.xuat-kho.export');
Route::get('/xuat-kho/tao-phieu', [XuatKhoController::class, 'search'])->name('api.xuat-kho.search');

Route::middleware(['web'])->group(function () {
    Route::get('/xuat-kho/them-san-pham', [App\Http\Controllers\Api\XuatKhoController::class, 'addToCard'])->name('api.xuat-kho.add')->middleware('guest');
    Route::get('/nhap-kho/them-san-pham', [App\Http\Controllers\Api\NhapKhoController::class, 'importCart'])->name('api.nhap-kho.add')->middleware('guest');
});


Route::post('/hang-hoa', [HangHoaController::class, 'import'])->name('api.them-hang.import');
Route::get('/doanh-thu', [DashboardController::class, 'doanhThu'])->name('api.doanh-thu');

//api for application
Route::post('/login', [AuthController::class, 'login'])->name('api.login');
Route::middleware(['auth:sanctum']) ->group(function() {
    //Information
    Route::prefix('/information')->group(function() {
        Route::post('/', [UserController::class, 'view'])->name('api.view');
        Route::post('/update', [UserController::class, 'update'])->name('api.update');
        Route::post('/change-password', [UserController::class, 'changePassword'])->name('api.change_password');
    });
    //product
    Route::prefix('/product')->group(function() {
        Route::post('/', [HangHoaController::class, 'viewFromBarcode'])->name('api.product.view');
        Route::get('/', [HangHoaController::class, 'viewAll'])->name('api.prroduct.viewall');
    });

    Route::post('/sale-history', [XuatKhoController::class, 'saleHistory']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
