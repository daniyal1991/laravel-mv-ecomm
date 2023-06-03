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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

/*Route::prefix('/admin')->namespace('App\Http\Controllers\Admin')->group(function(){
    Route::any('/login','AdminController@login');
    Route::get('/dashboard', 'AdminController@dashboard');
});*/

Route::group([
    'prefix' => '/admin',
    'namespace' => 'App\Http\Controllers\Admin'
], function() {
    Route::any('/login','AdminController@login')->name('admin_login');

    Route::group(['middleware' => 'admin'], function() {
        Route::get('/dashboard', 'AdminController@dashboard');
        Route::any('/update_admin_password', 'AdminController@updateAdminPassword')->name('admin_update_admin_password');
        Route::post('/check_admin_password', 'AdminController@checkAdminPassword')->name('admin_check_admin_password');;
        Route::match(['get','post'],'/update_admin_details', 'AdminController@updateAdminDetails')->name('admin_update_admin_details');;

        Route::get('/logout', 'AdminController@logout')->name('admin_logout');
    });

});

