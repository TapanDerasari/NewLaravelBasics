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

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('locale', function () {
    return \App::getLocale();
});
Route::get('locale/{locale}', function ($locale) {
    \Session::put('locale', $locale);
    return redirect()->back();
});

Route::get('locale/{locale}', function ($locale) {
    \Session::put('locale', $locale);
    return redirect()->back();
});
Auth::routes();


Route::get('shares/getChartData', 'ShareController@getChartData')->name('shares.getChartData');
Route::get('shares/getpdf', 'ShareController@getPdf')->name('shares.getpdf');
Route::get('shares/{id}/delete', 'ShareController@destroy')->name('shares.delete');
Route::resource('shares', 'ShareController');
Route::get('/login/admin', 'Auth\LoginController@showAdminLoginForm');
Route::get('/register/admin', 'Auth\RegisterController@showAdminRegisterForm');
Route::post('/login/admin', 'Auth\LoginController@adminLogin');
Route::post('/register/admin', 'Auth\RegisterController@createAdmin');
Route::view('/home', 'home')->middleware('auth');


/**
 * Admin Routes
 */
Route::group(['middleware' => 'isAdmin'], function () {
    Route::get('/admin/dashboard', 'Admin\DashboardController@index')->name('admin.dashboard');
//    Route::view('/admin', 'admin.dashboard');
    Route::resource('users', 'Admin\UserController');
    Route::post('/users/status', 'Admin\UserController@StatusUpdate')->name('users.status');

    //chatbox
    Route::get('/chat', 'Admin\ChatController@index')->name('chat');
});

/**
 * Users Routes
 */
Route::get('/chat', 'Users\ChatController@index')->name('users.chat')->middleware('auth');
Route::get('api/users', 'Api\V1\UsersController@index');
Route::post('api/messages', 'Api\V1\MessagesController@index');
Route::post('api/messages/send', 'Api\V1\MessagesController@store');
