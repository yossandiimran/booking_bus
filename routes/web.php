<?php

use Illuminate\Support\Facades\Route;

Auth::routes(['register' => false]);

Route::get('/', 'FrontEndController@index')->name('index');
Route::get('/fe', 'FrontEndController@index')->name('fe');
Route::post('/prosesFormFe', 'FrontEndController@prosesFormFe')->name('prosesFormFe');
Route::post('/createTransaksi', 'FrontEndController@createTransaksi')->name('createTransaksi');

Route::get('/admin', function () { return redirect('admin/beranda'); });
Route::get('home', function () { return redirect('admin/beranda'); })->name('home');

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin','middleware' => 'auth'], function () {
    Route::get('/', function () { return redirect('admin/beranda'); });
    Route::get('beranda', 'HomeController@index')->name('index');

    // Helper Route Untuk get value select Form
    Route::get('getSelectsopir', 'HelperController@getSelectsopir')->name('getSelectsopir');

    // Master route
    Route::group(['prefix' => 'master', 'namespace' => 'Master', 'as' => 'master.','middleware' => ['permission:1,2']], function () {
        // Master Bus
        Route::group(['prefix' => 'bus', 'as' => 'bus.','middleware' => ['permission:1']], function () {
            Route::get('/', 'MasterBusController@index')->name('index');
            Route::post('detail', 'MasterBusController@detail')->name('detail');
            Route::post('store', 'MasterBusController@store')->name('store');
            Route::post('scopeData', 'MasterBusController@scopeData')->name('scopeData');
            Route::post('destroy', 'MasterBusController@destroy')->name('destroy');
        });
        // Master Sopir
        Route::group(['prefix' => 'sopir', 'as' => 'sopir.','middleware' => ['permission:1']], function () {
            Route::get('/', 'MasterSopirController@index')->name('index');
            Route::post('detail', 'MasterSopirController@detail')->name('detail');
            Route::post('store', 'MasterSopirController@store')->name('store');
            Route::post('scopeData', 'MasterSopirController@scopeData')->name('scopeData');
            Route::post('destroy', 'MasterSopirController@destroy')->name('destroy');
        });
         // Master Tempat
         Route::group(['prefix' => 'tempat', 'as' => 'tempat.','middleware' => ['permission:1']], function () {
            Route::get('/', 'MasterTempatController@index')->name('index');
            Route::post('detail', 'MasterTempatController@detail')->name('detail');
            Route::post('store', 'MasterTempatController@store')->name('store');
            Route::post('scopeData', 'MasterTempatController@scopeData')->name('scopeData');
            Route::post('destroy', 'MasterTempatController@destroy')->name('destroy');
        });
    });

    // Transaksi route
    Route::group(['prefix' => 'transaksi', 'namespace' => 'Transaksi', 'as' => 'transaksi.','middleware' => ['permission:1,2']], function () {
        // Master Bus
        Route::group(['prefix' => 'transaction', 'as' => 'transaction.','middleware' => ['permission:1']], function () {
            Route::get('/', 'TransaksiController@index')->name('index');
            Route::post('detail', 'TransaksiController@detail')->name('detail');
            Route::post('store', 'TransaksiController@store')->name('store');
            Route::post('scopeData', 'TransaksiController@scopeData')->name('scopeData');
            Route::post('destroy', 'TransaksiController@destroy')->name('destroy');
        });
    });

    // Transaksi Route
    Route::group(['prefix' => 'transaksi', 'namespace' => 'Transaksi', 'as' => 'transaksi.','middleware' => ['permission:1,2']], function () {
        // Transaksi
        Route::get('/', 'TransaksiController@index')->name('index');
        Route::post('action', 'TransaksiController@store')->name('store');
        Route::post('detail', 'TransaksiController@detail')->name('detail');
        Route::post('scopeData', 'TransaksiController@scopeData')->name('scopeData');
        Route::post('destroy', 'TransaksiController@destroy')->name('destroy');
        // Report
        Route::get('report', 'ReportController@index')->name('report');
    });

});
 