<?php

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

// Example Routes
// Route::view('/', 'landing');

// // Auth::routes();


// // Route::middleware('auth', 'user-role:user')->group(function(){
// //         Route::get('/dashboard','dashboard');
// // });
// // Route::view('/dashboard', 'dashboard');
// // Route::prefix('dashboard')
// //     ->middleware('auth:sactum', 'admin')
// //     ->group(function(){
// //         Route::get('/', 'dasboard');

// //     });
// Route::view('/pages/slick', 'pages.slick');
// Route::view('/master/karyawan', 'pages.master.karyawan');
// Route::view('/master/jabatan', 'pages.master.jabatan');
// Route::view('/master/data_kpi', 'pages.master.kpi');
// Route::view('/master/unit_kerja', 'pages.master.unit');
// Route::view('/pages/blank', 'pages.blank');


// Route::view('/create/karyawan', 'pages.master.create.karyawan');
// Route::view('/create/jabatan', 'pages.master.create.jabatan');
// Route::view('/create/data_kpi', 'pages.master.create.kpi');
// Route::view('/create/unit_kerja', 'pages.master.create.unit');


// Route::view('/transaksi/karyawan', 'pages.transaksi.karyawan');
// Route::view('/transaksi/jabatan', 'pages.transaksi.jabatan');
// Route::view('/transaksi/data_kpi', 'pages.transaksi.kpi');

// Route::view('/transaksi_create/data_kpi', 'pages.transaksi.create.kpi');

