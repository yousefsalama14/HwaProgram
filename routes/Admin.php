<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Auth\AuthController;
use App\Http\Controllers\Admin\weldingwireController;
use App\Http\Controllers\Admin\dashboardController;
use App\Http\Controllers\Admin\rollingController;
use App\Http\Controllers\Admin\cuttingController;
use App\Http\Controllers\Admin\foldcontroller;
use App\Http\Controllers\Admin\materialsController;
use App\Http\Controllers\Admin\perforationController;


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
Route::controller(AuthController::class)->group(function () {
    Route::get('/Admin/login','login')->name('adminLogin');
    Route::Post('/Admin/login','Submitlogin')->name('Admin.login');
    Route::get('/Admin/logout','logout')->name('Admin.logout');
});
Route::middleware('AdminAuth')->group(function(){
    Route::resource('weldingwires', weldingwireController::class);
    Route::resource('materials', materialsController::class);
    Route::get('/upload-file', [materialsController::class, 'createForm']);
    Route::post('/upload-file', [materialsController::class, 'fileUpload'])->name('fileUpload');
    Route::controller(dashboardController::class)->group(function () {
        Route::get('/Admin/dashboard','index')->name('Admin.dashboard');
    });
      Route::resource('rollings', rollingController::class);
      Route::resource('cuttings', cuttingController::class);
      Route::resource('folds', foldcontroller::class);
      Route::controller(perforationController::class)->group(function () {
        Route::get('/perforation', 'index')->name('perforation.index');
        Route::post('/getThickness','getThickness');
        Route::post('/getDiameter','getDiameter');
        Route::post('/getPrice','getPrice');
        Route::post('/updatePrice','updatePrice')->name('perforation.updatePrice');
    });
});

