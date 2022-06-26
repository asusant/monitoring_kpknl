<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Dashboard\HomeController;
use App\Modules\Bobb\Controllers\BobbController;
use App\Modules\Epromosi\Controllers\EpromosiController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('sample.fe-sample');
})->name('slash');

// Route::middleware('web')->get('/', [BobbController::class, 'index'])->name('slash');

// function () {
//     return view('sample.fe-sample');
// }

/**
 * AUTH ROUTE
 */
Route::prefix('auth')->name('auth.')->middleware('guest')->group(function(){
    Route::get('login', [LoginController::class, 'index'])->name('login.view');
    Route::post('login', [LoginController::class, 'processLogin'])->name('login.post');
    // SSO
    Route::get('sso_login', [LoginController::class, 'ssoLogin'])->name('sso-login.view');
    Route::post('sso_login', [LoginController::class, 'doSsoLogin'])->name('sso-login.post');
});
Route::middleware('auth')->get('auth/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('auth/sso_logout', [LoginController::class, 'ssoLogout'])->name('logout.sso.post');

/**
 * Dashboard
 */
Route::middleware('web','auth')->get('/dashboard', [BobbController::class, 'index'])->name('dashboard.read');