Route::group(['namespace' => 'App\Http\Controllers'], function()
{   
    /**
     * Home Routes
     */
    // Route::get('/', 'HomeController@index')->name('home.index');
    Route::view('/', 'landing');
    Route::group(['middleware' => ['guest']], function() {
        /**
         * Register Routes
         */
        Route::get('/register', 'RegisterController@show')->name('register.show');
        Route::post('/register', 'RegisterController@register')->name('register.perform');

        /**
         * Login Routes
         */
        // Route::get('/login', 'LoginController@show')->name('login');
        Route::get('/login', 'LoginController@show')->name('login.show');
        Route::post('/login', 'LoginController@login')->name('login.perform');

    });

    Route::group(['middleware' => ['auth', 'permission']], function() {
        /**
         * Logout Routes
         */
        // Route::get('/login', 'LoginController@show')->name('login');

        Route::get('/dashboard','DashboardController@index')->name('dashboard');
        Route::get('/home','DashboardController@index')->name('home.index');
        Route::get('/logout', 'LogoutController@perform')->name('logout.perform');

        /**
         * User Routes
         */
        Route::group(['prefix' => 'users'], function() {
            Route::get('/', 'UserController@index')->name('users.index');
            Route::get('/create', 'UserController@create')->name('users.create');
            Route::post('/create', 'UserController@store')->name('users.store');
            Route::get('/{user}/show', 'UserController@show')->name('users.show');
            Route::get('/{user}/edit', 'UserController@edit')->name('users.edit');
            Route::patch('/{user}/update', 'UserController@update')->name('users.update');
            Route::delete('/{user}/delete', 'UserController@destroy')->name('users.destroy');
        });

        Route::group(['prefix' => 'karyawans'], function() {
            Route::get('/', 'KaryawansController@index')->name('karyawans.index');
            Route::get('/create', 'KaryawansController@create')->name('karyawans.create');
            Route::post('/create', 'KaryawansController@store')->name('karyawans.store');
            Route::get('/{karyawan}/show', 'KaryawansController@show')->name('karyawans.show');
            Route::get('/{karyawan}/edit', 'KaryawansController@edit')->name('karyawans.edit');
            Route::patch('/{karyawan}/update', 'KaryawansController@update')->name('karyawans.update');
            Route::delete('/{karyawan}/delete', 'KaryawansController@destroy')->name('karyawans.destroy');
            
            Route::get('/mutasi_index', 'KaryawansController@mutasi_index')->name('karyawans.mutasi_index');
            Route::get('/mutasi_get/{id}', 'KaryawansController@mutasi_get')->name('karyawans.mutasi_get');
            Route::get('/mutasi_create', 'KaryawansController@mutasi_create')->name('karyawans.mutasi_create');
            Route::post('/mutasi_create', 'KaryawansController@mutasi_store')->name('karyawans.mutasi_store');

            Route::get('/terminasi_index', 'KaryawansController@terminasi_index')->name('karyawans.terminasi_index');
            Route::get('/terminasi_create', 'KaryawansController@terminasi_create')->name('karyawans.terminasi_create');
            Route::post('/terminasi_create', 'KaryawansController@terminasi_store')->name('karyawans.terminasi_store');
        });

        /**
         * User Routes
         */
        Route::group(['prefix' => 'posts'], function() {
            Route::get('/', 'PostsController@index')->name('posts.index');
            Route::get('/create', 'PostsController@create')->name('posts.create');
            Route::post('/create', 'PostsController@store')->name('posts.store');
            Route::get('/{post}/show', 'PostsController@show')->name('posts.show');
            Route::get('/{post}/edit', 'PostsController@edit')->name('posts.edit');
            Route::patch('/{post}/update', 'PostsController@update')->name('posts.update');
            Route::delete('/{post}/delete', 'PostsController@destroy')->name('posts.destroy');
        });

        Route::group(['prefix' => 'departemens'], function() {
        Route::get('/', 'DepartemensController@index')->name('departemens.index');
            Route::get('/create', 'DepartemensController@create')->name('departemens.create');
            Route::post('/create', 'DepartemensController@store')->name('departemens.store');
            Route::get('/{departemen}/show', 'DepartemensController@show')->name('departemens.show');
            Route::get('/{departemen}/edit', 'DepartemensController@edit')->name('departemens.edit');
            Route::patch('/{departemen}/update', 'DepartemensController@update')->name('departemens.update');
            Route::delete('/{departemen}/delete', 'DepartemensController@destroy')->name('departemens.destroy');
        });
        /* unit kerja */
        Route::group(['prefix' => 'unit_kerjas'], function() {
            Route::get('/', 'UnitKerjaController@index')->name('unit_kerjas.index');
            Route::get('/create', 'UnitKerjaController@create')->name('unit_kerjas.create');
            Route::post('/create', 'UnitKerjaController@store')->name('unit_kerjas.store');
            Route::get('/{unit_kerja}/show', 'UnitKerjaController@show')->name('unit_kerjas.show');
            Route::get('/{unit_kerja}/edit', 'UnitKerjaController@edit')->name('unit_kerjas.edit');
            Route::patch('/{unit_kerja}/update', 'UnitKerjaController@update')->name('unit_kerjas.update');
            Route::delete('/{unit_kerja}/delete', 'UnitKerjaController@destroy')->name('unit_kerjas.destroy');
        });
        /* jabatan */
        Route::group(['prefix' => 'jabatans'], function() {
            Route::get('/', 'JabatansController@index')->name('jabatans.index');
            Route::get('/create', 'JabatansController@create')->name('jabatans.create');
            Route::post('/create', 'JabatansController@store')->name('jabatans.store');
            Route::get('/{jabatan}/show', 'JabatansController@show')->name('jabatans.show');
            Route::get('/{jabatan}/edit', 'JabatansController@edit')->name('jabatans.edit');
            Route::patch('/{jabatan}/update', 'JabatansController@update')->name('jabatans.update');
            Route::delete('/{jabatan}/delete', 'JabatansController@destroy')->name('jabatans.destroy');

            
            Route::get('/{jabatan}/data_kpi', 'JabatansController@data_kpi')->name('jabatans.data_kpi');
            Route::get('/{jabatan}/data_kpi_create', 'JabatansController@data_kpi_create')->name('jabatans.data_kpi_create');
            Route::post('/{jabatan}/update_data_kpi', 'JabatansController@update_data_kpi')->name('jabatans.update_data_kpi');
            Route::delete('/{jabatan}/delete_data_kpi', 'JabatansController@destroy_data_kpi')->name('jabatans.destroy_data_kpi');
        });
        /* data kpi */
        Route::group(['prefix' => 'data_kpis'], function() {
            Route::get('/', 'DataKpisController@index')->name('data_kpis.index');
            Route::get('/create', 'DataKpisController@create')->name('data_kpis.create');
            Route::post('/create', 'DataKpisController@store')->name('data_kpis.store');
            Route::get('/{data_kpi}/show', 'DataKpisController@show')->name('data_kpis.show');
            Route::get('/{data_kpi}/edit', 'DataKpisController@edit')->name('data_kpis.edit');
            Route::patch('/{data_kpi}/update', 'DataKpisController@update')->name('data_kpis.update');
            Route::delete('/{data_kpi}/delete', 'DataKpisController@destroy')->name('data_kpis.destroy');

            Route::get('/transaksi_kpi', 'DataKpisController@transaksi_kpi_create')->name('data_kpis.transaksi_kpi_create');
            Route::get('/transaksi_kpi_search', 'DataKpisController@transaksi_kpi_create_search')->name('data_kpis.transaksi_kpi_create_search');

            
            Route::get('/{data_kpi}/{bulan}/{tahun}/isi_kpi', 'DataKpisController@isi_kpi')->name('data_kpis.isi_kpi');
            Route::get('/{data_kpi}/{transaksi_kpi_id}/{bulan}/{tahun}/update_isi_kpi', 'DataKpisController@update_isi_kpi')->name('data_kpis.update_isi_kpi');

            Route::get('update_isi_kpi_user', 'DataKpisController@update_isi_kpi_user')->name('data_kpis.update_isi_kpi_user');
            
            Route::patch('/{data_kpi}/save_kpi', 'DataKpisController@save_kpi')->name('data_kpis.save_kpi');
            Route::patch('/{data_kpi}/save_update_isi_kpi', 'DataKpisController@save_update_isi_kpi')->name('data_kpis.save_update_isi_kpi');

            Route::patch('/{transaksi_kpi_id}/save_update_isi_kpi_user', 'DataKpisController@save_update_isi_kpi_user')->name('data_kpis.save_update_isi_kpi_user');
            Route::get('approval_update_isi_kpi_user', 'DataKpisController@approval_update_isi_kpi_user')->name('data_kpis.approval_update_isi_kpi_user');

            Route::post('/transaksi_kpi', 'DataKpisController@transaksi_kpi_store')->name('data_kpis.transaksi_kpi_store');
        });
        
        /* laporan */
        Route::group(['prefix' => 'laporans'], function() {
            Route::get('/laporan_absensi', 'LaporansController@laporan_absensi')->name('laporans.laporan_absensi');
            Route::get('/laporan_absensi', 'LaporansController@laporan_absensi')->name('laporans.laporan_absensi');

            Route::get('/laporan_karyawan', 'LaporansController@laporan_karyawan')->name('laporans.laporan_karyawan');
            Route::get('/laporan_karyawan', 'LaporansController@laporan_karyawan')->name('laporans.laporan_karyawan');

            Route::get('/laporan_kpi', 'DataKpisController@laporan_kpi')->name('laporans.laporan_kpi');
            Route::get('/laporan_kpi_search', 'DataKpisController@laporan_kpi_search')->name('laporans.laporan_kpi_search');

            Route::get('/laporan_rekap_kpi', 'DataKpisController@laporan_rekap_kpi')->name('laporans.laporan_rekap_kpi');
            Route::get('/laporan_rekap_kpi_search', 'DataKpisController@laporan_rekap_kpi_search')->name('laporans.laporan_rekap_kpi_search');
            // Route::get('/laporan_kpi_export/{bulan}', 'DataKpisController@laporan_kpi_export')->name('laporans.laporans_kpi_export');
            Route::get('laporan_kpi_export', 'DataKpisController@laporan_kpi_export')->name('laporans.laporans_kpi_export');

            Route::get('/laporan_mutasi_karyawan', 'LaporansController@laporan_mutasi_karyawan')->name('laporans.laporan_mutasi_karyawan_searchs');

            Route::get('/laporan_terminasi_karyawan', 'LaporansController@laporan_terminasi_karyawan')->name('laporans.laporan_terminasi_karyawan');
            Route::get('/laporan_terminasi_karyawan', 'LaporansController@laporan_terminasi_karyawan')->name('laporans.laporan_terminasi_karyawan');
        });

        Route::resource('roles', RolesController::class);
        Route::resource('permissions', PermissionsController::class);
    });
});
