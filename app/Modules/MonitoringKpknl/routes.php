<?php

use Illuminate\Support\Facades\Route;
use App\Modules\MonitoringKpkNl\Controllers\TimPenilaianController;
use App\Modules\MonitoringKpkNl\Controllers\TahapMonitoringController;
use App\Modules\MonitoringKpkNl\Controllers\PermohonanController;
use App\Modules\MonitoringKpkNl\Controllers\PerjalananController;

$slug = 'tim_penilaian';
Route::group(['middleware' => ['web','auth'],'namespace' => 'App\Modules'.$nama_modul.'\Controllers','prefix'=>$slug], function () use ($slug){
    Route::get('/', [TimPenilaianController::class, 'index'])->name($slug.'.read');
    Route::get('/create', [TimPenilaianController::class, 'create'])->name($slug.'.create');
    Route::post('/store', [TimPenilaianController::class, 'store'])->name($slug.'.store');
    Route::get('/edit/{id}', [TimPenilaianController::class, 'edit'])->name($slug.'.edit');
    Route::post('/update', [TimPenilaianController::class, 'update'])->name($slug.'.update');
    Route::get('/delete/{id}', [TimPenilaianController::class, 'delete'])->name($slug.'.delete');
});

$slug = 'tahap_monitoring';
Route::group(['middleware' => ['web','auth'],'namespace' => 'App\Modules'.$nama_modul.'\Controllers','prefix'=>$slug], function () use ($slug){
    Route::get('/', [TahapMonitoringController::class, 'index'])->name($slug.'.read');
    Route::get('/create', [TahapMonitoringController::class, 'create'])->name($slug.'.create');
    Route::post('/store', [TahapMonitoringController::class, 'store'])->name($slug.'.store');
    Route::get('/edit/{id}', [TahapMonitoringController::class, 'edit'])->name($slug.'.edit');
    Route::post('/update', [TahapMonitoringController::class, 'update'])->name($slug.'.update');
    Route::get('/delete/{id}', [TahapMonitoringController::class, 'delete'])->name($slug.'.delete');
});

$slug = 'permohonan';
Route::group(['middleware' => ['web','auth'],'namespace' => 'App\Modules'.$nama_modul.'\Controllers','prefix'=>$slug], function () use ($slug){
    Route::get('/', [PermohonanController::class, 'index'])->name($slug.'.read');
    Route::get('/create', [PermohonanController::class, 'create'])->name($slug.'.create');
    Route::post('/store', [PermohonanController::class, 'store'])->name($slug.'.store');
    Route::get('/edit/{id}', [PermohonanController::class, 'edit'])->name($slug.'.edit');
    Route::post('/update', [PermohonanController::class, 'update'])->name($slug.'.update');
    Route::get('/delete/{id}', [PermohonanController::class, 'delete'])->name($slug.'.delete');
});

$slug = 'perjalanan_permohonan';
Route::group(['middleware' => ['web','auth'],'namespace' => 'App\Modules'.$nama_modul.'\Controllers','prefix'=>$slug], function () use ($slug){
    Route::get('/', [PerjalananController::class, 'index'])->name($slug.'.read');
    Route::post('/detail', [PerjalananController::class, 'detail'])->name($slug.'.detail.read');
    Route::get('/detail/{no_permohonan}', [PerjalananController::class, 'detail'])->name($slug.'.detail-get.read');
    Route::get('/form-konfirmasi/{id}', [PerjalananController::class, 'formKonfirmasi'])->name($slug.'.form-konfirmasi.read');
    Route::get('/verifikasi-kelengkapan/{id}', [PerjalananController::class, 'formVerifikasiKelengkapan'])->name($slug.'.form-verifikasi-kelengkapan.read');
    Route::post('/verifikasi-kelengkapan', [PerjalananController::class, 'postVerifikasiKelengkapan'])->name($slug.'.verifikasi-kelengkapan.read');
});
