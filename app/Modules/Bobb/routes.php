<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Bobb\Controllers\BobbController;

/**
 * DASHBOARD
 */
$slug = strtolower($module);

Route::group(['middleware' => ['web','auth'],'namespace' => 'App\Modules'.$nama_modul.'\Controllers','prefix'=>$slug], function () use ($slug){
    Route::get('/', [BobbController::class, 'index'])->name($slug.'.read');
});

/**
 * Change Role
 */
$slug = 'change_role';
Route::group(['middleware' => ['web','auth'],'namespace' => 'App\Modules'.$nama_modul.'\Controllers','prefix'=>$slug], function () use ($slug){
    Route::get('/{role}/{unit_keu?}', [BobbController::class, 'changeRole'])->name($slug.'.read');
});

/**
 * Sys Menu Group
 */
$slug = 'sys_menu_group';
Route::group(['middleware' => ['web','auth'],'namespace' => 'App\Modules'.$nama_modul.'\Controllers','prefix'=>$slug], function () use ($slug){
    Route::get('/', [BobbController::class, 'sysMenuGroupIndex'])->name($slug.'.read');
    Route::get('/create', [BobbController::class, 'sysMenuGroupCreate'])->name($slug.'.create');
    Route::post('/store', [BobbController::class, 'sysMenuGroupStore'])->name($slug.'.store');
    Route::get('/edit/{id}', [BobbController::class, 'sysMenuGroupEdit'])->name($slug.'.edit');
    Route::post('/update', [BobbController::class, 'sysMenuGroupUpdate'])->name($slug.'.update');
    Route::get('/delete/{id}', [BobbController::class, 'sysMenuGroupDelete'])->name($slug.'.delete');
});

/**
 * Sys Module Group
 */
$slug = 'sys_module_group';
Route::group(['middleware' => ['web','auth'],'namespace' => 'App\Modules'.$nama_modul.'\Controllers','prefix'=>$slug], function () use ($slug){
    Route::get('/{id_menu}', [BobbController::class, 'sysModuleGroupIndex'])->name($slug.'.read');
    Route::get('/{id_menu}/create', [BobbController::class, 'sysModuleGroupCreate'])->name($slug.'.create');
    Route::post('/store', [BobbController::class, 'sysModuleGroupStore'])->name($slug.'.store');
    Route::get('/edit/{id}', [BobbController::class, 'sysModuleGroupEdit'])->name($slug.'.edit');
    Route::post('/update', [BobbController::class, 'sysModuleGroupUpdate'])->name($slug.'.update');
    Route::get('/delete/{id}', [BobbController::class, 'sysModuleGroupDelete'])->name($slug.'.delete');
});

/**
 * Sys Module
 */
$slug = 'sys_module';
Route::group(['middleware' => ['web','auth'],'namespace' => 'App\Modules'.$nama_modul.'\Controllers','prefix'=>$slug], function () use ($slug){
    Route::get('/{id_modul}', [BobbController::class, 'sysModuleIndex'])->name($slug.'.read');
    Route::get('/{id_modul}/create', [BobbController::class, 'sysModuleCreate'])->name($slug.'.create');
    Route::post('/store', [BobbController::class, 'sysModuleStore'])->name($slug.'.store');
    Route::get('/edit/{id}', [BobbController::class, 'sysModuleEdit'])->name($slug.'.edit');
    Route::post('/update', [BobbController::class, 'sysModuleUpdate'])->name($slug.'.update');
    Route::get('/delete/{id}', [BobbController::class, 'sysModuleDelete'])->name($slug.'.delete');
});

/**
 * Sys Role
 */
$slug = 'sys_role';
Route::group(['middleware' => ['web','auth'],'namespace' => 'App\Modules'.$nama_modul.'\Controllers','prefix'=>$slug], function () use ($slug){
    Route::get('/', [BobbController::class, 'sysRoleIndex'])->name($slug.'.read');
    Route::get('/create', [BobbController::class, 'sysRoleCreate'])->name($slug.'.create');
    Route::post('/store', [BobbController::class, 'sysRoleStore'])->name($slug.'.store');
    Route::get('/edit/{id}', [BobbController::class, 'sysRoleEdit'])->name($slug.'.edit');
    Route::post('/update', [BobbController::class, 'sysRoleUpdate'])->name($slug.'.update');
    Route::get('/delete/{id}', [BobbController::class, 'sysRoleDelete'])->name($slug.'.delete');
    Route::get('/validate/{id}', [BobbController::class, 'sysRoleDelete'])->name($slug.'.validate');
});

/**
 * Sys User
 */
$slug = 'sys_user';
Route::group(['middleware' => ['web','auth'],'namespace' => 'App\Modules'.$nama_modul.'\Controllers','prefix'=>$slug], function () use ($slug){
    Route::get('/', [BobbController::class, 'sysUserIndex'])->name($slug.'.read');
    Route::get('/create', [BobbController::class, 'sysUserCreate'])->name($slug.'.create');
    Route::post('/store', [BobbController::class, 'sysUserStore'])->name($slug.'.store');
    Route::get('/edit/{id}', [BobbController::class, 'sysUserEdit'])->name($slug.'.edit');
    Route::post('/update', [BobbController::class, 'sysUserUpdate'])->name($slug.'.update');
    Route::get('/delete/{id}', [BobbController::class, 'sysUserDelete'])->name($slug.'.delete');
});

/**
 * Sys User Role
 */
$slug = 'sys_user_role';
Route::group(['middleware' => ['web','auth'],'namespace' => 'App\Modules'.$nama_modul.'\Controllers','prefix'=>$slug], function () use ($slug){
    Route::get('/{id_user}', [BobbController::class, 'sysUserRoleIndex'])->name($slug.'.read');
    Route::get('/{id_user}/create', [BobbController::class, 'sysUserRoleCreate'])->name($slug.'.create');
    Route::post('/store', [BobbController::class, 'sysUserRoleStore'])->name($slug.'.store');
    Route::get('/edit/{id}', [BobbController::class, 'sysUserRoleEdit'])->name($slug.'.edit');
    Route::post('/update', [BobbController::class, 'sysUserRoleUpdate'])->name($slug.'.update');
    Route::get('/delete/{id}', [BobbController::class, 'sysUserRoleDelete'])->name($slug.'.delete');
});

/**
 * Sys Setting
 */
$slug = 'sys_setting';
Route::group(['middleware' => ['web','auth'],'namespace' => 'App\Modules'.$nama_modul.'\Controllers','prefix'=>$slug], function () use ($slug){
    Route::get('/', [BobbController::class, 'sysSettingIndex'])->name($slug.'.read');
    Route::post('/create', [BobbController::class, 'sysSettingCreate'])->name($slug.'.create');
    Route::post('/update', [BobbController::class, 'sysSettingUpdate'])->name($slug.'.update');
});

/**
 * App Setting
 */
$slug = 'app_setting';
Route::group(['middleware' => ['web','auth'],'namespace' => 'App\Modules'.$nama_modul.'\Controllers','prefix'=>$slug], function () use ($slug){
    Route::get('/', [BobbController::class, 'appSettingIndex'])->name($slug.'.read');
    Route::post('/create', [BobbController::class, 'appSettingCreate'])->name($slug.'.create');
    Route::post('/update', [BobbController::class, 'appSettingUpdate'])->name($slug.'.update');
});
