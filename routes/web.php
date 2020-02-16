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

  Route::get('/payment', 'PunkController@payment')->name('payment');
  Route::post('/payment_store', 'PunkController@paymentStore')->name('paymentstore');

  Route::get('/stock', 'PunkController@stock')->name('stock');
  Route::post('/stockstore', 'PunkController@stockStore')->name('stockstore');

  Route::get('/fuel_view', 'PunkController@fuelView')->name('fuelview');
  Route::get('/payment_view', 'PunkController@paymentView')->name('paymentview');
  Route::get('/stock_view', 'PunkController@stockview')->name('stockview');

  Route::get('fuels/tcpdf', 'PunkController@tcpdfFuel')->name('tcpdfFuel');
  // Route::get('fuels/tcpdf', 'PunkController@printall')->name('tcpdf.printall');


});
