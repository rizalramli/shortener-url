<?php

use App\Http\Controllers\ContentController;
use App\Http\Controllers\DaftarAdminController;
use App\Http\Controllers\GenerateLinkController;
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

Route::get('/', function () {
    return view('auth.login');
})->name('login');

Route::domain('{subdomain}.' . env('APP_DOMAIN'))->group(function () {
    Route::get('/{slug}', [ContentController::class, 'index']);
});

Auth::routes([
    'register' => false,
    'reset' => false,
    'verify' => false,
]);

Route::group(['middleware' => 'auth'], function () {
    Route::resources([
        'admin/daftar-admin' => DaftarAdminController::class,
        'admin/generate-link' => GenerateLinkController::class,
    ]);
    Route::post('admin/ubah-password-admin', [DaftarAdminController::class, 'ubah_password_admin'])->name('ubah-password-admin');
});
