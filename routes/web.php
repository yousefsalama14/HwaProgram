<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\Auth\AuthController;
use App\Http\Controllers\User\Home\HomeController;
use App\Http\Controllers\User\welding\weldingController;
use App\Http\Controllers\User\Cart\CartController;
use App\Http\Controllers\User\rolling\rollingController;
use App\Http\Controllers\User\Cutting\cuttingController;
use App\Http\Controllers\user\foldcontroller;

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
    return redirect()->route('user.home');
});


Route::controller(AuthController::class)->group(function () {
    Route::get('/login', 'login')->name('login');
    Route::Post('/user/login', 'Submitlogin')->name('user.login');

    Route::get('/logout', 'logout')->name('logout');
});
Route::middleware('auth')->group(function () {
    Route::controller(HomeController::class)->group(function () {
        Route::get('/user/home', 'index')->name('user.home');
    });

    Route::controller(weldingController::class)->group(function () {
        Route::get('/user/welding', 'index')->name('user.welding');
        Route::post('/user/welding', 'weldingorder')->name('welding.order');
        Route::get('/user/orderdetailes/delete/{id}', 'deleteOrderDetailes')->name('user.deleteOrderDetailes');
    });


    Route::controller(CartController::class)->group(function () {
        Route::get('/user/cart', 'index')->name('user.cart');
        Route::post('/user/paied', 'paied')->name('user.paied');
    });


    Route::controller(rollingController::class)->group(function () {
        Route::get('/user/rolling', 'index')->name('user.rolling');
        Route::post('/user/rolling', 'rollingorder')->name('rolling.order');
    });

    Route::controller(cuttingController::class)->group(function () {
        Route::get('/user/cutting/boards', 'indexboards')->name('user.cutting.boards');
        Route::post('/user/cutting/boardsorder', 'cuttingboardorder')->name('user.cuttingboard.order');
        Route::get('/user/cutting/bulbs', 'indexbulbs')->name('user.cutting.bulbs');
        Route::post('/user/cutting/bulbs', 'cuttingbulbsorder')->name('user.cuttingbulbs.order');
        Route::get('/user/cutting/pallet', 'indexpallet')->name('user.cutting.pallet');
        Route::post('/user/cutting/pallet', 'cuttingpallet')->name('user.cuttinpallet.order');
    });


    Route::controller(foldcontroller::class)->group(function () {
        Route::get('/user/folding/boards', 'indexboards')->name('user.folding.boards');
        Route::post('/user/folding/boardsorder', 'foldingboardorder')->name('user.foldingboard.order');

        Route::get('/user/folding/pallet', 'indexpallet')->name('user.folding.pallet');
        Route::post('/user/folding/palletorder', 'foldingpalletorder')->name('user.foldingpallet.order');

        Route::get('/user/folding/ornaments', 'indexornaments')->name('user.folding.ornaments');
        Route::post('/user/folding/ornaments', 'foldingornamentsorder')->name('user.foldingornaments.order');
    });
});
