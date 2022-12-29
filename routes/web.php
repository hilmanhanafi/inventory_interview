<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\TransaksiController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/',[AuthController::class,'index'])->name('login');

Route::post('/auth/login',[AuthController::class,'masuk']);

Route::get('/logout',[AuthController::class,'logout']);

Route::group(['middleware' =>'auth'],function(){
    Route::get('/dashboard',[DashboardController::class,'index']);

    Route::get('/produk',[ProdukController::class,'index']);

    Route::get('/produk/create',[ProdukController::class,'create']);

    Route::get('/produk/edit/{id}',[ProdukController::class,'edit']);

    Route::post('/produk/add',[ProdukController::class,'store']);

    Route::patch('/produk/update/{id}',[ProdukController::class,'update']);

    Route::delete('/produk/{id}',[ProdukController::class,'delete']);

    Route::get('/transaksi',[TransaksiController::class,'index']);

    Route::get('/transaksi/terbanyak',[TransaksiController::class,'terbanyak']);

    Route::get('/transaksi/terendah',[TransaksiController::class,'terendah']);

    Route::post('/transaksi/add',[TransaksiController::class,'store']);

});

// Route Api
Route::get('/api/data/produk',[ProdukController::class,'apiDataProduct']);
Route::get('/api/data/transaksi',[TransaksiController::class,'getApiDataTransaksi']);
Route::get('/api/data/transaksi/filter',[TransaksiController::class,'getApiDataTransaksiFilter']);


