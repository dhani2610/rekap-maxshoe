<?php

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

Auth::routes();

Route::get('/', 'HomeController@redirectAdmin')->name('index');
Route::get('/home', 'HomeController@index')->name('home');

Route::get('/admin/register', 'BerandaController@register')->name('admin-register');
Route::post('/admin/register/store', 'BerandaController@registerStore')->name('admin-register-store');

/**
 * Admin routes
 */
Route::group(['prefix' => 'admin'], function () {
    Route::get('/', 'Backend\DashboardController@index')->name('admin.dashboard');
    Route::resource('roles', 'Backend\RolesController', ['names' => 'admin.roles']);
    Route::resource('users', 'Backend\UsersController', ['names' => 'admin.users']);
    Route::resource('admins', 'Backend\AdminsController', ['names' => 'admin.admins']);


    Route::group(['prefix' => 'produk'], function () {
        Route::get('/', 'Backend\ProdukController@index')->name('produk');
        Route::post('store', 'Backend\ProdukController@store')->name('produk.store');
        Route::post('update/{id}', 'Backend\ProdukController@update')->name('produk.update');
        Route::get('destroy/{id}', 'Backend\ProdukController@destroy')->name('produk.destroy');
    });

    Route::group(['prefix' => 'produk'], function () {
        Route::get('/', 'Backend\ProdukController@index')->name('produk');
        Route::post('store', 'Backend\ProdukController@store')->name('produk.store');
        Route::post('update/{id}', 'Backend\ProdukController@update')->name('produk.update');
        Route::get('destroy/{id}', 'Backend\ProdukController@destroy')->name('produk.destroy');
    });

    Route::group(['prefix' => 'karyawan'], function () {
        Route::get('/', 'Backend\KaryawanController@index')->name('karyawan');
        Route::post('store', 'Backend\KaryawanController@store')->name('karyawan.store');
        Route::post('status/{id}', 'Backend\KaryawanController@updateStatus')->name('karyawan.status');
        Route::post('update/{id}', 'Backend\KaryawanController@update')->name('karyawan.update');
        Route::post('destroy/{id}', 'Backend\KaryawanController@destroy')->name('karyawan.destroy');
    });
    Route::group(['prefix' => 'order'], function () {
        Route::get('/rekap', 'Backend\OrderController@rekap')->name('order.data.rekap');
        Route::get('/', 'Backend\OrderController@index')->name('order');
        Route::get('/data', 'Backend\OrderController@getData')->name('order.data'); // <- untuk yajra
        Route::get('/rekap-data-json', 'Backend\OrderController@rekapDataJson')->name('order.rekap.data.json'); // <- untuk yajra
        Route::get('/data-order', 'Backend\OrderController@getDataAll')->name('order.data-all'); // <- untuk yajra
        Route::post('store', 'Backend\OrderController@store')->name('order.store');
        Route::get('edit/{id}', 'Backend\OrderController@edit')->name('order.edit');
        Route::post('status/{id}', 'Backend\OrderController@updateStatus')->name('order.status');
        Route::post('update/{id}', 'Backend\OrderController@update')->name('order.update');
        Route::get('destroy/{id}', 'Backend\OrderController@destroy')->name('order.destroy');
    });
    Route::group(['prefix' => 'komisi'], function () {
        Route::get('/', 'Backend\OrderController@komisi')->name('komisi');
        Route::get('/data', 'Backend\OrderController@getDataKomisi')->name('komisi.data'); // <- untuk yajra
    });
    Route::group(['prefix' => 'statistik'], function () {
        Route::get('/', 'Backend\OrderController@statistik')->name('statistik');
        Route::get('/data', 'Backend\OrderController@getDatastatistik')->name('statistik.data'); // <- untuk yajra
    });

    // Login Routes
    Route::get('/login', 'Backend\Auth\LoginController@showLoginForm')->name('admin.login');
    Route::post('/login/submit', 'Backend\Auth\LoginController@login')->name('admin.login.submit');

    // Logout Routes
    Route::post('/logout/submit', 'Backend\Auth\LoginController@logout')->name('admin.logout.submit');

    // Forget Password Routes
    Route::get('/password/reset', 'Backend\Auth\ForgetPasswordController@showLinkRequestForm')->name('admin.password.request');
    Route::post('/password/reset/submit', 'Backend\Auth\ForgetPasswordController@reset')->name('admin.password.update');
});
