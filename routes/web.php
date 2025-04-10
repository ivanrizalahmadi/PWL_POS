<?php

use App\Http\Controllers\KategoriController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\WelcomeController;

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
Route::get('/', [WelcomeController::class, 'index']);

Route::group(['prefix' => 'user'], function () {
    // Menampilkan halaman awal user
    Route::get('/', [UserController::class, 'index']);

    // Menampilkan data user dalam bentuk JSON untuk DataTables
    Route::post('/list', [UserController::class, 'list']);

    // Menampilkan halaman form tambah user
    Route::get('/create', [UserController::class, 'create']);

    // Menyimpan data user baru
    Route::post('/', [UserController::class, 'store']);

    // Menampilkan detail user
    Route::get('/{id}', [UserController::class, 'show']);

    // Menampilkan halaman form edit user
    Route::get('/{id}/edit', [UserController::class, 'edit']);

    // Menyimpan perubahan data user
    Route::put('/{id}', [UserController::class, 'update']);

    // Menghapus data user
    Route::delete('/{id}', [UserController::class, 'destroy']);
});