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
    Route::post('/konfirmasi', [PerjalananController::class, 'postKonfirmasi'])->name($slug.'.konfirmasi.read');

    Route::get('/verifikasi-kelengkapan/{id}', [PerjalananController::class, 'formVerifikasiKelengkapan'])->name($slug.'.form-verifikasi-kelengkapan.read');
    Route::post('/verifikasi-kelengkapan', [PerjalananController::class, 'postVerifikasiKelengkapan'])->name($slug.'.verifikasi-kelengkapan.read');

    Route::get('/form-kecukupan-penilai/{id}', [PerjalananController::class, 'formKecukupanPenilai'])->name($slug.'.form-kecukupan-penilai.read');
    Route::post('/kecukupan-penilai', [PerjalananController::class, 'postKecukupanPenilai'])->name($slug.'.kecukupan-penilai.read');

    //
    Route::get('/cetak-dok-verifikasi/{id}', [PerjalananController::class, 'cetakDokVerifikasi'])->name($slug.'.cetak-dok-verifikasi.read');

    // 7. Menandatangani Nota Dinas Penerbitan Surat Keputusan Tim Penilai
    Route::get('/form-ttd-nd-sk-tim-penilai/{id}', [PerjalananController::class, 'formNdSkTimPenilai'])->name($slug.'.form-nd-sk-tim-penilai.read');
    Route::post('/ttd-nd-sk-tim-penilai', [PerjalananController::class, 'postNdSkTimPenilai'])->name($slug.'.nd-sk-tim-penilai.read');

    // 8. Menerbitkan Surat Keputusan Tim Penilai
    Route::get('/form-sk-tim-penilai/{id}', [PerjalananController::class, 'formSkTimPenilai'])->name($slug.'.form-sk-tim-penilai.read');
    Route::post('/sk-tim-penilai', [PerjalananController::class, 'postSkTimPenilai'])->name($slug.'.sk-tim-penilai.read');

    // 11. Melakukan Serah Terima Berkas Permohonan kepada Tim Penilai
    Route::get('/form-st-permohonan-tim-penilai/{id}', [PerjalananController::class, 'formSerahTerimaTimPenilai'])->name($slug.'.form-st-permohonan-tim-penilai.read');
    Route::post('/st-permohonan-tim-penilai', [PerjalananController::class, 'postSerahTerimaTimPenilai'])->name($slug.'.st-permohonan-tim-penilai.read');

    // 12. Cetak form serah terima berkas
    Route::get('/cetak-st-berkas/{id}', [PerjalananController::class, 'cetakStBerkas'])->name($slug.'.cetak-st-berkas.read');

    // TODO - Belum
    // 14. Verifikasi Kelayakan Data/Informasi Permohonan Penilaian
    Route::get('/form-verif-layak-data/{id}', [PerjalananController::class, 'formVerifLayakData'])->name($slug.'.form-verif-layak-data.read');
    Route::post('/verif-layak-data', [PerjalananController::class, 'postVerifLayakData'])->name($slug.'.verif-layak-data.read');

    // 16. Membuat Konsep Nota Dinas Surat Tugas Tim Penilai dan Konsep Nota Dinas Penyampaian Jadwal Survei Lapangan
    Route::get('/form-konsep-nd-st-penilai/{id}', [PerjalananController::class, 'formKonsepNd'])->name($slug.'.form-konsep-nd-st-penilai.read');
    Route::post('/konsep-nd-st-penilai', [PerjalananController::class, 'postKonsepNd'])->name($slug.'.konsep-nd-st-penilai.read');

    // 17. Menandatangani Nota Dinas Surat Tugas Tim Penilai dan Nota Dinas Jadwal Survei Lapangan
    Route::get('/form-ttd-nd-st-penilai/{id}', [PerjalananController::class, 'formTtdNdStPenilai'])->name($slug.'.form-ttd-nd-st-penilai.read');
    Route::post('/ttd-nd-st-penilai', [PerjalananController::class, 'postTtdNdStPenilai'])->name($slug.'.ttd-nd-st-penilai.read');

    // 18. Menerbitkan Surat Tugas Tim Penilai
    Route::get('/form-st-penilai/{id}', [PerjalananController::class, 'formStTimPenilai'])->name($slug.'.form-st-penilai.read');
    Route::post('/st-penilai', [PerjalananController::class, 'postStTimPenilai'])->name($slug.'.st-penilai.read');
});
