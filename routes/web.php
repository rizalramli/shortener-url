<?php

use App\Http\Controllers\DaftarAdminController;
use App\Http\Controllers\GenerateLinkController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Auth::routes([
    'register' => false,
    'reset' => false,
    'verify' => false,
]);

Route::get('/', function () {
    return redirect()->route('login');
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::resources([
        'daftar-admin' => DaftarAdminController::class,
        'generate-link' => GenerateLinkController::class,
    ]);
    Route::post('ubah-password-admin', [DaftarAdminController::class, 'ubah_password_admin'])->name('ubah-password-admin');
});
