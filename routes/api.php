<?php

use App\Http\Controllers\Api\AbsenController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\Api\ProfilePerusahaanController;
use App\Http\Controllers\Api\RolesController;
use App\Http\Controllers\Api\SettingRolesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Yang Belum Login Dan Register (daftar)
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');

// Yang Sudah Login
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
return $request->user();
});

// Yang sudah Login
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/change-password', [AuthController::class, 'change_password']);
});

Route::middleware(['auth:sanctum', 'Admin'])->prefix('admin')->group(function () {
    Route::post('/search-user', [AuthController::class, 'search']);
    Route::resource('roles', RolesController::class);
    Route::resource('setting_roles', SettingRolesController::class);
    Route::resource('profile_perusahaan', ProfilePerusahaanController::class);

});

    Route::middleware(['auth:sanctum', 'Pegawai'])->prefix('pegawai')->group(function () {
        Route::resource('absen', AbsenController::class);
});