<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('login', 'KurirController@login');

Route::middleware('auth:api')->group( function () {
    Route::post('tambahKurir', 'KurirController@createDataKurir');
    Route::get('lihatKurir', 'KurirController@getDataKurir');
    Route::put('ubahKurir/{id}', 'KurirController@updateDataKurir');
    Route::delete('hapusKurir/{id}', 'KurirController@deleteDataKurir');
    
    Route::post('tambahBarang', 'BarangController@createDataBarang');
    Route::get('lihatBarang', 'BarangController@getDataBarang');
    Route::put('ubahBarang/{id}', 'BarangController@updateDataBarang');
    Route::delete('hapusBarang/{id}', 'BarangController@deleteDataBarang');
    
    Route::post('tambahLokasi', 'LokasiController@createDataLokasi');
    Route::get('lihatLokasi', 'LokasiController@getDataLokasi');
    Route::put('ubahLokasi/{id}', 'LokasiController@updateDataLokasi');
    Route::delete('hapusLokasi/{id}', 'LokasiController@deleteDataLokasi');

    Route::post('tambahPengiriman', 'PengirimanController@createDataPengiriman');
    Route::get('lihatPengiriman', 'PengirimanController@getDataPengiriman');
    Route::put('ubahStatus/{id}', 'PengirimanController@approval');
});
