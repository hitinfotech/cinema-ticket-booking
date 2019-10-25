<?php

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

Route::get('/', 'BookingController@index');
Route::post('/submit-booking', 'BookingController@booknow')->name('submit_booking');
Route::post('/cancel-booking', 'BookingController@cancelbooking')->name('cancel_booking');