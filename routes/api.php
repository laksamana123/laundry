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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


// petugas dan admin
Route::post('register', 'PetugasController@register');
Route::post('login', 'PetugasController@login');
Route::put('ubah_petugas/{id}','PetugasController@update')->middleware('jwt.verify');
Route::delete('hapus_petugas/{id}','PetugasController@destroy')->middleware('jwt.verify');

// jenis cuci
Route::post('simpan_jenis_cuci','Jenis_cuciController@insert')->middleware('jwt.verify');
Route::put('ubah_jenis_cuci/{id}','Jenis_cuciController@update')->middleware('jwt.verify');
Route::get('jenis_cuci/{id}','Jenis_cuciController@show')->middleware('jwt.verify');
Route::delete('hapus_jenis_cuci/{id}','Jenis_cuciController@destroy')->middleware('jwt.verify');

// pelanggan
Route::post('simpan_pelanggan','PelangganController@insert')->middleware('jwt.verify');
Route::put('ubah_pelanggan/{id}','PelangganController@update')->middleware('jwt.verify');
Route::get('pelanggan/{id}','PelangganController@show')->middleware('jwt.verify');
Route::delete('hapus_pelanggan/{id}','PelangganController@destroy')->middleware('jwt.verify');

// transaksi
Route::post('simpan_transaksi','TransaksiController@insert')->middleware('jwt.verify');
Route::put('ubah_transaksi/{id}','TransaksiController@update')->middleware('jwt.verify');
Route::post('transaksi','TransaksiController@show')->middleware('jwt.verify');
Route::delete('hapus_transaksi/{id}','TransaksiController@destroy')->middleware('jwt.verify');

// detail transaksi
Route::post('simpan_detail_transaksi','Detail_transaksiController@insert')->middleware('jwt.verify');
Route::put('ubah_detail_transaksi/{id}','Detail_transaksiController@update')->middleware('jwt.verify');
Route::get('detail_transaksi','Detail_transaksiController@show')->middleware('jwt.verify');
Route::delete('hapus_detail_transaksi/{id}','Detail_transaksiController@destroy')->middleware('jwt.verify');
