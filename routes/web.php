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


Auth::routes();

Route::name('punk.')->group(function() {
  Route::get('/', 'PunkController@index')->name('index');

  Route::get('/fuel', 'PunkController@fuel')->name('fuel');
  Route::post('/fuel_store', 'PunkController@fuelStore')->name('fuelstore');
  Route::post('/fuel_update/{fuel?}', 'PunkController@fuelUpdate')->name('fuelupdate');

  Route::get('/payment', 'PunkController@payment')->name('payment');
  Route::post('/payment_store', 'PunkController@paymentStore')->name('paymentstore');
  Route::post('/payment_update/{payment?}', 'PunkController@paymentUpdate')->name('paymentupdate');

  Route::get('/stock', 'PunkController@stock')->name('stock');
  Route::post('/stockstore', 'PunkController@stockStore')->name('stockstore');
  Route::post('/stock_update/{stock?}', 'PunkController@stockUpdate')->name('stockupdate');


  Route::get('/fuel_view', 'PunkController@fuelView')->name('fuelview');
  Route::get('/payment_view', 'PunkController@paymentView')->name('paymentview');
  Route::get('/stock_view', 'PunkController@stockview')->name('stockview');


  Route::get('fuels/tcpdf', 'TCPDFController@tcpdfFuel')->name('tcpdfFuel');
  Route::get('payment/tcpdf', 'TCPDFController@tcpdfPayment')->name('tcpdfpayment');
  Route::get('stock/tcpdf', 'TCPDFController@tcpdfStock')->name('tcpdfstock');

  Route::get('rise/query', 'PunkController@riseQuery')->name('risequery');

  Route::get('profile-change', 'PunkController@profile')->name('profile');
  Route::post('profile-update', 'PunkController@profileUpdate')->name('profileupdate');

  Route::get('manager-register', 'PunkController@register')->name('register');
  Route::post('manager-store', 'PunkController@storeRegister')->name('storeregister');

  Route::get('add-today-price', 'PunkController@todayPrice')->name('todayprice');
  Route::post('today-store', 'PunkController@todayPriceStore')->name('todaypricestore');

  Route::get('users', 'PunkController@users')->name('users');
  Route::get('query/remove', 'PunkController@remove')->name('remove');


});
